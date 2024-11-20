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
                  <x-simple-modal id="crud-modal" title="Add Supplier" buttonText="Add Data">
                    <form action="{{ route('suppliers.store') }}" method="POST">
                      @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">
                          <x-form.input name="name" label="Name" placeholder="Input supplier name" required />
                          <x-form.input type="email" name="email" label="Email" placeholder="Input supplier email" required />
                          <div class="col-span-2 sm:col-span-2">
                            <x-form.input name="phone" label="Phone" placeholder="Input phone number" required />
                          </div>
                          <x-form.textarea name="address" value="" label="Address" placeholder="Give Supplier Description" />
                        </div>
                      <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                          Add Supplier
                      </button>
                    </form>
                  </x-simple-modal>              
                @endslot

                @slot('header')
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">No.</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Name</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Address</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Phone</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Email</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Action</th>
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
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                          <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-white bg-yellow-300 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-yellow-300 dark:hover:bg-yellow-400 dark:focus:ring-yellow-800 hover:cursor-pointer">
                            <x-heroicon-s-pencil-square class="w-5 h-5 text-white" />
                          </a>
                          <a href="{{ route('suppliers.show', $supplier->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-800 dark:focus:ring-blue-800 hover:cursor-pointer">
                            <x-heroicon-s-eye class="w-5 h-5 text-white" />
                          </a>
                          <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-800 dark:focus:ring-red-800">
                              <x-heroicon-s-trash class="w-5 h-5 text-white" />
                            </button>
                          </form>
                        </td>    
                    </tr>
                @endforeach

                @slot('pagination')
                    {{ $suppliers->links() }}
                @endslot
            </x-table.table-layout>
        </section>
    </div>
@endsection
