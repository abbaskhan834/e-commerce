<?php
include 'config/conn.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <style> 
    .card{
      width: 100%;
    }

  </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Ecommerce</title>
    
  <!-- theme meta -->
  <meta name="theme-name" content="mono"/>


  <!-- GOOGLE FONTS -->
  <?php
  include 'config/google-fonts.php';
  ?>

  
<?php
include '../config/css-links.php';
?>

  <!-- FAVICON -->
  <link href="images/favicon.png" rel="shortcut icon"/>

  
</head>


  <body class="navbar-fixed sidebar-fixed" id="body">
    
  <?php
  include 'config/spinner.php'; 
  ?>

    <div class="wrapper">
      
    <!-- SIDEBAR  -->
        <?php
        include 'config/sidebar.php';
        ?>

      <div class="page-wrapper">
        
          <!-- Header -->
          <?php
          include 'config/header.php';
          ?>

        
        <div class="content-wrapper">
          <div class="content">                
    
       <div class="container">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-lg rounded-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title">
                  
                  <?php $select = "SELECT COUNT(*) FROM users";
                  $stmt = $conn->prepare($select);
                  $stmt->execute();
                  
                  $row = $stmt->fetchColumn();
                  ?>
                <div class="d-flex justify-content-center align-item-center">
                  <i class="fa solid fa-user fa-4x text-primary"></i>
                  <h1>
                  <span><?php echo $row?></span>
                  </h1>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div> 

          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-lg rouded-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title">
                   
                <?php
                $countOrder = "SELECT COUNT(*) FROM orders";
                $stmt = $conn->prepare($countOrder);
                $stmt->execute();
                $row = $stmt->fetchColumn();

                ?>
                <div class="d-flex justify-content-center align-item-center">
              <i class="fa solid fa-cart-shopping fa-4x text-success"></i>
              <h1>
                <span><?php echo $row?></span>
                </h1>
              </div>
            </div>
              </div>
              </div>
          </div>
          


          
          </div>
        </div>
       </div>
      </div>
    </div>
     <?php
         include 'config/footer.php';
         ?>
</div>
</div>


    <!-- JS LINKS -->
       <?php
       include 'config/js-links.php'; 
       ?> 

  </body>
</html>