@props([
    'hasFilters' => false,
    'hasActions' => false,
    'columns' => [],
    'items' => [],
    'noResults' => null,
    'noResultsLink' => null,
    'noResultsLinkText' => 'Yeni Ekle',
    'empty' => null,
    'actionEditRoute' => null,
    'actionEditText' => 'Düzenle',
    'actionDeleteRoute' => null,
    'actionDeleteText' => 'Sil',
])

<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 dark:border-gray-700 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            @foreach($columns as $key => $column)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ $column }}
                            </th>
                            @endforeach
                            @if($hasActions)
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">İşlemler</span>
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @if(isset($tbody))
                            {{ $tbody }}
                        @else
                            @foreach($items as $item)
                                <tr>
                                    @foreach($columns as $key => $column)
                                        <x-admin.table.td>{{ $item->$key }}</x-admin.table.td>
                                    @endforeach

                                    @if($hasActions)
                                    <x-admin.table.td class="text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-3">
                                            <a href="{{ $actionEditRoute ? route($actionEditRoute, $item) : '#' }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                                {{ $actionEditText }}
                                            </a>

                                            <button data-button-type="destroy" data-remove-url="{{ $actionDeleteRoute ? route($actionDeleteRoute, $item) : null }}" type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" >
                                                {{ $actionDeleteText }}
                                            </button>
                                        </div>
                                    </x-admin.table.td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif

                        @if(count($items) == 0)
                            <tr>
                                <td colspan="{{ $hasActions ? count($columns) + 1 : count($columns) }}" class="px-6 py-10 whitespace-nowrap">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400 text-base mb-1">
                                            @if($hasFilters)
                                                {{ $noResults ?? 'Aramanıza uygun sonuç bulunamadı.' }}
                                            @else
                                                {{ $empty ?? 'Hiç kayıt bulunamadı.' }}
                                            @endif
                                        </p>
                                        @if(!$hasFilters)
                                            <a href="{{ $noResultsLink ?? '#' }}" 
                                                class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                {{ $noResultsLinkText }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if ($items instanceof \Illuminate\Pagination\LengthAwarePaginator || $items instanceof \Illuminate\Pagination\Paginator)
    <div class="mt-4">
        {{ $items->links() }}
    </div>
@endif