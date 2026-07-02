<?php
session_start();
include 'config/conn.php';
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}

$seleceOrders = "SELECT * FROM orders ORDER BY id DESC;";
$stmt =  $conn->prepare($seleceOrders);
$stmt->execute();


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
  include 'config/css-links.php';
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
        <!-- SHOW ALL ORDERS -->
       <div class="card">
       <div class="card-header">
        <h4>All Orders</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User NAME</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                <?php
                $id = 1;
                while($orders = $stmt->fetch(PDO::FETCH_ASSOC)){

                ?>
                  <td><?= $id++?></td>  
                  <td><?= $orders['first_name']?></td>
                  <td><?= $orders['total_amount'] ?></td>
                  <td>
          <?php

          $status = $orders['order_status'];

          switch($status){

            case 'pending':
                $class = "badge-warning";
                break;

            case 'processing':
                $class = "badge-info";
                break;  

            case 'shipped':
                $class = "badge-primary";
                break;  

            case 'delivered':
                $class = "badge-success";
                break; 
                
            case 'cancelled':
                $class = "badge-danger";
                break; 

            default:
            $class = "badge-secondary";
          }

          ?>
        <span class="badge <?= $class?>">
            <?= ucfirst($status)?>
        </span>
       </td>

       <td><?= $orders['created_at']; ?></td>

       <td>
       <a href="order_details.php?id=<?= $orders['id']; ?>"
       class="btn btn-sm btn-primary">
                View
        </a>
       </td>

     </tr>
     <?php
       }
     ?>
        </tbody>
        </table>
    </div>
</div>
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