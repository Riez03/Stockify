<h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
    {{ $product->name }}
</h1>
<div class="mt-4 sm:items-center sm:gap-4 sm:flex">
    <p class="text-2xl font-bold text-gray-900 sm:text-3xl dark:text-white">
        {{ Number::currency($product->selling_price, 'IDR') }}
    </p>
</div>
<div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
    <button
        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
        <x-heroicon-o-heart class="w-5 h-5 mx-1 mr-2" />
        Add to favorites
    </button>
    <button
        class="text-white mt-4 sm:mt-0 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 flex items-center justify-center">
        <x-tabler-shopping-cart-plus class="w-5 h-5 mx-1 mr-2" />
        Add to cart
    </button>
</div>