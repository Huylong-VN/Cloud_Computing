<!doctype html>
<html lang="en">

<head>
    <title>Cart</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./icomoon/style.css">

    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style2.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">ATN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                Menu <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <?php
                    session_start();
                    if (isset($_SESSION['username'])) {
                        echo ("
                        <li class='nav-item'>
                        <a class='nav-link' href='#'>Xin Chào : " . $_SESSION['username'] . "</a>
                        </li>
                        <li class='nav-item'>
                        <a class='nav-link' href='cart.php'>Cart <i class='fas fa-cart-plus'></i></a>
                        </li>
                        <li class='nav-item'>
                        <a class='nav-link' href='?logout'>Đăng xuất</a>
                        </li>
                        ");
                    } else {
                        echo ("  <li class='nav-item'>
                        <a class='nav-link' href='login.php'>Đăng nhập</a>
                        </li>");
                    }
                    if (isset($_GET['logout'])) {
                        session_destroy();
                        header("location:index.php");
                    }

                    ?>

                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>

    </nav>

    <?php
    include_once("./config.php");
    if (isset($_SESSION['roleCustomer'])) {
            $n = 0;
            if (!empty($_GET['productId'])) {
                $price = $conn->query("Select * from product where productId='" . $_GET['productId'] . "'");
                while ($row = mysqli_fetch_array($price)) {
                    $n += (int)$row['productPrice'];
                }
                $check = $conn->query("SELECT *
                FROM cart WHERE cart.userId=" . $_GET['userId'] . " and cart.productId=" . $_GET['productId'] . "
                HAVING COUNT(productId) > 0");
                if ($check->num_rows != 1) {
                    $okks = $conn->query("INSERT INTO `cart`(`productId`, `userId`, `cartTotal`) VALUES ('" . $_GET['productId'] . "','" . $_GET['userId'] . "','" . $n . "')");
                }
        }
    } else {
       header("location:login.php");
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    Giỏ hàng
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $num = 0;
                            $sum = 0;
                            $cart = $conn->query("SELECT * FROM cart,product WHERE cart.productId=product.productId AND cart.userId=" . $_SESSION['roleCustomer'] . "");
                            while ($row = mysqli_fetch_array($cart)) {
                                $sum += (int)$row['productPrice'];
                                $sum = number_format($sum, 3) . "VND";
                                $num++;
                                echo ("
                                        <tr>
                                            <td>" . $num . "</td>
                                            <td>" . $row['productName'] . "</td>
                                            <td><img style='height: 50px;width:80px' src='" . $row['productImg'] . "' /></td>
                                            <td>" . $row['productPrice'] . "</td>
                                            <td><a href='?userId=" . $_SESSION['roleCustomer'] . "&deleteCart=" . $row['cartId'] . "' class='btn btn-primary'>Delete</a></td>
                                        </tr>
                                        ");
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <td>Tổng Tiền: <?php echo ($sum) ?></td>
                            <input id="userId" type="hidden" value="<?php echo ($_POST['userId']) ?>">
                            <td><a id="done" class='btn btn-success'>Thanh Toán</a></td>

                        </tfoot>
                        <?php
                        if (isset($_POST['type']) == "done") {
                            $PayDone = $conn->query("DELETE FROM `cart` WHERE userId=" . $_POST['userId'] . "");
                        }
                        if (isset($_GET['deleteCart'])) {
                            $PayDone = $conn->query("DELETE FROM `cart` WHERE cartId=" . $_GET['deleteCart'] . "");
                            header_remove("cart.php");
                            header("location:?userId=" . $_GET['userId'] . "");
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="content d-flex align-items-center bg-light">
        <h2 class="w-100 text-center"></h2>
    </div>
    <!-- Foooterr -->
    <footer class="footer-20192">
        <div class="site-section">
            <div class="container">
                <div class="cta d-block d-md-flex align-items-center px-5">
                    <div>
                        <h2 class="mb-0">Are you ready ?</h2>
                        <h3 class="text-dark">Let's get started!</h3>
                    </div>
                    <div class="ms-auto">
                        <a href="https://www.facebook.com/NothingFormeRN/" class="btn btn-dark rounded-0 py-3 px-5">Contact us</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <a href="https://www.facebook.com/NothingFormeRN/" class="footer-logo">ATN</a>
                        <p class="copyright">
                            <small>© 2021</small>
                        </p>
                    </div>
                    <div class="col-sm">
                        <h3>Customers</h3>
                        <ul class="list-unstyled links">
                            <li><a href="https://www.facebook.com/NothingFormeRN/">Buyer</a></li>
                            <li><a href="https://www.facebook.com/NothingFormeRN/">Supplier</a></li>
                        </ul>
                    </div>
                    <div class="col-sm">
                        <h3>Company</h3>
                        <ul class="list-unstyled links">
                            <li><a href="https://www.facebook.com/NothingFormeRN/">About us</a></li>
                            <li><a href="https://www.facebook.com/NothingFormeRN/">Careers</a></li>
                            <li><a href="https://www.facebook.com/NothingFormeRN/">Contact us</a></li>
                        </ul>
                    </div>
                    <div class="col-sm">
                        <h3>Further Information</h3>
                        <ul class="list-unstyled links">
                            <li><a href="https://www.facebook.com/NothingFormeRN/">Terms &amp; Conditions</a></li>
                            <li><a href="https://www.facebook.com/NothingFormeRN/">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h3>Follow us</h3>
                        <ul class="list-unstyled social">
                            <li><a href="https://www.facebook.com/NothingFormeRN/"><span class="icon-facebook"></span></a></li>
                            <li><a href="#"><span class="icon-twitter"></span></a></li>
                            <li><a href="#"><span class="icon-linkedin"></span></a></li>
                            <li><a href="#"><span class="icon-medium"></span></a></li>
                            <li><a href="#"><span class="icon-paper-plane"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script>
        $("#done").click(() => {
            var t = confirm("Bạn chắc chắn sẽ mua sản phẩm này chứ ?")
            if (t == true) {
                $.ajax({
                    url: "cart.php",
                    type: "POST",
                    data: {
                        type: "done",
                        userId: $("#userId").val()
                    },
                    success: () => {
                        alert("Mua sản phẩm thành công");
                        window.location = "./index.php";
                    }
                })
            }
        })
    </script>

</body>

</html>
