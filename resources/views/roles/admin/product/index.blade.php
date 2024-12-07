@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <x-notify::notify />
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">
            {{ $title }}
        </h1>

        <section>
            <x-table.table-layout :title="'List Products Data'" :description="'List Item of Products Information'">
                @slot('additional')
                    <div class="flex justify-between items-center gap-3">
                        <div class="flex justify-start items-start gap-3">
                            <x-simple-modal id="crud-modal" title="Create New Product" buttonText="Add Product">
                                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="grid gap-4 mb-4 grid-cols-2">
                                        <x-alert-error-form message="Please review the errors below:" />

                                        <x-form.input name="name" label="Name" placeholder="Product Name" required />
                                        <x-form.input name="sku" label="Stock Keeping Unit" placeholder="0" required />

                                        <x-form.select-option name="category_id" label="Category" placeholder="Select Category" required>
                                            @foreach ($category as $categories)
                                                <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                            @endforeach
                                        </x-form.select-option>
                                        <x-form.select-option name="supplier_id" label="Supplier" placeholder="Select Supplier" required>
                                            @foreach ($supplier as $suppliers)
                                                <option value="{{ $suppliers->id }}">{{ $suppliers->name }}</option>
                                            @endforeach
                                        </x-form.select-option>

                                        <x-form.textarea name="description" label="Description"
                                            placeholder="Write Product Description" />
                                        <x-form.input name="purchase_price" label="Purchase Price" placeholder="Rp. 0"
                                            type="number" required />
                                        <x-form.input name="selling_price" label="Selling Price" placeholder="Rp. 0"
                                            type="number" required />
                                        <x-form.file-input name="image" label="Image" />
                                    </div>
                                    <button type="submit"
                                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Add Product
                                    </button>
                                </form>
                            </x-simple-modal>
                            <a href="{{ route('attributes.index') }}" role="button"
                                class="flex focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                <x-tabler-arrows-split-2 class="w-6 h-5 me-0 -ms-1 md:me-2" />
                                <span class="hidden md:block">View Attributes</span>
                            </a>
                        </div>
                        <div class="flex justify-end items-end gap-3">
                            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="import_file" accept=".xlsx, .csv" onchange="this.form.submit()" hidden id="import-file">
                                <button type="button" onclick="document.getElementById('import-file').click()"
                                    class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                    <x-tabler-file-import class="w-6 h-5 me-0 -ms-0 md:me-2 md:-ms-1" />
                                    <span class="hidden md:block">Import File</span>
                                </button>
                            </form>
                            <form action="{{ route('products.export') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                    <x-tabler-table-export class="w-6 h-5 me-0 -ms-0 md:me-2 md:-ms-1" />
                                    <span class="hidden md:block">Export</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endslot

                @slot('header')
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">No.</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Name</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Category</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">SKU</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Purchase Price</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Action</th>
                @endslot

                @foreach ($products as $product)
                    <tr>
                        <td
                            class="p-4 text-sm font-normal text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                            {{ $loop->index + 1 }}</td>
                        <td
                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $product->name }}</td>
                        <td
                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $product->categories->name }}</td>
                        <td
                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $product->sku }}</td>
                        <td
                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ Number::currency($product->purchase_price, 'Rp.') }}</td>
                        <td
                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="text-white bg-yellow-300 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-yellow-300 dark:hover:bg-yellow-400 dark:focus:ring-yellow-800 hover:cursor-pointer">
                                <x-heroicon-s-pencil-square class="w-5 h-5 text-white" />
                            </a>
                            <a href="{{ route('products.show', $product->id) }}"
                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-800 dark:focus:ring-blue-800 hover:cursor-pointer">
                                <x-heroicon-s-eye class="w-5 h-5 text-white" />
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                style="display: inline"
                                onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-800 dark:focus:ring-red-800">
                                    <x-heroicon-s-trash class="w-5 h-5 text-white" />
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @slot('pagination')
                    {{ $products->links() }}
                @endslot
            </x-table.table-layout>
        </section>
    </div>
@endsection
