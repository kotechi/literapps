<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->isSiswa()) {
            $pengembalian = Pengembalian::with(['peminjaman.user', 'peminjaman.buku.kategori', 'user'])
                ->whereHas('peminjaman', function($q) {
                    $q->where('id_user', auth()->id());
                })
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            // Summary untuk siswa
            $totalPengembalian = Pengembalian::whereHas('peminjaman', function($q) {
                $q->where('id_user', auth()->id());
            })->count();
            $pengembalianSelesai = Pengembalian::whereHas('peminjaman', function($q) {
                $q->where('id_user', auth()->id());
            })->where('status', 'selesai')->count();
            $pengembalianMenunggu = Pengembalian::whereHas('peminjaman', function($q) {
                $q->where('id_user', auth()->id());
            })->where('status', 'menunggu')->count();
        } else {
            $pengembalian = Pengembalian::with(['peminjaman.user', 'peminjaman.buku.kategori', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            // Summary untuk admin
            $totalPengembalian = Pengembalian::count();
            $pengembalianSelesai = Pengembalian::where('status', 'selesai')->count();
            $pengembalianMenunggu = Pengembalian::where('status', 'menunggu')->count();
        }

        return view('pengembalian.index', compact('pengembalian', 'totalPengembalian', 'pengembalianSelesai', 'pengembalianMenunggu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $peminjaman = Peminjaman::with(['user', 'buku.kategori'])
            ->where('status', 'disetujui')
            ->orderBy('created_at', 'desc')
            ->get();

        $users = User::orderBy('name')->get();

        return view('pengembalian.create', compact('peminjaman', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id',
            'tanggal_kembali_realisasi' => 'required|date',
            'id_user' => 'nullable|exists:users,id',
            'bukti_pengembalian' => 'nullable|array',
            'bukti_pengembalian.*' => 'file|mimes:jpg,jpeg,png,pdf,webp|max:10240',
        ]);

        if(auth()->user()->isSiswa()) {
            $validated['id_user'] = auth()->id();
        }

        // $existingPengembalian = Pengembalian::where('id_peminjaman', $validated['id_peminjaman'])->first();
        // if ($existingPengembalian) {
        //     return back()
        //         ->withInput()
        //         ->withErrors(['id_peminjaman' => 'Peminjaman ini sudah memiliki pengembalian.']);
        // }

        $peminjaman = Peminjaman::find($validated['id_peminjaman']);
        $tanggalPengembalian = Carbon::parse($peminjaman->tgl_pengembalian);
        $tanggalKembaliRealisasi = Carbon::parse($validated['tanggal_kembali_realisasi']);

        $hariTerlambat = $tanggalPengembalian->diffInDays($tanggalKembaliRealisasi, false);
        $hariTerlambat = max(0, $hariTerlambat);


        $validated['hari_terlambat'] = $hariTerlambat;

        $pengembalian = Pengembalian::create($validated);

        foreach ($request->file('bukti_pengembalian', []) as $file) {
            $path = $file->store('bukti-pengembalian', 'public');
            $mimeType = $file->getMimeType() ?? '';

            $tipeMedia = match (true) {
                str_starts_with($mimeType, 'image/') => 'foto',
                str_starts_with($mimeType, 'video/') => 'video',
                default => 'dokumen',
            };

            $pengembalian->buktiPengembalian()->create([
                'tipe_media' => $tipeMedia,
                'path_file' => $path,
                'keterangan' => null,
            ]);
        }

      

        // Update peminjaman status
        $peminjaman->update(['status' => 'dikembalikan']);

        // Update buku status to tersedia
        $peminjaman->buku->update(['status' => 'tersedia']);

        return redirect()
            ->route('pengembalian.index')
            ->with('success', 'Pengembalian berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.user', 'peminjaman.buku.kategori', 'user', 'buktiPengembalian']);

        if (auth()->user()->isSiswa() && $pengembalian->peminjaman->id_user !== auth()->id()) {
            abort(403);
        }

        return view('pengembalian.show', compact('pengembalian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengembalian $pengembalian)
    {
        $peminjaman = Peminjaman::with(['user', 'buku.kategori'])->get();
        $users = User::orderBy('name')->get();

        return view('pengembalian.edit', compact('pengembalian', 'peminjaman', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengembalian $pengembalian)
    {
        $validated = $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id',
            'tanggal_kembali_realisasi' => 'required|date',
            'id_user' => 'required|exists:users,id',
            'status' => 'required|in:menunggu,disetujui,ditolak,selesai',
            'hari_terlambat' => 'required|integer|min:0',
            'bukti_pengembalian' => 'nullable|array',
            'bukti_pengembalian.*' => 'file|mimes:jpg,jpeg,png,pdf,webp|max:10240',
        ]);

        $pengembalian->update($validated);

        foreach ($request->file('bukti_pengembalian', []) as $file) {
            $path = $file->store('bukti-pengembalian', 'public');
            $mimeType = $file->getMimeType() ?? '';

            $tipeMedia = match (true) {
                str_starts_with($mimeType, 'image/') => 'foto',
                str_starts_with($mimeType, 'video/') => 'video',
                default => 'dokumen',
            };

            $pengembalian->buktiPengembalian()->create([
                'tipe_media' => $tipeMedia,
                'path_file' => $path,
                'keterangan' => null,
            ]);
        }

        return redirect()
            ->route('pengembalian.index')
            ->with('success', 'Pengembalian berhasil diperbarui.');
    }

    /**
     * Confirm pengembalian (approve/reject).
     */
    public function confirm(Request $request, Pengembalian $pengembalian)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak,selesai',
        ]);

        $message = match($validated['status']) {
            'disetujui' => 'Pengembalian berhasil disetujui.',
            'ditolak' => 'Pengembalian berhasil ditolak.',
            'selesai' => 'Pengembalian berhasil diselesaikan.',
        };
        $pengembalian->update(['status' => $validated['status']]);
        if($validated['status'] === 'selesai') {
            $pengembalian->peminjaman->update(['status' => 'dikembalikan']);

            $pengembalian->peminjaman->buku->update(['status' => 'tersedia']);
        }elseif($validated['status'] === 'disetujui') {
            $pengembalian->peminjaman->update(['status' => 'dikembalikan']);

            $pengembalian->peminjaman->buku->update(['status' => 'tidak_tersedia']);
        }elseif($validated['status'] === 'ditolak') {
            $pengembalian->peminjaman->update(['status' => 'disetujui']);

            $pengembalian->peminjaman->buku->update(['status' => 'tidak_tersedia']);
        }

        return redirect()
            ->route('pengembalian.index')
            ->with('success', $message);
    }
}
