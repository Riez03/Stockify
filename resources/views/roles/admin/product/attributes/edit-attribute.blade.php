@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section>
            <div class="p-4 my-5 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <form action="{{ route('attributes.update', $productAttribute->product_id) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    <x-alert-error-form />
                    <input type="hidden" name="product_id" value="{{ $productAttribute->products->id }}">
                    <div class="mb-5">
                        <x-form.input name="" label="SKU - Product Name" value="{{ $productAttribute->products->sku }} - {{  $productAttribute->products->name }}" disabled />
                    </div>
                    <div class="mb-5">
                        <x-form.input name="name" label="Attribute Name" value="{{ $productAttribute->name }}" required />
                    </div>
                    <div class="mb-5">
                        <x-form.input name="value" label="Attribute Value" value="{{ $productAttribute->value }}" required />
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mt-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
            </div>
        </section>
    </div>
@endsection
