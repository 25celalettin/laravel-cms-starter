@props([
    'name',
    'label' => null,
    'value' => null,
    'error' => null,
    'class' => '',
    'required' => false,
    'options' => [],
    'form' => null,
])

<div class="{{ $class }}">
    @isset($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endisset
    <div class="relative @isset($label) mt-1 @endisset">
        <select name="{{ $name }}" 
                id="{{ $name }}" 
                @if($form) form="{{ $form }}" @endif
                @if($required) required @endif
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error($name) border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
            @foreach($options as $option)
                <option value="{{ $option['value'] }}" {{ old($name, $value) === $option['value'] ? 'selected' : '' }}>
                    {{ $option['label'] }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>
    @error($name)
    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div>