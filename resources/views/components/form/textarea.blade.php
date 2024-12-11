@props(['placeholder' => '', 'label' => '', 'name' => '', 'required' => false, 'value' => '', 'rows' => '5'])

<div class="col-span-2 {{ $colSpan ?? 'sm:col-span-2' }}">
    <label for="{{ $name }}"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:border-0 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-100"
        {{ $required ? 'required' : '' }}>{{ $value ? $value : '' }}</textarea>
</div>
