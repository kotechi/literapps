<x-layouts::app :title="'Ajukan Bukti Pembayaran'">
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Button & Title -->
        <div class="flex items-center gap-4">
            <a href="{{ route('payment.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Ajukan Bukti Pembayaran</h1>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
            <form method="POST" action="{{ route('payment.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="id_denda" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Denda</label>
                        <select name="id_denda" id="id_denda"
                                class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                            <option value="">Pilih Denda</option>
                            @foreach($denda as $item)
                                <option value="{{ $item->id }}" data-total="{{ $item->total_denda }}" {{ (string) old('id_denda', $selectedDendaId ?? '') === (string) $item->id ? 'selected' : '' }}>
                                    {{ $item->pengembalian->peminjaman->user->name }} - {{ $item->nama_kategori }} (Rp {{ number_format($item->total_denda) }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_denda')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nominal" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nominal Pembayaran</label>
                        <input type="number" readonly name="nominal" id="nominal" value="{{ old('nominal') }}"
                               class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required min="0">
                        @error('nominal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="proof_img" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Bukti Pembayaran</label>
                        <input type="file" name="proof_img" id="proof_img" accept="image/*"
                               class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload gambar bukti pembayaran (JPEG, PNG, JPG, GIF, max 2MB)</p>
                        @error('proof_img')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('payment.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold shadow-sm transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dendaSelect = document.getElementById('id_denda');
        const nominalInput = document.getElementById('nominal');

        const syncNominal = () => {
            const selected = dendaSelect.options[dendaSelect.selectedIndex];
            nominalInput.value = selected ? (selected.dataset.total || '') : '';
        };

        if (dendaSelect && nominalInput) {
            syncNominal();
            dendaSelect.addEventListener('change', syncNominal);
        }
    </script>
</x-layouts::app>