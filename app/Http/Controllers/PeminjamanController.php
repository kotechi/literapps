<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->isPeminjam()) {
        
            $peminjaman = Peminjaman::with(['user', 'alat.kategori'])
                ->where('id_user', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            // Summary untuk peminjam
            $totalPeminjaman = Peminjaman::where('id_user', auth()->id())->count();
            $peminjamanDisetujui = Peminjaman::where('id_user', auth()->id())->where('status', 'disetujui')->count();
            $peminjamanMenunggu = Peminjaman::where('id_user', auth()->id())->where('status', 'menunggu')->count();
        } else {
                        
            $peminjaman = Peminjaman::with(['user', 'alat.kategori'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            // Summary untuk petugas/admin
            $totalPeminjaman = Peminjaman::count();
            $peminjamanDisetujui = Peminjaman::where('status', 'disetujui')->count();
            $peminjamanMenunggu = Peminjaman::where('status', 'menunggu')->count();
        }
        return view('peminjaman.index', compact('peminjaman', 'totalPeminjaman', 'peminjamanDisetujui', 'peminjamanMenunggu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $alat = Alat::with('kategori')
            ->where('status', 'tersedia')
            ->orderBy('nama_alat')
            ->get();

        return view('peminjaman.create', compact('users', 'alat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'nullable|exists:users,id',
            'id_alat' => 'required|exists:alat,id',
            'tanggal_pengembalian' => 'required|date|after:today',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        if (!isset($validated['id_user'])) {
            $validated['id_user'] = auth()->id();
        }

        // Check if alat is available
        $alat = Alat::find($validated['id_alat']);
        if ($alat->status !== 'tersedia') {
            return back()
                ->withInput()
                ->withErrors(['id_alat' => 'Alat tidak tersedia untuk dipinjam.']);
        }

        Peminjaman::create($validated);

        // Update alat status to tidak_tersedia
        $alat->update(['status' => 'tidak_tersedia']);

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'alat.kategori', 'pengembalian.user', 'pengembalian.buktiPengembalian', 'pengembalian.denda']);

        if (auth()->user()->isPeminjam() && $peminjaman->id_user !== auth()->id()) {
            abort(403);
        }

        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        $users = User::orderBy('name')->get();
        $alat = Alat::with('kategori')->orderBy('nama_alat')->get();

        return view('peminjaman.edit', compact('peminjaman', 'users', 'alat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'id_user' => 'nullable|exists:users,id',
            'id_alat' => 'required|exists:alat,id',
            'tanggal_pengembalian' => 'required|date|after:today',
            'deskripsi' => 'nullable|string|max:1000',
            'status' => 'required|in:menunggu,disetujui,ditolak,dikembalikan',
        ]);

        $oldAlatId = $peminjaman->id_alat;
        $newAlatId = $validated['id_alat'];

        $peminjaman->update($validated);

        // Update alat status if alat changed
        if ($oldAlatId !== $newAlatId) {
            $oldAlat = Alat::find($oldAlatId);
            $newAlat = Alat::find($newAlatId);

            if ($oldAlat) {
                $oldAlat->update(['status' => 'tersedia']);
            }
            if ($newAlat) {
                $newAlat->update(['status' => 'tidak_tersedia']);
            }
        }

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Confirm peminjaman (approve/reject).
     */
    public function confirm(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);
        $peminjaman->update(['status' => $validated['status']]);
        if($validated['status'] === 'ditolak') {
            $peminjaman->alat->update(['status' => 'tersedia']);
        }elseif($validated['status'] === 'disetujui') {
            $peminjaman->alat->update(['status' => 'tidak_tersedia']);
        }

        $message = $validated['status'] === 'disetujui'
            ? 'Peminjaman berhasil disetujui.'
            : 'Peminjaman berhasil ditolak.';

        return redirect()
            ->route('peminjaman.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        // Return alat to available status
        $alat = $peminjaman->alat;
        if ($alat) {
            $alat->update(['status' => 'tersedia']);
        }

        $peminjaman->delete();

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus.');
    }
}
