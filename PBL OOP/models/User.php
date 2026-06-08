<?php

require_once "../config/database.php";

class User extends Database {

    // semua user
    public function getAllUsers(){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM users
             WHERE role='anggota'
             OR role='admin'
             ORDER BY id DESC"
        );

        return mysqli_fetch_all(
            $query,
            MYSQLI_ASSOC
        );
    }

    // total anggota
    public function countAnggota(){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM users
             WHERE role='anggota'"
        );

        return mysqli_num_rows($query);
    }

    // tambah user
    public function tambahUser($data){

        $nama = htmlspecialchars($data['nama']);
        $email = htmlspecialchars($data['email']);
        $role = htmlspecialchars($data['role']);

        $password = password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        );

        mysqli_query(
            $this->conn,
            "INSERT INTO users
            (nama,email,password,role)

            VALUES

            ('$nama','$email','$password','$role')"
        );
    }

    // detail user
    public function getById($id){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM users
             WHERE id='$id'"
        );

        return mysqli_fetch_assoc($query);
    }

    // update user
    public function updateUser($data){

        $id = $data['id'];

        $nama = htmlspecialchars($data['nama']);
        $email = htmlspecialchars($data['email']);
        $role = htmlspecialchars($data['role']);

        // jika password diisi
        if(!empty($data['password'])){

            $password = password_hash(
                $data['password'],
                PASSWORD_DEFAULT
            );

            mysqli_query(
                $this->conn,
                "UPDATE users SET

                nama='$nama',
                email='$email',
                role='$role',
                password='$password'

                WHERE id='$id'"
            );

        } else {

            mysqli_query(
                $this->conn,
                "UPDATE users SET

                nama='$nama',
                email='$email',
                role='$role'

                WHERE id='$id'"
            );
        }
    }

    // hapus user
    public function hapusUser($id){

        mysqli_query(
            $this->conn,
            "DELETE FROM users
             WHERE id='$id'"
        );
    }
}