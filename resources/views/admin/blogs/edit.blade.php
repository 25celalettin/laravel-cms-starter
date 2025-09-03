@extends('admin.layout')

@section('title', 'Blog Düzenle')

@section('content')
<x-admin.page-header title="Blog Düzenle">
    <x-admin.form.button href="{{ route('admin.blogs.index') }}" style="btn-secondary" class="w-full md:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
        </svg>
        Geri Dön
    </x-admin.form.button>
</x-admin.page-header>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="col-span-2">

        <x-admin.card>
            <x-slot:content>
                <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" id="blog-edit-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
        
                    <x-admin.form.input name="title" label="Başlık" class="mb-6" value="{{ $blog->title }}" required />
                    <x-admin.form.input name="slug" label="Slug" class="mb-6" value="{{ $blog->slug }}" note="Boş bırakırsanız otomatik olarak oluşturulur." />
                    <x-admin.form.textarea name="content" label="İçerik" value="{{ $blog->content }}" required />
                </form>
            </x-slot:content>
            <x-slot:footer>
                <x-admin.form.button type="submit" style="btn-primary" class="w-full md:w-auto" form="blog-edit-form">
                    Blogu Güncelle
                </x-admin.form.button>
            </x-slot:footer>
        </x-admin.card>
    </div>
    <div class="col-span-1">
        <x-admin.card>
            <x-slot:content>
                <x-admin.form.select name="status" label="Durum" class="mb-6" value="{{ $blog->status }}" :options="$statuses" required form="blog-edit-form" />
                    {{-- Blog Image --}}
                    <div class="mb-6 space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Kapak Resmi
                        </label>
                        <div class="space-y-4">
                            <div class="relative">
                                <div class="w-full h-40 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 group">
                                    <input type="file" 
                                           name="image" 
                                           id="image" 
                                           accept="image/*"
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                           onchange="previewImage(this)"
                                           form="blog-edit-form">
                                    
                                    <div class="h-full flex flex-col items-center justify-center text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="mb-6 space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Mevcut Resim
                        </label>
                        <div class="relative">
                            <img id="preview" class="w-full object-contain rounded-lg shadow-lg" src="{{ $blog->getCoverImage() }}" alt="Mevcut Resim">
                        </div>
                    </div>
        
                    <script>
                        function previewImage(input) {
                            const preview = document.getElementById('preview');
                            const previewContainer = document.getElementById('preview-container');
                            const uploadText = document.getElementById('upload-text');
        
                            if (input.files && input.files[0]) {
                                const reader = new FileReader();
                                
                                reader.onload = function(e) {
                                    preview.src = e.target.result;
                                    previewContainer.classList.remove('hidden');
                                    uploadText.textContent = 'Resmi değiştir';
                                }
                                
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
        
                        function removeImage() {
                            const input = document.getElementById('image');
                            const preview = document.getElementById('preview');
                            const previewContainer = document.getElementById('preview-container');
                            const uploadText = document.getElementById('upload-text');
        
                            input.value = '';
                            preview.src = '';
                            previewContainer.classList.add('hidden');
                            uploadText.textContent = 'Resim yüklemek için tıklayın';
                        }
                    </script>
            </x-slot:content>
        </x-admin.card>
    </div>
</div>


@endsection