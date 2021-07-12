<!doctype html>
<html lang="en">

<head>
    <title>Trang chủ</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./icomoon/style.css">

    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style2.css">
</head>

<body style="background:#41c04d" >
    <?php session_start(); ?>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <h2 style="border-radius: 60%;border:1px solid">ATN</h2>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                Menu <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <?php
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
    <div class="container">
        <div class="row">
            <div id="carouselId" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselId" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselId" data-slide-to="1"></li>
                    <li data-target="#carouselId" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img style="height: 500px;width:100%;border-radius: 1%;" src="./img/slide1.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img style="height: 500px;width:100%;border-radius: 1%;" src="./img/slide2.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img style="height: 500px;width:100%;border-radius: 1%;" src="./img/slide3.jpg" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <br>
        <hr>
        <hr>
        <!-- End carousel -->
        <div class="row">
            <?php

            include_once("config.php");
            $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 5;
            $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;
            $off_set = ($current_page - 1) * $item_per_page;

            $products = $conn->query("select * from product order by productId limit " . $item_per_page . " offset " . $off_set . "");
            $total_products = $conn->query("select * from product");
            $total_products = $total_products->num_rows;
            $total_page = ceil($total_products / $item_per_page);
            $productId = null;
            $userId = null;
            while ($row = mysqli_fetch_array($products)) {
                $productId = $row['productId'];
                $userId = !empty($_SESSION['roleCustomer']) ? $_SESSION['roleCustomer'] : 0;
                echo ("   <div class='col-sm-4'>
                    <div class='card'>
                        <div class='card-header'>
                            <p>" . $row["productName"] . "</p>
                        </div>
                        <div class='card-body'>
                            <img style='height: 300px;width: 300px;' src='" . $row["productImg"] . "' alt=''>
                        </div>
                        <div class='card-footer'>
                            <a class='btn btn-info'>Xem</a>
                            <a href='cart.php?productId=" . $productId . "' class='btn btn-success'>Mua</a>
                        </div>
                    </div>
                        </div>");
            }
            echo ("<br>");
            include_once("pagination.php");
            ?>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
