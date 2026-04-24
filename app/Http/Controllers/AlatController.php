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
        $status = request()->get('status');

        $buku = Buku::with('kategori')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->paginate(15)
            ->withQueryString();

        return view('buku.index', compact('buku', 'status'));
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
        $status = $request->get('status');

        $buku = Buku::with('kategori')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('nama_buku', 'like', '%' . $query . '%')
                        ->orWhereHas('kategori', function ($kategoriQuery) use ($query) {
                            $kategoriQuery->where('nama_kategori', 'like', '%' . $query . '%');
                        });
                });
            })
            ->when($status, fn ($q) => $q->where('status', $status))
            ->paginate(15)
            ->withQueryString();

        return view('buku.index', compact('buku', 'query', 'status'));
    }
}
