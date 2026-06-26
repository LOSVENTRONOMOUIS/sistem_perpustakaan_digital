<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f4f7fe; font-family:'Poppins',sans-serif; }
        .form-box { max-width:650px; margin:50px auto; background:white; padding:35px; border-radius:24px; box-shadow:0 10px 25px rgba(0,0,0,0.05); }
        .current-cover { width: 80px; height: 110px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-box">
        <h2 class="fw-bold mb-4">Edit Buku</h2>

        <form action="buku.php?action=update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $book['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" class="form-control rounded-4" value="<?= htmlspecialchars($book['judul']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Penulis</label>
                <input type="text" name="penulis" class="form-control rounded-4" value="<?= htmlspecialchars($book['penulis']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Penerbit</label>
                <input type="text" name="penerbit" class="form-control rounded-4" value="<?= htmlspecialchars($book['penerbit']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun Terbit</label>
                <input type="number" name="tahun" class="form-control rounded-4" value="<?= htmlspecialchars($book['tahun']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control rounded-4" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php if(isset($kategori)): foreach($kategori as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= ($book['kategori'] == $k['id']) ? 'selected' : '' ?>>
                            <?= $k['nama_kategori'] ?>
                        </option>
                    <?php endforeach; endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Stok Buku</label>
                <input type="number" name="stok" class="form-control rounded-4" value="<?= htmlspecialchars($book['stok']) ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Ganti Cover Buku</label>
                <div class="d-flex align-items-center gap-3">
                    <?php if(!empty($book['cover'])): ?>
                        <img src="../assets/images/covers/<?= $book['cover'] ?>" alt="Cover Saat Ini" class="current-cover">
                    <?php else: ?>
                        <div class="current-cover d-flex align-items-center justify-content-center bg-light text-muted" style="font-size: 10px; text-align: center;">No Cover</div>
                    <?php endif; ?>
                    
                    <div class="flex-grow-1">
                        <input type="file" name="cover" class="form-control rounded-4" accept="image/png, image/jpeg, image/jpg">
                        <small class="text-muted d-block mt-2">*Biarkan kosong jika tidak ingin mengganti cover lama.</small>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="buku.php" class="btn btn-secondary rounded-4 px-4">Batal</a>
                <button type="submit" class="btn btn-primary rounded-4 px-4">Update Buku</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>