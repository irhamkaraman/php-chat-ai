<?php 
require  'controller/session.php';
require 'env.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/blob.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
  <header>
    <h1>Hello, <?= $_SESSION['nama']; ?></h1>
    <nav>
      <a href="#">Dashboard</a>
      <a href="https://irhamkaraman.my.id">Author</a>
    </nav>
    <div class="logout">
      <a href="<?= $currentUrl; ?>/logout">Logout</a>
    </div>
  </header>
  <div class="blob blob1"></div>
  <div class="blob blob2"></div>
  <div class="blob blob3"></div>
  
  <div class="container chat-ai">
    
    <div id="obrolan" class="obrolan">
      <h1>Obrolan PK-Chat</h1>
      <p style="text-align: center;">SIlahkan mulai obrolan baru bersama Chat AI ini!</p>
      <div class="chat-history">
      </div>
      <div class="box-container">
        <div class="box" onclick="sendPresetMessage(event, 'Hai, Perkenalkan siapa anda?')">
          <form action="controller/ChatController.php" method="POST" onsubmit="sendMessage(event)">
            <input type="text" name="message" value="Hai, Perkenalkan siapa anda?" hidden />
            <button type="submit" style="background: none; border: none; cursor: pointer;">
              Hai, Perkenalkan siapa anda?
            </button>
          </form>
        </div>
        <div class="box" onclick="sendPresetMessage(event, 'Buatkan saya artikel sederhana')">
          <form action="controller/ChatController.php" method="POST" onsubmit="sendMessage(event)">
            <input type="text" name="message" value="Buatkan saya artikel sederhana" hidden />
            <button type="submit" style="background: none; border: none; cursor: pointer;">
              Buatkan saya artikel sederhana
            </button>
          </form>
        </div>
      </div>
      <div class="box-container">
        <div class="box" onclick="sendPresetMessage(event, 'Bagaimana cara mempelajari Javascript')">
          <form action="controller/ChatController.php" method="POST" onsubmit="sendMessage(event)">
            <input type="text" name="message" value="Bagaimana cara mempelajari Javascript" hidden />
            <button type="submit" style="background: none; border: none; cursor: pointer;">
              Bagaimana cara belajar Javascript
            </button>
          </form>
        </div>
        <div class="box" onclick="sendPresetMessage(event, 'Bagaimana cara mempelajari PHP')">
          <form action="controller/ChatController.php" method="POST" onsubmit="sendMessage(event)">
            <input type="text" name="message" value="Bagaimana cara mempelajari PHP" hidden />
            <button type="submit" style="background: none; border: none; cursor: pointer;">
              Bagaimana cara mempelajari PHP
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>

  <div class="footer">
    <p>Copyright &copy; 2024. Irham Karaman</p>
  </div>
  <div class="chat" id="chat">
    <form class="chat-form" action="controller/ChatController.php" method="POST" onsubmit="sendMessage(event)">
      <input type="text" id="chat-input" name="message" placeholder="Type your message..." required />
      <button type="submit" id="chat-send">Send</button>
    </form>
  </div>

  <script src="assets/js/script.js"></script>
</body>
</html>
