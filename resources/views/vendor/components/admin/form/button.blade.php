@props([
    'type' => 'button',
    'form' => null,
    'class' => '',
    'style' => false,
    'href' => null,
    'target' => null,
    'rel' => null,
])

@php
    $classes = match ($style) {
        'btn-primary' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm cursor-pointer text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 dark:bg-primary-700',
        'btn-secondary' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm cursor-pointer text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-900',
        default => '',
    };
@endphp


@if($href)
    <a href="{{ $href }}" class="{{ $classes }} {{ $class }}" target="{{ $target }}" rel="{{ $rel }}">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" form="{{ $form }}" class="{{ $classes }} {{ $class }}">
        {{ $slot }}
    </button>
@endif