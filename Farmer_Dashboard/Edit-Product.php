<?php
    session_start();

    include "../Connect.php";

    $F_ID       = $_SESSION['F_Log'];
    $product_id = $_GET['product_id'];

    if (! $F_ID) {

        echo '<script language="JavaScript">
     document.location="../Farmer-Login.php";
    </script>';

    } else {

        $sql1 = mysqli_query($con, "select * from users where id='$F_ID'");
        $row1 = mysqli_fetch_array($sql1);

        $name  = $row1['name'];
        $email = $row1['email'];
        $image = $row1['image'];

        $sql2 = mysqli_query($con, "select * from products where id = '$product_id'");
        $row2 = mysqli_fetch_array($sql2);

        if (isset($_POST['Submit'])) {

            $product_id  = $_POST['product_id'];
            $category_id = $_POST['category_id'];
            $name        = $_POST['name'];
            $description = $_POST['description'];
            $price       = $_POST['price'];
            $qty         = $_POST['qty'];
            $image       = $_FILES["file"]["name"];

            if ($image) {

                $image = 'Product_Images/' . $image;

                $stmt = $con->prepare("UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, qty = ?, image = ? WHERE id = ?");

                $stmt->bind_param("issdisi", $category_id, $name, $description, $price, $qty, $image, $product_id);

            } else {

                $stmt = $con->prepare("UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, qty = ? WHERE id = ?");

                $stmt->bind_param("issdii", $category_id, $name, $description, $price, $qty, $product_id);
            }

            if ($stmt->execute()) {

                if ($image) {

                    move_uploaded_file($_FILES["file"]["tmp_name"], "./Product_Images/" . $_FILES["file"]["name"]);
                }

                echo "<script language='JavaScript'>
                alert ('Product Has Been Updated Successfully !');
           </script>";

                echo "<script language='JavaScript'>
          document.location='./Products.php';
             </script>";
            }

        }
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Edit Product - EcoLacto</title>
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

    <!-- jQuery (must be loaded before Bootstrap Multiselect) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

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
        <h1>Edit Product</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item">Edit Product</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->
      <section class="section">
        <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"></h5>

                <!-- Horizontal Form -->
                <form method="POST" action="./Edit-Product.php?product_id=<?php echo $product_id ?>" enctype="multipart/form-data">

                <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                <input type="hidden" name="sub_category_id" value="<?php echo $$row2['sub_category_id'] ?>" id="sub_category_id_input">

                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label"
                      >Category</label
                    >
                    <div class="col-sm-10">
                       <select name="category_id" class="form-select" id="category_id" required>
                        <option value="" selected disabled>Select Category</option>
                       <?php
                           $sql1 = mysqli_query($con, "SELECT * from categories WHERE active = '1' ORDER BY id DESC");

                           while ($row1 = mysqli_fetch_array($sql1)) {

                               $select_category_id   = $row1['id'];
                               $select_category_name = $row1['name'];

                           ?>
<option value="<?php echo $select_category_id ?>"<?php echo $row2['category_id'] == $select_category_id ? 'selected' : '' ?>><?php echo $select_category_name ?></option>
    <?php }?>
                       </select>
                    </div>
                  </div>






                  <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label"
                      >Name</label
                    >
                    <div class="col-sm-10">
                      <input type="text" name="name" value="<?php echo $row2['name'] ?>" class="form-control" id="name" required/>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="price" class="col-sm-2 col-form-label"
                      >Price</label
                    >
                    <div class="col-sm-10">
                      <input type="number" min="0.01" step="0.01" name="price" value="<?php echo $row2['price'] ?>" class="form-control" id="price" required/>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="description" class="col-sm-2 col-form-label"
                      >Description</label
                    >
                    <div class="col-sm-10">
                      <textarea name="description" class="form-control" id="description" value="<?php echo $row2['description'] ?>" required><?php echo $row2['description'] ?></textarea>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="qty" class="col-sm-2 col-form-label"
                      >Qty</label
                    >
                    <div class="col-sm-10">
                      <input type="number" name="qty" value="<?php echo $row2['qty'] ?>" class="form-control" id="qty" required/>
                    </div>
                  </div>


                  <div class="row mb-3">
                    <label for="file" class="col-sm-2 col-form-label"
                      >Image</label
                    >
                    <div class="col-sm-10">
                      <input type="file" name="file" class="form-control" id="file"/>
                    </div>
                  </div>



                  <div class="text-end">
                    <button type="submit" name="Submit" class="btn btn-primary">
                      Submit
                    </button>
                    <button type="reset" class="btn btn-secondary">
                      Reset
                    </button>
                  </div>
                </form>
                <!-- End Horizontal Form -->
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
     document.querySelector('#sidebar-nav .nav-item:nth-child(3) .nav-link').classList.remove('collapsed')
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

    <script>

    $(document).ready(function(){
    $('#colors').multiselect({
        templates: {
        button: '<button type="button" class="multiselect dropdown-toggle btn btn-primary w-100" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>',
        },
        includeSelectAllOption: true, // Adds "Select All" checkbox
        enableFiltering: true, // Adds a search box
        enableCaseInsensitiveFiltering: true,
        nonSelectedText: 'Select Colors', // Placeholder text
        allSelectedText: 'All Selected',
        nSelectedText: ' options selected'
    });
    $('#sizes').multiselect({
        templates: {
        button: '<button type="button" class="multiselect dropdown-toggle btn btn-primary w-100" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>',
        },
        includeSelectAllOption: true, // Adds "Select All" checkbox
        enableFiltering: true, // Adds a search box
        enableCaseInsensitiveFiltering: true,
        nonSelectedText: 'Select Sizes', // Placeholder text
        allSelectedText: 'All Selected',
        nSelectedText: ' options selected'
    });
    });


    </script>
    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>
  </body>
</html>
