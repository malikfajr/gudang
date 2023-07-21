<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Tambah Barang') }}
        </h2>
    </header>

    <form method="post" action="{{ route('barang.update', $barang->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div>
            <x-input-label for="nama" :value="__('Nama Barang')" />
            <x-text-input id="nama" name="nama" type="text" value="{{ old('nama', $barang->nama) }}" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="foto" :value="__('Foto Barang')" />
            <x-text-input id="foto" name="foto" type="file" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('foto')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="deskripsi" :value="__('Deskripsi Barang')" />
            <x-text-area id="deskripsi" name="deskripsi" type="text" class="mt-1 block w-full">{{old('deskripsi', $barang->deskripsi)}}</x-text-area>
            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="stock" :value="__('Stock Barang')" />
            <x-text-input id="stock" name="stock" type="number" min="1" value="{{ old('stock', $barang->stock) }}" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
