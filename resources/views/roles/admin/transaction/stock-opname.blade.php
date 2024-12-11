@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section>
            <x-table.table-layout :title="'Stock Inventory Audit'" :description="'Configuration Products Detail'">
                @slot('additional')
                    <div class="flex justify-between items-center gap-3">
                        <form action="{{ route('stock.update-minimum') }}" method="POST" class="flex justify-center gap-2">
                            @csrf
                            <x-form.input type="number" name="minimum_stock" label="Minimum Quantity" placeholder="Current Min. Qty is {{ $minimumStock }}" />
                            <button type="submit" name="action" value="view" class="text-gray-900 mt-7 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                <x-heroicon-s-arrow-path class="w-5 h-5 mr-0 md:mr-2" />
                                <span class="hidden md:block">Update</span>
                            </button>
                        </form>
                    </div>
                @endslot
                
                @slot('header')
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">No.</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Date</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Product</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Type</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Quantity</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Status</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Notes</th>
                @endslot

                <form action="{{ route('stock.update') }}" method="POST">
                    @csrf
                    @forelse ($transaction as $item)
                        @php
                            $options = [];

                            if ($item->status == 'Pending') {
                                $options = ['Diterima', 'Ditolak', 'Dikeluarkan'];
                            } elseif ($item->status == 'Diterima') {
                                $options = ['Pending', 'Ditolak', 'Dikeluarkan'];
                            } elseif ($item->status == 'Ditolak') {
                                $options = ['Diterima', 'Pending', 'Dikeluarkan'];
                            } else {
                                $options = ['Diterima', 'Ditolak', 'Pending'];
                            }
                        @endphp
                        <tr>
                            <td class="hidden">
                                <input type="hidden" name="stock_id[{{ $item->id }}]" value="{{ $item->id }}">
                            </td>
                            <td class="p-4 text-sm font-normal text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                                {{ $loop->index + 1 }}
                            </td>
                            <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                                {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}
                            </td>
                            <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                                {{ $item->products->name }}
                            </td>
                            <td class="p-4 text-sm font-normal w-full md:w-1/6 text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                                <x-form.select-option name="type[{{ $item->id }}]" placeholder="{{ $item->type }}" value>
                                    @if ($item->type == 'Masuk')
                                        <option value="Keluar" {{ $item->type == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                                    @elseif ($item->type == 'Keluar')
                                        <option value="Masuk" {{ $item->type == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                                    @endif
                                </x-form.select-option>
                            </td>
                            <td class="p-4 text-sm font-normal w-1/12 text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                                <x-form.input type="number" name="minimum_stock[{{ $item->id }}]" value="{{ $item->quantity }}" />
                            </td>
                            <td class="p-4 text-xs font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500">
                                <x-form.select-option class="" name="status[{{ $item->id }}]" placeholder="{{ $item->status }}">
                                    @foreach ($options as $option)
                                        <option value="{{ $option }}"
                                            {{ request('status') == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </x-form.select-option>
                            </td>
                            <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                                <x-form.textarea name="notes[{{ $item->id }}]" rows="1" value="{{ $item->notes ?? null }}" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"
                                class="p-4 text-sm text-center font-semibold italic text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                                Data Not Found
                            </td>
                        </tr>
                    @endforelse

                    <div class="flex justify-start sm:justify-start md:justify-start lg:justify-end">
                        <button type="submit" name="action" value="view" class="text-gray-900 mb-3 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-3 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                            <x-tabler-file-shredder class="w-5 h-5 mr-2" />
                            <span>Save Configuration</span>
                        </button>
                    </div>
                </form>


                @slot('pagination')
                    {{ $transaction->links() }}
                @endslot
            </x-table.table-layout>
        </section>
    </div>
@endsection
