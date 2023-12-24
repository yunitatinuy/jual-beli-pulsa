<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jual Beli Pulsa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="login.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body id="home">
  <nav>
    <div class="wrapper">
      <div class="logo"><a href="index.php">QUICK.TOP</a></div>
      <div class="menu">
        <ul>
          <li><a href="login.php" class="tbl-green">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="img fadeInDown mt-4 mb-4">
    <center><img src="logo.jpeg" width="200" class="rounded-circle" alt="..."></center>
  </div>
  <section>

    <div class="wrapper3 fadeIn first">
      <form action="cek_registrasi.php" method="POST">
        <h1>Sign Up</h1>
        <div class="input-box">
          <input type="text" class="fadeIn second" name="nama" placeholder="Name" autocomplete="off" required>
          <i class=' fadeIn second'></i>
        </div>
        <div class="input-box">
          <input type="text" class="fadeIn second" name="username" placeholder="Username" autocomplete="off" required>
          <i class='bx bxs-user fadeIn second'></i>
        </div>
        <div class="input-box">
          <input type="text" class="fadeIn second" name="email" placeholder="Email" autocomplete="off" required>
          <i class='bx bxs-envelope fadeIn second'></i>
        </div>
        <div class="input-box">
          <input type="password" class="fadeIn second" name="password" placeholder="Password" autocomplete="off" required>
          <i class='bx bxs-lock-open-alt fadeIn second'></i>
        </div>
        <div class="input-box">
          <input type="password" class="fadeIn third" name="password2" placeholder="Confirm Password" autocomplete="off" required>
          <i class='bx bxs-lock-alt fadeIn third'></i>
        </div>

        <div class="remember-forgot mt-2 fadeIn fourth">
          <label><input type="checkbox" required>I agree to the terms of User</label>
        </div>

        <button type="submit" class="btn fadeIn fifth">Register</button>
      </form>
    </div>
  </section>
</body>

</html>