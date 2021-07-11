<!doctype html>
<html lang="en">

<head>
    <title>Trang chủ</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <?php session_start(); ?>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">ATN</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">More</button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
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
                }
                else{
                    echo("  <li class='nav-item'>
                    <a class='nav-link' href='login.php'>Đăng nhập</a>
                    </li>");
                }
                if (isset($_GET['logout'])) {
                    session_destroy();
                    header("location:index.php");
                }
               
                ?>

            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
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
                        <img style="height: 500px;width:100%;" src="./img/slide1.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img style="height: 500px;width:100%;" src="./img/slide2.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img style="height: 500px;width:100%;" src="./img/slide3.jpg" alt="Third slide">
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
        <h2>I. Danh sách sản phẩm</h2>
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
                            <a href='cart.php?productId=" . $productId . "&userId=" . $userId . "' class='btn btn-success'>Mua</a>
                        </div>
                    </div>
                        </div>");
            }
            echo ("<br>");
            include_once("pagination.php");
            ?>
        </div>
    </div>

    <!-- Foooterr -->
    <div class="jumbotron">
        <h1 class="display-3">Jumbo heading</h1>
        <p class="lead">Jumbo helper text</p>
        <hr class="my-2">
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Jumbo action name</a>
        </p>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
