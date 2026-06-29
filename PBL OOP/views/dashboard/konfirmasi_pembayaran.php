<?php
/**
 * VIEW: Konfirmasi Pembayaran
 * Data disiapkan oleh public/konfirmasi_pembayaran.php
 */
if (!isset($kode)) {
    header('Location: dashboard_anggota.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice Pembayaran - <?= htmlspecialchars($kode) ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<script>
tailwind.config = {
  theme: {
    extend: {
      fontFamily: {
        poppins: ['Poppins', 'sans-serif'],
        mono: ['Space Mono', 'monospace'],
      },
    }
  }
}
</script>
<style>
@media print {
    body { background: white !important; }
    .no-print { display: none !important; }
    .print-border { border: 1px solid #e2e8f0; border-radius: 0; box-shadow: none !important; }
}
</style>
</head>
<body class="bg-slate-100 font-poppins min-h-screen p-4 md:p-8 flex items-center justify-center">

<div class="max-w-2xl w-full">
    
    <!-- Action Bar -->
    <div class="flex justify-between items-center mb-6 no-print">
        <a href="dashboard_anggota.php" class="bg-white hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-xl font-semibold shadow-sm transition-all border border-slate-200">
            <i class="bi bi-arrow-left mr-2"></i> Kembali
        </a>
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl font-semibold shadow-md transition-all">
            <i class="bi bi-printer mr-2"></i> Cetak Invoice
        </button>
    </div>

    <!-- Invoice Card -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden print-border print:shadow-none">
        
        <!-- Header -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 p-8 text-white text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 opacity-10 text-9xl -mt-10 -mr-4"><i class="bi bi-receipt"></i></div>
            <h1 class="text-3xl font-bold mb-2">Digital Library</h1>
            <p class="text-slate-300 font-medium">Bukti Pembayaran Denda Keterlambatan</p>
        </div>

        <!-- Content -->
        <div class="p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 pb-8 border-b border-dashed border-slate-200">
                <div>
                    <p class="text-sm text-slate-500 mb-1 font-semibold uppercase tracking-wider">Kode Referensi</p>
                    <h2 class="text-3xl font-bold text-indigo-600 font-mono tracking-widest"><?= htmlspecialchars($kode) ?></h2>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-sm text-slate-500 mb-1 font-semibold uppercase tracking-wider">Status</p>
                    <?php if ($status === 'pending'): ?>
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-bold bg-amber-100 text-amber-700 border border-amber-200">
                            <i class="bi bi-hourglass-split"></i> MENUNGGU PEMBAYARAN
                        </span>
                    <?php elseif ($status === 'lunas'): ?>
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                            <i class="bi bi-check-circle-fill"></i> LUNAS
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-bold bg-red-100 text-red-700 border border-red-200">
                            <i class="bi bi-x-circle-fill"></i> BELUM DIBAYAR
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-8">
                <div>
                    <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Ditagihkan Kepada:</p>
                    <p class="font-bold text-slate-800 text-lg"><?= htmlspecialchars($user_nama) ?></p>
                    <p class="text-sm text-slate-500">Email: <?= htmlspecialchars($user_email) ?></p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Tanggal & Metode:</p>
                    <p class="font-bold text-slate-800"><?= date('d F Y, H:i', strtotime($tanggal)) ?></p>
                    <p class="text-sm text-slate-500 capitalize">Metode: <?= htmlspecialchars($metode) ?></p>
                </div>
            </div>

            <!-- Table -->
            <div class="mb-8 overflow-hidden rounded-2xl border border-slate-200">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold">
                        <tr>
                            <th class="px-6 py-4">Judul Buku</th>
                            <th class="px-6 py-4 text-center">Denda</th>
                            <th class="px-6 py-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php foreach($denda_list as $item): ?>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800"><?= htmlspecialchars($item['judul']) ?></td>
                            <td class="px-6 py-4 text-center text-slate-500">Keterlambatan</td>
                            <td class="px-6 py-4 text-right font-mono font-medium">Rp <?= number_format($item['jumlah_denda'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-slate-50">
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-right font-bold text-slate-700 uppercase tracking-wider text-xs">Total Pembayaran:</td>
                            <td class="px-6 py-4 text-right font-bold text-indigo-600 font-mono text-lg">Rp <?= number_format($total_bayar, 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Instructions -->
            <?php if ($status === 'pending' && $metode === 'tunai'): ?>
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 mb-2">
                <h4 class="font-bold text-blue-800 mb-2 flex items-center gap-2"><i class="bi bi-info-circle-fill"></i> Instruksi Pembayaran Tunai</h4>
                <ol class="list-decimal list-inside text-sm text-blue-700 space-y-1.5 ml-1">
                    <li>Bawa cetakan invoice ini atau tunjukkan <strong>Kode Referensi</strong> dari layar HP Anda.</li>
                    <li>Serahkan uang tunai sebesar <strong>Rp <?= number_format($total_bayar, 0, ',', '.') ?></strong> kepada petugas perpustakaan.</li>
                    <li>Petugas akan melakukan konfirmasi di sistem, dan akses peminjaman Anda akan langsung dipulihkan.</li>
                </ol>
            </div>
            <?php endif; ?>

        </div>
        
        <div class="bg-slate-50 px-8 py-5 text-center text-xs text-slate-400 border-t border-slate-100">
            Invoice ini sah dan digenerate otomatis oleh sistem Perpustakaan Digital.
        </div>
    </div>
</div>

</body>
</html>
