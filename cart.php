<!doctype html>
<html lang="en">

<head>
    <title>Cart</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">ATN</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
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
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <?php
    include_once("./config.php");
    if ($_GET['userId'] != 0) {
        $n = 0;
        if (!empty($_GET['productId'])) {
            $price = $conn->query("Select * from product where productId='" . $_GET['productId'] . "'");
            while ($row = mysqli_fetch_array($price)) {
                $n += $row['productPrice'];
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
                            $cart = $conn->query("SELECT * FROM cart,product WHERE cart.productId=product.productId AND cart.userId=" . $_GET['userId'] . "");
                            while ($row = mysqli_fetch_array($cart)) {
                                $sum += $row['productPrice'];
                                $num++;
                                echo ("
                                        <tr>
                                            <td>" . $num . "</td>
                                            <td>" . $row['productName'] . "</td>
                                            <td><img style='height: 50px;width:80px' src='" . $row['productImg'] . "' /></td>
                                            <td>" . $row['productPrice'] . "</td>
                                            <td><a href='?userId=" . $_GET['userId'] . "&deleteCart=" . $row['cartId'] . "' class='btn btn-primary'>Delete</a></td>
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
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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