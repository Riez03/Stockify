@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <x-notify::notify />
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">
            {{ $title }}
        </h1>

        <section>
            <div class="bg-white dark:bg-slate-700 rounded-md shadow-md p-6 my-5">
                <h3 class="text-xl font-semibold text-gray-600 dark:text-white mb-4">Transaksi Barang</h3>
                <form action="{{ route('stock.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <x-alert-error-form message="Please review the errors below:" />
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <x-form.select-option name="product_id" label="Product" placeholder="Select Product" required>
                            @foreach($product as $products)
                                <option value="{{ $products->id }}" >{{ $products->name }}</option>
                            @endforeach
                        </x-form.select-option>

                        <x-form.select-option name="type" label="Type" placeholder="Select Item Type" required>
                            <option value="Masuk" {{ request('type') == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="Keluar" {{ request('type') == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                        </x-form.select-option>

                        <x-form.input name="date" type="date" label="Tanggal (Date)" colSpan="col-span-2 sm:col-span-1 md:col-span-1" required />
                        <input type="text" name="status" value="Pending" hidden>

                        <x-form.select-option name="supplier_id" colSpan="" label="Suppliers" placeholder="Select Suppliers" required>
                            @foreach($supplier as $suppliers)
                                <option value="{{ $suppliers->name }}" >{{ $suppliers->name }}</option>
                            @endforeach
                        </x-form.select-option>

                        <x-form.input name="quantity" type="number" colSpan="col-span-2" label="Quantity" placeholder="Item Quantity (Number)" required />

                        <x-form.textarea name="notes" label="Notes" placeholder="Tell them with a note ..." />

                        <div class="col-span-2 flex justify-end">
                            <button type="submit" class="text-white inline-flex bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <x-heroicon-o-shopping-cart class="w-6 h-6 text-white mr-2" />
                                Add Transaction
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <x-table.table-layout :title="'List Action Stock Transaction'" :description="'History Transaction In/Out Item Products'">
                @slot('additional')
                    <div class="flex justify-between items-center gap-3">
                        <form action="{{ route('stock.transaction') }}" method="GET" class="flex justify-center gap-2">
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
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Status</th>
                @endslot

                @forelse ($stockByType as $transaction)
                    @php
                        $statusClasses = [
                            'Pending' => 'bg-yellow-200 dark:bg-yellow-700 text-yellow-700 dark:text-yellow-200',
                            'Diterima' => 'bg-green-200 dark:bg-green-700 text-green-700 dark:text-green-200',
                            'Ditolak' => 'bg-red-200 dark:bg-red-700 text-red-700 dark:text-red-200',
                            'Dikeluarkan' => 'bg-blue-200 dark:bg-blue-700 text-blue-700 dark:text-blue-200',
                        ];

                        $statusClass = $statusClasses[$transaction->status] ?? 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200';
                    @endphp

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
                        <td class="p-4 text-xs font-medium text-gray-900 whitespace-nowrap border-b dark:border-gray-500">
                            <span class="py-1 px-2 rounded-full {{ $statusClass }}">
                                {{ $transaction->status }}
                            </span>
                        </td>
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
        </section>
    </div> 

@endsection
