@props([
    'title' => '',
])

<div class="flex items-center justify-between flex-col md:flex-row mb-4">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $title }}</h1>
    
    <div class="flex flex-col md:flex-row gap-2">
        {{ $slot }}
    </div>
</div>