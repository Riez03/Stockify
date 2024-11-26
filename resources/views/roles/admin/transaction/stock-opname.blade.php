@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section>
            <div class="bg-white mt-5 rounded-md shadow-md p-6 w-full">
                <h1 class="text-xl font-bold text-start mb-8 text-gray-800">Kelola Stok Minimum</h1>
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-5 text-white flex-1">
                        <h2 class="text-xl font-semibold mb-2">Minimum Stock Saat Ini</h2>
                        <div class="flex items-center justify-between">
                            <span class="text-4xl font-bold">{{ $minimumStock }}</span>
                            <x-heroicon-m-square-2-stack class="h-12 w-12 opacity-50" />
                        </div>
                    </div>

                    <div class="flex-1">
                        <form action="{{ route('stock.update-minimum') }}" method="POST" class="space-y-5 md:space-y-1">
                            @csrf
                            <div>
                                <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-2">Atur Minimum Stock</label>
                                <div class="relative">
                                    <input type="number" id="minimum_stock" name="minimum_stock"
                                        class="block w-full pr-10 sm:text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Masukkan jumlah minimum">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <x-heroicon-o-adjustments-vertical class="h-5 w-5 text-gray-400" />
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 md:py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                                Perbarui Minimum Stock
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
