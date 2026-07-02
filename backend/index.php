<?php

session_start();
$MSG = $_GET['message'] ?? '';
include 'config/conn.php';

if (isset($_POST['sign-in'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $selectQuery = "SELECT * FROM users WHERE email = :email";

    $stmt = $conn->prepare($selectQuery);

    $stmt->bindParam(':email', $email);

    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    

    // User mila?
    if ($user) {

        // Password verify
        if (password_verify($password, $user['password'])) {

            // Session create
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];



        if ($user['role'] == "admin") {

          header("location:dashboard.php");

        }elseif($user['role'] == "user"){

          header('location:customer/user-dashboard.php');
        }

        }else{
          header("location:congrats.php?goto_page=index.php&message=warning-- User Not Found");
        }

        }else{
          echo "email or password are incorrect please try again";
        }
        
        
    }else{
      // echo "user not found";
    }



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Ecommerce</title>
  <?php
  include '../config/alerts.php';
  ?>
  <!-- theme meta -->
  <meta name="theme-name" content="mono"/>


  <!-- GOOGLE FONTS -->
  <?php
  //  include '../config/google-fonts.php';
  ?>

  
<?php
include '../config/css-links.php';
?>


  <!-- FAVICON -->
  <link href="images/favicon.png" rel="shortcut icon"/>

</head>

   <body class="bg-light-gray" id="body">
          <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
          <div class="d-flex flex-column justify-content-between">
            <div class="row justify-content-center">
              <div class="col-lg-6 col-md-10">
                <div class="card card-default mb-0">
                  <div class="card-header pb-0">
                    <div class="app-brand w-100 d-flex justify-content-center border-bottom-0">
                      <a class="w-auto pl-0" href="/index.html">
                        <img src="assets/images/logo.png" alt="Mono">
                        <span class="brand-name text-dark">MONO</span>
                      </a>
                    </div>
                  </div>
                  <div class="card-body px-5 pb-5 pt-0">

                    <h4 class="text-dark mb-6 text-center">Sign in </h4>

                    <form method="POST">
                      <div class="row">
                        <div class="form-group col-md-12 mb-4">
                          <input type="email" class="form-control input-lg" id="email" aria-describedby="emailHelp"
                            placeholder="email" name="email" value="" required>
                        </div>
                        <div class="form-group col-md-12 ">
                          <input type="password" class="form-control input-lg" id="password" placeholder="Password" name="password" value="" required>
                        </div>
                        <div class="col-md-12">

                          <div class="d-flex justify-content-between mb-3">

                            <div class="custom-control custom-checkbox mr-3 mb-3">
                              <input type="checkbox" class="custom-control-input" id="customCheck2">
                              
                            </div>
                          
                          </div>
                          <button type="submit" class="btn btn-primary btn-pill mb-4 mr-5" name="sign-in">Sign In</button>
                      </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <?php
          include '../config/js-links.php';
        ?>
</body>
</html>
