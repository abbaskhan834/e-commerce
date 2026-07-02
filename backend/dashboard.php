<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
            
      
            </div> 
        </div>
        
          <!-- Footer -->
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