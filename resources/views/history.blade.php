<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            @if (! auth()->user()->is_admin)
                                <a href="{{ route('list.barang') }}" class="px-6">
                                    <x-primary-button>Daftar Barang</x-primary-button>
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
                                            <th scope="col" class="px-6 py-4">Nama Peminjam</th>
                                            <th scope="col" class="px-6 py-4">Nama Admin</th>
                                            <th scope="col" class="px-6 py-4">Nama Barang</th>
                                            <th scope="col" class="px-6 py-4">Qty</th>
                                            <th scope="col" class="px-6 py-4">Tanggal</th>
                                            <th scope="col" class="px-6 py-4">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($histories as $history)
                                            <tr class="border-b bg-white even:bg-neutral-100">
                                                <td class="whitespace-nowrap px-6 py-4">{{ $history->user->name }}</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{ $history->admin_name ?? '' }}</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{ $history->barang->nama }}</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{ $history->qty }}</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{ $history->date }}</td>
                                                <td class="whitespace-nowrap px-6 py-4">
                                                    @switch($history->status)
                                                        @case('diajukan')
                                                            <span class="px-3 py-2 text-sm rounded-md font-bold bg-yellow-300">Diajukan</span>
                                                            @break
                                                        @case('dipinjam')
                                                            <span class="px-3 py-2 text-sm rounded-md font-bold bg-green-600">Dipinjam</span>
                                                            @break
                                                        @case('dikembalikan')
                                                            <span class="px-3 py-2 text-sm rounded-md font-bold bg-blue-600">Dikembalikan</span>
                                                            @break
                                                        @case('dibatalkan')
                                                            <span class="px-3 py-2 text-sm rounded-md font-bold bg-red-600">Dibatalkan</span>
                                                            @break
                                                        @default
                                                            <span class="px-3 py-2 text-sm rounded-md font-bold bg-red-600">Ditolak</span>
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="border-b bg-white even:bg-neutral-100">
                                                <td class="whitespace-nowrap px-6 py-4 text-center font-bold" colspan="7">Data Belum Ada</td>
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
</x-app-layout>
