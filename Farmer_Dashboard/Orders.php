<?php
    session_start();

    include "../Connect.php";

    $F_ID = $_SESSION['F_Log'];

    if (! $F_ID) {

        echo '<script language="JavaScript">
     document.location="../Farmer-Login.php";
    </script>';

    } else {

        $sql1 = mysqli_query($con, "select * from users where id = '$F_ID'");
        $row1 = mysqli_fetch_array($sql1);

        $name  = $row1['name'];
        $email = $row1['email'];
        $image = $row1['image'];
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Orders - EcoLacto</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="../assets/img/Logo.png" rel="icon" />
    <link href="../assets/img/Logo.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link
      href="../assets/vendor/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="../assets/vendor/bootstrap-icons/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet" />
  </head>

  <body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
      <div class="d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
          <img src="../assets/img/Logo.png" alt="" />

        </a>
      </div>
      <!-- End Logo -->
      <!-- End Search Bar -->

      <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
          <li class="nav-item dropdown pe-3">
            <a
              class="nav-link nav-profile d-flex align-items-center pe-0"
              href="#"
              data-bs-toggle="dropdown"
            >
              <img
                                src="<?php echo $image ?>"
                alt="Profile"
                class="rounded-circle"
              />
              <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $name ?></span> </a
            >

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $name ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="./Logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul>
          </li>
          <!-- End Profile Nav -->
        </ul>
      </nav>
      <!-- End Icons Navigation -->
    </header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php require './Aside-Nav/Aside.php'?>
    <!-- End Sidebar-->

    <main id="main" class="main">
      <div class="pagetitle">
        <h1>Orders</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item">Orders</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->
      <section class="section">



        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
              <div class="card-body">
                <!-- Table with stripped rows -->
                <table class="table datatable">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Customer Name</th>
                      <th scope="col">Status</th>
                      <th scope="col">Total Price</th>
                      <th scope="col">Created At</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                      $sql1 = mysqli_query($con, "SELECT * FROM orders ORDER BY id DESC");

                      $totalPrice = 0;

                      while ($row1 = mysqli_fetch_array($sql1)) {

                          $order_id    = $row1['id'];
                          $consumer_id = $row1['consumer_id'];
                          $status      = $row1['status'];
                          $created_at  = $row1['created_at'];

                          $sql2 = mysqli_query($con, "SELECT * FROM order_items WHERE order_id = '$order_id'");

                          while ($row2 = mysqli_fetch_array($sql2)) {

                              $seller_id = $row2['seller_id'];

                              if ($seller_id == $F_ID) {

                                  $product_id = $row2['product_id'];
                                  $quantity   = $row2['quantity'];

                                  $sql3 = mysqli_query($con, "SELECT * FROM users WHERE id = '$consumer_id'");
                                  $row3 = mysqli_fetch_array($sql3);

                                  $buyer_name = $row3['name'];

                                  $sql4 = mysqli_query($con, "SELECT * FROM products WHERE id = '$product_id'");
                                  $row4 = mysqli_fetch_array($sql4);

                                  $product_price = $row4['price'];

                                  $totalPrice += $product_price * $quantity;

                              ?>
                    <tr>
                      <th scope="row"><?php echo $order_id ?></th>
                      <td><?php echo $buyer_name ?></td>
                      <td><?php echo $status ?></td>
                      <td><?php echo $totalPrice ?> JODs</td>
                      <th scope="row"><?php echo $created_at ?></th>
                      <td>

              <div class="d-flex flex-column">
              <div class="d-flex mb-2">




                          <?php if ($status == 'Pending') {?>
                            <a href="./ChangeStatus.php?order_id=<?php echo $order_id ?>&status_id=Accepted" class="btn btn-primary me-2">Accept</a>
                            <a href="./ChangeStatus.php?order_id=<?php echo $order_id ?>&status_id=Rejected" class="btn btn-danger me-2">Reject</a>
                            <?php } ?>
                            <a href="./Order-Items.php?order_id=<?php echo $order_id ?>" class="btn btn-success me-2"
                            >Items</a>

                        </div>


              </div>

                      </td>
                    </tr>
<?php
    }
        }
}?>
                  </tbody>
                </table>
                <!-- End Table with stripped rows -->
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
      <div class="copyright">
        &copy; Copyright <strong><span>EcoLacto</span></strong
        >. All Rights Reserved
      </div>
    </footer>
    <!-- End Footer -->

    <a
      href="#"
      class="back-to-top d-flex align-items-center justify-content-center"
      ><i class="bi bi-arrow-up-short"></i
    ></a>

    <script>
    window.addEventListener('DOMContentLoaded', (event) => {
     document.querySelector('#sidebar-nav .nav-item:nth-child(4) .nav-link').classList.remove('collapsed')
   });
</script>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.min.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>
  </body>
</html>
