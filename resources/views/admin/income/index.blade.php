<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pemasukan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="" method="get" class="flex justify-end items-baseline gap-2 w-auto sm:mx-7">
                    <x-input-label for="start" :value="__('Tanggal Mulai')" />
                    <x-text-input id="start" name="start" type="date" value="{{ request()->start ?? '' }}" />

                    <x-input-label for="end" :value="__('Tanggal Selesai')" />
                    <x-text-input id="end" name="end" type="date" value="{{ request()->end ?? '' }}"/>

                    <a href="{{ route('income')}}" class="inline-flex items-center px-4 py-2  border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 bg-yellow-600">
                        RESET
                    </a>
                    <x-primary-button type="submit">Cari</x-primary-button>
                </form>

                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden mx-4">
                                Total Pendapatan: Rp. <strong>{{ number_format($total_income) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full text-left text-sm font-light">
                                    <thead class="border-b bg-white font-medium ">
                                        <tr>
                                            <th scope="col" class="px-6 py-4">Nama Peminjam</th>
                                            <th scope="col" class="px-6 py-4">Nama Barang</th>
                                            <th scope="col" class="px-6 py-4">Tanggal Sewa</th>
                                            <th scope="col" class="px-6 py-4">Tanggal Kembali</th>
                                            <th scope="col" class="px-6 py-4">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($income as $item)
                                            <tr class="border-b bg-white even:bg-neutral-100">
                                                <td class="px-6 py-4">{{ $item->user->name }}</td>
                                                <td class="px-6 py-4">{{ $item->barang->nama }}</td>
                                                <td class="px-6 py-4">{{ $item->starting_date }}</td>
                                                <td class="px-6 py-4">{{ $item->ending_date }}</td>
                                                <td class="px-6 py-4">Rp. {{ number_format($item->income) }}</td>
                                            </tr>
                                        @empty
                                            <tr class="border-b bg-white even:bg-neutral-100">
                                                <td class="whitespace-nowrap px-6 py-4 text-center font-bold" colspan="5">Data Belum Ada</td>
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
</x-app-layout>
