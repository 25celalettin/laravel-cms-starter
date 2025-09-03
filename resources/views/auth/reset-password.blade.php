@extends('auth.layout')

@section('title', 'Şifre Sıfırla - Emlak Ajansı')

@section('content')
<!-- Sol Taraf - Form -->
<div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white rounded-xl shadow-xl p-8 border border-gray-100">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Yeni Şifre Oluştur</h2>
                <p class="text-gray-600 mt-2">Güvenli bir şifre seçin</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-posta Adresi</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $email) }}"
                           readonly
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Yeni Şifre</label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm transition-all duration-200"
                           placeholder="••••••••">
                    <p class="mt-2 text-sm text-gray-500">
                        Şifreniz en az 8 karakter uzunluğunda olmalıdır.
                    </p>
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Şifre Tekrarı</label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm transition-all duration-200"
                           placeholder="••••••••">
                </div>

                <div>
                    <button type="submit" 
                            class="w-full py-3 px-4 rounded-lg shadow-lg text-white font-medium bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        Şifremi Sıfırla
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Şifrenizi hatırladınız mı?
                    <a href="{{ route('auth.login') }}" class="font-medium text-purple-600 hover:text-purple-500 transition-colors duration-200">
                        Giriş Yap
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
