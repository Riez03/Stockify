@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
      <x-notify::notify />
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">
          {{ $title }}
        </h1>

        <section>
            <x-table.table-layout :title="'List Suppliers'" :description="'This is a list of all suppliers information'">
                @slot('additional')
                    {{-- Undefined --}}
                @endslot

                @slot('header')
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">No.</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Name</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Address</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Phone</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Email</th>
                @endslot

                @foreach ($suppliers as $index => $supplier)
                    <tr>
                        <td class="p-4 text-sm font-normal text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                            {{ ($suppliers->currentPage() - 1) * $suppliers->perPage() + $loop->index + 1 }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $supplier->name }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $supplier->address }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $supplier->phone }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $supplier->email }}</td>
                    </tr>
                @endforeach

                @slot('pagination')
                    {{ $suppliers->links() }}
                @endslot
            </x-table.table-layout>
        </section>
    </div>
@endsection
