@extends('admin.layout')

@section('title', 'Yeni Mağaza')

@section('content')
<x-admin.page-header title="Yeni Mağaza">
    <x-admin.form.button href="{{ route('admin.users.index') }}" style="btn-secondary" class="w-full md:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
        </svg>
        Geri Dön
    </x-admin.form.button>
</x-admin.page-header>

<x-admin.card>
    <x-slot:content>
        <form action="{{ route('admin.users.store') }}" method="POST" id="user-create-form">
            @csrf

            <!-- Mağaza Adı -->
            <x-admin.form.input name="name" label="Adı Soyadı" class="mb-6" required />

            <div class="grid grid-cols-2 gap-4">
                <!-- E-posta -->
                <x-admin.form.input name="email" label="E-posta" class="mb-6" required />

                <!-- Telefon -->
                <x-admin.form.input name="phone" label="Telefon" class="mb-6" />
            </div>

            <!-- Rol -->
            <x-admin.form.select name="role" label="Rol" class="mb-6" :options="array_map(fn($role) => ['value' => $role->value, 'label' => $role->label()], $roles)" required />

            <div class="grid grid-cols-2 gap-4">
                <!-- Şifre -->
                <x-admin.form.input name="password" label="Şifre" type="password" required />

                <!-- Şifre Tekrar -->
                <x-admin.form.input name="password_confirmation" label="Şifre Tekrar" type="password" required />
            </div>
        </form>
        
    </x-slot:content>
    <x-slot:footer>
        <button type="submit" form="user-create-form" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900">
            Kullanıcı Oluştur
        </button>
    </x-slot:footer>
</x-admin.card>
@endsection 