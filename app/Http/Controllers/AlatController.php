<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    /**
     * Build the buku query from request filters.
     */
    protected function bukuQuery(Request $request)
    {
        $query = Buku::with('kategori');

        $search = $request->get('q');
        $status = $request->get('status');
        $kategoriId = $request->get('kategori');

        $query->when($search, function ($builder) use ($search) {
            $builder->where(function ($subQuery) use ($search) {
                $subQuery->where('nama_buku', 'like', '%' . $search . '%')
                    ->orWhereHas('kategori', function ($kategoriQuery) use ($search) {
                        $kategoriQuery->where('nama_kategori', 'like', '%' . $search . '%');
                    });
            });
        });

        $query->when($status, fn ($builder) => $builder->where('status', $status));
        $query->when($kategoriId, fn ($builder) => $builder->where('id_kategori', $kategoriId));

        return $query;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $status = $request->get('status');
        $selectedKategori = $request->get('kategori');

        $buku = $this->bukuQuery($request)
            ->paginate(15)
            ->withQueryString();

        $availableCount = (clone $this->bukuQuery($request))->where('status', 'tersedia')->count();
        $unavailableCount = (clone $this->bukuQuery($request))->where('status', 'tidak_tersedia')->count();

        return view('buku.index', compact('buku', 'status', 'kategori', 'selectedKategori', 'availableCount', 'unavailableCount'));
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
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $query = $request->get('q');
        $status = $request->get('status');
        $selectedKategori = $request->get('kategori');

        $buku = $this->bukuQuery($request)
            ->paginate(15)
            ->withQueryString();

        $availableCount = (clone $this->bukuQuery($request))->where('status', 'tersedia')->count();
        $unavailableCount = (clone $this->bukuQuery($request))->where('status', 'tidak_tersedia')->count();

        return view('buku.index', compact('buku', 'query', 'status', 'kategori', 'selectedKategori', 'availableCount', 'unavailableCount'));
    }
}
