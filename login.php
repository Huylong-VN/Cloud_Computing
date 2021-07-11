<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Login - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="bg-primary">
        <?php session_start(); ?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="POST">
                                            <div class="form-floating mb-3">
                                                <input required class="form-control" id="inputEmail" type="text" placeholder="name@example.com" name="account"/>
                                                <label for="inputEmail">Account</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input required class="form-control" id="inputPassword" type="password" placeholder="Password" name="password"/>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Forgot Password?</a>
                                                <button class="btn-primary btn" type="submit" name="submit">Login</button>
                                            </div>
                                        </form>
                                        <?php
                                       
                                        if(isset($_POST["submit"])){
                                            include_once("config.php");
                                            $login=$conn->query("Select * from user where account='".$_POST['account']."' and password='".$_POST['password']."'");
                                            if($login->num_rows!=0){       
                                                $row=mysqli_fetch_array($login);
                                                $userId=$row['userId'];
                                                $name=$row['username'];
                                                $userrole=$conn->query("Select * from userrole,role where userrole.roleId=role.roleId AND userrole.userId='".$userId."'");
                                                if($userrole->num_rows!=0){
                                                    while($row=mysqli_fetch_array($userrole)){
                                                        if($row['roleName']=="admin"||$row['roleName']=="employee"){
                                                            $_SESSION['roleControl']=$userId;
                                                            header("location:admin/index.php");
                                                        }
                                                    }
                                                }
                                                else{
                                                    $_SESSION['roleCustomer']=$userId;
                                                    $_SESSION['username']=$name;
                                                    
                                                    header("location:index.php");
                                                }
                                               
                                            }
                                            else{
                                                echo("<div class='alert alert-primary' role='alert'>
                                                Tài khoản hoặc mật khẩu sai !
                                              </div>");
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
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
        <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
