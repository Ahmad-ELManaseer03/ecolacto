<?php
    session_start();

    include "./Connect.php";

    if (isset($_POST['Submit'])) {

        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $phone    = $_POST['phone'];
        $password = $_POST['password'];
        $image    = $_FILES["file"]["name"];
        $image    = 'Home_Cook_Images/' . $image;
        $type     = 3;

        $query = mysqli_query($con, "SELECT * FROM users WHERE email ='$email'");

        if (mysqli_num_rows($query) > 0) {

            echo '<script language="JavaScript">
        alert ("Account Already exist !")
        </script>';

        } else {

            $stmt = $con->prepare("INSERT INTO users (user_type_id, name, email, phone, password, image) VALUES (?, ?, ?, ?, ?, ?) ");

            $stmt->bind_param("isssss", $type, $name, $email, $phone, $password, $image);

            if ($stmt->execute()) {

                move_uploaded_file($_FILES["file"]["tmp_name"], "./Home_Cook_Dashboard/Home_Cook_Images/" . $_FILES["file"]["name"]);

                echo "<script language='JavaScript'>
              alert ('Signed up succefully, You can login now !');
         </script>";

                echo "<script language='JavaScript'>
        document.location='./Home-Cook-Login.php';
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

    <title>Signup Page</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/Logo.png" rel="icon" />
    <link href="assets/img/Logo.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link
      href="assets/vendor/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />
  </head>

  <body>
    <main>
      <div class="container">
        <section
          class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4"
        >
          <div class="container">
            <div class="row justify-content-center">
              <div
                class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center"
              >
                <div class="d-flex justify-content-center py-4">
                  <a
                    href="index.php"
                    class="logo d-flex align-items-center w-auto"
                  >
                    <img src="assets/img/Logo.png" alt="" width="50px"/>
                    <span class="d-none d-lg-block text-uppercase"
                      >EcoLacto</span
                    >
                  </a>
                </div>
                <!-- End Logo -->

                <div class="card mb-3">
                  <div class="card-body">
                    <div class="pt-4 pb-2">
                      <h5 class="card-title text-center pb-0 fs-4">
                        Create New Account
                      </h5>

                    </div>

                    <form class="row g-3 needs-validation" method="POST" action="./Home-Cook-Signup.php" id="signup-form" enctype="multipart/form-data">

                    <div class="col-6">
                        <label for="name" class="form-label">Name</label>
                        <div class="input-group has-validation">

                          <input
                            type="text"
                            name="name"
                            class="form-control"
                            id="Name"
                            required
                          />
                          <div class="invalid-feedback">
                            Please enter a valid Name!
                          </div>
                        </div>
                      </div>

                      <div class="col-6">
                        <label for="name" class="form-label">Email</label>
                        <div class="input-group has-validation">

                          <input
                            type="email"
                            name="email"
                            class="form-control"
                            id="Name"
                            required
                          />
                          <div class="invalid-feedback">
                            Please enter a valid Email adddress!
                          </div>
                        </div>
                      </div>

                      <div class="col-12">
                        <label for="name" class="form-label">Phone</label>
                        <div class="input-group has-validation">

                          <input
                            type="text"
                            name="phone"
                            pattern="[0-9]{10}" title="Phone Number Must Be 10 Numbers"
                            class="form-control"
                            id="Name"
                            required
                          />
                          <div class="invalid-feedback">
                            Please enter a valid Phone adddress!
                          </div>
                        </div>
                      </div>

                      <div class="col-12">
                        <label for="yourPassword" class="form-label"
                          >Password</label
                        >
                        <input
                          type="password"
                          name="password"
                          class="form-control"
                          id="yourPassword"
                          required
                        />
                        <div class="invalid-feedback" id="password-Message">
                          Please enter your password!
                        </div>
                      </div>


                      <div class="col-12">
                        <label for="yourPassword" class="form-label"
                          >Image</label
                        >
                        <input
                          type="file"
                          name="file"
                          class="form-control"
                          id="yourPassword"
                          required
                        />
                        <div class="invalid-feedback" id="password-Message">
                          Please enter your password!
                        </div>
                      </div>

                      <div class="col-12">
                        <p class="small mb-0">
                          Already have account?
                          <a href="./Home-Cook-Login.php">Login Now</a>
                        </p>
                      </div>
                      <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit" name="Submit">
                          Signup
                        </button>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>
    <!-- End #main -->

    <a
      href="#"
      class="back-to-top d-flex align-items-center justify-content-center"
      ><i class="bi bi-arrow-up-short"></i
    ></a>

    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
  </body>
</html>
