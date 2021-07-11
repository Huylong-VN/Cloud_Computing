<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    include_once("../../config.php");
    if (isset($_SESSION['roleControl']) == null) {
        header("location:../index.php");
    }
    $userControl = $conn->query("Select * from user where userId='" . $_SESSION['roleControl'] . "'");
    $row = mysqli_fetch_array($userControl);
    ?>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include_once("../layout/nav.php") ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include_once("../layout/layoutSidenav_nav.php") ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
            <h1 class="mt-4">Create</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Create</li>
                </ol>
                <div class="container">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Product Name</label>
                        <input required type="text" class="form-control" id="exampleInputEmail1" name="productName">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Description</label>
                        <input required type="text" class="form-control" name="productDescription">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Product Price</label>
                        <input required type="text" class="form-control"  name="productPrice" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" class="form-control" name="productImg" aria-describedby="emailHelp">
                    </div>
                    <button name="create" type="submit" class="btn btn-primary">Create</button>
                </form>
                </div>
               
                <br>
                <?php
                    if(isset($_POST['create'])){
                        $productImg=$_FILES['productImg']['name'];
                        $target="../../img/".basename($productImg);
                        $targetValue="img/".basename($productImg);
                        if(!file_exists($target)&&getimagesize($_FILES['productImg']['tmp_name'])==true){
                            move_uploaded_file($_FILES['productImg']['tmp_name'],$target);
                            $create=$conn->query("INSERT INTO `product`(`productName`, `productDescription`, `productPrice`,`productImg`) VALUES ('".$_POST['productName']."','".$_POST['productDescription']."','".$_POST['productPrice']."','".$targetValue."')");
                            if($create){
                                echo("<div class='alert alert-info' role='alert'>
                                Create Success!
                              </div>");
                            }
                        }
                        else{
                            echo("<script>alert('Not Found')</script>");
                        }
                    }
                ?>
                <a href='../manage_product.php' class='btn btn-success'>Back To list <i class="fas fa-door-open"></i></a>
            </main>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
</body>

</html>