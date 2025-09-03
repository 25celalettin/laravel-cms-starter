@props([
    'name',
    'label' => null,
    'value' => null,
    'error' => null,
    'class' => '',
    'type' => 'text',
    'required' => false,
    'note' => null,
    'accept' => null,
    'step' => null,
    'placeholder' => null,
])

<div class="{{ $class }}">
    @isset($label)
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endisset
    @isset($note)
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $note }}</p>
    @endisset
    <div class="@isset($label) mt-1 @endisset">
        <input type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ old($name, $value) }}"
        @if($accept) accept="{{ $accept }}" @endif
        @if($step) step="{{ $step }}" @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error($name) border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
    </div>
    @error($name)
    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div>