@extends('admin.layout')

@section('title', 'Kullanıcılar')

@section('content')
<x-admin.page-header title="Kullanıcılar">
    <x-admin.form.button href="{{ route('admin.users.create') }}" style="btn-primary" class="w-full md:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Yeni Kullanıcı
    </x-admin.form.button>
</x-admin.page-header>

<x-admin.table.filters :has-filters="request()->hasAny(['search', 'role'])" action="{{ route('admin.users.index') }}">
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
                    placeholder="Ad, soyad veya e-posta">
        </div>
    </div>

    <!-- Role Filter -->
    <div class="w-full sm:w-44">
        <select name="role" 
                id="role" 
                class="appearance-none block w-full px-3 py-1.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="">Tüm Roller</option>
            @foreach(\App\Enums\UserRole::getAvailableRoles() as $role)
                <option value="{{ $role->value }}" {{ request('role') == $role->value ? 'selected' : '' }}>
                    {{ $role->label() }}
                </option>
            @endforeach
        </select>
    </div>
</x-admin.table.filters>

<x-admin.table.index
    :items="$users"
    :columns="['name' => 'Kullanıcı', 'role' => 'Rol', 'created_at' => 'Kayıt Tarihi']"
    empty="Kullanıcı bulunamadı."
    no-results="Aramanıza uygun kullanıcı bulunamadı."
    :no-results-link="route('admin.users.create')"
    no-results-link-text="İlk Kullanıcıyı Ekle"
    :has-filters="request()->hasAny(['search', 'role'])"
    :has-actions="true"
>
    <x-slot name="tbody">
        @foreach($users as $user)
            <tr>
                <x-admin.table.td>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                <span class="text-primary-600 dark:text-primary-300 font-medium text-sm">
                                    {{ implode(array_map(function($name) {
                                        return strtoupper(substr($name, 0, 1));
                                    }, explode(' ', $user->name))) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $user->name }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>
                </x-admin.table.td>
                <x-admin.table.td>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role->color() }}">
                        {{ $user->role->label() }}
                    </span>
                </x-admin.table.td>
                <x-admin.table.td class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $user->created_at->format('d.m.Y') }}
                </x-admin.table.td>
                <x-admin.table.td class="text-right text-sm font-medium">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                            Düzenle
                        </a>
                        @if($user->role->value === \App\Enums\UserRole::SUPERADMIN->value)
                            <button type="button" 
                                    disabled
                                    title="Süper admin silinemez"
                                    class="text-gray-400 dark:text-gray-600 cursor-not-allowed">
                                Sil
                            </button>
                        @else
                            <button data-button-type="destroy" data-remove-url="{{ route('admin.users.destroy', $user) }}" type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                Sil
                            </button>
                        @endif
                    </div>
                </x-admin.table.td>
            </tr>
        @endforeach
    </x-slot>
</x-admin.table.index>
@endsection