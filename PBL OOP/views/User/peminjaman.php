<tbody>

<?php $no = 1; ?>

<?php foreach($dataPeminjaman as $d): ?>

<tr>

    <td><?= $no++ ?></td>

    <td>
        <strong><?= $d['judul'] ?></strong>
    </td>

    <td><?= $d['nama'] ?></td>

    <td><?= $d['nim'] ?></td>

    <td><?= $d['tanggal_pinjam'] ?></td>

    <td><?= $d['tanggal_kembali'] ?></td>

    <td>

        <?php

        if($d['status'] == 'dipinjam'){
            $class = "s-dipinjam";
            $label = "Dipinjam";
        }
        elseif($d['status'] == 'terlambat'){
            $class = "s-terlambat";
            $label = "Terlambat";
        }
        else{
            $class = "s-kembali";
            $label = "Dikembalikan";
        }

        ?>

        <span class="status-pill <?= $class ?>">
            <?= $label ?>
        </span>

    </td>

    <td>

        <button
        class="btn-lihat"
        onclick='showFormDetail(
        <?= json_encode([
            "id" => $d["id"],
            "judul" => $d["judul"],
            "nama" => $d["nama"],
            "nim" => $d["nim"],
            "tglPinjam" => $d["tanggal_pinjam"],
            "tglKembali" => $d["tanggal_kembali"],
            "status" => $d["status"]
        ]) ?>
        )'>

        👁 Lihat

        </button>

    </td>

</tr>

<?php endforeach; ?>

<?php if(empty($dataPeminjaman)): ?>

<tr>

    <td colspan="8" class="text-center text-muted py-4">

        Belum ada data peminjaman

    </td>

</tr>

<?php endif; ?>

</tbody>