@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <x-notify::notify />
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section>
            <div class="container mx-auto px-4 py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    {{-- Jumlah Produk --}}
                    <div class="bg-white rounded-lg shadow-md p-6 dark:bg-slate-700">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-blue-500">
                                Jumlah Produk
                            </h2>
                            <x-tabler-box class="h-8 w-8 text-blue-500" />
                        </div>
                        <p class="text-3xl font-bold text-blue-500">{{ $totalProducts }}</p>
                        <p class="text-xs font-medium text-blue-500 mt-2">Total produk dalam inventaris</p>
                    </div>

                    {{-- Stok Rendah --}}
                    <div class="bg-white rounded-lg shadow-md p-6 dark:bg-slate-700">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-yellow-500">
                                Total Stok Rendah
                            </h2>
                            <x-heroicon-o-exclamation-circle class="h-8 w-8 text-yellow-500" />
                        </div>
                        <p class="text-3xl font-bold text-yellow-500">{{ $totalLowStock }}</p>
                        <p class="text-xs font-medium text-yellow-500 mt-2">Produk perlu diisi ulang</p>
                    </div>

                    {{-- Transaksi Masuk --}}
                    <div class="bg-white rounded-lg shadow-md p-6 dark:bg-slate-700">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-green-700 dark:text-green-400">
                                Transaksi Masuk
                            </h2>
                            <x-heroicon-c-bars-arrow-up class="h-8 w-8 text-green-600 dark:text-green-400" />
                        </div>
                        <p class="text-3xl font-bold text-green-700 dark:text-green-400">{{ $incomingTransaction }}</p>
                        <p class="text-xs font-medium text-green-700 mt-2 dark:text-green-400">Dalam 30 hari terakhir</p>
                    </div>

                    {{-- Transaksi Keluar --}}
                    <div class="bg-white rounded-lg shadow-md p-6 dark:bg-slate-700">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-red-700 dark:text-red-500">
                                Transaksi Keluar
                            </h2>
                            <x-heroicon-c-bars-arrow-down class="h-8 w-8 text-red-600 dark:text-red-500" />
                        </div>
                        <p class="text-3xl font-bold text-red-700 dark:text-red-500">{{ $outgoingTransaction }}</p>
                        <p class="text-xs font-medium text-red-700 mt-2 dark:text-red-500">Dalam 30 hari terakhir</p>
                    </div>
                </div>

                {{-- Grafik Stok Barang --}}
                <div class="bg-white dark:bg-slate-700 rounded-lg shadow-md p-6 mb-8 max-w-full overflow-hidden">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-4">
                        Grafik Stok Barang
                    </h2>
                    <canvas id="stockChart" class="m-auto w-full"></canvas>
                </div>

                {{-- Aktivitas Pengguna Terbaru --}}
                <div class="bg-white dark:bg-slate-700 rounded-lg shadow-md p-6">
                    <div class="flex flex-col md:flex-row items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-4 md:mb-0">
                            Aktivitas Pengguna Terbaru
                        </h2>
                        <div class="flex items-center justify-center space-x-2 md:space-x-4 w-full md:w-auto">
                            <form action="{{ route('user.activities-report') }}" method="GET">
                                <button id="generate-report" type="submit"
                                    class="bg-blue-500 text-white px-3 py-2.5 mt-2 font-medium rounded text-sm hover:bg-blue-600 transition duration-300 flex items-center justify-center">
                                    <x-tabler-file-invoice class="h-5 w-5 mr-2" />
                                    Generate Report
                                </button>
                            </form>
                        </div>
                    </div>
                    <ul>
                        @if (is_array($activities) && count($activities) > 0)
                            @foreach (array_slice($activities, 0, 3) as $activity)
                                <div class="my-2">
                                    <div class="flex items-center">
                                        <div class="flex-grow">
                                            <p class="text-sm font-medium text-blue-800 dark:text-white">{{ $activity['user_id'] }}</p>
                                            <p class="text-xs text-blue-600 font-semibold uppercase"{{ $activity['action'] }}</p>
                                        </div>
                                        <span class="text-xs italic font-semibold text-gray-500 dark:text-white">
                                            {{ \Carbon\Carbon::parse($activity['timestamp'])->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="ml-13 pl-3 border-l-4 mt-5 p-2 py-3 border-blue-500 dark:bg-slate-600">
                                        <p class="text-sm text-gray-600 dark:text-white">
                                            <spanclass="font-medium">Entity:</span> {{ $activity['entity'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-white">
                                            <span class="font-medium">Entity Name:</span> {{ $activity['entity_name'] }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-white">
                                            <span class="font-medium">Message:</span> {{ $activity['message'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </ul>
                </div>

            </div>
        </section>
    </div>

    <script type="module">
        import { generateStockChart } from '/assets/js/charts.js';
        const transactionData = {!! json_encode($transactionData) !!};
        generateStockChart(transactionData);
    </script>
@endsection
