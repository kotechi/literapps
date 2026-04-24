<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\buku;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->isSiswa()) {
        
            $peminjaman = Peminjaman::with(['user', 'buku.kategori'])
                ->where('id_user', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            // Summary untuk siswa
            $totalPeminjaman = Peminjaman::where('id_user', auth()->id())->count();
            $peminjamanDisetujui = Peminjaman::where('id_user', auth()->id())->where('status', 'disetujui')->count();
            $peminjamanMenunggu = Peminjaman::where('id_user', auth()->id())->where('status', 'menunggu')->count();
        } else {
                        
            $peminjaman = Peminjaman::with(['user', 'buku.kategori'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            // Summary untuk admin
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
        $buku = buku::with('kategori')
            ->where('status', 'tersedia')
            ->orderBy('nama_buku')
            ->get();

        return view('peminjaman.create', compact('users', 'buku'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'nullable|exists:users,id',
            'id_buku' => 'required|exists:buku,id',
            'tgl_pinjam' => 'nullable|date',
            'tgl_pengembalian' => 'required|date|after:today',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        if (!isset($validated['id_user'])) {
            $validated['id_user'] = auth()->id();
        }

        if (empty($validated['tgl_pinjam'])) {
            $validated['tgl_pinjam'] = now()->toDateString();
        }

        // Check if buku is available
        $buku = buku::find($validated['id_buku']);
        if ($buku->status !== 'tersedia') {
            return back()
                ->withInput()
                ->withErrors(['id_buku' => 'buku tidak tersedia untuk dipinjam.']);
        }

        Peminjaman::create($validated);

        // Update buku status to tidak_tersedia
        $buku->update(['status' => 'tidak_tersedia']);

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'buku.kategori', 'pengembalian.user', 'pengembalian.buktiPengembalian']);

        if (auth()->user()->isSiswa() && $peminjaman->id_user !== auth()->id()) {
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
        $buku = buku::with('kategori')->orderBy('nama_buku')->get();

        return view('peminjaman.edit', compact('peminjaman', 'users', 'buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'id_user' => 'nullable|exists:users,id',
            'id_buku' => 'required|exists:buku,id',
            'tgl_pinjam' => 'required|date',
            'tgl_pengembalian' => 'required|date|after:today',
            'deskripsi' => 'nullable|string|max:1000',
            'status' => 'required|in:menunggu,disetujui,ditolak,dikembalikan',
        ]);

        $oldbukuId = $peminjaman->id_buku;
        $newbukuId = $validated['id_buku'];

        $peminjaman->update($validated);

        // Update buku status if buku changed
        if ($oldbukuId !== $newbukuId) {
            $oldbuku = buku::find($oldbukuId);
            $newbuku = buku::find($newbukuId);

            if ($oldbuku) {
                $oldbuku->update(['status' => 'tersedia']);
            }
            if ($newbuku) {
                $newbuku->update(['status' => 'tidak_tersedia']);
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
            $peminjaman->buku->update(['status' => 'tersedia']);
        }elseif($validated['status'] === 'disetujui') {
            $peminjaman->buku->update(['status' => 'tidak_tersedia']);
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
        // Return buku to available status
        $buku = $peminjaman->buku;
        if ($buku) {
            $buku->update(['status' => 'tersedia']);
        }

        $peminjaman->delete();

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus.');
    }
}
