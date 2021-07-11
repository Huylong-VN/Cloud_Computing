<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
  
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <div class="card-body">
                                    <form onsubmit="return false">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input required class="form-control" id="account" type="text" placeholder="Enter your first name" />
                                                    <label for="account">Account</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input required class="form-control" id="username" type="text" placeholder="Enter your last name" />
                                                    <label for="username">UserName</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input required class="form-control" id="email" type="email" placeholder="name@example.com" />
                                            <label for="email">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="phone" type="text" placeholder="name@example.com" />
                                            <label for="phone">Your Phone</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input required class="form-control" id="password" type="password" placeholder="Create a password" />
                                                    <label for="password">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input required class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password" />
                                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button id="create" class="btn btn-primary btn-block">Create Account</button></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php
            include_once("config.php");
            if(isset($_POST['type'])){
                $createUser=$conn->query("INSERT INTO `user`( `account`, `password`, `email`, `phone`, `username`) VALUES ('".$_POST['account']."','".$_POST['password']."','".$_POST['email']."','".$_POST['phone']."','".$_POST['username']."')");
                var_dump($createUser);
            }
           
        ?>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2021</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/scripts.js"></script>
    <script>
        $("#create").click(() => {
            if($("#account").val()!==""&&$("#password").val()!==""&&$("#email").val()!==""&&$("#phone").val()!==""&&$("#username").val()!==""){
                if ($("#password").val() === $("#inputPasswordConfirm").val()) {
                $.ajax({
                    url: "register.php",
                    type: "POST",
                    data: {
                        type:"create",
                        account: $("#account").val(),
                        password: $("#password").val(),
                        email: $("#email").val(),
                        phone: $("#phone").val(),
                        username: $("#username").val()
                    },
                    success:()=>{
                        alert("Chúc mừng bạn đã đăng kí thành công");
                        window.location="./login.php"
                    },
                    Error:()=>{
                        alert("Đăng kí thất bại");
                    }
                })
            }
            else{
                alert("Mật khẩu phải trùng nhau")
            }
            }
            else{
                alert("Vui Lòng nhập Data")
            }
            
        })
    </script>
</body>

</html>