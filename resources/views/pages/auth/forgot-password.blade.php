<x-layouts::auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Forgot password')" :description="__('Enter your username to receive a password reset link')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.username') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Username Address -->
            <flux:input
                name="username"
                :label="__('Username Address')"
                type="username"
                required
                autofocus
                placeholder="username@example.com"
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="username-password-reset-link-button">
                {{ __('Username password reset link') }}
            </flux:button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
            <span>{{ __('Or, return to') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('log in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
