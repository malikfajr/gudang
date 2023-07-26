<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Detail Barang') }}
        </h2>
    </header>

    <div class="mt-3 space-y-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div class="max-w-xl">
            <div class="flex gap-6 items-baseline mt-2">
                <x-input-label for="nama" :value="__('Nama Barang')" />
                <x-text-input :disabled="true" id="nama" type="text" value="{{ old('nama', $barang->nama) }}" class="mt-1" />
            </div>
            <div class="flex gap-6 items-baseline mt-2">
                <x-input-label for="stock" :value="__('Stock Barang')" />
                <x-text-input :disabled="true" id="stock" type="number" value="{{ old('stock', $barang->stock) }}" class="mt-1" />
            </div>

            <img src="{{ asset('storage/' . $barang->foto) }}" class="mt-2" alt="">
        </div>
        
        <div class="max-w-xl">
            <div>
                <x-input-label for="deskripsi" :value="__('Deskripsi Barang')" />
                <x-text-area :disabled="true" id="deskripsi" class="mt-1 w-full h-auto" rows="15">{{old('deskripsi', $barang->deskripsi)}}</x-text-area>
            </div>
        </div>
    </div>

    <h2 class="text-lg font-medium text-gray-900 mt-12">
        {{ __('Form Peminjaman') }}
    </h2>
    <form method="post" action="{{ route('pinjam.store', $barang->id) }}" class="space-y-6">
        @csrf

        <input type="hidden" name="barang_id" value="{{ $barang->id }}">
        <div class="max-w-xl">
            <div class="mt-2">
                <x-input-label for="qty" :value="__('Jumlah Barang')" />
                <x-text-input id="qty" name="qty" onchange="updateHarga()" required min="1" max="{{ $barang->stock }}" type="number" value="{{ old('qty') }}" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('qty')" class="mt-2" />
            </div>

            <div class="mt-2">
                <x-input-label for="starting_date" :value="__('Tanggal Peminjaman')" />
                <x-text-input id="starting_date" required 
                    min="{{ now()->format('Y-m-d') }}" 
                    name="starting_date" type="date" 
                    onchange="updateHarga()"
                    value="{{ old('starting_date', now()->format('Y-m-d')) }}" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('starting_date')" class="mt-2" />
            </div>

            <div class="mt-2">
                <x-input-label for="ending_date" :value="__('Jumlah Pengembalian')" />
                <x-text-input id="ending_date" required 
                    min="{{ now()->addDays()->format('Y-m-d') }}" 
                    name="ending_date" type="date" 
                    onchange="updateHarga()"
                    value="{{ old('ending_date', now()->addDays()->format('Y-m-d')) }}" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('ending_date')" class="mt-2" />
            </div>

            <div class="mt-2">
                <x-input-label for="total_harga" :value="__('Total Harga')" />
                <x-text-input id="total_harga" :disabled="true" 
                    name="total_harga" type="text" 
                    class="mt-1 block w-full" />
            </div>

            <div class="flex justify-end items-center gap-4 mt-2">
                <x-danger-button type="reset">{{ __('Reset') }}</x-danger-button>
                <x-primary-button>{{ __('Pinjam') }}</x-primary-button>
            </div>
        </div>
    </form>

    <x-slot name="script">
        <script defer>
            function updateHarga() {
                const harga = {{ $barang->harga }}
                const start = new Date(document.querySelector("#starting_date").value)
                const end = new Date(document.querySelector("#ending_date").value)

                const diff_time = end.getTime() - start.getTime()
                const diff_days = diff_time / (1000 * 3600 * 24);

                const qty =  document.querySelector("#qty").value
                const total_harga = (harga * diff_days * qty)
                document.querySelector("#total_harga").value = `Rp. ${  new Intl.NumberFormat().format(total_harga) }`

                console.log(new Intl.NumberFormat().format(total_harga));
            }
        </script>
    </x-slot>
</section>
