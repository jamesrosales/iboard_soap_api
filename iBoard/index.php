<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>iBoard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #2d3145;
      color: white;
    }
    header {
      background: linear-gradient(to right, #87CEEB, #0000);
      color: white;
      padding: 5px;
      text-align: center;
    }

    header img {
      height: 150px;
      width: 150px;
    }
    main {
      margin: 20px 100px; /* top, right/left, bottom */
    }

    form {
      display: flex;
      align-items: center;
      margin-bottom: 40px;
    }
    label {
      font-size: 20px;
      margin-right: 10px;
    }
    input[type=text] {
      font-size: 15px;
      padding: 10px;
      margin: 3px 7px; /* adjust the margin values as per your needs */
      flex-grow: 1;
      border: none;
      background-color: #E0FFFF; /* super light blue */
      border-radius: 20px; /* or any other value that suits your needs */
    }

    button[type=submit] {
      font-size: 20px;
      padding: 5px 20px;
      background: linear-gradient(to bottom, #87CEEB, #87CEEB);
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 20px; /* or any other value that suits your needs */
    }

    ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }
    li {
      font-size: 20px;
      margin-bottom: 10px;
    }
    .error {
      color: red;
    }

    .messages-container {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .gradient-box {
      background: linear-gradient(to bottom, #87CEEB, #0000);
      padding: 20px;
      border-radius: 10px;
      width: 800px; /* example width */
      margin: auto;
    }
  
  .center {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 10vh; /* adjust this value to your preference */
  }

  </style>
</head>
<body>

<header>
  <img src="images\LOGO.png" alt="logo">
</header>

  <main>
  <?php
    if (isset($_POST['submit']) && !empty($_POST['message'])) {
        $message = $_POST['message'];
        $options = array(
          'location' => 'http://localhost:8081/Iboard/server.php',
          'uri' => 'http://example.com/soap'
        );
        $client = new SoapClient(null, $options);
        $result = $client->displayString($message);
        // echo "<p>Message sent: $message</p>";

        // Save the message to a JSON file
        $data = array('message' => $message);
        $json = json_encode($data);
        $file = 'messages.json';
        file_put_contents($file, $json . PHP_EOL, FILE_APPEND | LOCK_EX); // PHP_EOL adds a newline at the end
    } else {
        echo "<p></p>";
    }
  ?>

<form method="post">
    <label for="message"></label>
    <input type="text" name="message" id="message" placeholder="Input Boarding House Names">
    <button type="submit" name="submit">Add</button>
  </form>

    <div class="center">
  <?php if (isset($result)): ?>
    <p>The server receives the Boarding Houses in Ampayon, Butuan City: <?php echo $result; ?></p>
  <?php endif; ?>
</div>

    <div class="messages-container">
  <ul class="gradient-box">
    <?php
    // Display all messages saved in messages.json
    $file = 'messages.json';
    if (file_exists($file)) {
        $messages = file($file);
        if ($messages) {
            foreach ($messages as $line) {
                $data = json_decode(trim($line), true);
                $color = '#' . substr(md5($data['message']), 0, 6);
                echo '<li style="background-color: rgba(173,216,230, 0.7); border-radius: 10px; color: white; padding: 10px; margin: 10px;">' . $data['message'] . '</li>';
            }
        } else {
            echo '<li>No boarding houses saved yet.</li>';
        }
    } else {
        echo '<li>No boarding houses yet.</li>';
    }
    ?>
  </ul>
</div>


  </main>
</body>
</html>
