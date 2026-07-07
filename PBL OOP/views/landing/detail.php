<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($buku['judul']) ?> — Perpustakaan Digital</title>
<meta name="description" content="Detail buku <?= htmlspecialchars($buku['judul']) ?> oleh <?= htmlspecialchars($buku['penulis'] ?? '') ?> — tersedia di Perpustakaan Digital Kampus.">
<meta property="og:title"       content="<?= htmlspecialchars($buku['judul']) ?> — Perpustakaan Digital">
<meta property="og:description" content="Penulis: <?= htmlspecialchars($buku['penulis'] ?? '') ?>. Kategori: <?= htmlspecialchars($buku['kategori_nama'] ?? '') ?>.">
<meta property="og:type"        content="book">

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script>
tailwind.config = {
  theme: {
    extend: {
      fontFamily: { poppins: ['Poppins', 'sans-serif'] },
      colors: {
        brand: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' }
      }
    }
  }
}
</script>

<style>
  *, *::before, *::after { box-sizing: border-box; }
  body { font-family: 'Poppins', sans-serif; }
  ::-webkit-scrollbar { width: 6px; }
  ::-webkit-scrollbar-track { background: #f1f5f9; }
  ::-webkit-scrollbar-thumb { background: #2563eb; border-radius: 99px; }
  .navbar-glass { background: rgba(255,255,255,0.92); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid rgba(37,99,235,0.08); }
  .gradient-text { background: linear-gradient(135deg, #2563eb, #6366f1); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
  .cover-3d { box-shadow: 6px 6px 0 rgba(37,99,235,0.15), 12px 12px 0 rgba(37,99,235,0.08), 0 20px 60px rgba(0,0,0,0.12); transform: perspective(800px) rotateY(-8deg); transition: transform 0.4s ease, box-shadow 0.4s ease; }
  .cover-3d:hover { transform: perspective(800px) rotateY(-2deg); box-shadow: 3px 3px 0 rgba(37,99,235,0.1), 6px 6px 0 rgba(37,99,235,0.06), 0 30px 80px rgba(0,0,0,0.15); }
  @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
  .animate-fade-up { animation: fadeUp 0.5s ease-out forwards; }
  .badge-tersedia { background:#d1fae5; color:#065f46; }
  .badge-terbatas { background:#fef3c7; color:#92400e; }
  .badge-habis    { background:#fee2e2; color:#991b1b; }
</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

<!-- Navbar -->
<header class="fixed top-0 left-0 right-0 z-50 navbar-glass">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <a href="index.php" class="flex items-center gap-2.5">
        <div class="w-9 h-9 rounded-xl bg-brand-600 flex items-center justify-center shadow-md shadow-brand-200">
          <i class="bi bi-book-half text-white text-lg"></i>
        </div>
        <span class="font-bold text-slate-800 text-lg hidden sm:block">
          Digital<span class="text-brand-600"> Library</span>
        </span>
      </a>
      <div class="flex items-center gap-3">
        <a href="index.php#katalog" class="hidden sm:flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 hover:text-brand-600 hover:bg-brand-50 rounded-xl transition-all">
          <i class="bi bi-collection"></i> Katalog
        </a>
        <?php if ($isLoggedIn): ?>
          <a href="<?= $roleUser === 'admin' ? 'dashboard.php' : 'dashboard_anggota.php' ?>"
             class="px-4 py-2 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-all shadow-md shadow-brand-200 flex items-center gap-2">
            <i class="bi bi-grid-fill"></i> Dashboard
          </a>
        <?php else: ?>
          <a href="login.php?buku_id=<?= $buku['id'] ?>" class="px-4 py-2 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-all shadow-md shadow-brand-200 flex items-center gap-2">
            <i class="bi bi-box-arrow-in-right"></i> Login
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>

<!-- Breadcrumb -->
<div class="pt-20 pb-0 bg-white border-b border-slate-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
    <nav class="flex items-center gap-2 text-xs text-slate-500">
      <a href="index.php" class="hover:text-brand-600 transition-colors">Beranda</a>
      <i class="bi bi-chevron-right text-slate-300"></i>
      <a href="index.php#katalog" class="hover:text-brand-600 transition-colors">Katalog</a>
      <i class="bi bi-chevron-right text-slate-300"></i>
      <span class="text-slate-800 font-medium line-clamp-1"><?= htmlspecialchars($buku['judul']) ?></span>
    </nav>
  </div>
</div>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
  <div class="grid lg:grid-cols-3 gap-10 lg:gap-16 items-start animate-fade-up">

    <!-- Left: Cover -->
    <div class="lg:col-span-1 flex justify-center lg:justify-start">
      <div class="relative">
        <div class="cover-3d w-60 lg:w-72 rounded-2xl overflow-hidden aspect-[2/3] flex items-center justify-center"
             style="background:<?= $buku['cover_bg'] ?>">
          <?php if (!empty($buku['cover'])): ?>
            <img src="../assets/images/covers/<?= htmlspecialchars($buku['cover']) ?>"
                 alt="<?= htmlspecialchars($buku['judul']) ?>"
                 class="w-full h-full object-cover"
                 onerror="this.style.display='none'; document.getElementById('coverEmoji').style.display='flex'">
            <div id="coverEmoji" class="hidden absolute inset-0 text-8xl items-center justify-center">
              <?= $buku['cover_emoji'] ?>
            </div>
          <?php else: ?>
            <div class="text-8xl"><?= $buku['cover_emoji'] ?></div>
          <?php endif; ?>
        </div>

        <!-- Status Badge -->
        <?php
          $stok = (int)($buku['stok'] ?? 0);
          if ($stok > 3)     { $badge='badge-tersedia'; $badgeLabel='Tersedia'; $badgeIcon='bi-check-circle-fill'; }
          elseif ($stok > 0) { $badge='badge-terbatas'; $badgeLabel='Stok Terbatas'; $badgeIcon='bi-exclamation-circle-fill'; }
          else               { $badge='badge-habis';    $badgeLabel='Stok Habis'; $badgeIcon='bi-x-circle-fill'; }
        ?>
        <div class="absolute -bottom-3 -right-3 <?= $badge ?> flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold shadow-lg">
          <i class="bi <?= $badgeIcon ?>"></i>
          <?= $badgeLabel ?>
        </div>
      </div>
    </div>

    <!-- Right: Detail -->
    <div class="lg:col-span-2 space-y-6">

      <!-- Category tag -->
      <div class="flex items-center gap-2 flex-wrap">
        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-brand-700 bg-brand-100 px-3 py-1.5 rounded-full">
          <i class="bi bi-tag-fill text-xs"></i>
          <?= htmlspecialchars($buku['kategori_nama'] ?? 'Umum') ?>
        </span>
        <?php if (!empty($buku['tahun'])): ?>
        <span class="text-sm text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full">
          📅 <?= htmlspecialchars($buku['tahun']) ?>
        </span>
        <?php endif; ?>
      </div>

      <!-- Title -->
      <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 leading-tight">
        <?= htmlspecialchars($buku['judul']) ?>
      </h1>

      <!-- Author -->
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center shrink-0">
          <i class="bi bi-person-fill text-brand-600"></i>
        </div>
        <div>
          <div class="text-xs text-slate-400">Penulis</div>
          <div class="font-semibold text-slate-700"><?= htmlspecialchars($buku['penulis'] ?? '-') ?></div>
        </div>
      </div>

      <!-- Info Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <?php
        $infoItems = [
          ['icon'=>'bi-building',      'label'=>'Penerbit',  'value'=>$buku['penerbit'] ?? '-'],
          ['icon'=>'bi-calendar3',     'label'=>'Tahun',     'value'=>$buku['tahun'] ?? '-'],
          ['icon'=>'bi-upc-scan',      'label'=>'ISBN',      'value'=>$buku['isbn'] ?? ($buku['id'] ? 'BK-'.str_pad($buku['id'],4,'0',STR_PAD_LEFT) : '-')],
          ['icon'=>'bi-stack',         'label'=>'Stok',      'value'=>$stok . ' eksemplar'],
          ['icon'=>'bi-journal-check', 'label'=>'Dipinjam',  'value'=>(int)($buku['total_pinjam'] ?? 0) . 'x'],
          ['icon'=>'bi-layers-fill',   'label'=>'Kategori',  'value'=>$buku['kategori_nama'] ?? 'Umum'],
        ];
        foreach ($infoItems as $info): ?>
        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
          <div class="flex items-center gap-2 mb-1.5">
            <i class="bi <?= $info['icon'] ?> text-brand-500 text-sm"></i>
            <span class="text-xs text-slate-400 font-medium"><?= $info['label'] ?></span>
          </div>
          <div class="font-semibold text-slate-800 text-sm truncate">
            <?= htmlspecialchars($info['value']) ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Description -->
      <?php if (!empty($buku['deskripsi'])): ?>
      <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
          <i class="bi bi-file-text text-brand-500"></i> Deskripsi Buku
        </h3>
        <p class="text-slate-600 text-sm leading-relaxed"><?= nl2br(htmlspecialchars($buku['deskripsi'])) ?></p>
      </div>
      <?php else: ?>
      <div class="bg-slate-50 rounded-2xl border border-slate-100 p-6">
        <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
          <i class="bi bi-file-text text-brand-500"></i> Tentang Buku Ini
        </h3>
        <p class="text-slate-500 text-sm leading-relaxed">
          Buku <strong><?= htmlspecialchars($buku['judul']) ?></strong> oleh <strong><?= htmlspecialchars($buku['penulis'] ?? '') ?></strong>
          merupakan salah satu koleksi dalam kategori <strong><?= htmlspecialchars($buku['kategori_nama'] ?? 'Umum') ?></strong> 
          yang tersedia di Perpustakaan Digital.
          <?php if (!empty($buku['penerbit'])): ?>
          Diterbitkan oleh <strong><?= htmlspecialchars($buku['penerbit']) ?></strong>
          <?php endif; ?>
          <?php if (!empty($buku['tahun'])): ?>
          pada tahun <strong><?= htmlspecialchars($buku['tahun']) ?></strong>.
          <?php endif; ?>
        </p>
      </div>
      <?php endif; ?>

      <!-- CTA Buttons -->
      <div class="flex flex-col sm:flex-row gap-3 pt-2">
        <?php if ($stok > 0): ?>
          <?php if ($isLoggedIn): ?>
            <a href="katalog.php?buku_id=<?= $buku['id'] ?>"
               class="flex-1 sm:flex-none px-8 py-4 bg-brand-600 text-white font-bold rounded-2xl hover:bg-brand-700 active:scale-95 transition-all shadow-xl shadow-brand-200 flex items-center justify-center gap-2 text-sm">
              <i class="bi bi-journal-plus text-lg"></i>
              Pinjam Buku Ini
            </a>
          <?php else: ?>
            <button onclick="handlePinjam()" id="btnPinjamDetail"
                    class="flex-1 sm:flex-none px-8 py-4 bg-brand-600 text-white font-bold rounded-2xl hover:bg-brand-700 active:scale-95 transition-all shadow-xl shadow-brand-200 flex items-center justify-center gap-2 text-sm">
              <i class="bi bi-journal-plus text-lg"></i>
              Pinjam Buku Ini
            </button>
          <?php endif; ?>
        <?php else: ?>
          <button disabled class="flex-1 sm:flex-none px-8 py-4 bg-slate-200 text-slate-400 font-bold rounded-2xl cursor-not-allowed flex items-center justify-center gap-2 text-sm">
            <i class="bi bi-x-circle text-lg"></i>
            Stok Habis
          </button>
        <?php endif; ?>

        <a href="index.php#katalog"
           class="flex-1 sm:flex-none px-8 py-4 border-2 border-slate-200 text-slate-600 font-bold rounded-2xl hover:border-brand-300 hover:text-brand-600 hover:bg-brand-50 transition-all flex items-center justify-center gap-2 text-sm">
          <i class="bi bi-arrow-left"></i>
          Kembali ke Katalog
        </a>
      </div>

      <!-- Login notice (if not logged in and stok > 0) -->
      <?php if (!$isLoggedIn && $stok > 0): ?>
      <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-2xl p-4">
        <i class="bi bi-info-circle-fill text-amber-500 mt-0.5 shrink-0"></i>
        <div>
          <div class="font-semibold text-amber-800 text-sm">Login diperlukan untuk meminjam</div>
          <div class="text-amber-700 text-xs mt-0.5">
            Anda perlu <a href="login.php?buku_id=<?= $buku['id'] ?>" class="underline font-semibold">login</a> sebagai anggota untuk meminjam buku ini. 
            Setelah login, Anda akan langsung diarahkan ke halaman peminjaman.
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Back button mobile -->
  <div class="mt-10 lg:hidden">
    <a href="index.php" class="flex items-center gap-2 text-sm text-brand-600 font-semibold">
      <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>
  </div>
</main>

<!-- Footer minimal -->
<footer class="bg-slate-900 text-slate-500 py-6 mt-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2 text-sm">
    <p>&copy; <?= date('Y') ?> Sistem Perpustakaan Digital</p>
    <div class="flex items-center gap-4">
      <a href="index.php" class="hover:text-white transition-colors">Beranda</a>
      <a href="index.php#katalog" class="hover:text-white transition-colors">Katalog</a>
      <a href="login.php" class="hover:text-white transition-colors">Login</a>
    </div>
  </div>
</footer>

<script>
const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
const bukuId = <?= (int)$buku['id'] ?>;

function handlePinjam() {
  if (!isLoggedIn) {
    const redirectUrl = encodeURIComponent('katalog.php?buku_id=' + bukuId);
    window.location.href = 'login.php?redirect=' + redirectUrl + '&buku_id=' + bukuId;
    return;
  }
  window.location.href = 'katalog.php?buku_id=' + bukuId;
}

// Navbar shadow on scroll
window.addEventListener('scroll', () => {
  document.querySelector('header').classList.toggle('shadow-md', window.scrollY > 10);
});
</script>
</body>
</html>
