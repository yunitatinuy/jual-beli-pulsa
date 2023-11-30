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
    <div class="logo"><a href="">QUICK.TOP</a></div>
    <div class="menu">
      <ul>
        <li><a href="registrasi.php" class="tbl-green">Registration</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="img fadeInDown mt-4">
    <center><img src="logo.jpeg" width="200" class="rounded-circle" alt="..."></center>
  </div>
<section>
    
<div class="wrapper2 fadeIn first">
    <form action="cek_login.php" method="POST">
        <h1>Login</h1>
        <div class="input-box">
            <input type="text" class="fadeIn second" name="username" placeholder="Username" required>
            <i class='bx bxs-user fadeIn second'></i>
        </div>
        <div class="input-box">
            <input type="password" class="fadeIn third" name="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt fadeIn third'></i>
        </div>

        <div class="remember-forgot fadeIn fourth">
            <label><input type="checkbox">Remember me</label>
            <a href="#">Forgot password?</a>
        </div>

        <button type="submit" class="btn fadeIn fifth">Login</button>
    </form>
</div>
</section>
</body>
</html>