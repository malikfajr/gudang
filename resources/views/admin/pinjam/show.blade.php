<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pinjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
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

                            <img src="{{ asset('storage/' . $barang->foto) }}"  class="mt-2 w-20 mx-auto" alt="">
                        </div>
                        
                        <div class="max-w-xl">
                            <div>
                                <x-input-label for="deskripsi" :value="__('Deskripsi Barang')" />
                                <x-text-area :disabled="true" id="deskripsi" class="mt-1 w-full h-auto" rows="4">{{old('deskripsi', $barang->deskripsi)}}</x-text-area>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="w-full max-w-xl">
                            <h2 class="text-lg font-medium text-gray-900 mt-12">
                                {{ __('Data Peminjaman') }}
                            </h2>
                            <div class="mt-2">
                                <x-input-label for="qty" :value="__('Jumlah Barang')" />
                                <x-text-input id="qty" name="qty" 
                                    type="number" readonly
                                    value="{{ $pinjam->qty }}" class="mt-1 block w-full" />
                            </div>

                            <div class="mt-2">
                                <x-input-label for="starting_date" :value="__('Tanggal Peminjaman')" />
                                <x-text-input id="starting_date" required 
                                    readonly type="text"
                                    value="{{ $pinjam->starting_date }}" class="mt-1 block w-full" />
                            </div>

                            <div class="mt-2">
                                <x-input-label for="ending_date" :value="__('Tanggal Pengembalian')" />
                                <x-text-input id="ending_date" required 
                                    name="ending_date" type="text" 
                                    readonly
                                    value="{{ $pinjam->ending_date }}" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('ending_date')" class="mt-2" />
                            </div>

                            <div class="mt-2">
                                <x-input-label for="total_harga" :value="__('Total Harga')" />
                                <x-text-input id="total_harga" :disabled="true" 
                                    name="total_harga" type="text" 
                                    value="Rp. {{ number_format($pinjam->total_harga, 2) }}"
                                    class="mt-1 block w-full" />
                            </div>
                        </div>

                        <div class="w-full max-w-xl mt-0">
                            <h2 class="text-lg font-medium text-gray-900 mt-12">
                                {{ __('Form Pemrosesan') }}
                            </h2>

                            <form action="{{ route('pinjaman.proses', $pinjam->id) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="mt-2">
                                    <x-input-label for="uang_muka" :value="__('Uang Muka')" />
                                    <x-text-input id="uang_muka"
                                        name="uang_muka" 
                                        min="0"
                                        type="{{ $pinjam->status != 'diajukan' ? 'text' : 'number' }}" 
                                        disabled="{{ $pinjam->status != 'diajukan' }}"
                                        value="{{ old('uang_muka', 'Rp. ' . number_format($pinjam->uang_muka)) }}" class="mt-1 block w-full" />
                                    <x-input-error :messages="$errors->get('uang_muka')" class="mt-2" />
                                </div>


                                @if ($pinjam->status == 'diajukan')
                                <div class="mt-2 flex items-baseline justify-evenly">
                                    <x-primary-button 
                                        class="bg-green-700" 
                                        name="status" 
                                        value="dipinjam">Terima</x-primary-button>
                                    <x-primary-button 
                                        class="bg-red-700" 
                                        name="status" 
                                        value="ditolak">Tolak</x-primary-button>
                                </div>
                                @elseif ($pinjam->status == 'dipinjam' || $pinjam->status == 'dikembalikan')
                                <div class="mt-2">
                                    <x-input-label for="sisa_bayar" :value="__('Sisa Bayar')" />
                                    <x-text-input id="sisa_bayar"
                                        type="text" 
                                        min="0"
                                        disabled="true"
                                        name="sisa_bayar"
                                        value="Rp. {{ number_format($pinjam->sisa_bayar, 2) }}" class="mt-1 block w-full" />
                                    <x-input-error :messages="$errors->get('sisa_bayar')" class="mt-2" />
                                </div>
                                <div class="mt-2">
                                    <x-input-label for="denda" :value="__('Denda')" />
                                    <x-text-input id="denda"
                                        type="text" 
                                        min="0"
                                        disabled="true"
                                        name="denda"
                                        value="Rp. {{ number_format($denda, 2) }}" class="mt-1 block w-full" />
                                    <x-input-error :messages="$errors->get('denda')" class="mt-2" />
                                </div>
                                    @if ($pinjam->status == 'dipinjam')
                                    <div class="mt-2 flex items-baseline justify-evenly">
                                        <x-primary-button 
                                            class="bg-green-700" 
                                            name="status" 
                                            value="dikembalikan">Dikembalikan</x-primary-button>
                                    </div>
                                    @else
                                    <div class="mt-2">
                                        <x-input-label for="end" :value="__('Realisasi Pengembalian')" />
                                        <x-text-input id="end" required 
                                            readonly type="text"
                                            value="{{ (new Carbon\Carbon($pinjam->updated_at))->locale('id')->translatedFormat('l, d F Y') }}" class="mt-1 block w-full" />
                                    </div>
                                    @endif
                                @endif
                            </form>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
</x-app-layout>
