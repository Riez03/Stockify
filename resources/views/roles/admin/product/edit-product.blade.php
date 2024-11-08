@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section>
            <div class="p-4 my-5 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')
                    <x-alert-error-form />
                    <div class="mb-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" id="name" name="name" value="{{ $product->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:italic" />
                    </div>
                    <div class="mb-5">
                        <x-form.select-option name="category_id" label="Category" placeholder="Select Category">
                            @foreach($category as $categories)
                                <option value="{{ $categories->id }}" {{ $categories->id == $product->category_id ? 'selected' : '' }}>
                                    {{ $categories->name }}
                                </option>
                             @endforeach
                        </x-form.select-option>
                    </div>
                    <div class="mb-5">
                        <x-form.select-option name="supplier_id" label="Supplier" placeholder="Select Supplier">
                            @foreach($supplier as $suppliers)
                                <option value="{{ $suppliers->id }}" {{ $suppliers->id == $product->supplier_id ? 'selected' : '' }}>
                                    {{ $suppliers->name }}
                                </option>
                            @endforeach
                        </x-form.select-option>
                    </div>
                    <div class="mb-5">
                        <label for="sku" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock Keeping Unit</label>
                        <input type="text" id="sku" name="sku" value="{{ $product->sku }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:italic" />
                    </div>
                    <div class="mb-5">
                        <label for="purchase_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purchase Price</label>
                        <input type="number" id="purchase_price" name="purchase_price" value="{{ $product->purchase_price }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:italic" />
                    </div>
                    <div class="mb-5">
                        <label for="selling_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selling Price</label>
                        <input type="number" id="selling_price" name="selling_price" value="{{ $product->selling_price }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:italic" />
                    </div>
                    <div class="mb-5">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea name="description" id="description" rows="5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $product->description }}</textarea>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mt-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
            </div>
        </section>
    </div>
@endsection
