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
                        <x-form.input name="name" label="Product Name" value="{{ $product->name }}" required />
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
                        <x-form.input name="sku" label="Stock Keeping Unit" value="{{ $product->sku }}" required />
                    </div>
                    <div class="mb-5">
                        <x-form.input type="number" name="purchase_price" label="Purchase Price" value="{{ $product->purchase_price }}" required />
                    </div>
                    <div class="mb-5">
                        <x-form.input type="number" name="selling_price" label="Selling Price" value="{{ $product->selling_price }}" required />
                    </div>
                    <div class="mb-5">
                        <x-form.textarea name="description" label="Description" placeholder="Write Product Description" value="{{ $product->description }}" />
                    </div>
                    <div class="mb-5">
                        <x-form.file-input name="image" label="Image" />
                        <div class="my-3">
                            <span class="font-medium">Preview Formerly Image:</span>
                            <img class="w-1/6 mt-2 rounded-md border-2 border-gray-400"
                                src="{{ $product->image ? asset('/storage/' . $product->image) : asset('/images/defaultProduct.jpg') }}"
                                alt="{{ $product->name }}" />
                        </div>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mt-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
            </div>
        </section>
    </div>
@endsection
