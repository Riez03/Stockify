@props(['name' => '', 'label' => ''])

<div class="col-span-2">
    <label for="{{ $name }}"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
        <input 
            type="file" 
            name="{{ $name }}" 
            id="{{ $name }}"
            class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-opacity-10 disabled:cursor-default disabled:bg-gray-400 dark:border-form-strokedark dark:file:border-form-strokedark dark:file:text-white dark:text-white dark:border-0 dark:bg-slate-800" 
        />
</div>
