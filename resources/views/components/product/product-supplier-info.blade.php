@props(['product' => null])

<div class="flex flex-col p-4 bg-gray-100 my-3 dark:bg-gray-800">
    <p class="text-md text-gray-600 font-semibold dark:text-white">
        {{ $product->suppliers->name }}
    </p>
    <span class="text-xs text-gray-400 dark:text-gray-200 mb-3">
        {{ 'Active ' . $product->created_at->diffForHumans() }}
    </span>
    <div class="flex flex-row items-center gap-2">
        <button
            class="inline-flex items-center px-4 py-2 bg-blue-300 bg-opacity-75 border-blue-800 border rounded-sm hover:bg-blue-400 dark:bg-blue-200 dark:hover:bg-blue-300">
            <x-tabler-message class="w-5 h-5 text-blue-800 mr-2" />
            <span class="text-blue-800 text-sm font-semibold">Chat Now</span>
        </button>
        <button
            class="inline-flex items-center px-4 py-2 bg-white border-gray-500 border rounded-sm hover:bg-gray-100 dark:hover:bg-gray-200">
            <x-heroicon-o-building-storefront class="w-5 h-5 text-gray-500 dark:text-gray-700 mr-2" />
            <span class="text-gray-500 text-sm font-semibold dark:text-gray-700">View
                Supplier</span>
        </button>
    </div>
</div>