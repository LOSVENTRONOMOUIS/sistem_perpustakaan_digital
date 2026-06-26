<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f4f7fe; font-family:'Poppins',sans-serif; }
        .form-box { max-width:650px; margin:50px auto; background:white; padding:35px; border-radius:24px; box-shadow:0 10px 25px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="container">
    <div class="form-box">
        <h2 class="fw-bold mb-4">Tambah Buku</h2>

        <form action="buku.php?action=store" method="POST" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" class="form-control rounded-4" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Penulis</label>
                <input type="text" name="penulis" class="form-control rounded-4" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Penerbit</label>
                <input type="text" name="penerbit" class="form-control rounded-4" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun Terbit</label>
                <input type="number" name="tahun" class="form-control rounded-4" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control rounded-4" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php if(isset($kategori)): foreach($kategori as $k): ?>
                        <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Stok Buku</label>
                <input type="number" name="stok" class="form-control rounded-4" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Cover Buku <span class="text-muted">(Opsional)</span></label>
                <input type="file" name="cover" class="form-control rounded-4" accept="image/png, image/jpeg, image/jpg">
                <small class="text-muted d-block mt-1">*Format: JPG, JPEG, PNG.</small>
            </div>

            <div class="d-flex gap-2">
                <a href="buku.php" class="btn btn-secondary rounded-4 px-4">Kembali</a>
                <button type="submit" class="btn btn-primary rounded-4 px-4">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>