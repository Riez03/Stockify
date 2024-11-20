@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <x-notify::notify />
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">
            {{ $title }}
        </h1>

        <section>
            <x-table.table-layout :title="'List Action Stock Transaction'" :description="'History Transaction In/Out Item Products'">
                @slot('additional')
                    <div class="flex justify-between items-center gap-3">
                        <form action="{{ route('stock.index') }}" method="GET" class="flex justify-center gap-2">
                            <x-form.select-option name="type" label="Filter by:" placeholder="All Transaction Type">
                                <option value="Masuk" {{ request('type') == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                                <option value="Keluar" {{ request('type') == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                            </x-form.select-option>
                            <button type="submit" name="action" value="view" class="text-gray-900 mt-7 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                <x-tabler-filter class="w-5 h-5 mr-1" />
                                Filter
                            </button>
                            <button type="submit" name="action" value="print-transaction" class="text-gray-900 mt-7 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                <x-tabler-table-export class="w-5 h-5 me-2 -ms-1" />
                                Print
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
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">User</th>
                @endslot

                @forelse ($stockByType as $transaction)
                    <tr>
                        <td class="p-4 text-sm font-normal text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                            {{ $loop->index + 1 }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y') }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $transaction->products->name }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $transaction->type }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $transaction->quantity }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $transaction->users->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-sm text-center font-semibold italic text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                            Data Not Found
                        </td>
                    </tr>
                @endforelse

                @slot('pagination')
                    {{ $stockByType->links() }}
                @endslot
            </x-table.table-layout>

            <x-table.table-layout :title="'Stock Transaction by Filter'" :description="'Filter Stock Transaction Item Products'">
                @slot('additional')
                    <form action="{{ route('stock.index') }}" method="GET">
                        <div class="flex justify-between items-center gap-3">
                            <x-form.select-option name="periods" label="Period:" placeholder="All Periods">
                                <option value="7 Days" {{ request('periods') == '7 Days' ? 'selected' : '' }}>Last 7 Days</option>
                                <option value="30 Days" {{ request('periods') == '30 Days' ? 'selected' : '' }}>Last 30 Days</option>
                                <option value="3 Months" {{ request('periods') == '3 Months' ? 'selected' : '' }}>Last 3 Months</option>
                                <option value="custom" {{ request('periods') == 'custom' ? 'selected' : '' }}>Custom</option>
                            </x-form.select-option>
                            <x-form.select-option name="categories" label="Category:" placeholder="All Categories">
                                @foreach($category as $categories)
                                    <option value="{{ $categories->name }}" {{ request('categories') == $categories->name ? 'selected' : '' }}>{{ $categories->name }}</option>
                                @endforeach
                            </x-form.select-option>
                            <button type="submit" name="action" value="view" class="text-gray-900 mt-7 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                <x-tabler-filter class="w-5 h-5 mr-0 md:mr-1" />
                                <span class="hidden md:block">Filter</span>
                            </button>
                            <button type="submit" name="action" value="print-stock" class="text-gray-900 mt-7 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                <x-tabler-table-export class="w-5 h-5 me-0 -ms-0 md:me-2 md:-ms-1" />
                                <span class="hidden md:block">Print</span>
                            </button>
                        </div>
                        <div class="justify-center flex-col items-center gap-3 mt-3">
                            <div id="custom-date-range" class="{{ request('periods') == 'custom' ? '' : 'hidden' }} space-y-2">
                                <x-form.input name="start_date" type="date" label="Start Date:" value="{{ request('start_date') }}" />
                                <x-form.input name="end_date" type="date" label="End Date:" value="{{ request('end_date') }}" />
                            </div>
                        </div>
                    </form>
                @endslot
                
                @slot('header')
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">No.</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Product</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Category</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">User</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Quantity</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Date</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Status</th>
                @endslot

                @forelse ($stockByCriteria as $transaction)
                    <tr>
                        <td class="p-4 text-sm font-normal text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                            {{ $loop->index + 1 }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $transaction->products->name }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $transaction->products->categories->name }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $transaction->users->name }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $transaction->quantity }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y') }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $transaction->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-sm text-center font-semibold italic text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                            Data Not Found
                        </td>
                    </tr>
                @endforelse

                @slot('pagination')
                    {{ $stockByCriteria->links() }}
                @endslot
            </x-table.table-layout>
        </section>
    </div> 

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const periodSelect = document.querySelector('[name="periods"]');
            const customDateRange = document.getElementById('custom-date-range');

            periodSelect.addEventListener('change', function() {
                if (periodSelect.value === 'custom') {
                    customDateRange.classList.remove('hidden');
                } else {
                    customDateRange.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
