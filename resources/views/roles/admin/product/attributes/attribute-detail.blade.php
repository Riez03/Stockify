@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section>
            <div class="bg-white shadow-md rounded-lg overflow-hidden my-4">
               <form method="get">
                @csrf
                <div class="px-6 py-4 bg-gray-200 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800">Product Information</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Product Name</h3>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $productAttribute->products->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Category</h3>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $productAttribute->products->categories->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Stock Keeping Unit</h3>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $productAttribute->products->sku }}</p>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 underline">Product Attributes</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($attributes as $attr)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $attr->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $attr->value }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
               </form>
            </div>
        </section>
    </div>
@endsection
