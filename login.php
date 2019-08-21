<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS Link -->
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://kit.fontawesome.com/eb8b44741d.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="assets/script.js"></script>

    
    <title>Paypon-login</title>
</head>
<body>
<div class="login-container">
    <i class="fas fa-money-bill-wave"></i>
    <h1>Paypon</h1>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Email atau Password</strong> yang anda masukan salah!!
    </div>
    
    <form method="post" class="login-form border" id="login-form">
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <button id="login-submit" type="button" name="login" class="btn btn-primary btn-block">Login</button>
    </form>
    <p>Nggk punya akun? <a href="register.php">Daftar yuk!!</a></p>
    <script>
        $(document).ready(function() {
            $(".alert").hide();
            $("#login-submit").click(function() {
                user_login();
              });
              $("#login-form").keypress(function(e) {
                var key = e.which;
                if (key == '13') {
                  user_login();
                  return false;
                }
              })
        })
        
    </script>
</div>
</body>
</html>