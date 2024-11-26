@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <x-notify::notify />
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section>
            <div class="container mx-auto px-4 py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Jumlah Produk -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-blue-700">Jumlah Produk</h2>
                            <x-tabler-box class="h-8 w-8 text-blue-500" />
                        </div>
                        <p class="text-3xl font-bold text-blue-700">{{ $totalProducts }}</p>
                        <p class="text-xs font-medium text-blue-700 mt-2">Total produk dalam inventaris</p>
                    </div>

                    <!-- Stok Rendah -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-yellow-500">Total Stok Rendah</h2>
                            <x-heroicon-o-exclamation-circle class="h-8 w-8 text-yellow-500" />
                        </div>
                        <p class="text-3xl font-bold text-yellow-500">{{ $totalLowStock }}</p>
                        <p class="text-xs font-medium text-yellow-500 mt-2">Produk perlu diisi ulang</p>
                    </div>

                    <!-- Transaksi Masuk -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-green-700">Transaksi Masuk</h2>
                            <x-heroicon-c-bars-arrow-up class="h-8 w-8 text-green-600" />
                        </div>
                        <p class="text-3xl font-bold text-green-700">256</p>
                        <p class="text-xs font-medium text-green-700 mt-2">Dalam 30 hari terakhir</p>
                    </div>

                    <!-- Transaksi Keluar -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-red-700">Transaksi Keluar</h2>
                            <x-heroicon-c-bars-arrow-down class="h-8 w-8 text-red-600" />
                        </div>
                        <p class="text-3xl font-bold text-red-700">189</p>
                        <p class="text-xs font-medium text-red-700 mt-2">Dalam 30 hari terakhir</p>
                    </div>
                </div>

                <!-- Grafik Stok Barang -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Grafik Stok Barang</h2>
                    <div class="bg-gray-200 h-64 rounded-lg flex items-center justify-center"></div>
                </div>

                <!-- Aktivitas Pengguna Terbaru -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex flex-col md:flex-row items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4 md:mb-0">Aktivitas Pengguna Terbaru</h2>
                        <div class="flex items-center justify-center space-x-2 md:space-x-4 w-full md:w-auto">
                            <button id="generate-report" class="bg-blue-500 text-white px-3 py-2.5 mt-2 font-medium rounded text-sm hover:bg-blue-600 transition duration-300 flex items-center justify-center">
                                <x-tabler-file-invoice class="h-5 w-5 mr-2" />
                                Generate Report
                            </button>
                        </div>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        @if (is_array($activities) && count($activities) > 0)
                            @foreach ($activities as $activity)
                                <div>
                                    <div class="flex items-center mb-1">
                                        <div class="flex-grow">
                                            <p class="text-sm font-medium text-gray-900">{{ $activity['user_id'] }}</p>
                                            <p class="text-xs text-blue-600 font-semibold uppercase">{{ $activity['action'] }}</p>
                                        </div>
                                        <span class="text-xs italic font-semibold text-gray-500">
                                            {{ \Carbon\Carbon::parse($activity['timestamp'])->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="ml-13 pl-3 border-l-2 mt-5 p-2 border-blue-500">
                                        <p class="text-sm text-gray-600"><span class="font-medium">Entity:</span> {{ $activity['entity'] }}</p>
                                        <p class="text-sm text-gray-600"><span class="font-medium">Entity Name:</span> {{ $activity['entity_name'] }}</p>
                                        <p class="text-sm text-gray-600"><span class="font-medium">Message:</span> {{ $activity['message']}}</p>
                                    </div>
                                </div>
                            @endforeach
                        @elseif (is_array($activities) && count($activities) === 0)
                            <p>Tidak ada aktivitas yang tercatat.</p>
                        @endif
                    </ul>
                </div>
                
            </div>
        </section>
    </div>
@endsection
