<?php

class LoginController {

  public static function index() {
    include 'views/login/index.php';
  }

  public static function register() {
    include 'views/login/register.php';
  }

  public static function login($username, $password) {
    require 'env.php';

    if (empty($username) || empty($password)) {
      $_SESSION["error"] = "Username dan Password Tidak Boleh Kosong";
      header('Location: '.$currentUrl.'/login');
      exit;
    }

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $query = mysqli_query($koneksi, $sql);
    $data = mysqli_fetch_assoc($query);

    if ($data) {
      $user = $data['username'];
      $pass = $data['password'];

      if ($username == $user && password_verify($password, $pass)) {
          $_SESSION['nama'] = $data['nama'];
          $_SESSION['email'] = $data['email'];          
          $_SESSION['username'] = $username;
          $_SESSION['password'] = $password;
          header('Location: '.$currentUrl.'/');
          exit;
      } else {
          $_SESSION["error"] = "Password Tidak Sesuai";
          header('Location: '.$currentUrl.'/login');
          exit;
      }
    } else {
      $_SESSION["error"] = "Username Tidak Terdaftar";
      header('Location: '.$currentUrl.'/login');
      exit;
    }
  }

  public static function create($name, $username, $email, $password, $confirmPassword) {
    require 'env.php';
    if ($password == $confirmPassword) {
        $_SESSION['nama'] = $name;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;

        if (empty($name) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            $_SESSION["error"] = "Isian Tidak Boleh Kosong";
            header('Location: '.$currentUrl.'/register');
            exit;
        }

        $queryUsername = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
        $resultUsername = mysqli_fetch_assoc($queryUsername);

        if ($resultUsername) {
            $_SESSION["error"] = "Username Sudah Terdaftar";
            header('Location: '.$currentUrl.'/register');
            exit;
        }

        $queryEmail = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
        $resultEmail = mysqli_fetch_assoc($queryEmail);

        if ($resultEmail) {
            $_SESSION["error"] = "Email Sudah Terdaftar";
            header('Location: '.$currentUrl.'/register');
            exit;
        }

        if($password != $confirmPassword){
          $_SESSION["error"] = "Password dan Konfirmasi Password Salah";
          header('Location: '.$currentUrl.'/register');
          exit;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (nama, username, email, password) VALUES ('$name', '$username', '$email', '$password')";
        
        if ($koneksi->query($sql) === TRUE) {
            $_SESSION["success"] = "Akun Berhasil Di Buat";
            header('Location: '.$currentUrl.'/login');
            exit;
        } else {
            $_SESSION["error"] = "Akun Gagal Dibuat";
            header('Location: '.$currentUrl.'/register');
            exit;
        }
    } else {
        $_SESSION["error"] = "Password dan Konfirmasi Password Salah";
        header('Location: '.$currentUrl.'/register');
        exit;
    }
  }

  public static function logout() {
    require 'env.php';
    session_destroy();
    return true;
  }
}

