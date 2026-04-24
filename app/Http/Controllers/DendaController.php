<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Pengembalian;
use App\Models\User;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->isPeminjam()) {
            $denda = Denda::with(['pengembalian.peminjaman.user', 'pengembalian.peminjaman.buku', 'user'])
                ->whereHas('pengembalian.peminjaman', function($q) {
                    $q->where('id_user', auth()->id());
                })
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            // Summary untuk peminjam
            $totalDenda = Denda::whereHas('pengembalian.peminjaman', function($q) {
                $q->where('id_user', auth()->id());
            })->sum('total_denda');
            $dendaMenunggu = Denda::whereHas('pengembalian.peminjaman', function($q) {
                $q->where('id_user', auth()->id());
            })->where('status', 'menunggu')->count();
            $dendaLunas = Denda::whereHas('pengembalian.peminjaman', function($q) {
                $q->where('id_user', auth()->id());
            })->where('status', 'selesai')->count();
        } else {
            $denda = Denda::with(['pengembalian.peminjaman.user', 'pengembalian.peminjaman.buku', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            // Summary untuk petugas/admin
            $totalDenda = Denda::sum('total_denda');
            $dendaMenunggu = Denda::where('status', 'menunggu')->count();
            $dendaLunas = Denda::where('status', 'selesai')->count();
        }

        return view('denda.index', compact('denda', 'totalDenda', 'dendaMenunggu', 'dendaLunas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengembalian = Pengembalian::with(['peminjaman.user', 'peminjaman.buku.kategori'])
            ->where('status', 'disetujui')
            ->whereDoesntHave('denda')
            ->orderBy('created_at', 'desc')
            ->get();

        $users = User::orderBy('name')->get();

        return view('denda.create', compact('pengembalian', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pengembalian' => 'required|exists:pengembalian,id',
            'id_user' => 'required|exists:users,id',
            'nama_kategori' => 'required|string|max:255',
            'total_denda' => 'required|integer|min:0',
        ]);

        // Check if pengembalian already has denda
        $existingDenda = Denda::where('id_pengembalian', $validated['id_pengembalian'])->first();
        if ($existingDenda) {
            return back()
                ->withInput()
                ->withErrors(['id_pengembalian' => 'Pengembalian ini sudah memiliki denda.']);
        }

        Denda::create($validated);

        return redirect()
            ->route('denda.index')
            ->with('success', 'Denda berhasil dibuat.');
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
    public function edit(Denda $denda)
    {
        $pengembalian = Pengembalian::with(['peminjaman.user', 'peminjaman.buku.kategori'])->get();
        $users = User::orderBy('name')->get();

        return view('denda.edit', compact('denda', 'pengembalian', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Denda $denda)
    {
        $validated = $request->validate([
            'id_pengembalian' => 'required|exists:pengembalian,id',
            'id_user' => 'required|exists:users,id',
            'nama_kategori' => 'required|string|max:255',
            'status' => 'required|in:menunggu,selesai',
            'total_denda' => 'required|integer|min:0',
        ]);

        $denda->update($validated);

        return redirect()
            ->route('denda.index')
            ->with('success', 'Denda berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Denda $denda)
    {
        $denda->delete();

        return redirect()
            ->route('denda.index')
            ->with('success', 'Denda berhasil dihapus.');
    }
}
