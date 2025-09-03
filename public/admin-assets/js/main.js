$(document).ready(function() {
    initTheme();
    
    $('.toggle-theme').click(toggleTheme);

    // Flash mesajlarını kapatma
    $('.flash-close').click(function() {
        let flashMessage = $(this).closest('.flash-message');
        flashMessage.animate({
            opacity: 0,
            marginTop: '-20px'
        }, 200, function() {
            $(this).remove();
        });
    });

    let isSidebarOpen = false;

    function toggleSidebar() {
        if (isSidebarOpen) {
            $('.sidebar-overlay').addClass('hidden');
            $('.sidebar-overlay').removeClass('block');
            $('aside').addClass('-translate-x-full');
            $('aside').removeClass('translate-x-0');
        }
        else {
            $('.sidebar-overlay').removeClass('hidden');
            $('.sidebar-overlay').addClass('block');
            $('aside').removeClass('-translate-x-full');
            $('aside').addClass('translate-x-0');
        }

        isSidebarOpen = !isSidebarOpen;
    }

    $('.sidebar-toggle').click(toggleSidebar);

    $('.sidebar-overlay').click(toggleSidebar);

    // Dil değiştirme
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Dropdown'ları açıp kapatan fonksiyon
    function toggleDropdown(dropdown) {
        if (dropdown.hasClass('hidden')) {
            // Diğer açık dropdown'ları kapat
            $('.language-dropdown, .profile-dropdown').not(dropdown).each(function() {
                $(this).addClass('opacity-0');
                setTimeout(() => $(this).addClass('hidden'), 200);
            });
            
            // Seçilen dropdown'ı aç
            dropdown.removeClass('hidden');
            setTimeout(() => dropdown.removeClass('opacity-0'), 0);
        } else {
            // Seçilen dropdown'ı kapat
            dropdown.addClass('opacity-0');
            setTimeout(() => dropdown.addClass('hidden'), 200);
        }
    }

    // Dil değiştirme dropdown'ı
    $('.language-dropdown-toggle').click(function(e) {
        e.stopPropagation();
        toggleDropdown($('.language-dropdown'));
    });

    $('.language-option').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        let selectedLang = $(this).data('lang');
        
        $.ajax({
            url: '/language/change',
            type: 'POST',
            data: {
                language: selectedLang,
                _token: csrfToken
            },
            success: function() {
                location.reload();
            }
        });
    });

    // Profil dropdown'ı
    $('.profile-dropdown-toggle').click(function(e) {
        e.stopPropagation();
        toggleDropdown($('.profile-dropdown'));
    });

    // Dropdown menülerin içine tıklandığında kapanmasını engelle
    $('.language-dropdown, .profile-dropdown').click(function(e) {
        e.stopPropagation();
    });

    // Sayfa herhangi bir yerine tıklandığında dropdown'ları kapat
    $(document).click(function() {
        $('.language-dropdown, .profile-dropdown').each(function() {
            let dropdown = $(this);
            if (!dropdown.hasClass('hidden')) {
                dropdown.addClass('opacity-0');
                setTimeout(() => dropdown.addClass('hidden'), 200);
            }
        });
    });

    // remove button
    $('button[data-button-type="destroy"]').click(function() {
        let removeUrl = $(this).data('remove-url');

        if (!removeUrl) return;

        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        Swal.fire({
            title: 'Silmek istediğinize emin misiniz?',
            text: 'Bu işlem geri alınamaz.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, sil',
            cancelButtonText: 'İptal',
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: removeUrl,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Başarılı',
                            text: response?.message || 'Silindi',
                            icon: 'success',
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    },
                    error: function(response) {
                        Swal.fire({
                            title: 'Hata',
                            text: response.responseJSON.message || 'Silinirken bir hata oluştu',
                            icon: 'error',
                        });
                    }
                });
            }
        });
    });
});

// Tema ile ilgili fonksiyonlar
function initTheme() {
    const currentTheme = localStorage.getItem('theme') || 'light';
    setTheme(currentTheme);
}

function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    setTheme(newTheme);
}

function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    document.documentElement.classList.toggle('dark', theme === 'dark');
    localStorage.setItem('theme', theme);
    updateThemeIcons(theme);
}

function updateThemeIcons(theme) {
    if (theme === 'dark') {
        $('.light-icon').css('display', 'none');
        $('.dark-icon').css('display', 'block');
    }
    else {
        $('.light-icon').css('display', 'block');
        $('.dark-icon').css('display', 'none');
    }
}