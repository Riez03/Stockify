@props(['product' => null])

<div class="flex items-start my-3">
    <p class="text-md text-gray-600 font-medium dark:text-white w-32">Purchase Price &raquo;</p>
    <span class="font-medium text-base text-gray-600">
        {{ Number::currency($product->selling_price, 'IDR') }}
    </span>
</div>

<div class="flex items-start my-3">
    <p class="text-md text-gray-600 font-medium dark:text-white w-40">Stock Keeping Unit &raquo;</p>
    <span class="font-medium text-base text-gray-600">
        {{ $product->sku }}
    </span>
</div>

<div class="flex flex-col items-start space-y-2 my-3">
    <span class="text-md text-gray-600 font-medium dark:text-white">Category:</span>
    <div class="inline-block mb-3 px-3 py-1 text-justify bg-green-300 border-green-700 border rounded-md">
        <p class="text-green-700 text-sm font-semibold dark:text-green-800 first-letter:uppercase">
            {{ $product->categories->name }}
        </p>
    </div>
</div>

<div class="flex flex-col items-start space-y-2 my-3">
    <span class="text-md text-gray-600 font-medium dark:text-white">Description:</span>
    <p class="mb-6 text-gray-500 dark:text-gray-400">
        {{ $product->description }}
    </p>
</div>
