@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <x-notify::notify />
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">
          {{ $title }}
        </h1>

        <section>
            <x-table.table-layout :title="'Product Attributes Catalogs'" :description="'List of Product Attributes Information'">
                @slot('additional')
                    <div class="flex justify-between items-center gap-3">
                        <div class="flex justify-start items-start gap-3">
                            <x-simple-modal id="crud-modal" title="Create New Product" buttonText="Add Attribute">
                                <form action="{{ route('attributes.store') }}" method="POST">
                                @csrf
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <x-alert-error-form message="Please review the errors below:" />
                                    
                                    <x-form.select-option name="product_id" label="Product" placeholder="Select Product" required>
                                        @foreach($product as $products)
                                            <option value="{{ $products->id }}">{{ $products->sku }} - {{ $products->name }}</option>
                                         @endforeach
                                    </x-form.select-option>

                                    <x-form.input name="name" label="Attribute Name" placeholder="Pound / Material / Color" required />
                                    <x-form.input name="value" label="Attribute Value" placeholder="15 Gram / Wood / Red" required />
                                </div>
                                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Add Attribute
                                </button>
                                </form>
                            </x-simple-modal>
                        </div>
                    </div>
                @endslot

                @slot('header')
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">No.</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Product Name</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Category</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Attribute</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Action</th>
                    
                @endslot

                
                @foreach ($productAttribute as $attribute)
                    <tr>
                        <td class="p-4 text-sm font-normal text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                            {{ $loop->index + 1 }}
                        </td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $attribute->products->name }}
                        </td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $attribute->products->categories->name }}
                        </td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            <li>{{ $attribute->name }} - {{ $attribute->value }}</li>
                        </td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            <a href="{{ route('attributes.edit', $attribute->id) }}" class="text-white bg-yellow-300 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-yellow-300 dark:hover:bg-yellow-400 dark:focus:ring-yellow-800 hover:cursor-pointer">
                              <x-heroicon-s-pencil-square class="w-5 h-5 text-white" />
                            </a>
                            <a href="{{ route('attributes.show', $attribute->product_id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-800 dark:focus:ring-blue-800 hover:cursor-pointer">
                              <x-heroicon-s-eye class="w-5 h-5 text-white" />
                            </a>
                            <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                              @csrf @method('DELETE')
                              <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-800 dark:focus:ring-red-800">
                                <x-heroicon-s-trash class="w-5 h-5 text-white" />
                              </button>
                            </form>
                          </td>  
                    </tr>
                @endforeach

                @slot('pagination')
                @endslot
            </x-table.table-layout>
        </section>
    </div>
@endsection