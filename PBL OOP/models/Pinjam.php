<?php

require_once "../config/database.php";

class Pinjam extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getByUser($user_id)
    {
        $user_id = (int)$user_id;

        $query = "
            SELECT
                p.*,
                b.judul,
                b.penulis,
                b.cover
            FROM peminjaman p
            JOIN buku b ON p.buku_id = b.id
            WHERE p.user_id = $user_id
            ORDER BY p.id DESC
        ";

        $result = $this->conn->query($query);

        $data = [];

        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }

        return $data;
    }
    public function countByUser($user_id)
{
    $user_id = (int)$user_id;

    $query = "
        SELECT COUNT(*) as total
        FROM peminjaman
        WHERE user_id = $user_id
    ";

    $result = $this->conn->query($query);

    $row = $result->fetch_assoc();

    return $row['total'];
}

public function countDipinjamByUser($user_id)
{
    $user_id = (int)$user_id;

    $query = "
        SELECT COUNT(*) as total
        FROM peminjaman
        WHERE user_id = $user_id
        AND status = 'dipinjam'
    ";

    $result = $this->conn->query($query);

    $row = $result->fetch_assoc();

    return $row['total'];
}

public function countKembaliByUser($user_id)
{
    $user_id = (int)$user_id;

    $query = "
        SELECT COUNT(*) as total
        FROM peminjaman
        WHERE user_id = $user_id
        AND status = 'dikembalikan'
    ";

    $result = $this->conn->query($query);

    $row = $result->fetch_assoc();

    return $row['total'];
}
}