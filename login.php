<?php
require_once("etc/config.php");
session_start();
$error = "Masukan nomor induk dan password";

// Cek koneksi ke database
if (!$mysqli) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $nomor_induk = $_POST['nomor_induk'];
    $password = md5($_POST['password']);

    $sql = "SELECT nomor_induk, nama FROM pengguna WHERE nomor_induk = '$nomor_induk' AND password = '$password'";
    $result = mysqli_query($mysqli, $sql);

    // Cek apakah query berhasil dijalankan
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $nomor_induk = $row['nomor_induk'];
        $nama = $row['nama'];

        // Set session dan redirect ke halaman index
        $_SESSION['nomor_induk'] = $nomor_induk;
        $_SESSION['nama'] = $nama;
        $_SESSION['login'] = 1;

        header("Location: index.php");
        exit;
    } else {
        $error = "Nomor Induk / Password Salah";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <title>Absensi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <h3>Login Absensi</h3>
      </div>
      <div class="card-body">
        <p class="login-box-msg"><?php echo $error; ?></p>

        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="nomor_induk" placeholder="Nomor Induk" autofocus required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" name="login" class="btn btn-primary btn-block">Masuk</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>
