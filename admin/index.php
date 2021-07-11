<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    include_once("../config.php");
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
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include_once("layout/nav.php") ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include_once("layout/layoutSidenav_nav.php") ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        Hello
                    </div>
                    <div class="card-body">
                        <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                            <div class="dataTable-top">
                                <div class="dataTable-dropdown"><label>
                                        <select class="dataTable-selector">
                                            <option value="5">5</option>
                                            <option value="10" selected="">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                        </select> entries per page</label></div>
                                <div class="dataTable-search"><input class="dataTable-input" placeholder="Search..." type="text"></div>
                            </div>
                            <div class="dataTable-container">
                                <table id="datatablesSimple" class="dataTable-table table table-striped ">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Account</th>
                                            <th>Password</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Username</th>
                                            <th>Avatar</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $item_per_page = !empty($_GET["per_page"]) ? $_GET["per_page"] : 5;
                                        $current_page = !empty($_GET['page']) ? $_GET["page"] : 1;
                                        $offset = ($current_page - 1) * $item_per_page;
                                        $users = $conn->query("Select * from user order by userId limit " . $item_per_page . " offset " . $offset . "");
                                        $total_users = $conn->query("Select * from user");
                                        $total_users = $total_users->num_rows;
                                        $total_page = ceil($total_users / $item_per_page);
                                        $stt = 0;
                                        while ($row = mysqli_fetch_array($users)) {
                                            $stt++;
                                            echo ("
                                            <tr>
                                                <td>" . $stt . "</td>
                                                <td>" . $row['account'] . "</td>
                                                <td>" . $row['password'] . "</td>
                                                <td>" . $row['email'] . "</td>
                                                <td>" . $row['phone'] . "</td>
                                                <td>" . $row['username'] . "</td>
                                                <td><img src=" . $row['avatar'] . " style='height:50px;width:50px' alt='not found'/></td>
                                                <td style='display: flex;
                                                justify-content: space-evenly;'>
                                                <a class='btn btn-primary' href=crud_user/edit.php?edit=" . $row['userId'] . "><i class='fas fa-edit'></i></a>
                                                <a class='btn btn-danger' href='?delete=" . $row['userId'] . "'><i class='fas fa-user-slash'></i></a>
                                                <a class='btn btn-warning' href='crud_user/addRole.php?role=" . $row['userId'] . "'>Role</a>
                                                </td>
                                            </tr>
                                            ");
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            if (isset($_GET['delete'])) {
                                $conn->query("DELETE FROM `user` WHERE userId=" . $_GET['delete'] . "");
                                echo ("<script>window.location='index.php'</script>");
                            }
                            ?>

                            <div class="dataTable-bottom">
                                <?php include_once("../pagination.php") ?>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
</body>

</html>