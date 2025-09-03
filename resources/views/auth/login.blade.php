@extends('auth.layout')

@section('title', 'Giriş Yap - Emlak Ajansı')

@section('content')
<!-- Sol Taraf - Form -->
<div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white rounded-xl shadow-xl p-8 border border-gray-100">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Hoş Geldiniz</h2>
                <p class="text-gray-600 mt-2">Hesabınıza giriş yapın</p>
            </div>

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <p class="text-sm text-center">{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('auth.login') }}" method="POST" class="space-y-6">
                @csrf

                @if(request()->get('redirect_to'))
                    <input type="hidden" name="redirect_to" value="{{ request()->get('redirect_to') }}">
                @endif

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-posta Adresi</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}"
                           required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm transition-all duration-200"
                           placeholder="ornek@email.com">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Şifre</label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm transition-all duration-200"
                           placeholder="••••••••">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="remember" 
                               id="remember" 
                               {{ old('remember') ? 'checked' : '' }}
                               class="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Beni Hatırla</label>
                    </div>

                    @if(Route::has('auth.forgot-password'))
                        <a href="{{ route('auth.forgot-password') }}" 
                           class="text-sm text-purple-600 hover:text-purple-500 transition-colors duration-200">
                            Şifremi Unuttum
                        </a>
                    @endif
                </div>

                <div>
                    <button type="submit" 
                            class="w-full py-3 px-4 rounded-lg shadow-lg text-white font-medium bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        Giriş Yap
                    </button>
                </div>
            </form>

            @if(Route::has('auth.register'))
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        Hesabınız yok mu?
                        <a href="{{ route('auth.register') }}" class="font-medium text-purple-600 hover:text-purple-500 transition-colors duration-200">
                            Kayıt Ol
                        </a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
