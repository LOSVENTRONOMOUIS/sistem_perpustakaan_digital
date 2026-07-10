<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Baca buku_id dari URL (dikirim dari landing page saat klik Pinjam sebelum login)
$buku_id_from_url = isset($_GET['buku_id']) ? (int)$_GET['buku_id'] : 0;
// Jika ada redirect parameter, simpan ke session untuk digunakan setelah login
if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    $_SESSION['redirect_after_login'] = urldecode($_GET['redirect']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
            <!-- Card Header -->
            <div class="bg-blue-600 px-6 py-8 text-center">
                <h3 class="text-2xl font-bold text-white tracking-wide">Login Perpustakaan</h3>
                <p class="text-blue-100 mt-2 text-sm">Masuk untuk mengelola dan meminjam buku</p>
            </div>
            
            <!-- Card Body -->
            <div class="p-8">
                <form action="login_proses.php" method="POST" class="space-y-6">
                    
                    <?php if ($buku_id_from_url > 0): ?>
                    <input type="hidden" name="buku_id" value="<?= $buku_id_from_url ?>">
                    <?php endif; ?>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700 placeholder-slate-400"
                            placeholder="Masukkan email Anda"
                            required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700 placeholder-slate-400"
                            placeholder="Masukkan password"
                            required>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 active:scale-[0.98]">
                        Login
                    </button>
                    
                </form>
            </div>
            
        </div>
        
        <!-- Footer Info -->
        <p class="text-center text-slate-500 text-sm mt-8">
            &copy; 2026 Sistem Perpustakaan Digital
        </p>
    </div>

</body>
</html>