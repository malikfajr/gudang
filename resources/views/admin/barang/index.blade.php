<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            @if (auth()->user()->is_admin)
                                <a href="{{ route('barang.create') }}" class="px-6">
                                    <x-primary-button>Tambah Data</x-primary-button>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full text-left text-sm font-light">
                                    <thead class="border-b bg-white font-medium ">
                                        <tr>
                                            <th scope="col" class="px-6 py-4">Nama</th>
                                            <th scope="col" class="px-6 py-4">Gambar</th>
                                            <th scope="col" class="px-6 py-4">Stok</th>
                                            <th scope="col" class="px-6 py-4" width="250">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($barang as $item)
                                            <tr class="border-b bg-white even:bg-neutral-100">
                                                <td class="whitespace-nowrap px-6 py-4">{{ $item->nama }}</td>
                                                <td class="whitespace-nowrap px-6 py-4">
                                                    <img src="{{ asset('storage/' . $item->foto) }}" width="100" alt="foto {{$item->nama}}">
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4">{{ $item->stock }}</td>
                                                <td class="whitespace-nowrap px-6 py-4">
                                                    <div class="flex flex-row gap-2 flex-wrap">
                                                        <a href="{{ route('barang.edit', $item->id) }}" >
                                                            <x-primary-button class="bg-yellow-500 hover:bg-yellow-400">Edit</x-primary-button>
                                                        </a>
                                                        <form action="{{ route('barang.destroy', $item->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <x-danger-button onclick="return confirm('Apakah anda ingin menghapus data ini?')">Delete</x-danger-button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="border-b bg-white even:bg-neutral-100">
                                                <td class="whitespace-nowrap px-6 py-4 text-center font-bold" colspan="4">Data Belum Ada</td>
                                            </tr>
                                        @endforelse
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>

    @if (session('status') === 'deleted')
        <script>
            alert('Data berhasil dihapus.')
        </script>
    @endif
</x-app-layout>