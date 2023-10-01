<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $proyecto; ?></title>

    <!-- Custom fonts for this template-->
    <script src="https://kit.fontawesome.com/839b3d030d.js" crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?=$baseURL?>css/sb-admin-2.min.css" rel="stylesheet">
    <script src="<?=$baseURL?>vendor/jquery/jquery.min.js"></script>
    

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include("sidebar.php");?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                           
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    
                                </form>
                            </div>
                        </li>

                       

                       

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <?php 
                                $sqlUsuario = "SELECT * FROM tusuarios WHERE id = '$idUsuario'";
                                $queryUsuario = mysqli_query($conn, $sqlUsuario);
                                while($rowUsuario = mysqli_fetch_assoc($queryUsuario)){
                                    echo $rowUsuario['nombre'];
                                }
                                ?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="<?=$baseURL?>img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <style>
                                .dropdown-menu {
                                    background-color: #fff;
                                    border: none;
                                    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
                                }

                                .dropdown-menu a {
                                    color: #333;
                                    font-size: 14px;
                                    font-weight: 400;
                                    padding: 8px 20px;
                                    transition: all 0.3s ease;
                                }

                                .dropdown-menu a:hover {
                                    color: #fff;
                                    background-color: #007bff;
                                }

                                .dropdown-divider {
                                    margin: 0;
                                    border-top: 1px solid #ccc;
                                }
                            </style>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?=$baseURL?>logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <!--<div class="container-fluid">-->

                    <!-- Page Heading -->
                    <!--<div class="d-sm-flex align-items-center justify-content-between mb-4">-->
                   <!--     <h1 class="titulo-pagina"><?php echo $titulo; ?></h1>-->
                   <!-- </div>-->

                    <!-- Content Row -->