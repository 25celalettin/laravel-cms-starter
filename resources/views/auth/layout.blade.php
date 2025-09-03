<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title', 'Emlak Ajansı')</title>

    <link rel="icon" href="{{ asset('admin-assets/img/favicon.png') }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #000000 0%, #0a0a0a 25%, #1a1a1a 50%, #000000 100%);
        }
        .brand-pattern {
            background: #2980B9;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #95e8e9, #6DD5FA, #2980B9);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #95e8e9, #6DD5FA, #2980B9); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen flex">
        @yield('content')

        <div class="hidden lg:flex lg:w-1/2 gradient-bg brand-pattern">
            <div class="flex items-center justify-center w-full p-12">
                <div class="text-center text-white">
                    <div class="mb-8">
                        <h1 class="text-5xl font-bold mb-4">Emlak Ajansı</h1>
                        <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full"></div>
                        <p class="text-xl opacity-90 leading-relaxed">
                            Hayalinizdeki ev için güvenilir ortağınız
                        </p>
                    </div>
                    
                    <div class="space-y-6 text-left max-w-md mx-auto">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Uzman Danışmanlık</h3>
                                <p class="text-sm opacity-80">Deneyimli ekibimizle size özel çözümler</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Güvenilir İşlemler</h3>
                                <p class="text-sm opacity-80">%100 güvenli ve hızlı süreçler</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/>
                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Geniş Portföy</h3>
                                <p class="text-sm opacity-80">Binlerce konut seçeneği</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>
