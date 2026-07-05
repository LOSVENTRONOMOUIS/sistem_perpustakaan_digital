<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased py-10 px-4">

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-10">
        
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-xl">
                <i class="bi bi-journal-plus"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Tambah Buku Baru</h2>
                <p class="text-slate-500 text-sm mt-1">Lengkapi data buku di bawah ini</p>
            </div>
        </div>

        <form action="buku.php?action=store" method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Buku</label>
                <input type="text" name="judul" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700" placeholder="Masukkan judul buku" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penulis</label>
                    <input type="text" name="penulis" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700" placeholder="Nama penulis" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penerbit</label>
                    <input type="text" name="penerbit" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700" placeholder="Nama penerbit" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Terbit</label>
                    <input type="number" name="tahun" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700" placeholder="YYYY" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700 bg-white" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php if(isset($kategori)): foreach($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Buku</label>
                    <input type="number" name="stok" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700" placeholder="0" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Buku (Rp)</label>
                    <input type="number" name="harga" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700" placeholder="Contoh: 150000" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Cover Buku <span class="font-normal text-slate-400">(Opsional)</span></label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:border-blue-400 transition-colors bg-slate-50">
                    <div class="space-y-1 text-center">
                        <i class="bi bi-image text-4xl text-slate-400"></i>
                        <div class="flex text-sm text-slate-600 justify-center">
                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                <span>Upload a file</span>
                                <input name="cover" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-slate-500">PNG, JPG up to 2MB</p>
                    </div>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3 justify-end">
                <a href="buku.php" class="inline-flex justify-center items-center px-6 py-3 border border-slate-300 shadow-sm text-sm font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>