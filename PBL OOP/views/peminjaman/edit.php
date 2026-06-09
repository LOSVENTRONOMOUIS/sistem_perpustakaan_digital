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
    <title>Edit Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background: #f4f7fe; font-family: 'Poppins', sans-serif; }
        .card-custom { border: none; border-radius: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Edit Data Peminjaman</h3>
                <a href="peminjaman.php" class="btn btn-outline-secondary rounded-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card card-custom p-4">
                <form action="peminjaman.php?action=update" method="POST">
                    
                    <input type="hidden" name="id" value="<?= htmlspecialchars($pinjam['id']) ?>">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Peminjam</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($pinjam['nama'] ?? '') ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Pinjam</label>
                        <input type="date" class="form-control" name="tanggal_pinjam" value="<?= $pinjam['tanggal_pinjam'] ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Kembali</label>
                        <input type="date" class="form-control" name="tanggal_kembali" value="<?= $pinjam['tanggal_kembali'] ?>">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Status Peminjaman</label>
                        <select class="form-select" name="status">
                            <option value="dipinjam" <?= ($pinjam['status'] == 'dipinjam') ? 'selected' : '' ?>>Sedang Dipinjam</option>
                            <option value="dikembalikan" <?= ($pinjam['status'] == 'dikembalikan') ? 'selected' : '' ?>>Sudah Dikembalikan</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 text-end">
                        <button type="submit" class="btn btn-primary rounded-3 py-2 fw-semibold">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>