<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
               <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">
                        <div class="flex flex-wrap -m-4">
                            @forelse ($barang as $item)
                                <div class="border lg:w-1/4 md:w-1/2 p-4 w-full relative">
                                    <a class="block relative h-48 rounded overflow-hidden" href="{{ route('pinjam.create', $item->id) }}">
                                        <img alt="foto {{ $item->nama }}" class="object-cover object-center w-full h-full block" src="{{ asset('storage/' . $item->foto) }}">
                                    </a>
                                    <div class="mt-4">
                                        {{-- <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">CATEGORY</h3> --}}
                                        <h2 class="text-gray-900 title-font text-lg font-medium">{{ $item->nama }}</h2>
                                        <p class="mt-1">Harga: <strong>Rp. {{ $item->harga }}</strong></p>
                                        <p class="mt-1">Stock: <strong>{{ $item->stock }}</strong></p>
                                        <p class="mt-1">{{ Str::limit($item->deskripsi, 150) }}</p>
                                    </div>
                                </div>
                            @empty
                                Tidak ada barang yang bisa dipinjam
                            @endforelse
                        </div>
                    </div>
                </section>
                    
            </div>
        </div>
    </div>

    @if (session('status') === 'deleted')
        <script>
            alert('Data berhasil dihapus.')
        </script>
    @endif
</x-app-layout>