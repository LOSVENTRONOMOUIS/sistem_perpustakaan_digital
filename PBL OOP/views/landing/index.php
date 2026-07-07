<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perpustakaan Digital — Katalog Buku</title>
<meta name="description" content="Perpustakaan Digital kampus — jelajahi koleksi buku akademik dan pinjam secara online.">
<meta property="og:title" content="Perpustakaan Digital">
<meta property="og:description" content="Katalog buku perpustakaan digital kampus.">
<meta property="og:type" content="website">

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<script>
tailwind.config = {
  theme: {
    extend: {
      fontFamily: { sans: ['Poppins', 'sans-serif'] },
      colors: {
        brand: {50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a'}
      }
    }
  }
}
</script>

<style>
  :root { --ease: cubic-bezier(0.4, 0, 0.2, 1); }
  body { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
  ::-webkit-scrollbar-thumb:hover { background: #2563eb; }

  .glass { background: rgba(255,255,255,0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }

  .book-card { transition: transform 0.2s var(--ease), box-shadow 0.2s var(--ease); }
  .book-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px -8px rgba(37,99,235,0.12); }

  .cat-pill { transition: all 0.15s var(--ease); }
  .cat-pill:hover { background: #dbeafe; color: #1d4ed8; }
  .cat-pill.active { background: #2563eb; color: #fff; }

  .fade-in { opacity: 0; transform: translateY(16px); transition: opacity 0.5s var(--ease), transform 0.5s var(--ease); }
  .fade-in.visible { opacity: 1; transform: translateY(0); }

  .skeleton { background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; }
  @keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

  .counter { display: inline-block; }

  .badge-tersedia { background:#dcfce7; color:#166534; }
  .badge-terbatas { background:#fef9c3; color:#854d0e; }
  .badge-habis { background:#fee2e2; color:#991b1b; }

  .page-btn { min-width:34px; height:34px; display:flex; align-items:center; justify-content:center; border-radius:8px; font-size:0.8rem; font-weight:500; transition:all 0.15s; }
  .page-btn:hover:not(.active):not(.disabled) { background:#dbeafe; color:#1d4ed8; }
  .page-btn.active { background:#2563eb; color:#fff; }
  .page-btn.disabled { opacity:0.35; cursor:not-allowed; }

  .faq-body { max-height:0; overflow:hidden; transition:max-height 0.3s var(--ease); }
  .faq-body.open { max-height:200px; }
  .faq-arrow { transition:transform 0.25s var(--ease); }
  .faq-item.open .faq-arrow { transform:rotate(180deg); }

  #mobileNav { transition: opacity 0.2s, transform 0.2s; }
  #mobileNav.hidden { opacity:0; transform:translateY(-8px); pointer-events:none; }
</style>
</head>

<body class="bg-white text-slate-800 antialiased">

<!-- ═══════════════════════════════════════════════
     NAVBAR
     ═══════════════════════════════════════════════ -->
<header id="nav" class="fixed inset-x-0 top-0 z-50 glass border-b border-slate-100/60">
  <div class="max-w-6xl mx-auto flex items-center justify-between h-14 px-4 lg:px-6">

    <a href="index.php" class="flex items-center gap-2">
      <div class="w-8 h-8 rounded-lg bg-brand-600 grid place-items-center">
        <i class="bi bi-book-half text-white text-sm"></i>
      </div>
      <span class="font-semibold text-[15px] hidden sm:block">Digital <span class="text-brand-600">Library</span></span>
    </a>

    <nav class="hidden md:flex items-center gap-1 text-[13px] font-medium text-slate-500">
      <a href="#beranda" class="px-3 py-1.5 rounded-lg hover:text-brand-600 hover:bg-brand-50 transition-all">Beranda</a>
      <a href="#katalog" class="px-3 py-1.5 rounded-lg hover:text-brand-600 hover:bg-brand-50 transition-all">Katalog</a>
      <a href="#faq"     class="px-3 py-1.5 rounded-lg hover:text-brand-600 hover:bg-brand-50 transition-all">FAQ</a>
    </nav>

    <div class="flex items-center gap-2">
      <?php if ($isLoggedIn): ?>
        <span class="hidden sm:block text-xs text-slate-500"><?= htmlspecialchars($namaUser) ?></span>
        <a href="<?= $roleUser === 'admin' ? 'dashboard.php' : 'dashboard_anggota.php' ?>"
           class="h-8 px-3.5 bg-brand-600 text-white text-xs font-semibold rounded-lg hover:bg-brand-700 transition inline-flex items-center gap-1.5">
          <i class="bi bi-grid-fill text-[10px]"></i> Dashboard
        </a>
      <?php else: ?>
        <a href="login.php" class="h-8 px-3.5 bg-brand-600 text-white text-xs font-semibold rounded-lg hover:bg-brand-700 transition inline-flex items-center gap-1.5">
          <i class="bi bi-box-arrow-in-right text-[10px]"></i> Login
        </a>
      <?php endif; ?>
      <button id="menuBtn" class="md:hidden w-8 h-8 grid place-items-center rounded-lg text-slate-500 hover:bg-slate-100 transition">
        <i class="bi bi-list text-lg"></i>
      </button>
    </div>
  </div>

  <!-- Mobile nav -->
  <div id="mobileNav" class="hidden md:hidden border-t border-slate-100 bg-white px-4 pb-3 pt-1">
    <a href="#beranda" class="block py-2 text-sm text-slate-600 hover:text-brand-600">Beranda</a>
    <a href="#katalog" class="block py-2 text-sm text-slate-600 hover:text-brand-600">Katalog</a>
    <a href="#faq"     class="block py-2 text-sm text-slate-600 hover:text-brand-600">FAQ</a>
  </div>
</header>


<!-- ═══════════════════════════════════════════════
     HERO — compact, search‑focused
     ═══════════════════════════════════════════════ -->
<section id="beranda" class="pt-24 pb-12 sm:pt-28 sm:pb-16 bg-gradient-to-b from-brand-50/60 to-white">
  <div class="max-w-3xl mx-auto px-4 text-center fade-in">

    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 leading-snug">
      Perpustakaan <span class="text-brand-600">Digital</span> Kampus
    </h1>
    <p class="mt-2 text-sm text-slate-500 max-w-md mx-auto">
      Cari, jelajahi, dan pinjam buku akademik secara online.
    </p>

    <!-- Search -->
    <div class="mt-6 flex items-center bg-white rounded-xl border border-slate-200 shadow-sm focus-within:border-brand-400 focus-within:ring-4 focus-within:ring-brand-50 transition-all overflow-hidden max-w-xl mx-auto">
      <i class="bi bi-search text-slate-400 pl-4"></i>
      <input id="heroSearch" type="text" placeholder="Cari judul, penulis, atau kategori…"
             class="flex-1 py-3 px-3 text-sm bg-transparent outline-none text-slate-700 placeholder-slate-400">
      <button onclick="doHeroSearch()" class="h-full px-5 py-3 bg-brand-600 text-white text-xs font-semibold hover:bg-brand-700 transition-colors">
        Cari
      </button>
    </div>

    <!-- Mini stats -->
    <div class="mt-6 flex justify-center gap-6 sm:gap-8 text-center">
      <?php
      $miniStats = [
        [$stats['total_buku'], 'Buku'],
        [$stats['total_kategori'], 'Kategori'],
        [$stats['total_penulis'], 'Penulis'],
        [$stats['total_peminjaman'], 'Peminjaman'],
      ];
      foreach ($miniStats as $ms): ?>
      <div>
        <div class="text-lg sm:text-xl font-bold text-slate-800 counter" data-to="<?= $ms[0] ?>">0</div>
        <div class="text-[11px] text-slate-400 mt-0.5"><?= $ms[1] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════
     KATALOG  — the main focus
     ═══════════════════════════════════════════════ -->
<section id="katalog" class="pb-20">
  <div class="max-w-6xl mx-auto px-4 lg:px-6">

    <!-- Category pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 mb-6 scrollbar-hide fade-in" id="catBar">
      <button class="cat-pill active shrink-0 px-3.5 py-1.5 rounded-full text-xs font-medium bg-brand-600 text-white"
              data-cat="" onclick="pickCat(this,'')">Semua</button>
      <?php foreach ($categories as $cat): ?>
      <button class="cat-pill shrink-0 px-3.5 py-1.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600"
              data-cat="<?= htmlspecialchars($cat['nama_kategori'], ENT_QUOTES) ?>"
              onclick="pickCat(this,'<?= htmlspecialchars($cat['nama_kategori'], ENT_QUOTES) ?>')">
        <?= htmlspecialchars($cat['nama_kategori']) ?>
        <span class="text-[10px] opacity-60 ml-0.5"><?= $cat['jumlah_buku'] ?></span>
      </button>
      <?php endforeach; ?>
    </div>

    <!-- Toolbar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-5 fade-in">
      <div class="flex items-center gap-3 w-full sm:w-auto">
        <div class="relative flex-1 sm:w-56">
          <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
          <input id="catSearch" type="text" placeholder="Cari buku…"
                 class="w-full pl-8 pr-3 py-2 rounded-lg border border-slate-200 text-xs bg-slate-50 focus:bg-white focus:border-brand-400 focus:outline-none focus:ring-3 focus:ring-brand-50 transition-all">
        </div>
        <select id="catSort" class="py-2 px-3 rounded-lg border border-slate-200 text-xs text-slate-600 bg-slate-50 focus:border-brand-400 focus:outline-none focus:ring-3 focus:ring-brand-50 transition-all">
          <option value="terbaru">Terbaru</option>
          <option value="populer">Populer</option>
          <option value="az">A → Z</option>
          <option value="za">Z → A</option>
        </select>
      </div>

      <p class="text-xs text-slate-400">
        <span id="bookCount"><?= $catalogData['total_records'] ?></span> buku ditemukan
      </p>
    </div>

    <!-- Skeleton -->
    <div id="skeleton" class="hidden grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
      <?php for($i=0;$i<10;$i++): ?>
      <div class="rounded-2xl overflow-hidden border border-slate-100">
        <div class="h-40 skeleton"></div>
        <div class="p-3 space-y-2"><div class="h-2.5 skeleton rounded w-14"></div><div class="h-3 skeleton rounded"></div><div class="h-2.5 skeleton rounded w-3/4"></div></div>
      </div>
      <?php endfor; ?>
    </div>

    <!-- Book grid -->
    <div id="bookGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
      <?php foreach ($catalogData['books'] as $b): ?>
      <?= renderCard($b) ?>
      <?php endforeach; ?>
    </div>

    <!-- Empty -->
    <div id="emptyState" class="<?= empty($catalogData['books'])?'':'hidden' ?> text-center py-20">
      <i class="bi bi-inbox text-4xl text-slate-300 block mb-2"></i>
      <p class="text-sm text-slate-400">Tidak ada buku ditemukan</p>
      <button onclick="resetFilters()" class="mt-3 text-xs font-semibold text-brand-600 hover:underline">Reset filter</button>
    </div>

    <!-- Pagination -->
    <div id="pagination" class="flex justify-center gap-1.5 mt-8"></div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════
     FAQ — minimal
     ═══════════════════════════════════════════════ -->
<section id="faq" class="bg-slate-50 py-16">
  <div class="max-w-2xl mx-auto px-4">
    <h2 class="text-lg font-bold text-slate-800 text-center mb-8 fade-in">Pertanyaan Umum</h2>

    <div class="space-y-2 fade-in">
      <?php
      $faqs = [
        ['Bagaimana cara meminjam buku?','Cari buku → klik Pinjam → login → konfirmasi. Buku bisa diambil di perpustakaan.'],
        ['Apakah harus login untuk melihat katalog?','Tidak. Katalog bisa dijelajahi tanpa login. Login hanya diperlukan untuk meminjam.'],
        ['Berapa lama masa peminjaman?','14 hari sejak tanggal pinjam. Denda Rp 2.000/hari jika terlambat.'],
        ['Berapa buku yang bisa dipinjam?','Maksimal 3 buku secara bersamaan.'],
      ];
      foreach ($faqs as $f): ?>
      <div class="faq-item bg-white rounded-xl border border-slate-100">
        <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-4 text-left">
          <span class="text-sm font-medium text-slate-700"><?= $f[0] ?></span>
          <i class="bi bi-chevron-down faq-arrow text-slate-400 text-xs ml-3 shrink-0"></i>
        </button>
        <div class="faq-body px-4">
          <p class="text-xs text-slate-500 leading-relaxed pb-4"><?= $f[1] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════
     FOOTER — compact
     ═══════════════════════════════════════════════ -->
<footer class="bg-slate-900 text-slate-500 py-8">
  <div class="max-w-6xl mx-auto px-4 lg:px-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
    <div class="flex items-center gap-2">
      <div class="w-6 h-6 rounded-md bg-brand-600 grid place-items-center"><i class="bi bi-book-half text-white text-[10px]"></i></div>
      <span>&copy; <?= date('Y') ?> Digital Library</span>
    </div>
    <div class="flex items-center gap-4">
      <a href="index.php" class="hover:text-white transition">Beranda</a>
      <a href="#katalog" class="hover:text-white transition">Katalog</a>
      <a href="#faq" class="hover:text-white transition">FAQ</a>
      <a href="login.php" class="hover:text-white transition">Login</a>
    </div>
  </div>
</footer>


<!-- ═══════════════════════════════════════════════
     PHP HELPER — render book card
     ═══════════════════════════════════════════════ -->
<?php
function renderCard($b) {
  $id    = (int)$b['id'];
  $stok  = (int)($b['stok'] ?? 0);
  $judul = htmlspecialchars($b['judul'] ?? '');
  $pen   = htmlspecialchars($b['penulis'] ?? '-');
  $kat   = htmlspecialchars($b['kategori_nama'] ?? 'Umum');
  $tahun = htmlspecialchars($b['tahun'] ?? '');
  $bg    = $b['cover_bg'] ?? 'linear-gradient(135deg,#f3f4f6,#e5e7eb)';
  $emoji = $b['cover_emoji'] ?? '📔';
  $cover = $b['cover'] ?? '';

  if ($stok > 3) { $bc='badge-tersedia'; $bl='Tersedia'; }
  elseif ($stok > 0) { $bc='badge-terbatas'; $bl='Terbatas'; }
  else { $bc='badge-habis'; $bl='Habis'; }

  $coverHtml = $cover
    ? '<img src="../assets/images/covers/'.htmlspecialchars($cover).'" alt="'.$judul.'" class="w-full h-full object-cover" loading="lazy"
            onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\'">
       <span class="text-5xl hidden items-center justify-center w-full h-full">'.$emoji.'</span>'
    : '<span class="text-5xl">'.$emoji.'</span>';

  $disBtn = $stok <= 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-brand-700';
  $dis    = $stok <= 0 ? 'disabled' : '';
  $jsTitle = htmlspecialchars(addslashes($b['judul'] ?? ''), ENT_QUOTES);

  return <<<HTML
<div class="book-card bg-white rounded-2xl border border-slate-100 overflow-hidden group cursor-pointer"
     onclick="window.location.href='buku_detail.php?id={$id}'">
  <div class="h-40 flex items-center justify-center relative overflow-hidden" style="background:{$bg}">
    {$coverHtml}
    <span class="absolute top-1.5 right-1.5 text-[10px] font-semibold px-1.5 py-0.5 rounded-md {$bc}">{$bl}</span>
  </div>
  <div class="p-3">
    <p class="text-[10px] font-medium text-brand-600">{$kat}</p>
    <h3 class="text-xs font-semibold text-slate-800 leading-snug line-clamp-2 mt-0.5 group-hover:text-brand-600 transition-colors">{$judul}</h3>
    <p class="text-[10px] text-slate-400 mt-0.5 line-clamp-1">{$pen} · {$tahun}</p>
    <div class="flex gap-1.5 mt-2.5">
      <a href="buku_detail.php?id={$id}" onclick="event.stopPropagation()"
         class="flex-1 text-center text-[10px] font-semibold py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:border-brand-300 hover:text-brand-600 transition-all">Detail</a>
      <button onclick="event.stopPropagation(); handlePinjam({$id},'{$jsTitle}',{$stok})"
              class="flex-1 text-[10px] font-semibold py-1.5 rounded-lg bg-brand-600 text-white transition-all {$disBtn}" {$dis}>Pinjam</button>
    </div>
  </div>
</div>
HTML;
}
?>


<!-- ═══════════════════════════════════════════════
     JAVASCRIPT
     ═══════════════════════════════════════════════ -->
<script>
const IS_LOGGED_IN = <?= $isLoggedIn ? 'true' : 'false' ?>;
let page = 1, keyword = '', category = '', sort = 'terbaru', timer;

/* ── Mobile menu ────────────────────────────── */
document.getElementById('menuBtn').addEventListener('click', () => {
  document.getElementById('mobileNav').classList.toggle('hidden');
});
document.querySelectorAll('#mobileNav a').forEach(a =>
  a.addEventListener('click', () => document.getElementById('mobileNav').classList.add('hidden'))
);

/* ── Navbar shadow ──────────────────────────── */
addEventListener('scroll', () =>
  document.getElementById('nav').classList.toggle('shadow-sm', scrollY > 4)
);

/* ── Scroll fade-in ─────────────────────────── */
const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }});
}, { threshold: 0.1 });
document.querySelectorAll('.fade-in').forEach(el => obs.observe(el));

/* ── Counter animation ──────────────────────── */
document.querySelectorAll('.counter').forEach(el => {
  const io = new IntersectionObserver(([e]) => {
    if (!e.isIntersecting) return;
    const to = +el.dataset.to, dur = 1200, step = Math.max(1, Math.ceil(to/(dur/16)));
    let cur = 0;
    const t = setInterval(() => {
      cur = Math.min(cur + step, to);
      el.textContent = cur.toLocaleString('id-ID');
      if (cur >= to) clearInterval(t);
    }, 16);
    io.unobserve(el);
  }, { threshold: 0.5 });
  io.observe(el);
});

/* ── Hero search ────────────────────────────── */
const heroInput = document.getElementById('heroSearch');
heroInput.addEventListener('keydown', e => { if (e.key === 'Enter') doHeroSearch(); });
function doHeroSearch() {
  keyword = heroInput.value.trim();
  page = 1;
  document.getElementById('catSearch').value = keyword;
  document.getElementById('katalog').scrollIntoView({ behavior: 'smooth' });
  setTimeout(load, 300);
}

/* ── Category pills ─────────────────────────── */
function pickCat(btn, cat) {
  category = cat; page = 1;
  document.querySelectorAll('.cat-pill').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  load();
}

/* ── Toolbar search / sort ──────────────────── */
document.getElementById('catSearch').addEventListener('input', function() {
  clearTimeout(timer);
  timer = setTimeout(() => { keyword = this.value.trim(); page = 1; load(); }, 350);
});
document.getElementById('catSort').addEventListener('change', function() {
  sort = this.value; page = 1; load();
});

function resetFilters() {
  keyword = ''; category = ''; sort = 'terbaru'; page = 1;
  document.getElementById('catSearch').value = '';
  document.getElementById('catSort').value = 'terbaru';
  document.querySelectorAll('.cat-pill').forEach(b => b.classList.remove('active'));
  document.querySelector('.cat-pill[data-cat=""]').classList.add('active');
  load();
}

/* ── AJAX load ──────────────────────────────── */
function load() {
  const grid = document.getElementById('bookGrid');
  const skel = document.getElementById('skeleton');
  const empty = document.getElementById('emptyState');
  skel.classList.remove('hidden'); grid.style.opacity = '0.25';

  const p = new URLSearchParams({ ajax:1, q:keyword, kategori:category, sort:sort, page:page });
  fetch('index.php?' + p).then(r => r.json()).then(d => {
    skel.classList.add('hidden'); grid.style.opacity = '1';
    if (!d.success) return;
    document.getElementById('bookCount').textContent = (d.total_records || 0).toLocaleString('id-ID');
    if (!d.books || !d.books.length) { grid.innerHTML = ''; empty.classList.remove('hidden'); document.getElementById('pagination').innerHTML = ''; return; }
    empty.classList.add('hidden');
    grid.innerHTML = d.books.map(cardHtml).join('');
    paginate(d.current_page, d.total_pages);
  }).catch(() => { skel.classList.add('hidden'); grid.style.opacity = '1'; });
}

function cardHtml(b) {
  const id = +b.id, stok = +(b.stok||0);
  const judul = esc(b.judul||''), pen = esc(b.penulis||'-'), kat = esc(b.kategori_nama||'Umum'), yr = b.tahun||'';
  const bg = b.cover_bg||'linear-gradient(135deg,#f3f4f6,#e5e7eb)', emoji = b.cover_emoji||'📔';
  let bc,bl;
  if(stok>3){bc='badge-tersedia';bl='Tersedia';}else if(stok>0){bc='badge-terbatas';bl='Terbatas';}else{bc='badge-habis';bl='Habis';}
  const dis = stok<=0, disCls = dis?'opacity-50 cursor-not-allowed':'hover:bg-brand-700', disA = dis?'disabled':'';
  const coverImg = b.cover
    ? `<img src="../assets/images/covers/${esc(b.cover)}" alt="${judul}" class="w-full h-full object-cover" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><span class="text-5xl hidden items-center justify-center w-full h-full">${emoji}</span>`
    : `<span class="text-5xl">${emoji}</span>`;
  return `<div class="book-card bg-white rounded-2xl border border-slate-100 overflow-hidden group cursor-pointer" onclick="location.href='buku_detail.php?id=${id}'">
    <div class="h-40 flex items-center justify-center relative overflow-hidden" style="background:${bg}">${coverImg}<span class="absolute top-1.5 right-1.5 text-[10px] font-semibold px-1.5 py-0.5 rounded-md ${bc}">${bl}</span></div>
    <div class="p-3"><p class="text-[10px] font-medium text-brand-600">${kat}</p>
      <h3 class="text-xs font-semibold text-slate-800 leading-snug line-clamp-2 mt-0.5 group-hover:text-brand-600 transition-colors">${judul}</h3>
      <p class="text-[10px] text-slate-400 mt-0.5 line-clamp-1">${pen} · ${yr}</p>
      <div class="flex gap-1.5 mt-2.5">
        <a href="buku_detail.php?id=${id}" onclick="event.stopPropagation()" class="flex-1 text-center text-[10px] font-semibold py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:border-brand-300 hover:text-brand-600 transition-all">Detail</a>
        <button onclick="event.stopPropagation();handlePinjam(${id},'${escJs(b.judul||'')}',${stok})" class="flex-1 text-[10px] font-semibold py-1.5 rounded-lg bg-brand-600 text-white transition-all ${disCls}" ${disA}>Pinjam</button>
      </div>
    </div></div>`;
}
function esc(s){const d=document.createElement('div');d.textContent=s;return d.innerHTML;}
function escJs(s){return String(s).replace(/\\/g,'\\\\').replace(/'/g,"\\'");}

/* ── Pagination ─────────────────────────────── */
function paginate(cur, total) {
  const c = document.getElementById('pagination');
  if (total <= 1) { c.innerHTML = ''; return; }
  let h = `<button class="page-btn ${cur<=1?'disabled':''}" onclick="${cur>1?'goPage('+(cur-1)+')':''}" ${cur<=1?'disabled':''}><i class="bi bi-chevron-left text-[10px]"></i></button>`;
  for (let i=1;i<=total;i++) {
    if (i===1||i===total||(i>=cur-2&&i<=cur+2)) h += `<button class="page-btn ${i===cur?'active':''}" onclick="goPage(${i})">${i}</button>`;
    else if (i===cur-3||i===cur+3) h += `<span class="page-btn">…</span>`;
  }
  h += `<button class="page-btn ${cur>=total?'disabled':''}" onclick="${cur<total?'goPage('+(cur+1)+')':''}" ${cur>=total?'disabled':''}><i class="bi bi-chevron-right text-[10px]"></i></button>`;
  c.innerHTML = h;
}
function goPage(p) { page=p; load(); document.getElementById('katalog').scrollIntoView({behavior:'smooth'}); }

/* ── Pinjam handler ─────────────────────────── */
function handlePinjam(id, title, stok) {
  if (stok <= 0) return;
  if (!IS_LOGGED_IN) {
    window.location.href = 'login.php?redirect=' + encodeURIComponent('katalog.php?buku_id='+id) + '&buku_id=' + id;
    return;
  }
  window.location.href = 'katalog.php?buku_id=' + id;
}

/* ── FAQ toggle ─────────────────────────────── */
function toggleFaq(btn) {
  const item = btn.closest('.faq-item'), body = item.querySelector('.faq-body'), isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i=>{i.classList.remove('open');i.querySelector('.faq-body').classList.remove('open');});
  if (!isOpen) { item.classList.add('open'); body.classList.add('open'); }
}

/* ── Init from URL params ───────────────────── */
(function(){
  const p = new URLSearchParams(location.search);
  if (p.get('keyword')) { keyword=p.get('keyword'); document.getElementById('catSearch').value=keyword; }
  if (p.get('kategori')) { category=p.get('kategori'); document.querySelectorAll('.cat-pill').forEach(b=>{b.classList.toggle('active',b.dataset.cat===category);}); }
})();
</script>

</body>
</html>
