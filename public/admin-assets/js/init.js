tailwind.config = {
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                    950: '#082f49',
                },
                secondary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                    950: '#082f49',
                }
            }
        }
    }
}

// localStorage'den tema tercihini al
let theme = localStorage.getItem('theme');

// Eğer localStorage'de tema tercihi yoksa sistem tercihini kontrol et
if (!theme) {
    // Sistem dark mode kullanıyorsa
    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        theme = 'dark';
    }
    else {
        theme = 'light';
    }
}

// Temayı uygula
document.documentElement.classList.toggle('dark', theme === 'dark');
document.documentElement.setAttribute('data-theme', theme);

// Sistem teması değiştiğinde otomatik güncelle (localStorage'de tema tercihi yoksa)
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    if (!localStorage.getItem('theme')) {
        document.documentElement.classList.toggle('dark', e.matches);
        document.documentElement.setAttribute('data-theme', e.matches ? 'dark' : 'light');
    }
});