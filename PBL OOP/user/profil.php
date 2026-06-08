<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil - Sistem Perpustakaan Digital</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root {
  --green: #3B6D11;
  --green-light: #639922;
  --green-bg: #EAF3DE;
  --green-sidebar: #C0DD97;
  --sidebar-w: 130px;
  --bg: #d4d4d4;
  --card-bg: #e8e8e8;
  --card-border: #c0c0c0;
  --text: #1a1a1a;
  --text-muted: #555;
  --radius: 10px;
  --radius-sm: 6px;
}
* { box-sizing: border-box; margin: 0; padding: 0; font-family: var(--font-sans, 'DM Sans', sans-serif); }
.frame { width: 100%; background: #2a2a2a; border-radius: 12px; overflow: hidden; max-width: 900px; margin: 20px auto; box-shadow: 0 20px 50px rgba(0,0,0,0.3); }
.frame-bar { background: #3a3a3a; height: 28px; display: flex; align-items: center; padding: 0 12px; gap: 6px; font-size: 11px; color: #aaa; user-select: none; }
.frame-dot { width: 10px; height: 10px; border-radius: 50%; }
.dot-r{background:#ff5f57}.dot-y{background:#febc2e}.dot-g{background:#28c840}
.app { background: var(--bg); min-height: 480px; display: flex; flex-direction: column; position: relative; }
.header { height: 52px; background: var(--bg); border-bottom: 1px solid var(--card-border); display: flex; align-items: center; justify-content: space-between; padding: 0 18px; }
.header-title { font-size: 15px; font-weight: 700; color: var(--text); letter-spacing: 0.04em; flex: 1; text-align: center; }
.body { display: flex; flex: 1; }
.sidebar { width: var(--sidebar-w); background: var(--green-sidebar); padding-top: 8px; flex-shrink: 0; display: flex; flex-direction: column; }
.nav-item { padding: 12px 16px; font-size: 12px; font-weight: 500; color: var(--text); cursor: pointer; border-left: 3px solid transparent; transition: all 0.2s; }
.nav-item:hover { background: rgba(255,255,255,0.3); }
.nav-item.active { background: var(--green-bg); border-left: 3px solid var(--green); font-weight: 700; }
.main { flex: 1; padding: 16px 18px; overflow-y: auto; max-height: 500px; }
.page { display: none; animation: fadeIn 0.3s ease; }
.page.active { display: block; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

.search-wrap { display: flex; justify-content: center; margin-bottom: 16px; }
.search-box { display: flex; align-items: center; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius-sm); padding: 6px 12px; width: 240px; gap: 8px; transition: border-color 0.2s; }
.search-box:focus-within { border-color: var(--green); }
.search-box input { border: none; background: transparent; font-size: 12px; color: var(--text); flex: 1; outline: none; }
.search-box input::placeholder { color: #999; }
.stat-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; margin-bottom: 16px; }
.stat-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius); padding: 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
.stat-label { font-size: 10px; color: var(--text-muted); font-weight: 500; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
.stat-value { font-size: 24px; font-weight: 700; color: var(--text); line-height: 1; }
.stat-note { font-size: 10px; color: #c03030; font-weight: 600; margin-top: 5px; }
.section-box { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius); padding: 14px; }
.section-title { font-size: 12px; font-weight: 700; color: var(--text); margin-bottom: 12px; border-bottom: 2px solid #eee; padding-bottom: 6px; display: inline-block; }
.book-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.book-item { display: flex; align-items: center; gap: 8px; padding: 9px; background: #f0f0f0; border-radius: var(--radius-sm); border: 1px solid var(--card-border); transition: transform 0.2s; }
.book-item:hover { transform: translateY(-2px); border-color: var(--green); }
.book-cover { width: 32px; height: 44px; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
.book-title { font-size: 10px; font-weight: 700; color: var(--text); line-height: 1.3; margin-bottom: 1px; }
.book-author { font-size: 9px; color: var(--text-muted); margin-bottom: 4px; }
.badge { display: inline-block; font-size: 8px; font-weight: 700; padding: 2px 7px; border-radius: 20px; }
.badge-tersedia { background: #d4edda; color: #276432; }
.badge-habis { background: #f8d7da; color: #842029; }
.badge-terbatas { background: #fff3cd; color: #856404; }
.pinjam-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
.pinjam-header h3 { font-size: 13px; font-weight: 700; }
.btn-tambah { background: var(--green); color: white; border: none; border-radius: var(--radius-sm); padding: 6px 12px; font-size: 10px; font-weight: 700; cursor: pointer; transition: background 0.2s; }
.btn-tambah:hover { background: var(--green-light); }
.pinjam-table { width: 100%; border-collapse: collapse; font-size: 11px; table-layout: fixed; }
.pinjam-table th { background: var(--green-bg); padding: 8px 8px; text-align: left; font-weight: 700; color: var(--text); border-bottom: 2px solid var(--green); }
.pinjam-table td { padding: 8px 8px; border-bottom: 1px solid var(--card-border); color: var(--text); vertical-align: middle; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.pinjam-table tr:hover td { background: rgba(255,255,255,0.4); }
.status-pill { padding: 2px 8px; border-radius: 20px; font-size: 9px; font-weight: 700; text-transform: capitalize; }
.s-dipinjam { background: #fff3cd; color: #856404; }
.s-terlambat { background: #f8d7da; color: #842029; }
.s-kembali { background: #d4edda; color: #276432; }
.filter-pill { padding: 4px 10px; border-radius: 20px; font-size: 10px; font-weight: 600; border: 1px solid var(--card-border); background: var(--bg); color: var(--text-muted); cursor: pointer; transition: all 0.2s; }
.filter-pill:hover { border-color: var(--green); color: var(--green); }
.filter-pill.active { background: var(--green); border-color: var(--green); color: white; }
.btn-pinjam-kecil { padding: 2px 7px; font-size: 9px; font-weight: 700; background: var(--green); color: white; border: none; border-radius: 4px; cursor: pointer; }
.btn-lihat { padding: 2px 7px; font-size: 9px; font-weight: 700; background: #185FA5; color: white; border: none; border-radius: 4px; cursor: pointer; }
.btn-lihat:hover { background: #0C447C; }
.aksi-group { display: flex; gap: 4px; }
.modal-faux { display: none; min-height: 490px; background: rgba(0,0,0,0.45); position: absolute; inset: 0; z-index: 200; align-items: center; justify-content: center; backdrop-filter: blur(2px); }
.modal-faux.show { display: flex; animation: fadeInOverlay 0.2s; }
@keyframes fadeInOverlay { from { opacity: 0; } to { opacity: 1; } }

/* --- Modal Peminjaman --- */
.modal-box { background: var(--bg); border-radius: var(--radius); width: 92%; max-width: 390px; padding: 18px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.modal-title { font-size: 12px; font-weight: 700; margin-bottom: 14px; }
.stepper { display: flex; align-items: flex-start; justify-content: center; margin-bottom: 16px; }
.step { display: flex; flex-direction: column; align-items: center; gap: 4px; flex: 1; }
.step-circle { width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; background: var(--card-bg); border: 2px solid var(--card-border); color: var(--text-muted); transition: all 0.3s; }
.step.active .step-circle,.step.done .step-circle { background: var(--green); border-color: var(--green); color: white; }
.step-label { font-size: 9px; color: var(--text-muted); text-align: center; font-weight: 500; transition: color 0.3s; }
.step.active .step-label,.step.done .step-label { color: var(--green); font-weight: 700; }
.step-line { flex: 1; height: 2px; background: var(--card-border); margin-top: 13px; transition: background 0.3s; }
.step-line.done { background: var(--green); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 8px; }
.form-group { display: flex; flex-direction: column; gap: 3px; }
.form-group label { font-size: 10px; color: var(--text-muted); font-weight: 500; }
.form-group input { padding: 6px 9px; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius-sm); font-size: 11px; color: var(--text); outline: none; transition: border-color 0.2s; }
.form-group input:focus { border-color: var(--green); }
.form-group input[readonly] { background: #f0f0f0; color: var(--text-muted); cursor: default; border: 1px solid #ccc; }
.book-preview { display: flex; align-items: center; gap: 10px; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius-sm); padding: 10px; margin-bottom: 8px; }
.book-preview-cover { width: 38px; height: 50px; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
.book-preview-title { font-size: 12px; font-weight: 700; }
.book-preview-author { font-size: 10px; color: var(--text-muted); margin: 2px 0 5px; }
.modal-footer { display: flex; gap: 8px; justify-content: flex-end; margin-top: 14px; padding-top: 12px; border-top: 1px solid var(--card-border); }
.btn-batal { padding: 7px 16px; border-radius: var(--radius-sm); background: var(--card-bg); border: 1px solid var(--card-border); font-size: 11px; font-weight: 700; cursor: pointer; color: var(--text); }
.btn-batal:hover { background: #e0e0e0; }
.btn-proses { padding: 7px 16px; border-radius: var(--radius-sm); background: var(--green); border: none; color: white; font-size: 11px; font-weight: 700; cursor: pointer; }
.btn-proses:hover { background: var(--green-light); }
.success-box { text-align: center; padding: 18px 10px; }
.success-icon { font-size: 38px; margin-bottom: 8px; display: block; }
.success-title { font-size: 14px; font-weight: 700; margin-bottom: 5px; }
.success-sub { font-size: 11px; color: var(--text-muted); }
.profil-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius); padding: 16px; max-width: 320px; margin: 0 auto; }
.profil-avatar { font-size: 44px; text-align: center; margin-bottom: 8px; }
.profil-name { font-size: 15px; font-weight: 700; text-align: center; }
.profil-nim { font-size: 11px; color: #666; text-align: center; margin-top: 2px; }
.profil-badge { display: inline-block; margin: 7px auto; background: var(--green-bg); color: var(--green); padding: 2px 12px; border-radius: 20px; font-size: 10px; font-weight: 700; }
.profil-divider { border-top: 1px solid var(--card-border); padding-top: 12px; display: flex; flex-direction: column; gap: 8px; font-size: 11px; }
.profil-row { display: flex; justify-content: space-between; }
.toast { display: none; position: absolute; bottom: 16px; right: 16px; background: var(--green); color: white; padding: 8px 16px; border-radius: 8px; font-size: 11px; font-weight: 700; z-index: 999; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }

/* --- MODAL DETAIL --- */
.detail-modal-box { 
  background: var(--bg); 
  border-radius: var(--radius); 
  width: 90%; 
  max-width: 360px; 
  max-height: 85vh; 
  padding: 0; 
  overflow: hidden; 
  display: flex; 
  flex-direction: column; 
  box-shadow: 0 10px 25px rgba(0,0,0,0.2); 
  animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1); 
}

.detail-header { 
  background: #185FA5; 
  padding: 10px 14px; 
  flex-shrink: 0; 
}
.detail-header-title { font-size: 12px; font-weight: 700; color: white; margin-bottom: 1px; }
.detail-header-sub { font-size: 9px; color: rgba(255,255,255,0.75); }

.detail-body { 
  padding: 12px 14px; 
  overflow-y: auto; 
  flex: 1; 
}
.detail-book-card { 
  display: flex; 
  align-items: center; 
  gap: 10px; 
  background: #f0f0f0; 
  border-radius: var(--radius-sm); 
  padding: 10px; 
  margin-bottom: 10px; 
  border: 1px solid var(--card-border); 
}
.detail-book-cover { 
  width: 38px; 
  height: 50px; 
  border-radius: 5px; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
  font-size: 22px; 
  flex-shrink: 0; 
  box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
}
.detail-book-title { font-size: 11px; font-weight: 700; color: var(--text); margin-bottom: 2px; }
.detail-book-author { font-size: 9px; color: var(--text-muted); }
.detail-section { font-size: 9px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 6px; margin-top: 4px; }
.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 10px; }
.detail-item { 
  background: var(--card-bg); 
  border: 1px solid var(--card-border); 
  border-radius: var(--radius-sm); 
  padding: 6px 8px; 
  margin-bottom: 6px;
}
.detail-item-label { font-size: 8px; color: var(--text-muted); font-weight: 500; margin-bottom: 2px; }
.detail-item-value { font-size: 10px; font-weight: 700; color: var(--text); }
.detail-status-row { 
  display: flex; 
  align-items: center; 
  gap: 8px; 
  background: var(--card-bg); 
  border: 1px solid var(--card-border); 
  border-radius: var(--radius-sm); 
  padding: 8px 10px; 
  margin-bottom: 6px; 
}
.detail-status-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.dot-dipinjam { background: #856404; }
.dot-terlambat { background: #842029; }
.dot-kembali { background: #276432; }
.detail-status-label { font-size: 9px; color: var(--text-muted); }
.detail-status-val { font-size: 11px; font-weight: 700; color: var(--text); }
.sisa-bar-wrap { 
  background: var(--card-bg); 
  border: 1px solid var(--card-border); 
  border-radius: var(--radius-sm); 
  padding: 8px 10px; 
  margin-bottom: 10px; 
}
.sisa-bar-label { display: flex; justify-content: space-between; font-size: 9px; color: var(--text-muted); margin-bottom: 4px; }
.sisa-bar-track { background: #ccc; border-radius: 4px; height: 6px; overflow: hidden; }
.sisa-bar-fill { height: 100%; border-radius: 4px; transition: width 1s ease; }
.detail-footer { 
  display: flex; 
  gap: 8px; 
  justify-content: flex-end; 
  padding: 10px 14px; 
  border-top: 1px solid var(--card-border); 
  background: #fafafa; 
  flex-shrink: 0; 
}
.btn-detail-close { 
  padding: 6px 14px; 
  border-radius: var(--radius-sm); 
  background: var(--card-bg); 
  border: 1px solid var(--card-border); 
  font-size: 10px; 
  font-weight: 700; 
  cursor: pointer; 
  color: var(--text); 
}
.btn-detail-close:hover { background: #e0e0e0; }
</style>
</head>
<body style="background:#f4f4f4; display:flex; align-items:center; min-height:100vh;">

<div class="frame">
  <div class="frame-bar">
    <div class="frame-dot dot-r"></div>
    <div class="frame-dot dot-y"></div>
    <div class="frame-dot dot-g"></div>
    <span style="margin-left:8px;font-size:11px;">Sistem Perpustakaan Digital</span>
  </div>
  <div class="app">

    <!-- Modal Peminjaman (Wizard) -->
    <div class="modal-faux" id="modalOverlay">
      <div class="modal-box">
        <div class="modal-title">Alur Peminjaman Buku</div>
        <div class="stepper">
          <div class="step active" id="step1"><div class="step-circle">1</div><div class="step-label">Pilih Buku</div></div>
          <div class="step-line" id="line1"></div>
          <div class="step" id="step2"><div class="step-circle">2</div><div class="step-label">Peminjaman</div></div>
          <div class="step-line" id="line2"></div>
          <div class="step" id="step3"><div class="step-circle">3</div><div class="step-label">Konfirmasi</div></div>
        </div>
        <div id="modalStep1">
          <div class="book-preview">
            <div class="book-preview-cover" id="mCover" style="background:#d4e8f4;">📘</div>
            <div>
              <div class="book-preview-title" id="mJudul">—</div>
              <div class="book-preview-author" id="mPenulis">—</div>
              <span class="badge badge-tersedia">Tersedia</span>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn-batal" onclick="closeModal()">Batal</button>
            <button class="btn-proses" onclick="goStep(2)">Lanjut →</button>
          </div>
        </div>
        <div id="modalStep2" style="display:none;">
          <div class="form-row">
            <div class="form-group"><label>NIM Peminjam</label><input type="text" id="inputNim" placeholder="2021001234" readonly></div>
            <div class="form-group"><label>Nama Peminjam</label><input type="text" id="inputNama" placeholder="Nama lengkap" readonly></div>
          </div>
          <div class="book-preview">
            <div class="book-preview-cover" id="mCover2" style="background:#d4e8f4;">📘</div>
            <div>
              <div class="book-preview-title" id="mJudul2">—</div>
              <div class="book-preview-author" id="mPenulis2">—</div>
              <span class="badge badge-tersedia">Tersedia</span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group"><label>Tanggal Dipinjam</label><input type="text" id="iTglPinjam" readonly></div>
            <div class="form-group"><label>Tanggal Kembali</label><input type="text" id="iTglKembali" readonly></div>
          </div>
          <div class="form-group" style="margin-bottom:4px;"><label>Durasi Peminjaman</label><input type="text" id="iDurasi" readonly></div>
          <div class="modal-footer">
            <button class="btn-batal" onclick="goStep(1)">← Kembali</button>
            <button class="btn-proses" onclick="prosesStep2()">Proses Pinjam</button>
          </div>
        </div>
        <div id="modalStep3" style="display:none;">
          <div class="success-box">
            <div class="success-icon">✅</div>
            <div class="success-title">Peminjaman Berhasil!</div>
            <div class="success-sub" id="successDesc">Buku telah berhasil dipinjam.</div>
          </div>
          <div class="modal-footer" style="justify-content:center;">
            <button class="btn-proses" onclick="selesai()">Selesai</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal-faux" id="detailOverlay">
      <div class="detail-modal-box">
        <div class="detail-header">
          <div class="detail-header-title" id="dHeaderTitle">Detail Peminjaman</div>
          <div class="detail-header-sub" id="dHeaderSub">ID Transaksi: #TRX-0001</div>
        </div>
        <div class="detail-body">
          <div class="detail-book-card">
            <div class="detail-book-cover" id="dCover" style="background:#d4e8f4;">📘</div>
            <div>
              <div class="detail-book-title" id="dJudul">—</div>
              <div class="detail-book-author" id="dPenulis">—</div>
            </div>
          </div>

          <div class="detail-section">Data Peminjam</div>
          <div class="detail-grid">
            <div class="detail-item"><div class="detail-item-label">NIM</div><div class="detail-item-value" id="dNim">—</div></div>
            <div class="detail-item"><div class="detail-item-label">Nama</div><div class="detail-item-value" id="dNama">—</div></div>
          </div>

          <div class="detail-section">Informasi Peminjaman</div>
          <div class="detail-grid">
            <div class="detail-item"><div class="detail-item-label">Tgl Pinjam</div><div class="detail-item-value" id="dTglPinjam">—</div></div>
            <div class="detail-item"><div class="detail-item-label">Tgl Kembali</div><div class="detail-item-value" id="dTglKembali">—</div></div>
            <div class="detail-item"><div class="detail-item-label">Durasi</div><div class="detail-item-value" id="dDurasi">—</div></div>
            <div class="detail-item"><div class="detail-item-label">Sisa Hari</div><div class="detail-item-value" id="dSisaHari">—</div></div>
          </div>

          <div class="sisa-bar-wrap">
            <div class="sisa-bar-label"><span id="dBarLabel">Progress Peminjaman</span><span id="dBarPct">0%</span></div>
            <div class="sisa-bar-track"><div class="sisa-bar-fill" id="dBarFill" style="width:0%;background:var(--green);"></div></div>
          </div>

          <div class="detail-status-row">
            <div class="detail-status-dot" id="dDot"></div>
            <div>
              <div class="detail-status-label">Status Peminjaman</div>
              <div class="detail-status-val" id="dStatus">—</div>
            </div>
          </div>
        </div>
        <div class="detail-footer">
          <button class="btn-detail-close" onclick="closeDetail()">Tutup</button>
        </div>
      </div>
    </div>

    <header class="header">
      <div style="width:50px;"></div>
      <div class="header-title">SISTEM PERPUSTAKAAN DIGITAL</div>
      <div style="font-size:16px;">🛒👤</div>
    </header>

    <div class="body">
      <aside class="sidebar">
        <div class="nav-item" id="nav-dashboard" onclick="showPage('dashboard')">Dashboard</div>
        <div class="nav-item" id="nav-peminjaman" onclick="showPage('peminjaman')">Peminjaman</div>
        <div class="nav-item" id="nav-katalog" onclick="showPage('katalog')">Katalog</div>
        <div class="nav-item active" id="nav-profil" onclick="showPage('profil')">Profil</div>
      </aside>

      <main class="main">

        <!-- HALAMAN DASHBOARD -->
        <div class="page" id="page-dashboard">
          <div class="search-wrap">
            <div class="search-box">
              <input type="text" placeholder="Cari buku..." id="searchInput" oninput="searchDash()">
              <span style="color:#666;font-size:13px;">🔍</span>
            </div>
          </div>
          <div class="stat-row">
            <div class="stat-card"><div class="stat-label">Total Koleksi Buku</div><div class="stat-value">1.000</div></div>
            <div class="stat-card"><div class="stat-label">Dipinjam Aktif</div><div class="stat-value">350</div></div>
            <div class="stat-card"><div class="stat-label">Terlambat</div><div class="stat-value">50</div><div class="stat-note">Perlu Tindakan</div></div>
          </div>
          <div class="section-box">
            <div class="section-title">Buku paling diminati</div>
            <div class="book-grid" id="bookGrid">
              <div class="book-item"><div class="book-cover" style="background:#d4e8f4;">📘</div><div><div class="book-title">Algoritma &amp; Pemrograman</div><div class="book-author">Rinaldi M. · Informatika</div><span class="badge badge-tersedia">Tersedia</span></div></div>
              <div class="book-item"><div class="book-cover" style="background:#fde8d8;">📙</div><div><div class="book-title">Manajemen Keuangan</div><div class="book-author">Brigham · Ekonomi</div><span class="badge badge-habis">Habis</span></div></div>
              <div class="book-item"><div class="book-cover" style="background:#e8f4d4;">📗</div><div><div class="book-title">Hukum Perdata Indonesia</div><div class="book-author">Subekti · Hukum</div><span class="badge badge-terbatas">6 Tersisa</span></div></div>
              <div class="book-item"><div class="book-cover" style="background:#f4d4e8;">📕</div><div><div class="book-title">Biologi Molekuler</div><div class="book-author">Lewin · Kedokteran</div><span class="badge badge-tersedia">Tersedia</span></div></div>
            </div>
          </div>
        </div>

        <!-- HALAMAN PEMINJAMAN -->
        <div class="page" id="page-peminjaman">
          <div class="section-box">
            <div class="pinjam-header">
              <h3>Data Peminjaman Saya</h3>
            </div>
            <table class="pinjam-table">
              <thead>
                <tr>
                  <th style="width:28px;">#</th>
                  <th style="width:30%;">Judul Buku</th>
                  <th style="width:22%;">Peminjam</th>
                  <th style="width:17%;">Tgl Pinjam</th>
                  <th style="width:17%;">Tgl Kembali</th>
                  <th style="width:13%;">Status</th>
                  <th style="width:50px;">Aksi</th>
                </tr>
              </thead>
              <tbody id="pinjamTbody"></tbody>
            </table>
          </div>
        </div>

        <!-- HALAMAN KATALOG -->
        <div class="page" id="page-katalog">
          <div class="section-box">
            <div class="pinjam-header" style="flex-wrap:wrap;gap:8px;">
              <h3>Katalog Buku</h3>
              <div class="search-box" style="width:160px;"><input type="text" id="katalogSearch" placeholder="Cari buku..." oninput="filterKatalog()"><span style="font-size:12px;color:#666;">🔍</span></div>
            </div>
            <div style="display:flex;gap:5px;flex-wrap:wrap;margin-bottom:10px;">
              <button class="filter-pill active" data-filter="semua" onclick="setFilter(this,'semua')">Semua</button>
              <button class="filter-pill" data-filter="Informatika" onclick="setFilter(this,'Informatika')">Informatika</button>
              <button class="filter-pill" data-filter="Ekonomi" onclick="setFilter(this,'Ekonomi')">Ekonomi</button>
              <button class="filter-pill" data-filter="Hukum" onclick="setFilter(this,'Hukum')">Hukum</button>
              <button class="filter-pill" data-filter="Kedokteran" onclick="setFilter(this,'Kedokteran')">Kedokteran</button>
              <button class="filter-pill" data-filter="Sains" onclick="setFilter(this,'Sains')">Sains</button>
              <button class="filter-pill" data-filter="Kimia" onclick="setFilter(this,'Kimia')">Kimia</button>
            </div>
            <div style="display:flex;gap:5px;margin-bottom:12px;align-items:center;">
              <span style="font-size:10px;color:var(--text-muted);font-weight:600;">Status:</span>
              <button class="filter-pill active" data-status="semua" onclick="setStatus(this,'semua')">Semua</button>
              <button class="filter-pill" data-status="tersedia" onclick="setStatus(this,'tersedia')">Tersedia</button>
              <button class="filter-pill" data-status="terbatas" onclick="setStatus(this,'terbatas')">Terbatas</button>
              <button class="filter-pill" data-status="habis" onclick="setStatus(this,'habis')">Habis</button>
            </div>
            <div class="book-grid" id="katalogGrid">
              <div class="book-item" data-kategori="Informatika" data-status="tersedia"><div class="book-cover" style="background:#d4e8f4;">📘</div><div><div class="book-title">Algoritma &amp; Pemrograman</div><div class="book-author">Rinaldi M. · Informatika</div><div style="display:flex;align-items:center;gap:5px;margin-top:3px;"><span class="badge badge-tersedia">Tersedia</span><button class="btn-pinjam-kecil" onclick="pinjamBuku('Algoritma & Pemrograman','Rinaldi M. · Informatika','#d4e8f4','📘')">Pinjam</button></div></div></div>
              <div class="book-item" data-kategori="Ekonomi" data-status="habis"><div class="book-cover" style="background:#fde8d8;">📙</div><div><div class="book-title">Manajemen Keuangan</div><div class="book-author">Brigham · Ekonomi</div><div style="display:flex;align-items:center;gap:5px;margin-top:3px;"><span class="badge badge-habis">Habis</span><button class="btn-pinjam-kecil" disabled style="opacity:0.4;cursor:not-allowed;">Pinjam</button></div></div></div>
              <div class="book-item" data-kategori="Hukum" data-status="terbatas"><div class="book-cover" style="background:#e8f4d4;">📗</div><div><div class="book-title">Hukum Perdata Indonesia</div><div class="book-author">Subekti · Hukum</div><div style="display:flex;align-items:center;gap:5px;margin-top:3px;"><span class="badge badge-terbatas">6 Tersisa</span><button class="btn-pinjam-kecil" onclick="pinjamBuku('Hukum Perdata Indonesia','Subekti · Hukum','#e8f4d4','📗')">Pinjam</button></div></div></div>
              <div class="book-item" data-kategori="Kedokteran" data-status="tersedia"><div class="book-cover" style="background:#f4d4e8;">📕</div><div><div class="book-title">Biologi Molekuler</div><div class="book-author">Lewin · Kedokteran</div><div style="display:flex;align-items:center;gap:5px;margin-top:3px;"><span class="badge badge-tersedia">Tersedia</span><button class="btn-pinjam-kecil" onclick="pinjamBuku('Biologi Molekuler','Lewin · Kedokteran','#f4d4e8','📕')">Pinjam</button></div></div></div>
              <div class="book-item" data-kategori="Sains" data-status="tersedia"><div class="book-cover" style="background:#f4f0d4;">📒</div><div><div class="book-title">Fisika Dasar</div><div class="book-author">Halliday · Sains</div><div style="display:flex;align-items:center;gap:5px;margin-top:3px;"><span class="badge badge-tersedia">Tersedia</span><button class="btn-pinjam-kecil" onclick="pinjamBuku('Fisika Dasar','Halliday · Sains','#f4f0d4','📒')">Pinjam</button></div></div></div>
              <div class="book-item" data-kategori="Kimia" data-status="terbatas"><div class="book-cover" style="background:#e4d4f4;">📓</div><div><div class="book-title">Kimia Organik</div><div class="book-author">McMurry · Kimia</div><div style="display:flex;align-items:center;gap:5px;margin-top:3px;"><span class="badge badge-terbatas">3 Tersisa</span><button class="btn-pinjam-kecil" onclick="pinjamBuku('Kimia Organik','McMurry · Kimia','#e4d4f4','📓')">Pinjam</button></div></div></div>
              <div class="book-item" data-kategori="Informatika" data-status="tersedia"><div class="book-cover" style="background:#d4eaf4;">📔</div><div><div class="book-title">Basis Data Modern</div><div class="book-author">Ramakrishnan · Informatika</div><div style="display:flex;align-items:center;gap:5px;margin-top:3px;"><span class="badge badge-tersedia">Tersedia</span><button class="btn-pinjam-kecil" onclick="pinjamBuku('Basis Data Modern','Ramakrishnan · Informatika','#d4eaf4','📔')">Pinjam</button></div></div></div>
              <div class="book-item" data-kategori="Ekonomi" data-status="terbatas"><div class="book-cover" style="background:#fdf4d4;">📜</div><div><div class="book-title">Akuntansi Keuangan</div><div class="book-author">Kieso · Ekonomi</div><div style="display:flex;align-items:center;gap:5px;margin-top:3px;"><span class="badge badge-terbatas">2 Tersisa</span><button class="btn-pinjam-kecil" onclick="pinjamBuku('Akuntansi Keuangan','Kieso · Ekonomi','#fdf4d4','📜')">Pinjam</button></div></div></div>
            </div>
            <div id="katalogEmpty" style="display:none;text-align:center;padding:24px 0;color:var(--text-muted);font-size:12px;"><div style="font-size:24px;margin-bottom:6px;">📭</div>Tidak ada buku yang sesuai filter</div>
          </div>
        </div>

        <!-- HALAMAN PROFIL -->
        <div class="page active" id="page-profil">
          <div class="profil-card">
            <div class="profil-avatar">🧑‍🎓</div>
            <div class="profil-name">Budi Santoso</div>
            <div class="profil-nim">NIM: 2021001234</div>
            <div style="text-align:center;"><span class="profil-badge">Mahasiswa Aktif</span></div>
            <div class="profil-divider">
              <div class="profil-row"><span style="color:#666;">Email</span><span style="font-weight:600;">budi@kampus.ac.id</span></div>
              <div class="profil-row"><span style="color:#666;">Jurusan</span><span style="font-weight:600;">Teknik Informatika</span></div>
              <div class="profil-row"><span style="color:#666;">Buku Dipinjam</span><span style="font-weight:600;">5 buku</span></div>
              <div class="profil-row"><span style="color:#666;">Total Dipinjam</span><span style="font-weight:600;">25 buku</span></div>
            </div>
          </div>
        </div>

        <!-- Toast Notification -->
        <div class="toast" id="toast"></div>
      </main>
    </div>
  </div>
</div>

<script>
let activeKategori='semua', activeStatus='semua', currentBook={}, pinjamCount=0;

const coverMap = {
  'Algoritma & Pemrograman': {bg:'#d4e8f4', em:'📘'},
  'Manajemen Keuangan': {bg:'#fde8d8', em:'📙'},
  'Hukum Perdata Indonesia': {bg:'#e8f4d4', em:'📗'},
  'Biologi Molekuler': {bg:'#f4d4e8', em:'📕'},
  'Fisika Dasar': {bg:'#f4f0d4', em:'📒'},
  'Kimia Organik': {bg:'#e4d4f4', em:'📓'},
  'Basis Data Modern': {bg:'#d4eaf4', em:'📔'},
};

const nimMap = {
  'Budi Santoso': '2021001234',
  'Siti Rahma': '2021001002',
  'Andi Kurnia': '2021001003',
  'Dewi Lestari': '2021001004',
  'Rizky Pratama': '2021001005',
  'Hendra Wijaya': '2021001006',
  'Laila Nur': '2021001007',
};

const initialData = [
  {id:1, judul:'Algoritma & Pemrograman', nim:'2021001234', nama:'Budi Santoso', tglPinjam:'01 Apr 2025', tglKembali:'15 Apr 2025', status:'terlambat'},
  {id:2, judul:'Basis Data Modern', nim:'2021001234', nama:'Budi Santoso', tglPinjam:'18 Apr 2025', tglKembali:'02 May 2025', status:'dipinjam'},
  {id:3, judul:'Fisika Dasar', nim:'2021001234', nama:'Budi Santoso', tglPinjam:'10 Mar 2025', tglKembali:'24 Mar 2025', status:'kembali'},
  {id:4, judul:'Hukum Perdata Indonesia', nim:'2021001234', nama:'Budi Santoso', tglPinjam:'20 Apr 2025', tglKembali:'04 May 2025', status:'dipinjam'},
  {id:5, judul:'Biologi Molekuler', nim:'2021001234', nama:'Budi Santoso', tglPinjam:'05 Apr 2025', tglKembali:'19 Apr 2025', status:'terlambat'},
  {id:6, judul:'Kimia Organik', nim:'2021001234', nama:'Budi Santoso', tglPinjam:'12 Apr 2025', tglKembali:'26 Apr 2025', status:'dipinjam'},
  {id:7, judul:'Manajemen Keuangan', nim:'2021001002', nama:'Siti Rahma', tglPinjam:'10 Apr 2025', tglKembali:'24 Apr 2025', status:'dipinjam'},
  {id:8, judul:'Akuntansi Keuangan', nim:'2021001003', nama:'Andi Kurnia', tglPinjam:'15 Apr 2025', tglKembali:'29 Apr 2025', status:'dipinjam'},
];

let dataList = [...initialData];
pinjamCount = dataList.length;

function parseDate(str) {
  const months = {Jan:0,Feb:1,Mar:2,Apr:3,Mei:4,Jun:5,Jul:6,Agu:7,Sep:8,Okt:9,Nov:10,Des:11};
  const parts = str.split(' ');
  return new Date(parseInt(parts[2]), months[parts[1]], parseInt(parts[0]));
}

function sisaHari(tglKembali, status) {
  if (status === 'kembali') return null;
  const today = new Date();
  today.setHours(0,0,0,0);
  const due = parseDate(tglKembali);
  return Math.round((due - today) / 86400000);
}

function statusLabel(s) {
  if (s==='dipinjam') return 'Dipinjam';
  if (s==='terlambat') return 'Terlambat';
  return 'Dikembalikan';
}

function statusPillClass(s) {
  if (s==='dipinjam') return 's-dipinjam';
  if (s==='terlambat') return 's-terlambat';
  return 's-kembali';
}

function renderTable() {
  const tbody = document.getElementById('pinjamTbody');
  if(!tbody) return;
  tbody.innerHTML = '';
  const currentUser = 'Budi Santoso';
  const userLoans = dataList.filter(d => d.nama === currentUser);

  if (userLoans.length === 0) {
    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:12px;color:#888;">Belum ada riwayat peminjaman.</td></tr>';
    return;
  }

  userLoans.forEach(d => {
    const tr = document.createElement('tr');
    tr.innerHTML =
      '<td>' + d.id + '</td>' +
      '<td style="font-weight:600;">' + d.judul + '</td>' +
      '<td>' + d.nama + '</td>' +
      '<td>' + d.tglPinjam + '</td>' +
      '<td>' + d.tglKembali + '</td>' +
      '<td><span class="status-pill ' + statusPillClass(d.status) + '">' + statusLabel(d.status) + '</span></td>' +
      '<td><div class="aksi-group"><button class="btn-lihat" onclick="lihatDetail(' + d.id + ')">👁 Lihat</button></div></td>';
    tbody.appendChild(tr);
  });
}

function lihatDetail(id) {
  const d = dataList.find(x => x.id === id);
  if (!d) return;
  const cover = coverMap[d.judul] || {bg:'#d4e8f4', em:'📘'};

  document.getElementById('dHeaderTitle').textContent = 'Detail Peminjaman #' + String(d.id).padStart(3,'0');
  document.getElementById('dHeaderSub').textContent = 'ID Transaksi: #TRX-' + String(d.id).padStart(4,'0');
  document.getElementById('dCover').style.background = cover.bg;
  document.getElementById('dCover').textContent = cover.em;
  document.getElementById('dJudul').textContent = d.judul;
  document.getElementById('dPenulis').textContent = d.nama;
  document.getElementById('dNim').textContent = d.nim || nimMap[d.nama] || '—';
  document.getElementById('dNama').textContent = d.nama;
  document.getElementById('dTglPinjam').textContent = d.tglPinjam;
  document.getElementById('dTglKembali').textContent = d.tglKembali;
  
  const pinjamDate = parseDate(d.tglPinjam);
  const kembaliDate = parseDate(d.tglKembali);
  const totalDuration = Math.round((kembaliDate - pinjamDate) / 86400000);
  document.getElementById('dDurasi').textContent = totalDuration + ' hari';

  const today = new Date();
  today.setHours(0,0,0,0);

  let sisaText = '';
  let barColor = '';
  let labelText = '';
  let barWidth = '100%';

  if (d.status === 'kembali') {
    sisaText = 'Selesai';
    barColor = '#276432'; 
    labelText = 'Selesai dikembalikan';
  } else if (d.status === 'terlambat') {
    const daysOverdue = Math.round((today - kembaliDate) / 86400000);
    sisaText = 'Terlambat ' + Math.abs(daysOverdue) + ' hari';
    barColor = '#842029'; 
    labelText = 'Status Terlambat';
  } else {
    sisaText = totalDuration + ' hari';
    barColor = '#856404'; 
    labelText = 'Total Durasi Peminjaman';
  }

  document.getElementById('dSisaHari').textContent = sisaText;
  document.getElementById('dBarFill').style.width = barWidth;
  document.getElementById('dBarPct').textContent = '100%';
  document.getElementById('dBarLabel').textContent = labelText;
  document.getElementById('dBarFill').style.background = barColor;

  let dotClass = 'dot-dipinjam';
  if (d.status==='terlambat') dotClass='dot-terlambat';
  if (d.status==='kembali') dotClass='dot-kembali';
  
  document.getElementById('dDot').className = 'detail-status-dot ' + dotClass;
  document.getElementById('dStatus').textContent = statusLabel(d.status);

  document.getElementById('detailOverlay').classList.add('show');
}

function closeDetail() {
  document.getElementById('detailOverlay').classList.remove('show');
}

// Fungsi Navigasi (Diupdate untuk file terpisah)
function showPage(name) {
  if(name === 'dashboard') window.location.href = 'dashboard.html';
  if(name === 'peminjaman') window.location.href = 'peminjaman.html';
  if(name === 'katalog') window.location.href = 'katalog.html';
  if(name === 'profil') window.location.href = 'profil.html';
}

function searchDash() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  document.querySelectorAll('#bookGrid .book-item').forEach(item => {
    item.style.display = item.innerText.toLowerCase().includes(q) ? 'flex' : 'none';
  });
}

function setFilter(el, val) {
  document.querySelectorAll('[data-filter]').forEach(b => b.classList.remove('active'));
  el.classList.add('active'); activeKategori = val; filterKatalog();
}

function setStatus(el, val) {
  document.querySelectorAll('[data-status]').forEach(b => b.classList.remove('active'));
  el.classList.add('active'); activeStatus = val; filterKatalog();
}

function filterKatalog() {
  const q = (document.getElementById('katalogSearch').value || '').toLowerCase();
  let visible = 0;
  document.querySelectorAll('#katalogGrid .book-item').forEach(item => {
    const ok = (activeKategori==='semua' || item.dataset.kategori===activeKategori)
             && (activeStatus==='semua' || item.dataset.status===activeStatus)
             && item.innerText.toLowerCase().includes(q);
    item.style.display = ok ? 'flex' : 'none';
    if (ok) visible++;
  });
  const empty = document.getElementById('katalogEmpty');
  if(empty) empty.style.display = visible===0 ? 'block' : 'none';
}

function pinjamBuku(judul, penulis, coverBg, coverEmoji, fromPeminjaman) {
  currentBook = { judul, penulis, coverBg: coverBg||'#d4e8f4', coverEmoji: coverEmoji||'📘' };
  document.getElementById('mJudul').textContent = judul || '— Pilih dari katalog —';
  document.getElementById('mPenulis').textContent = penulis || '';
  document.getElementById('mCover').style.background = currentBook.coverBg;
  document.getElementById('mCover').textContent = currentBook.coverEmoji;
  document.getElementById('mJudul2').textContent = judul || '—';
  document.getElementById('mPenulis2').textContent = penulis || '';
  document.getElementById('mCover2').style.background = currentBook.coverBg;
  document.getElementById('mCover2').textContent = currentBook.coverEmoji;

  document.getElementById('inputNim').value = '2021001234';
  document.getElementById('inputNama').value = 'Budi Santoso';

  const today = new Date(), due = new Date(today);
  due.setDate(due.getDate() + 14);
  const fmt = d => d.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'});
  currentBook.tglPinjam = fmt(today);
  currentBook.tglKembali = fmt(due);
  document.getElementById('iTglPinjam').value = currentBook.tglPinjam;
  document.getElementById('iTglKembali').value = currentBook.tglKembali;
  document.getElementById('iDurasi').value = '14 hari';
  goStep(1);
  document.getElementById('modalOverlay').classList.add('show');
}

function goStep(n) {
  [1,2,3].forEach(i => {
    document.getElementById('modalStep'+i).style.display = i===n ? 'block' : 'none';
    const s = document.getElementById('step'+i);
    s.classList.remove('active','done');
    if (i<n) s.classList.add('done');
    if (i===n) s.classList.add('active');
  });
  document.getElementById('line1').classList.toggle('done', n>=2);
  document.getElementById('line2').classList.toggle('done', n>=3);
}

function prosesStep2() {
  const nim = document.getElementById('inputNim').value.trim();
  const nama = document.getElementById('inputNama').value.trim();
  if (!nim || !nama) { alert('Data peminjam wajib diisi!'); return; }
  
  pinjamCount++;
  const newEntry = {
    id: pinjamCount,
    judul: currentBook.judul || 'Buku Baru',
    nim: nim,
    nama: nama,
    tglPinjam: currentBook.tglPinjam,
    tglKembali: currentBook.tglKembali,
    status: 'dipinjam'
  };
  dataList.unshift(newEntry);
  dataList.forEach((d, i) => d.id = dataList.length - i);
  renderTable();
  document.getElementById('successDesc').textContent = '"' + newEntry.judul + '" berhasil dipinjam oleh ' + nama + '.';
  goStep(3);
}

function closeModal() { document.getElementById('modalOverlay').classList.remove('show'); }

function selesai() {
  closeModal();
  window.location.href = 'peminjaman.html';
  showToast('✓ Peminjaman berhasil dicatat!');
}

function showToast(msg) {
  const t = document.getElementById('toast');
  if(!t) return;
  t.textContent = msg; t.style.display = 'block'; t.style.opacity = '1';
  setTimeout(() => {
    t.style.transition = 'opacity 0.4s'; t.style.opacity = '0';
    setTimeout(() => { t.style.display='none'; t.style.opacity='1'; t.style.transition=''; }, 400);
  }, 2500);
}

window.onload = function() {
  renderTable();
};
</script>
</body>
</html>