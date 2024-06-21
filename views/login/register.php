<?php 
include 'env.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/blob.css">
  <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

  <title>Register Form</title>
</head>
<body>
  <div class="blob blob1"></div>
  <div class="blob blob2"></div>
  <div class="blob blob3"></div>
    <section>
      <div class="container container-responsive">
        <?php 
          if (isset($_SESSION["error"])) { 
            echo "<div class='error'>" . $_SESSION["error"] . "</div>";
            unset($_SESSION["error"]);
          }
          if (isset($_SESSION["success"])) { 
            echo "<div class='success'>" . $_SESSION["success"] . "</div>";
            unset($_SESSION["success"]);
          }
        ?>
        <h2>Register Form</h2>
        <form class="form-responsive" action="<?php echo $currentUrl ?>/do-register" method="post">
          <label for="nama">Nama Lengkap:</label>
          <input type="text" id="nama" name="nama"/><br /><br />
          <label for="username">Username:</label>
          <input type="text" id="username" name="username"/><br /><br />
          <label for="email">Email:</label>
          <input type="text" id="email" name="email"/><br /><br />
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" /><br /><br />
          <label for="confirmPassword">Confirm Password:</label>
          <input type="password" id="confirmPassword" name="confirmPassword" /><br /><br />

          <button type="submit">Mendaftar</button>

          <div style="display:flex; justify-content: center; align-items: center;">
            <span>Sudah punya akun? <a href="<?php echo $currentUrl ?>/login">Masuk</a></span>
          </div>

          <style>
            div span {
              text-align: center;
            }
          </style>
        </form>
        <div class="footer">
          <p>&copy; 2024 Irham Karaman.</p>
          <p>All Rights Reserved.</p>
        </div>
      </div>
    </section>
  </body>
</html>