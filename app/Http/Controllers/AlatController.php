<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::with('kategori')->paginate(15);
        return view('buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        return view('buku.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori,id',
            'nama_buku' => 'required|string|max:255',
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);

        Buku::create($validated);

        return redirect()
            ->route('buku.index')
            ->with('success', 'buku berhasil ditambahkan.');
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
    public function edit(Buku $buku)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        return view('buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori,id',
            'nama_buku' => 'required|string|max:255',
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);

        $buku->update($validated);

        return redirect()
            ->route('buku.index')
            ->with('success', 'buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'buku berhasil dihapus.');
    }

    /**
     * Search for buku.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $buku = Buku::with('kategori')
            ->where('nama_buku', 'like', '%' . $query . '%')
            ->orWhereHas('kategori', function ($q) use ($query) {
                $q->where('nama_kategori', 'like', '%' . $query . '%');
            })
            ->paginate(15);

        return view('buku.index', compact('buku', 'query'));
    }
}
