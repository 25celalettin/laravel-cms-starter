@props([
    'name',
    'label' => null,
    'accept' => 'image/*',
    'maxSize' => '10MB',
    'acceptedTypes' => 'PNG, JPG, GIF',
    'class' => '',
    'required' => false,
    'multiple' => false,
    'placeholder' => null,
    'currentImage' => null
])

<div class="{{ $class }}">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        <input type="file" 
               name="{{ $multiple ? $name.'[]' : $name }}" 
               id="{{ $name }}" 
               accept="{{ $accept }}"
               {{ $required ? 'required' : '' }}
               {{ $multiple ? 'multiple' : '' }}
               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
        
        <div class="flex items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500">
                        {{ $placeholder ?? ($multiple ? 'Dosyaları seçin veya sürükleyip bırakın' : 'Dosya seçin veya sürükleyip bırakın') }}
                    </span>
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                    {{ $acceptedTypes }} maksimum {{ $maxSize }}
                </p>
            </div>
        </div>
    </div>
    
    <div id="preview-{{ $name }}" class="mt-3 {{ $currentImage ? '' : 'hidden' }}">
        @if($multiple)
            <div id="preview-files-{{ $name }}" class="space-y-2">
                @if($currentImage)
                    <div class="flex items-center p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <img src="{{ $currentImage }}" alt="Mevcut resim" class="w-12 h-12 object-cover rounded mr-3" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Mevcut resim</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Yeni resim seçildiğinde değişecek</p>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <img id="preview-img-{{ $name }}" src="{{ $currentImage ?? '' }}" alt="Önizleme" class="max-w-xs rounded-lg shadow-sm" />
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('{{ $name }}');
    const previewContainer = document.getElementById('preview-{{ $name }}');
    const previewImg = document.getElementById('preview-img-{{ $name }}');
    const dropZone = fileInput.parentElement.querySelector('div');
    
    // Maksimum dosya boyutunu MB cinsinden hesapla
    const maxSizeMB = parseInt('{{ $maxSize }}'.replace('MB', ''));
    const maxSizeBytes = maxSizeMB * 1024 * 1024;

    // Dosya seçildiğinde önizleme göster
    fileInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files.length > 0) {
            // Çoklu dosya kontrolü
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                // Dosya boyutu kontrolü
                if (file.size > maxSizeBytes) {
                    alert(`"${file.name}" dosyası ${maxSizeMB}MB'dan büyük olamaz!`);
                    fileInput.value = '';
                    return;
                }

                // Dosya türü kontrolü (sadece image/* için)
                if ('{{ $accept }}'.includes('image/*') && !file.type.startsWith('image/')) {
                    alert(`"${file.name}" geçerli bir resim dosyası değil!`);
                    fileInput.value = '';
                    return;
                }
            }

            // Önizleme göster
            if ('{{ $multiple }}' === 'true') {
                // Çoklu dosya önizleme
                const previewFilesContainer = document.getElementById('preview-files-{{ $name }}');
                previewFilesContainer.innerHTML = '';
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileElement = document.createElement('div');
                    fileElement.className = 'flex items-center p-3 bg-gray-100 dark:bg-gray-700 rounded-lg';
                    
                    if (file.type.startsWith('image/')) {
                        // Resim dosyası için önizleme
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            fileElement.innerHTML = `
                                <img src="${e.target.result}" alt="${file.name}" class="w-12 h-12 object-cover rounded mr-3" />
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${file.name}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                                </div>
                            `;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        // Resim olmayan dosyalar için dosya adını göster
                        fileElement.innerHTML = `
                            <svg class="h-8 w-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${file.name}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                            </div>
                        `;
                    }
                    
                    previewFilesContainer.appendChild(fileElement);
                }
                
                previewContainer.classList.remove('hidden');
            } else {
                // Tek dosya önizleme
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Resim olmayan dosyalar için dosya adını göster
                    previewContainer.innerHTML = `
                        <div class="flex items-center p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <svg class="h-8 w-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${file.name}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                            </div>
                        </div>
                    `;
                    previewContainer.classList.remove('hidden');
                }
            }
        }
    });

    // Drag & Drop fonksiyonalitesi
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });
});
</script> 