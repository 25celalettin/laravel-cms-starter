@extends('admin.layout')

@section('title', 'Bloglar')

@section('content')
<x-admin.page-header title="Bloglar">
    <x-admin.form.button href="{{ route('admin.blogs.create') }}" style="btn-primary" class="w-full md:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Yeni Blog
    </x-admin.form.button>
</x-admin.page-header>

<x-admin.table.filters :has-filters="request()->hasAny(['search', 'status'])" action="{{ route('admin.blogs.index') }}">
    <!-- Search -->
    <div class="w-full sm:w-64">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" 
                name="search" 
                id="search" 
                value="{{ request('search') }}"
                class="appearance-none block w-full pl-9 px-3 py-1.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                placeholder="Başlık, içerik veya kullanıcı adı">
        </div>
    </div>

    <!-- Status Filter -->
    <div class="w-full sm:w-44">
            <select name="status" 
                    id="status" 
                    class="appearance-none block w-full px-3 py-1.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="">Tüm Durumlar</option>
                @foreach(['draft', 'published', 'archived'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ $statusLabels[$status] }}
                    </option>
                @endforeach
            </select>
    </div>
</x-admin.table.filters>

<x-admin.table.index
    :items="$blogs"
    :columns="['title' => 'Başlık', 'status' => 'Durum', 'created_at' => 'Oluşturulma Tarihi']"
    empty="Blog bulunamadı."
    no-results="Aramanıza uygun blog bulunamadı."
    :no-results-link="route('admin.blogs.create')"
    no-results-link-text="İlk Blogu Oluştur"
    :has-filters="request()->hasAny(['search', 'status'])"
    :has-actions="true"
>
    <x-slot name="tbody">
        @foreach($blogs as $blog)
            <tr>
                <x-admin.table.td>
                    <div class="flex items-center">
                        <img src="{{ $blog->getCoverImage() }}" alt="{{ $blog->title }}" class="h-10 w-10 rounded-lg object-cover">
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $blog->title }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $blog->user->name }}</div>
                        </div>
                    </div>
                </x-admin.table.td>
                <x-admin.table.td>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $statusLabels[$blog->status] }}</div>
                </x-admin.table.td>
                <x-admin.table.td>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $blog->created_at->format('d.m.Y H:i') }}</div>
                </x-admin.table.td>
                <x-admin.table.td class="text-right text-sm font-medium">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                            Düzenle
                        </a>
                        <button data-button-type="destroy" data-remove-url="{{ route('admin.blogs.destroy', $blog) }}" type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                            Sil
                        </button>
                    </div>
                </x-admin.table.td>
            </tr>
        @endforeach
    </x-slot>
</x-admin.table.index>
@endsection