@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto bg-white p-5 sm:p-7 border border-slate-200 rounded-2xl shadow-sm my-2 sm:my-4">
    <div class="text-center mb-5">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-800">Registrasi Identitas Digital</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Lengkapi data kependudukan berikut untuk membuat akun layanan administrasi.</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 border border-red-200 p-3 rounded-xl mb-4 text-xs sm:text-sm">
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mb-3">
            <div>
                <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Nomor Induk Kependudukan (NIK)</label>
                <input type="text" name="nik" value="{{ old('nik') }}" class="w-full border-slate-300 border rounded-xl p-2.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required maxlength="16" placeholder="16 digit NIK">
            </div>
            <div>
                <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Nomor Kartu Keluarga (No. KK)</label>
                <input type="text" name="no_kk" value="{{ old('no_kk') }}" class="w-full border-slate-300 border rounded-xl p-2.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required maxlength="16" placeholder="16 digit No. KK">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mb-3">
            <div>
                <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full border-slate-300 border rounded-xl p-2.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Nama lengkap sesuai KTP">
            </div>
            <div>
                <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border-slate-300 border rounded-xl p-2.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mb-3">
            <div>
                <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border-slate-300 border rounded-xl p-2.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Kota kelahiran">
            </div>
            <div>
                <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border-slate-300 border rounded-xl p-2.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mb-3">
            <div>
                <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Agama</label>
                <select name="agama" class="w-full border-slate-300 border rounded-xl p-2.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" required>
                    <option value="">Pilih Agama</option>
                    @foreach(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agm)
                        <option value="{{ $agm }}" {{ old('agama') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="w-full border-slate-300 border rounded-xl p-2.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Contoh: Wiraswasta, Buruh, Karyawan">
            </div>
        </div>

        <div class="mb-3">
            <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Alamat Lengkap</label>
            <input type="text" name="alamat" value="{{ old('alamat') }}" class="w-full border-slate-300 border rounded-xl p-2.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Jalan, RT/RW, No. Rumah">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mb-4">
            <div>
                <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Kata Sandi</label>
                <div style="position: relative; width: 100%;">
                    <input type="password" id="regPassword" name="password" style="padding-right: 42px;" class="w-full border-slate-300 border rounded-xl p-2.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Minimal 6 karakter">
                    <button type="button" onclick="togglePasswordVisibility('regPassword', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 4px; color: #6b7280;" title="Lihat Kata Sandi">
                        <svg class="eye-icon" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-slash-icon" style="width: 18px; height: 18px; display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Konfirmasi Kata Sandi</label>
                <div style="position: relative; width: 100%;">
                    <input type="password" id="regPasswordConfirm" name="password_confirmation" style="padding-right: 42px;" class="w-full border-slate-300 border rounded-xl p-2.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Ulangi kata sandi">
                    <button type="button" onclick="togglePasswordVisibility('regPasswordConfirm', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 4px; color: #6b7280;" title="Lihat Kata Sandi">
                        <svg class="eye-icon" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-slash-icon" style="width: 18px; height: 18px; display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between border-t border-slate-100 pt-4 mt-2 gap-3 text-xs sm:text-sm">
            <span class="text-slate-500 text-center sm:text-left">Sudah memiliki identitas digital? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk di sini</a></span>
            <button type="submit" class="w-full sm:w-auto bg-green-600 text-white font-bold py-2.5 px-6 rounded-xl hover:bg-green-700 shadow transition active:scale-95">Daftarkan Akun</button>
        </div>
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
