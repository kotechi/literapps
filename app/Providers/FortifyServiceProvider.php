<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();
        $this->configureAuthEvents();
    }

    /**
     * Configure authentication event listeners.
     */
    private function configureAuthEvents(): void
    {
        Event::listen(Login::class, function ($event) {
            LogAktivitas::create([
                'id_user' => $event->user->id,
                'jenis_aktivitas' => 'login',
                'deskripsi' => 'Login ke sistem',
                'tanggal_aktivitas' => now(),
            ]);
        });

        Event::listen(Logout::class, function ($event) {
            if ($event->user) {
                LogAktivitas::create([
                    'id_user' => $event->user->id,
                    'jenis_aktivitas' => 'logout',
                    'deskripsi' => 'Logout dari sistem',
                    'tanggal_aktivitas' => now(),
                ]);
            }
        });
    }

    /**
     * Configure Fortify actions.
     */
    private function configureActions(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::authenticateUsing(function (Request $request) {
            $request->validate([
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]);

            $user = User::where('username', $request->input('username'))->first();

            if (! $user || ! Hash::check($request->input('password'), $user->password)) {
                return null;
            }

            $expectedRole = $request->input('expected_role');
            if (in_array($expectedRole, ['admin', 'siswa'], true) && $user->role !== $expectedRole) {
                return null;
            }

            return $user;
        });
    }

    /**
     * Configure Fortify views.
     */
    private function configureViews(): void
    {
        Fortify::loginView(function () {
            $selectedRole = request()->query('role');
            if (! in_array($selectedRole, ['admin', 'siswa'], true)) {
                $selectedRole = null;
            }

            return view('pages::auth.login', [
                'selectedRole' => $selectedRole,
            ]);
        });
        Fortify::verifyEmailView(fn () => view('pages::auth.verify-username'));
        Fortify::twoFactorChallengeView(fn () => view('pages::auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn () => view('pages::auth.confirm-password'));
        Fortify::registerView(fn () => view('pages::auth.register'));
        Fortify::resetPasswordView(fn () => view('pages::auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn () => view('pages::auth.forgot-password'));
    }

    /**
     * Configure rate limiting.
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
    }
}
