<div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg divide-y divide-gray-200 dark:divide-gray-700 mb-5">
    @isset($content)
    <div class="px-4 py-5 sm:p-6 @isset($class) {{ $class }} @endisset">
        {{ $content }}
    </div>
    @endisset


    @isset($footer)
    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 sm:px-6">
        {{ $footer }}
    </div>
    @endisset
</div>