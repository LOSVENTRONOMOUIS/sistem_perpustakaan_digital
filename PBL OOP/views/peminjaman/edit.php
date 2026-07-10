<?php
// =========================
// views/peminjaman/edit.php
// =========================
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peminjaman - Admin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="text-slate-800 antialiased bg-slate-50 min-h-screen flex items-center justify-center py-10 px-4">

    <div class="w-full max-w-2xl bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden transition-all hover:shadow-2xl">
        
        <div class="bg-yellow-500 px-8 py-6 text-white flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-2xl backdrop-blur-sm">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold m-0 text-white">Edit Peminjaman</h2>
                <p class="text-yellow-100 text-sm mt-1 mb-0">Perbarui data peminjaman buku</p>
            </div>
        </div>

        <div class="p-8">
            <form action="peminjaman.php?action=update" method="POST" class="space-y-6">
                
                <input type="hidden" name="id" value="<?= htmlspecialchars($pinjam['id']) ?>">

                <!-- Input Group: Nama -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700">Nama Peminjam</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="bi bi-person"></i>
                        </div>
                        <input type="text" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 transition-all text-slate-500 bg-slate-100 cursor-not-allowed" value="<?= htmlspecialchars($pinjam['nama'] ?? '') ?>" readonly>
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
                            <input type="date" name="tanggal_pinjam" value="<?= $pinjam['tanggal_pinjam'] ?>" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all text-slate-700 bg-slate-50 focus:bg-white" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Tanggal Kembali</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <input type="date" name="tanggal_kembali" value="<?= $pinjam['tanggal_kembali'] ?>" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all text-slate-700 bg-slate-50 focus:bg-white" required>
                        </div>
                    </div>
                </div>

                <!-- Input Group: Status & Kondisi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Status Peminjaman</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <select name="status" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all text-slate-700 bg-slate-50 focus:bg-white appearance-none">
                                <option value="dipinjam" <?= ($pinjam['status'] == 'dipinjam') ? 'selected' : '' ?>>Sedang Dipinjam</option>
                                <option value="dikembalikan" <?= ($pinjam['status'] == 'dikembalikan') ? 'selected' : '' ?>>Sudah Dikembalikan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Kondisi Buku (Saat Kembali)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-book"></i>
                            </div>
                            <select name="kondisi_buku" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all text-slate-700 bg-slate-50 focus:bg-white appearance-none">
                                <option value="baik" <?= (($pinjam['kondisi_buku'] ?? 'baik') == 'baik') ? 'selected' : '' ?>>Baik</option>
                                <option value="rusak" <?= (($pinjam['kondisi_buku'] ?? '') == 'rusak') ? 'selected' : '' ?>>Rusak (Denda Sesuai Harga Buku)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Denda (Jika Terlambat / Ada Denda) -->
                <?php if (isset($is_late) && ($is_late || !empty($denda))) : ?>
                <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <h4 class="text-red-700 font-semibold flex items-center gap-2 mb-2">
                        <i class="bi bi-exclamation-triangle"></i> Informasi Denda Keterlambatan
                    </h4>
                    <p class="text-sm text-red-600 mb-4">Peminjaman ini terdeteksi terlambat.</p>
                    
                    <?php if (!empty($denda)) : ?>
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <div class="bg-white px-4 py-3 rounded-lg border border-red-100 flex-1 w-full shadow-sm">
                                <span class="block text-xs text-slate-500 mb-2">Status Denda</span>
                                <div class="flex items-center gap-2" id="dendaStatusWrapper">
                                    <select 
                                        id="dendaStatusSelect"
                                        class="w-full px-3 py-2 rounded-lg border-2 font-bold text-sm transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-yellow-500 appearance-none
                                        <?php if($denda['status'] == 'lunas'): ?> bg-emerald-50 border-emerald-300 text-emerald-700
                                        <?php elseif($denda['status'] == 'pending'): ?> bg-amber-50 border-amber-300 text-amber-700
                                        <?php else: ?> bg-red-50 border-red-300 text-red-700
                                        <?php endif; ?>"
                                        data-denda-id="<?= $denda['id'] ?>"
                                        onchange="updateDendaStatusEdit(this)"
                                        style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 16 16%27%3E%3Cpath fill=%27%2364748b%27 d=%27M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z%27/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 10px center; background-size: 14px; padding-right: 32px;"
                                    >
                                        <option value="pending" <?= ($denda['status'] == 'pending') ? 'selected' : '' ?>>⏳ PENDING</option>
                                        <option value="lunas" <?= ($denda['status'] == 'lunas') ? 'selected' : '' ?>>✅ LUNAS</option>
                                        <option value="unpaid" <?= ($denda['status'] == 'unpaid') ? 'selected' : '' ?>>❌ UNPAID</option>
                                    </select>
                                    <span id="dendaSaveSpinner" class="hidden">
                                        <span class="inline-block w-5 h-5 border-2 border-slate-200 border-t-blue-500 rounded-full animate-spin"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="bg-white px-4 py-3 rounded-lg border border-red-100 flex-1 w-full shadow-sm">
                                <span class="block text-xs text-slate-500 mb-1">Jumlah Denda</span>
                                <span class="font-bold text-slate-800">Rp <?= number_format($denda['jumlah_denda'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="bg-white px-4 py-3 rounded-lg border border-red-100 inline-block shadow-sm">
                            <span class="block text-xs text-slate-500 mb-1">Status Denda</span>
                            <span class="font-bold text-red-600 uppercase flex items-center gap-2">
                                <i class="bi bi-exclamation-circle-fill"></i> UNPAID (Sistem belum mencatat denda)
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="peminjaman.php" class="px-6 py-3 text-sm font-semibold text-slate-700 bg-white border-2 border-slate-200 rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all text-center">
                        <i class="bi bi-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="submit" class="px-8 py-3 text-sm font-semibold text-white bg-yellow-500 border-2 border-yellow-500 rounded-xl hover:bg-yellow-600 hover:border-yellow-600 shadow-lg shadow-yellow-200 transition-all flex justify-center items-center gap-2">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
                
            </form>
        </div>
    </div>

    <!-- Toast container -->
    <div id="toastContainer" style="position:fixed;top:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px;"></div>

    <script>
        function showToast(message, type) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            const bg = type === 'success' 
                ? 'linear-gradient(135deg, #10b981, #059669)' 
                : 'linear-gradient(135deg, #ef4444, #dc2626)';
            toast.style.cssText = `padding:12px 20px;border-radius:12px;color:white;font-size:14px;font-weight:500;box-shadow:0 8px 24px rgba(0,0,0,0.15);display:flex;align-items:center;gap:8px;background:${bg};animation:toastIn 0.4s ease;`;
            const icon = type === 'success' ? '<i class="bi bi-check-circle-fill"></i>' : '<i class="bi bi-x-circle-fill"></i>';
            toast.innerHTML = icon + ' ' + message;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.animation = 'toastOut 0.4s ease forwards';
                setTimeout(() => toast.remove(), 400);
            }, 2600);
        }

        function updateDendaStatusEdit(selectEl) {
            const dendaId = selectEl.dataset.dendaId;
            const newStatus = selectEl.value;
            const spinner = document.getElementById('dendaSaveSpinner');
            
            spinner.classList.remove('hidden');
            selectEl.disabled = true;

            const formData = new FormData();
            formData.append('denda_id', dendaId);
            formData.append('status', newStatus);

            fetch('peminjaman.php?action=updateDendaStatus', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showToast('Status denda berhasil diperbarui!', 'success');
                    
                    // Update dropdown colors dynamically
                    selectEl.classList.remove(
                        'bg-emerald-50', 'border-emerald-300', 'text-emerald-700',
                        'bg-amber-50', 'border-amber-300', 'text-amber-700',
                        'bg-red-50', 'border-red-300', 'text-red-700'
                    );
                    if (newStatus === 'lunas') {
                        selectEl.classList.add('bg-emerald-50', 'border-emerald-300', 'text-emerald-700');
                    } else if (newStatus === 'pending') {
                        selectEl.classList.add('bg-amber-50', 'border-amber-300', 'text-amber-700');
                    } else {
                        selectEl.classList.add('bg-red-50', 'border-red-300', 'text-red-700');
                    }
                } else {
                    showToast(data.message || 'Gagal memperbarui status', 'error');
                }
            })
            .catch(() => {
                showToast('Terjadi kesalahan jaringan', 'error');
            })
            .finally(() => {
                selectEl.disabled = false;
                spinner.classList.add('hidden');
            });
        }
    </script>

    <style>
        @keyframes toastIn {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes toastOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(120%); opacity: 0; }
        }
    </style>

</body>
</html>