<?php
session_start();

include 'config/conn.php';

if (isset($_GET['remove'])) {

    $remove_id = (int)$_GET['remove'];

    if (isset($_SESSION['cart'][$remove_id])) {

        unset($_SESSION['cart'][$remove_id]);
    }

    header("Location: cart.php");
    exit();
}

if (!empty($_SESSION['cart'])) {
	
    $ids = array_keys($_SESSION['cart']);
	
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $sql = "SELECT * FROM products WHERE id IN ($placeholders)";

    $stmt = $conn->prepare($sql);
    $stmt->execute($ids);

} else {
    // cart empty case
    $stmt = null;

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        	<h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        	</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="cart">
	                <div class="container">
	                	<div class="row">
	                		<div class="col-lg-9">
	                			<table class="table table-cart table-mobile">
									<thead>
										<tr>
											<th>Product</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Total</th>
											<th></th>
										</tr>
									</thead>

									<tbody>
										
										<?php
										$grandTotal = 0;
											
										if($stmt !== null){	
										while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
										
										$qty = $_SESSION['cart'][$row['id']];
										$subtotal = $row['price'] * $qty;
										$grandTotal += $subtotal;

										?>
										<tr>
											<td class="product-col">
												<div class="product">
													<figure class="product-media">
														<a href="#">
															<img src="backend/assets/product-img/<?= $row['image']?>" alt="Product image">
														</a>
													</figure>

													<h3 class="product-title">
														<a href="#"><?= $row['description']?></a>
													</h3><!-- End .product-title -->
												</div><!-- End .product -->
											</td>
											<td class="price-col">$<?= $row['price']?></td>
											<td class="quantity-col">
                                                <div class="cart-product-quantity">
                                                    <input type="text" class="form-control" value="<?= $qty ?>" min="1" max="10" step="1" data-decimals="0" required>
                                                </div><!-- End .cart-product-quantity -->
                                            </td>
											<td class="total-col">$<?= number_format($subtotal, 2) ?></td>
											<td class="remove-col">
    										<a href="cart.php?remove=<?= $row['id'] ?>" class="btn-remove">
        									<i class="icon-close"></i>
    									</a>
										</td>
										</tr>
										
								 <?php
							     } 
								 }else{
									echo '<tr><td colspan="5" class="text-center" style="color:red">cart is empty</td> </tr>';
								 }
							   ?>
								</table><!-- End .table table-wishlist -->
				       
	                			<div class="cart-bottom">
			            			<div class="cart-discount">
			            				<form action="#">
			            					<div class="input-group">
				        						<input type="text" class="form-control" required placeholder="coupon code">
				        						<div class="input-group-append">
													<button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
												</div><!-- .End .input-group-append -->
			        						</div><!-- End .input-group -->
			            				</form>
			            			</div><!-- End .cart-discount -->
							
							</tbody>
							
			            			<a href="#" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></a>
		            			</div><!-- End .cart-bottom -->
	                		</div><!-- End .col-lg-9 -->
	                		<aside class="col-lg-3">
	                			<div class="summary summary-cart">
	                				<h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

	                				<table class="table table-summary">
	                					<tbody>
	                						<tr class="summary-subtotal">
	                							<td>Subtotal:</td>
	                							<td>$<?= number_format($grandTotal, 2) ?></td>
	                						</tr><!-- End .summary-subtotal -->
	                						<tr class="summary-shipping">
	                							<td>Shipping:</td>
	                							<td>&nbsp;</td>
	                						</tr>

	                						<tr class="summary-shipping-row">
	                							<td>
													<div class="custom-control custom-radio">
														<input type="radio" id="free-shipping" name="shipping" class="custom-control-input">
														<label class="custom-control-label" for="free-shipping">Free Shipping</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>$0.00</td>
	                						</tr><!-- End .summary-shipping-row -->

	                						<tr class="summary-shipping-row">
	                							<td>
	                								<div class="custom-control custom-radio">
														<input type="radio" id="standart-shipping" name="shipping" class="custom-control-input">
														<label class="custom-control-label" for="standart-shipping">Standart:</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>$10.00</td>
	                						</tr><!-- End .summary-shipping-row -->

	                						<tr class="summary-shipping-row">
	                							<td>
	                								<div class="custom-control custom-radio">
														<input type="radio" id="express-shipping" name="shipping" class="custom-control-input">
														<label class="custom-control-label" for="express-shipping">Express:</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>$20.00</td>
	                						</tr><!-- End .summary-shipping-row -->

	                						<tr class="summary-shipping-estimate">
	                							<td>Estimate for Your Country<br> <a href="dashboard.html">Change address</a></td>
	                							<td>&nbsp;</td>
	                						</tr><!-- End .summary-shipping-estimate -->

	                						<tr class="summary-total">
	                							<td>Total:</td>
	                							<td>$<?= number_format($grandTotal, 2) ?></td>
	                						</tr><!-- End .summary-total -->
	                					</tbody>
	                				</table><!-- End .table table-summary -->

	                				<a href="checkout.php" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
	                			</div><!-- End .summary -->

		            			<a href="category.html" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
	                		</aside><!-- End .col-lg-3 -->
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
            <?php
            include 'config/footer.php';
            ?>
        </main>

</body>
</html>