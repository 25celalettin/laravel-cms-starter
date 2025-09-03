@extends('admin.layout')

@section('title', 'Ayarlar')

@section('content')
<div class="">
    <div class="flex justify-between items-center h-[38px] mb-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Ayarlar</h1>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="group" value="{{ $groupName }}">
        
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-2" aria-label="Tabs" role="tablist">
                    @foreach($groups as $key => $title)
                        <a href="{{ route('admin.settings.index', ['group' => $key]) }}"
                            type="button"
                            class="px-4 py-3 text-sm font-medium border-b-2 {{ $groupName == $key ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}"
                            data-bs-toggle="tab" 
                            href="#{{ $key }}" 
                            role="tab"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        >
                            {{ $title }}
                        </a>
                    @endforeach
                </nav>
            </div>
            
            <div class="p-6">
                <div class="tab-content">
                    <div class="tab-pane block" 
                            id="{{ $groupName }}" 
                            role="tabpanel">
                        
                        @foreach($settings as $setting)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $setting->title }}
                                    @if($setting->description)
                                        <span class="block text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $setting->description }}</span>
                                    @endif
                                </label>

                                @switch($setting->type)
                                    @case('textarea')
                                        <div class="mt-1">
                                            <textarea class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                                                name="{{ $setting->key }}" 
                                                rows="3">{{ old($setting->key, $setting->value) }}</textarea>
                                        </div>
                                        @break

                                    @case('image')
                                        <div class="mt-2 mb-4">
                                            @if($setting->value)
                                                <img src="{{ asset($setting->value) }}" 
                                                        class="h-24 w-auto object-contain rounded-lg border border-gray-200 dark:border-gray-700" 
                                                        alt="Preview">
                                            @endif
                                        </div>
                                        <div class="mt-1">
                                            <input type="file" 
                                                class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                        file:mr-4 file:py-2 file:px-4
                                                        file:rounded-md file:border-0
                                                        file:text-sm file:font-medium
                                                        file:bg-primary-50 file:text-primary-700
                                                        dark:file:bg-primary-900 dark:file:text-primary-400
                                                        hover:file:bg-primary-100 dark:hover:file:bg-primary-800" 
                                                name="{{ $setting->key }}" 
                                                accept="image/*">
                                        </div>
                                        @break

                                    @default
                                        <div class="mt-1">
                                            <input type="{{ $setting->type }}" 
                                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                                                name="{{ $setting->key }}" 
                                                value="{{ old($setting->key, $setting->value) }}">
                                        </div>
                                @endswitch
                            </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900">
                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Ayarları Kaydet
                </button>
            </div>
        </div>
    </form>

</div>
@endsection