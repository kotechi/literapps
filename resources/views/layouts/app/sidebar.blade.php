<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <style>
            .app-shell {
                background:
                    radial-gradient(900px 350px at -10% -5%, rgba(14, 165, 233, 0.08), transparent 60%),
                    radial-gradient(700px 320px at 110% 0%, rgba(16, 185, 129, 0.08), transparent 60%),
                    #f8fafc;
            }

            .modern-sidebar {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-right: 1px solid #e2e8f0;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            }

            .brand-pill {
                background: linear-gradient(135deg, #0284c7 0%, #0f766e 100%);
                color: #fff;
                border-radius: 16px;
                box-shadow: 0 10px 20px rgba(14, 116, 144, 0.28);
            }

            .nav-item-modern {
                border-radius: 12px;
                font-weight: 600;
                color: #334155;
                transition: all 180ms ease;
            }

            .nav-item-modern:hover {
                background: #ecfeff;
                color: #0f172a;
                transform: translateX(2px);
            }

            .nav-item-modern[data-current="true"] {
                background: linear-gradient(135deg, #0ea5e9 0%, #14b8a6 100%);
                color: #ffffff;
                box-shadow: 0 6px 16px rgba(20, 184, 166, 0.35);
            }

            .section-title {
                font-size: 0.72rem;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: #64748b;
                font-weight: 700;
            }
        </style>
    </head>
    <body class="min-h-screen app-shell text-slate-800">
        <flux:sidebar sticky collapsible="mobile" class="modern-sidebar">
            <flux:sidebar.header>
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 p-4">
                    <img src="/logo.svg" alt="Logo" class="h-7 w-15 rounded-lg" />
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Literapps</p>
                        <p class="text-sm font-bold leading-tight">Sistem Peminjaman Buku</p>
                    </div>
                </a>
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav class="mt-2">
                <div class="section-title px-2 pb-2">Menu Utama</div>
                <flux:sidebar.group class="grid gap-1">
                    <flux:sidebar.item class="nav-item-modern" icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item class="nav-item-modern" icon="archive-box" :href="route('buku.index')" :current="request()->routeIs('buku.*')" wire:navigate>
                        {{ __('Buku') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item class="nav-item-modern" icon="clipboard-document-list" :href="route('peminjaman.index')" :current="request()->routeIs('peminjaman.*')" wire:navigate>
                        {{ __('Peminjaman') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item class="nav-item-modern" icon="arrow-path" :href="route('pengembalian.index')" :current="request()->routeIs('pengembalian.*')" wire:navigate>
                        {{ __('Pengembalian') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item class="nav-item-modern" icon="identification" :href="route('anggota.index')" :current="request()->routeIs('anggota.*')" wire:navigate>
                        {{ __('Daftar Anggota') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                @if(auth()->user()->isAdmin())
                <div class="section-title px-2 pb-2 pt-4">Manajemen Tambahan</div>
                <flux:sidebar.group  class="grid gap-1">
                    @if(auth()->user()->isAdmin())
                    <flux:sidebar.item class="nav-item-modern" icon="users" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>
                        {{ __('Users') }}
                    </flux:sidebar.item>
                    @endif
                    <flux:sidebar.item class="nav-item-modern" icon="tag" :href="route('kategori.index')" :current="request()->routeIs('kategori.*')" wire:navigate>
                        {{ __('Kategori') }}
                    </flux:sidebar.item>
                    
                    @if(auth()->user()->isAdmin())
                    <flux:sidebar.item class="nav-item-modern" icon="clipboard-document-list" :href="route('log-aktivitas.index')" :current="request()->routeIs('log-aktivitas.*')" wire:navigate>
                        {{ __('Log Aktivitas') }}
                    </flux:sidebar.item>
                    @endif
                </flux:sidebar.group>
                @endif
            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>


        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->username }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
