    @extends('layouts.default.dashboard')
    @section('content')
        <div class="px-4 pt-6">
            <x-notify::notify />
            <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

            <section>
                <x-table.table-layout :title="'Item Check Confirmation'" :description="'Pending/Struggle data information'">
                    @slot('additional')
                    @endslot
                    
                    @slot('header')
                        <th class="p-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-white">No.</th>
                        <th class="p-4 text-xs font-bold text-center tracking-wider text-gray-500 uppercase dark:text-white">Product</th>
                        <th class="p-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-white">Category</th>
                        <th class="p-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-white">Type</th>
                        <th class="p-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-white">Quantity</th>
                        <th class="p-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-white">Date</th>
                        <th class="p-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-white">Status</th>
                        <th class="p-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-white">Action</th>
                    @endslot

                    @forelse ($data as $index => $stock)
                        @php
                            $statusClasses = [
                                'Pending' => 'bg-yellow-200 dark:bg-yellow-700 text-yellow-700 dark:text-yellow-200',
                                'Diterima' => 'bg-green-200 dark:bg-green-700 text-green-700 dark:text-green-200',
                                'Ditolak' => 'bg-red-200 dark:bg-red-700 text-red-700 dark:text-red-200',
                                'Dikeluarkan' => 'bg-blue-200 dark:bg-blue-700 text-blue-700 dark:text-blue-200',
                            ];

                            $statusClass = $statusClasses[$stock->status] ?? 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200';
                        @endphp
                        <tr>
                            <td class="p-4 text-sm font-normal text-center text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                                {{ $loop->index + 1 }}</td>
                            <td class="p-4 text-sm font-normal text-center text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                                {{ $stock->products->name }}</td>
                            <td class="p-4 text-sm font-normal text-center text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                                {{ $stock->products->categories->name }}</td>
                            <td class="p-4 text-sm font-normal text-center text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                                <span class="bg-lime-400 text-lime-800 dark:text-white dark:bg-lime-700 py-1 px-3 rounded-full text-xs font-medium">
                                    {{ $stock->type }}
                                </span>
                            </td>
                            <td class="p-4 text-sm font-normal text-center text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                                <span class="bg-violet-200 dark:bg-violet-700 dark:text-white text-violet-600 py-1 px-3 rounded-full text-sm font-medium">
                                    {{ $stock->quantity }}
                                </span>
                            </td>
                            <td class="p-4 text-sm font-normal text-center text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                                {{ \Carbon\Carbon::parse($stock->date)->translatedFormat('d F Y') }}</td>
                            <td class="p-4 text-xs font-medium text-center text-gray-900 whitespace-nowrap border-b dark:border-gray-500">
                                <span class="py-1 px-2 rounded-full {{ $statusClass }}">
                                    {{ $stock->status }}
                                </span>
                            </td>
                            <td class="p-4 text-xs font-medium text-gray-900 whitespace-nowrap border-b dark:border-gray-500">
                                <div class="flex flex-col md:flex-row md:row-span-3 gap-2">
                                    <form action="{{ route('stock.update-confirmation', $stock->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Diterima" />
                                        <button type="submit" class="flex items-center justify-center bg-sky-400 p-2 font-medium text-sky-900 dark:text-white dark:bg-sky-600 rounded-lg basis-1/3">
                                            <x-heroicon-o-check-badge class="w-4 h-4 mr-1 dark:text-white" />
                                            Konfirmasi
                                        </button>
                                    </form>
                                    <form action="{{ route('stock.update-confirmation', $stock->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Ditolak" />
                                            <button type="submit" class="flex items-center justify-center bg-rose-400 p-2 font-medium text-rose-900 dark:text-white dark:bg-rose-600 rounded-lg basis-1/3">
                                                <x-heroicon-o-x-circle class="w-4 h-4 mr-1 dark:text-white" />
                                                Ditolak
                                            </button>
                                    </form>
                                    <form action="{{ route('stock.update-confirmation', $stock->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Dikeluarkan" />
                                            <button type="submit" class="flex items-center justify-center bg-green-400 p-2 font-medium text-green-900 dark:text-white dark:bg-green-600 rounded-lg basis-1/3">
                                                <x-heroicon-o-check-badge class="w-4 h-4 mr-1 dark:text-white" />
                                                Dikeluarkan
                                            </button>
                                    </form>
                                    
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-sm text-center font-semibold italic text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                                Pending Stock Item is Empty!
                            </td>
                        </tr>
                    @endforelse
                </x-table.table-layout>

            </section>
        </div>
    @endsection
