<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman - Admin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="text-slate-800 antialiased bg-slate-50 min-h-screen flex items-center justify-center py-10 px-4">

    <div class="w-full max-w-2xl bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden transition-all hover:shadow-2xl">
        
        <div class="bg-blue-600 px-8 py-6 text-white flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-2xl backdrop-blur-sm">
                <i class="bi bi-journal-plus"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold m-0">Tambah Peminjaman</h2>
                <p class="text-blue-100 text-sm mt-1 mb-0">Catat peminjaman buku baru</p>
            </div>
        </div>

        <div class="p-8">
            <form action="store_peminjaman.php" method="POST" class="space-y-6">
                
                <!-- Input Group: User & Buku -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">ID User</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-person"></i>
                            </div>
                            <input type="number" name="user_id" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700 bg-slate-50 focus:bg-white" placeholder="Masukkan ID User" required>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">ID Buku</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-book"></i>
                            </div>
                            <input type="number" name="buku_id" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700 bg-slate-50 focus:bg-white" placeholder="Masukkan ID Buku" required>
                        </div>
                    </div>
                </div>

                <!-- Input Group: Tanggal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Tanggal Pinjam</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <input type="date" name="tanggal_pinjam" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700 bg-slate-50 focus:bg-white" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Tanggal Kembali</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <input type="date" name="tanggal_kembali" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700 bg-slate-50 focus:bg-white" required>
                        </div>
                    </div>
                </div>

                <!-- Input Group: Status -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700">Status Peminjaman</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="bi bi-info-circle"></i>
                        </div>
                        <select name="status" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700 bg-slate-50 focus:bg-white appearance-none">
                            <option value="dipinjam">Dipinjam</option>
                            <option value="dikembalikan">Dikembalikan</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="peminjaman.php" class="px-6 py-3 text-sm font-semibold text-slate-700 bg-white border-2 border-slate-200 rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all text-center">
                        <i class="bi bi-arrow-left mr-2"></i> Batal
                    </a>
                    <button type="submit" class="px-8 py-3 text-sm font-semibold text-white bg-blue-600 border-2 border-blue-600 rounded-xl hover:bg-blue-700 hover:border-blue-700 shadow-lg shadow-blue-200 transition-all flex justify-center items-center gap-2">
                        <i class="bi bi-save"></i> Simpan Peminjaman
                    </button>
                </div>
                
            </form>
        </div>
    </div>

</body>
</html>