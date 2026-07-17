<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - SmartCatalog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-[2rem] shadow-xl w-full max-w-md border border-slate-100">
        <h1 class="text-2xl font-black text-center text-slate-800 tracking-tight">Register Account</h1>
        <p class="text-center text-slate-400 text-sm mb-8 font-medium">Buat akun Merchant Resmi Anda</p>

        @if($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-600 p-4 rounded-2xl text-xs mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1 ml-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1 ml-1">Email Bisnis</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1 ml-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                <p class="text-[10px] text-slate-400 mt-2 ml-1 leading-relaxed italic">
                    * Minimal 8 karakter, harus mengandung huruf besar, huruf kecil, angka, dan simbol khusus.
                </p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1 ml-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 mt-4 uppercase tracking-widest text-xs">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center mt-8 text-sm text-slate-500 font-medium">
            Sudah terdaftar? <a href="{{ url('/login') }}" class="text-indigo-600 font-bold hover:underline">Masuk di sini</a>
        </p>
    </div>
</body>
</html>