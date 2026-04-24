<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    /**
     * Display daftar anggota (user role siswa + data anggota).
     */
    public function index()
    {
        if (! auth()->user()->isAdmin() && ! auth()->user()->isSiswa()) {
            abort(403);
        }

        $anggota = User::query()
            ->with('anggota')
            ->where('role', 'siswa')
            ->orderBy('name')
            ->paginate(15);

        return view('anggota.index', compact('anggota'));
    }

    /**
     * Show the form for creating a new anggota.
     */
    public function create()
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('anggota.create');
    }

    /**
     * Store a newly created anggota and user in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->whereNull('deleted_at'),
            ],
            'password' => 'required|string|min:8|confirmed',
            'angkatan' => 'required|integer',
            'kelas' => 'required|string|max:50',
            'nis' => [
                'required',
                'string',
                'max:30',
                Rule::unique('anggota', 'nis')->whereNull('deleted_at'),
            ],
            'nisn' => [
                'required',
                'string',
                'max:30',
                Rule::unique('anggota', 'nisn')->whereNull('deleted_at'),
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => 'siswa',
            ]);

            Anggota::create([
                'id_user' => $user->id,
                'angkatan' => $validated['angkatan'],
                'kelas' => $validated['kelas'],
                'nis' => $validated['nis'],
                'nisn' => $validated['nisn'],
            ]);
        });

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Show the form for editing anggota.
     */
    public function edit(User $anggota)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($anggota->role !== 'siswa') {
            abort(404);
        }

        $anggota->load('anggota');

        return view('anggota.edit', compact('anggota'));
    }

    /**
     * Update anggota and linked user.
     */
    public function update(Request $request, User $anggota)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($anggota->role !== 'siswa') {
            abort(404);
        }

        $anggotaProfile = $anggota->anggota;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($anggota->id)->whereNull('deleted_at'),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'angkatan' => 'required|integer',
            'kelas' => 'required|string|max:50',
            'nis' => [
                'required',
                'string',
                'max:30',
                Rule::unique('anggota', 'nis')->ignore($anggotaProfile?->id)->whereNull('deleted_at'),
            ],
            'nisn' => [
                'required',
                'string',
                'max:30',
                Rule::unique('anggota', 'nisn')->ignore($anggotaProfile?->id)->whereNull('deleted_at'),
            ],
        ]);

        DB::transaction(function () use ($anggota, $anggotaProfile, $validated) {
            $payloadUser = [
                'name' => $validated['name'],
                'username' => $validated['username'],
                'role' => 'siswa',
            ];

            if (! empty($validated['password'])) {
                $payloadUser['password'] = Hash::make($validated['password']);
            }

            $anggota->update($payloadUser);

            if ($anggotaProfile) {
                $anggotaProfile->update([
                    'angkatan' => $validated['angkatan'],
                    'kelas' => $validated['kelas'],
                    'nis' => $validated['nis'],
                    'nisn' => $validated['nisn'],
                ]);
            } else {
                Anggota::create([
                    'id_user' => $anggota->id,
                    'angkatan' => $validated['angkatan'],
                    'kelas' => $validated['kelas'],
                    'nis' => $validated['nis'],
                    'nisn' => $validated['nisn'],
                ]);
            }
        });

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Soft-delete anggota and linked user.
     */
    public function destroy(User $anggota)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($anggota->role !== 'siswa') {
            abort(404);
        }

        DB::transaction(function () use ($anggota) {
            $anggota->loadMissing('anggota');

            if ($anggota->anggota) {
                $anggota->anggota->delete();
            }

            $anggota->delete();
        });

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
