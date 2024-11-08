@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <x-notify::notify />
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">
            {{ $title }}
        </h1>

        <section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased mt-5">
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
                    
                    {{-- Product Image --}}
                    <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
                        <img class="w-full"
                            src="{{ $product->image ? asset('/storage/' . $product->image) : asset('/images/defaultProduct.jpg') }}"
                            alt="{{ $product->name }}" />
                    </div>

                    {{-- Product Data --}}
                    <div class="mt-6 sm:mt-8 lg:mt-0">
                        <x-product.product-header :product="$product" />
                        <hr class="my-6 md:my-4 border-gray-200 dark:border-gray-800" />
                        <x-product.product-supplier-info :product="$product" />
                        <x-product.product-information :product="$product" />
                    </div>
                    
                </div>
            </div>
        </section>
    </div>
@endsection
