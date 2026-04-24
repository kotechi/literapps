<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class, 'username')],
            'password' => $this->passwordRules(),
            'angkatan' => ['required', 'integer', 'min:2000', 'max:2100'],
            'kelas' => ['required', 'string', 'max:100'],
            'nis' => ['required', 'string', 'max:50', Rule::unique(Anggota::class, 'nis')],
        ])->validate();

        return DB::transaction(function () use ($input): User {
            $user = User::create([
                'name' => $input['name'],
                'username' => $input['username'],
                'password' => $input['password'],
                'role' => 'siswa',
            ]);

            Anggota::create([
                'id_user' => $user->id,
                'angkatan' => $input['angkatan'],
                'kelas' => $input['kelas'],
                'nis' => $input['nis'],
                // Kolom nisn masih wajib di skema saat ini.
                'nisn' => $input['nis'],
            ]);

            return $user;
        });
    }
}
