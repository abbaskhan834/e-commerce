<?php
session_start();
include 'config/conn.php';
$MSG = $_GET['message'] ?? '';
if (!isset($_SESSION['user_id'])) {
  header("location: index.php");
}

if(isset($_POST['update_product'])){

  $id            = $_POST['edit_id'];
  $product_name  = $_POST['product_name'];
  $description   = $_POST['description'];
  $price         = $_POST['price'];
  $stock         = $_POST['stock'];

  $updateProduct = "UPDATE products SET product_name = :product_name,
    description  = :description,
    price        = :price,
    stock        = :stock
  WHERE id       = :id";

  $stmt = $conn->prepare($updateProduct);

  $stmt->execute([
    ':product_name' => $product_name,
    ':description'  => $description,
    ':price'        => $price,
    ':stock'        => $stock,
    ':id'           => $id
  ]);

  header("Location:congrats.php?goto_page=add_products.php&message=success--Product updated successfully");
    exit;
}
  
if (isset($_POST['add-product'])) {
  $product_name  = $_POST['product_name'];
  $description   = $_POST['description'];
  $price         = $_POST['price'];
  $stock         = $_POST['stock'];
  
  $profile_pic = "";
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        $tmpName   = $_FILES['image']['tmp_name'];
        $folder = "assets/product-img/" . $imageName;
        move_uploaded_file($tmpName, $folder);
        $profile_pic = $imageName;
    }

  try {

    $conn->beginTransaction();

    $insertProduct = "INSERT INTO products(product_name, description, price, stock, image)VALUES(:product_name, :description, :price, :stock, :image);";
    $stmt = $conn->prepare($insertProduct);
    $stmt->execute([
      ':product_name' => $product_name,
      ':description' => $description,
      ':price' => $price,
      ':stock' => $stock,
      ':image' => $profile_pic
    ]);
    header("location:congrats.php?goto_page=add_products.php&message=success--product added successfully");
    $conn->commit();

  } catch (\Throwable $th) {
    $conn->rollback();
  }

}

$selectProduct = "SELECT * FROM products";
$stmt = $conn->prepare($selectProduct);
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
    
  <?php
include 'config/alerts.php';
?>

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
            <!-- ADD PRODUCTS BUTTON-->
          <div class="d-flex justify-content-end mb-2">
            <button 
            type="button" 
            class="open-btn"
            data-bs-toggle="modal" 
            data-bs-target="#registerModal" require>
            Add Products
            </button>
        </div>
     
        
<div class="card card-default">
  <div class="card-header">
    <h2>Product Table</h2>
    <a data-toggle="collapse" href="#collapse-data-tables" role="button" aria-expanded="false"
      aria-controls="collapse-data-tables"> </a>
  </div>

  <div class="card-body">
    <div class="collapse" id="collapse-data-tables">
      <pre class="language-html mb-4">
<code>
<table id="productsTable" class="table table-hover table-product" style="width:80%">

</table>
</code>
      </pre>
    </div>
    <table id="productsTable" class="table table-product" style="width:100%">
      <thead>
      <tr>
      <th>Id</th>
      <th>Product Name</th>
      <th>Price</th>
      <th>Stock</th>
      <th>Image</th>
      <th>Edit</th>
    </tr>
      </thead>
      <tbody>
    <tr>
      <?php
      $goto_page = "add_products.php";
      $table = "products";
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
     
      ?>
      <td><?= $row['id']?></td>
      <td><?= $row['product_name']?></td>
      <td><?= $row['price']?></td>
      <td><?= $row['stock']?></td>
      <td><img src="assets/product-img./<?= $row['image']?>"<style height=30px></style></td>

    <td><button 
       type="button"
       class="editBtn"
       data-id="<?= $row['id'] ?>"
       data-product_name="<?= $row['product_name'] ?>"
       data-description="<?= $row['description'] ?>"
       data-price="<?= $row['price'] ?>"
       data-stock="<?= $row['stock'] ?>"
       data-toggle="modal"
       data-target="#editProductModal" required>
       <i class="fa fa-edit"></i>
       </button>
       <a href="delete.php?goto_page=<?=($goto_page)?>&table=<?=($table)?>&id=<?= $row['id']?>"onclick="return deleteConfirm(this);"><i class="fa fa-trash"></i></a>
       </td>

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

  <div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Header -->
        <div class="modal-header">
          <h4 class="modal-title">Product Table</h4>

          <button 
            type="button" 
            class="btn-close btn-close-white" 
            data-bs-dismiss="modal">
          </button>
        </div>

        <!-- Body -->
        <div class="modal-body p-4">
          <form method="post" enctype="multipart/form-data">

            <!-- PRODUCT NAME -->
            <div class="mb-3">
              <label class="form-label fw-bold">
                Product Name
              </label>

              <input 
                type="text" 
                class="form-control"
                placeholder="Enter your Product name" name="product_name" require>
            </div>

            <!-- Description -->
            <div class="mb-3">
              <label class="form-label fw-bold">
                Description
              </label>

              <input 
                type="text" 
                class="form-control"
                placeholder="Enter your Description" name="description" require>
            </div>

            <!-- price -->
            <div class="mb-3">
              <label class="form-label fw-bold">
                Price
              </label>

              <input 
                type="text" 
                class="form-control"
                placeholder="Enter your Price" name="price" require>
            </div>
            <!-- STOCK -->
            <div class="mb-3">
              <label class="form-label fw-bold">
                Stock
              </label>
              <input 
                type="text" 
                class="form-control"
                placeholder="Enter your Stock" name="stock" require>
            </div>

            <!-- PROFILE PIC -->
            <div class="mb-4">
              <label class="form-label fw-bold">
                Product Image
              </label>

              <input name="image"
                type="file" 
                class="form-control" require>
            </div>

            <!-- Submit -->
            <button name="add-product"
              type="submit" 
              class="btn submit-btn text-white w-100 btn btn-success" require>
              Add Product
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
        

        <!-- PRODUCT EDIT MODAL -->
  <div class="modal fade" id="editProductModal" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
             <h5>Edit Product</h5>
             <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" id="description" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" id="price" class="form-control">
                    </div>
                     <div class="form-group">
                        <label>Stock</label>
                        <input type="text" name="stock" id="stock" class="form-control">
                    </div>
                     
                    <div class="text-right">
                    <button type="submit" name="update_product" class="btn btn-success">
                        Update
                </button>
                </div>
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



  <script>
   $('.editBtn').click(function(){

    $('#edit_id').val($(this).data('id'));
    $('#product_name').val($(this).data('product_name'));
    $('#description').val($(this).data('description'));
    $('#price').val($(this).data('price'));
    $('#stock').val($(this).data('stock'))
   })
  </script>

  </body>
</html>

<script>

function deleteConfirm(el) {
  Swal.fire({
    title: 'Are you sure?',
    text: "you want to delete this product!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = el.href; 
    }
  });

  return false;   
}
</script>

  <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') { ?>
  <script>
  Swal.fire({
    icon: 'success',
    title: 'Deleted!',
    text: 'Product deleted successfully',
    confirmButtonColor: '#28a745'
  });
  </script>
  <?php 
  } 
  ?>
</script>