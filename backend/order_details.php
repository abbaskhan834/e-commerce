<?php
session_start();

include 'config/conn.php';

$id = $_GET['id'];

if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}

$selectOrderDetail = "SELECT * FROM `orders` WHERE id = $id";

$stmt = $conn->prepare($selectOrderDetail);

$stmt->execute();

$orderDetail = $stmt->fetch(PDO::FETCH_ASSOC);


    if (isset($_POST['update_status'])) {
   
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        // allowed statuses
        $allowed_status = ['pending','processing','shipped','delivered','cancelled'];

        if (in_array($status, $allowed_status)) {

            $stmt = $conn->prepare("UPDATE orders SET order_status = :status WHERE id = :id");

            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $order_id);
            $stmt->execute();

        } else {
            echo "Invalid status selected.";
        }
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
            
       <div class="card">
    <div class="card-header">
        <h4>Order Details</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">Phone</th>
                <td><?= $orderDetail['phone'] ?></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><?= $orderDetail['email'] ?></td>
            </tr>

            <tr>
                <th>City</th>
                <td><?= $orderDetail['city'] ?></td>
            </tr>

            <tr>
                <th>Country</th>
                <td><?= $orderDetail['country'] ?></td>
            </tr>
        </table>

        <a href="orders.php" class="btn btn-primary mt-2 px-2">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <form method="POST">
    <input type="hidden" name="order_id" value="<?= $id?>">
    
    <div class="d-flex align-items-center mt-3 mb-2">
    <select name="status" class="form-control col-7 mx-5">
    <option value="pending" <?= $orderDetail['order_status']=='pending' ? 'selected' : '' ?>>
        Pending
    </option>

    <option value="processing" <?= $orderDetail['order_status']=='processing' ? 'selected' : '' ?>>
        Processing
    </option>

    <option value="shipped" <?= $orderDetail['order_status']=='shipped' ? 'selected' : '' ?>>
        Shipped
    </option>

    <option value="delivered" <?= $orderDetail['order_status']=='delivered' ? 'selected' : '' ?>>
        Delivered
    </option>

    <option value="cancelled" <?= $orderDetail['order_status']=='cancelled' ? 'selected' : '' ?>>
        Cancelled
    </option>
</select>
<button type="submit" name="update_status" class="btn btn-primary">
        update status
    </button>
    </form>
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