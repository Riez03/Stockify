@props(['required' => false, 'name' => '', 'label' => '', 'placeholder' => '', 'type' => 'text', 'value' => '', 'disabled' => false, 'colSpan' => ''])

<div {{ $attributes->merge(['class' => $colSpan]) }}>
    <label for="{{ $name }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <input 
        type="{{ $type }}" value="{{ $value }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:placeholder:text-slate-200 dark:bg-slate-800 dark:text-white dark:border-slate-800 {{ $disabled ? 'bg-slate-200' : '' }}"
        {{ $required ? 'required' : '' }} 
        {{ $disabled ? 'disabled' : '' }} 
        />
</div>
