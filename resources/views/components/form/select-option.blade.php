@props(['placeholder' => '', 'label' => '', 'name' => '', 'required' => false, 'id' => '', 'colSpan' => ''])

<div class="col-span-2 sm:col-span-1">
    <label for="{{ $name }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'bg-gray-50 border border-gray-300 text-gray-900 dark:text-white dark:bg-gray-800 dark:border-gray-700 text-sm rounded-lg block w-full p-2.5']) }}
        {{ $required ? 'required' : '' }}>
        <option value="" readonly>{{ $placeholder }}</option>
        {{ $slot }}
    </select>
</div>
