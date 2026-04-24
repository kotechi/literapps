<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->isSiswa()) {
            $payment = Payment::with(['denda.pengembalian.peminjaman.user', 'denda.pengembalian.peminjaman.buku'])
                ->whereHas('denda.pengembalian.peminjaman', function($q) {
                    $q->where('id_user', auth()->id());
                })
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            // Summary untuk peminjam
            $totalPembayaran = Payment::whereHas('denda.pengembalian.peminjaman', function($q) {
                $q->where('id_user', auth()->id());
            })->sum('nominal');
            $pembayaranDisetujui = Payment::whereHas('denda.pengembalian.peminjaman', function($q) {
                $q->where('id_user', auth()->id());
            })->where('status', 'disetujui')->count();
            $pembayaranMenunggu = Payment::whereHas('denda.pengembalian.peminjaman', function($q) {
                $q->where('id_user', auth()->id());
            })->where('status', 'menunggu')->count();
        } else {
            $payment = Payment::with(['denda.pengembalian.peminjaman.user', 'denda.pengembalian.peminjaman.buku'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            // Summary untuk petugas/admin
            $totalPembayaran = Payment::sum('nominal');
            $pembayaranDisetujui = Payment::where('status', 'disetujui')->count();
            $pembayaranMenunggu = Payment::where('status', 'menunggu')->count();
        }

        return view('payment.index', compact('payment', 'totalPembayaran', 'pembayaranDisetujui', 'pembayaranMenunggu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $selectedDendaId = request()->get('id_denda');

        $denda = Denda::with(['pengembalian.peminjaman.user', 'pengembalian.peminjaman.buku'])
            ->where('status', 'menunggu')
            ->when(auth()->user()->isSiswa(), function ($query) {
                $query->whereHas('pengembalian.peminjaman', function ($subQuery) {
                    $subQuery->where('id_user', auth()->id());
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('payment.create', compact('denda', 'selectedDendaId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_denda' => 'required|exists:denda,id',
            'proof_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $denda = Denda::with('pengembalian.peminjaman')->findOrFail($validated['id_denda']);

        if (auth()->user()->isSiswa() && $denda->pengembalian->peminjaman->id_user !== auth()->id()) {
            abort(403);
        }

        if ($denda->status === 'selesai') {
            return back()->withInput()->withErrors(['id_denda' => 'Denda ini sudah lunas.']);
        }

        $existingPayment = Payment::where('id_denda', $denda->id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->exists();

        if ($existingPayment) {
            return back()->withInput()->withErrors(['id_denda' => 'Denda ini sudah memiliki pengajuan pembayaran aktif.']);
        }

        $validated['nominal'] = $denda->total_denda;
        $validated['status'] = 'menunggu';

        // Handle file upload
        if ($request->hasFile('proof_img')) {
            $file = $request->file('proof_img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('proof_images', $filename, 'public');
            $validated['proof_img'] = $path;
        }

        Payment::create($validated);

        return redirect()
            ->route('payment.index')
            ->with('success', 'Pembayaran berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $denda = Denda::with(['pengembalian.peminjaman.user', 'pengembalian.peminjaman.buku'])->get();

        return view('payment.edit', compact('payment', 'denda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'id_denda' => 'required|exists:denda,id',
            'status' => 'required|in:menunggu,disetujui,ditolak',
            'nominal' => 'required|integer|min:0',
            'proof_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload if new file provided
        if ($request->hasFile('proof_img')) {
            // Delete old file
            if ($payment->proof_img && Storage::disk('public')->exists($payment->proof_img)) {
                Storage::disk('public')->delete($payment->proof_img);
            }

            $file = $request->file('proof_img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('proof_images', $filename, 'public');
            $validated['proof_img'] = $path;
        }

        $payment->update($validated);

        return redirect()
            ->route('payment.index')
            ->with('success', 'Pembayaran berhasil diperbarui.');
    }

    /**
     * Confirm payment (approve/reject).
     */
    public function confirm(Request $request, Payment $payment)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        $payment->update(['status' => $validated['status']]);

        // Update denda status if payment approved
        if ($validated['status'] === 'disetujui') {
            $payment->denda->update(['status' => 'selesai']);
            $payment->denda->pengembalian->update(['status' => 'selesai']);
            $payment->denda->pengembalian->peminjaman->update(['status' => 'dikembalikan']);
            $payment->denda->pengembalian->peminjaman->buku->update(['status' => 'tersedia']);
        } else {
            $payment->denda->update(['status' => 'menunggu']);
        }

        $message = $validated['status'] === 'disetujui'
            ? 'Pembayaran berhasil disetujui.'
            : 'Pembayaran berhasil ditolak.';

        return redirect()
            ->route('payment.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        // Delete proof image file
        if ($payment->proof_img && Storage::disk('public')->exists($payment->proof_img)) {
            Storage::disk('public')->delete($payment->proof_img);
        }

        $payment->delete();

        return redirect()
            ->route('payment.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }
}
