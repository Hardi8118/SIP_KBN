@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto bg-white p-5 sm:p-7 border border-slate-200 rounded-2xl shadow-sm my-2 sm:my-4">
    <div class="text-center mb-5">
        <h2 class="text-2xl font-bold text-slate-800">Masuk ke Sistem</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Silakan masukkan NIK dan Kata Sandi Anda yang terdaftar.</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 border border-red-200 p-3 rounded-xl mb-4 text-center text-xs sm:text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3 sm:mb-4">
            <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Nomor Induk Kependudukan (NIK)</label>
            <input type="text" name="nik" value="{{ old('nik') }}" class="w-full border-slate-300 border rounded-xl p-2.5 sm:p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="16 digit NIK">
        </div>

        <div class="mb-3 sm:mb-4">
            <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Kata Sandi</label>
            <div style="position: relative; width: 100%;">
                <input type="password" id="loginPassword" name="password" style="padding-right: 42px;" class="w-full border-slate-300 border rounded-xl p-2.5 sm:p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Masukkan kata sandi">
                <button type="button" onclick="togglePasswordVisibility('loginPassword', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 4px; color: #6b7280;" title="Lihat Kata Sandi">
                    <svg class="eye-icon" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg class="eye-slash-icon" style="width: 20px; height: 20px; display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="mb-4 flex items-center justify-between text-xs sm:text-sm">
            <label class="flex items-center text-slate-600 cursor-pointer">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                <span class="ml-2">Ingat Saya</span>
            </label>
        </div>

        <div class="text-center">
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2.5 sm:py-3 rounded-xl hover:bg-blue-700 shadow transition active:scale-95 text-sm sm:text-base mb-4">Masuk</button>
        </div>
        
        <p class="text-center text-slate-500 text-xs sm:text-sm">
            Belum memiliki identitas digital? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar sekarang</a>
        </p>
    </form>
</div>

<script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const eyeIcon = btn.querySelector('.eye-icon');
        const eyeSlashIcon = btn.querySelector('.eye-slash-icon');
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.style.display = 'none';
            eyeSlashIcon.style.display = 'block';
        } else {
            input.type = 'password';
            eyeIcon.style.display = 'block';
            eyeSlashIcon.style.display = 'none';
        }
    }
</script>
@endsection
