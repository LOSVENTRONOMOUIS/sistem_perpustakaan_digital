<?php
session_start();
require 'koneksi.php';

$error = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_array($query);

    if($user){

        if($password == $user['password']){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nama'] = $user['nama'];

            // redirect berdasarkan role
            if($user['role'] == 'admin'){
                header("Location: index.php");
            } 
            elseif($user['role'] == 'anggota'){
                header("Location: dashboard_mhs.php");
            }
        

            exit;

        } else {
            $error = "Password salah!";
        }

    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#4facfe,#00f2fe);
    font-family:'Poppins',sans-serif;
}

.login-card{
    width:100%;
    max-width:380px;
    border:none;
    border-radius:20px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    background:white;
}

.form-control{
    border-radius:12px;
    padding:12px;
}

.btn-login{
    border-radius:12px;
    padding:12px;
    font-weight:600;
}

</style>

</head>

<body class="d-flex justify-content-center align-items-center" style="height:100vh;">

<form method="POST" class="login-card">

<h3 class="text-center fw-bold mb-4">
Login Perpustakaan
</h3>

<?php if($error != ""){ ?>
<div class="alert alert-danger text-center">
<?= $error ?>
</div>
<?php } ?>

<div class="mb-3">
<input type="email"
name="email"
class="form-control"
placeholder="Email"
required>
</div>

<div class="mb-3">
<input type="password"
name="password"
class="form-control"
placeholder="Password"
required>
</div>

<button name="login" class="btn btn-primary w-100 btn-login">
Login
</button>

</form>

</body>
</html>
