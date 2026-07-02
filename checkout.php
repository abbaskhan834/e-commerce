<?php
session_start();
include 'config/conn.php';
$MSG = $_GET['message'] ?? '';

if(empty($_SESSION['cart'])){
	header("location:cart.php");
	exit;
}

$ids = array_keys($_SESSION['cart']);


$placeholders = implode(',', array_fill(0, count($ids), '?'));

$selectProduct = "SELECT * FROM `products` WHERE `id` IN ($placeholders)";
$stmt = $conn->prepare($selectProduct);
$stmt->execute($ids);

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(empty($rows)){
	header('location:cart.php');
	exit;
}

$total = 0;
$shipping = 0;

foreach($rows as $item){
	
    $qty = $_SESSION['cart'][$item['id']];
	
    $subtotal = $item['price'] * $qty;

    $total += $subtotal;
}

if ($total > 500) {
    $shipping = 0;
}else{
    $shipping = 50;
}
$grandTotal = $total + $shipping;

if (isset($_POST['place-order'])) {

    $first_name       = $_POST['first_name'];
    $last_name        = $_POST['last_name'];
    $phone            = $_POST['phone'];
    $email            = $_POST['email'];
    $city             = $_POST['city'];
    $country          = $_POST['country'];
    $shipping_address = $_POST['shipping_address'];
	$payment_method   = $_POST['payment_method'];
	if(!isset($_SESSION['user_id'])){
	 header("Location:congrats.php?goto_page=checkout.php&message=warning--please login first");
	}else{
		$user_id = $_SESSION['user_id'];
	}
	
    try {
        
        // Insert order
        $insertQuery = "INSERT INTO orders 
        (user_id, first_name, last_name, phone, email, city, country, shipping_address, total_amount, payment_method)
        VALUES 
        (:user_id, :first_name, :last_name, :phone, :email, :city, :country, :shipping_address, :total_amount, :payment_method)";

        $stmt = $conn->prepare($insertQuery);
        $stmt->execute([
            ':user_id' => $user_id,
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':phone' => $phone,
            ':email' => $email,
            ':city' => $city,
            ':country' => $country,
            ':shipping_address' => $shipping_address,
            ':total_amount' => $total,
			':payment_method' => $payment_method
        ]);

		$order_id = $conn->lastInsertId();
		        

// Insert order items
$insertOrderItem = "INSERT INTO order_items 
(order_id, product_id, quantity, price)
VALUES (:order_id, :product_id, :quantity, :price)";

$stmt2 = $conn->prepare($insertOrderItem);

foreach ($_SESSION['cart'] as $product_id => $qty) {
	
    // GET PRICE
    $selectProduct = "SELECT price FROM products WHERE id = ?";
    $stmt = $conn->prepare($selectProduct);
    $stmt->execute([$product_id]);

    $price = $stmt->fetchColumn();
    
    // INSERT ORDER ITEM
    $stmt2->execute([
        ':order_id'   => $order_id,
        ':product_id' => $product_id,
        ':quantity'   => $qty,
        ':price'      => $price
    ]);
	
	header("location:invoice.php?order_id=". $order_id);
   
	unset($_SESSION['cart']);
	
	$stockUpdate =  "UPDATE products SET stock = stock - $qty WHERE id = $product_id";
	$stmt = $conn->prepare($stockUpdate);
	$stmt->execute();
}


} catch (\Throwable $th) {
	echo $th->getMessage();
       
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	<?php
	include './config/alerts.php';
	?>
</head>
<?php
include 'config/css-links.php';
?>
<body>
 <header class="header header-7">
         
        <!-- HEADER -->
        <?php
        include 'config/header.php';
        ?>

        <!-- NAVBAR -->
         <?php
         include 'config/navbar.php';
         ?>   
        </header>

    <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Checkout<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="checkout">
	                <div class="container">
            			<div class="checkout-discount">
            				<form action="#">
        						<input type="text" class="form-control" required id="checkout-discount-input">
            					<label for="checkout-discount-input" class="text-truncate">Have a coupon? <span>Click here to enter your code</span></label>
            				</form>
            			</div><!-- End .checkout-discount -->
            			<form method="post">
		                	<div class="row">
		                		<div class="col-lg-9">
		                			<h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
		                				<div class="row">
		                					<div class="col-sm-6">
		                						<label>First Name *</label>
		                						<input type="text" class="form-control" name="first_name" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>Last Name *</label>
		                						<input type="text" class="form-control" name="last_name" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

	            						<label>phone</label>
	            						<input type="text" class="form-control" name="phone" required>
										<label>email</label>
	            						<input type="text" class="form-control" name="email" required>
										<label>city</label>
	            						<input type="text" class="form-control" name="city" required>
										<label>Country *</label>
	            						<input type="text" class="form-control" name="country" required>

	            						<label>shipping address</label>
	            						<input type="text" class="form-control" placeholder="House number and Street name"  name="shipping_address" required>
	        							<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="checkout-create-acc">
											<label class="custom-control-label" for="checkout-create-acc">Create an account?</label>
										</div><!-- End .custom-checkbox -->

										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="checkout-diff-address">
											<label class="custom-control-label" for="checkout-diff-address">Ship to a different address?</label>
										</div><!-- End .custom-checkbox -->

	                					<label>Order notes (optional)</label>
	        							<textarea class="form-control" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
		                		</div><!-- End .col-lg-9 -->
		                		<aside class="col-lg-3">
		                			<div class="summary">
		                				<h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

		                				<table class="table table-summary">
		                					<thead>
		                						<tr>
		                							<th>Product</th>
		                							<th>Price</th>
		                						</tr>
		                					</thead>

		                					<tbody>
					
		                						<tr>
		                							<td><a href="#"><?= $item['description']?></a></td>
		                							<td><?= $item['price']?></td>
		                						</tr>

		                						<tr>
		                							
		                							
		                						</tr>
		                						<tr class="summary-subtotal">
		                							<td>Subtotal:</td>
		                							<td>$<?= $item['price']?></td>
		                						</tr><!-- End .summary-subtotal -->
		                						<tr>
		                							<td>Shipping:</td>
		                							<td><?= $shipping?></td>
		                						</tr>
		                						<tr class="summary-total">
		                							<td>Total:</td>
		                							<td name="total_amount">$<?= $total?></td>
													<input type="hidden" name="total_amount" value="<?= $total ?>">
		                						</tr><!-- End .summary-total -->
												
		                					</tbody>
											
		                				</table><!-- End .table table-summary -->

		                				<div class="accordion-summary" id="accordion-payment">
										    <div class="card">
										        <div class="card-header" id="heading-1">
										            <h2 class="card-title">
										                <a role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
										                    Direct bank transfer
										                </a>
										            </h2>
										        </div><!-- End .card-header -->
										        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-payment">
										            <div class="card-body">
										                Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.
										            </div><!-- End .card-body -->
										        </div><!-- End .collapse -->
										    </div><!-- End .card -->

										    
										    <div class="card">
    <div class="card-header" id="heading-3">
        <h2 class="card-title">

            <input type="hidden" name="payment_method" value="COD">

            <label for="cod">
                <a class="collapsed" role="button"
                   data-toggle="collapse"
                   href="#collapse-3"
                   aria-expanded="false"
                   aria-controls="collapse-3">
                    Cash on Delivery
                </a>
            </label>

        </h2>
    </div>

    <div id="collapse-3" class="collapse" aria-labelledby="heading-3">
        <div class="card-body">
            Pay when your order is delivered.
        </div>
    </div>
</div>

										</div><!-- End .accordion -->

		                				<button type="submit" name="place-order" class="btn btn-outline-primary-2 btn-order btn-block">
		                					<span class="btn-text">Place Order</span>
		                					<span class="btn-hover-text">Proceed to Checkout</span>
		                				</button>
		                			</div><!-- End .summary -->
		                		</aside><!-- End .col-lg-3 -->
		                	</div><!-- End .row -->
            			
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
				<?php
                include 'config/js-links.php';
                ?>
            </div><!-- End .page-content -->
			</form>
            <?php
            include 'config/footer.php';
            ?>
        </main><!-- End .main -->
	
</body>
</html>