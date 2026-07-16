<?php 
session_start();
$MSG = $_GET['message'] ?? '';
include 'config/conn.php';

if (!isset($_SESSION['user_id'])) {
  header("location:index.php");
}

if (isset($_POST['update_user'])) {

    $id          = $_POST['edit_id'];
    $editName    = $_POST['full_name'];
    $editEmail   = $_POST['email'];
    $editPhone   = $_POST['phone'];
    $editAddress = $_POST['address'];
    $editRole    = $_POST['role'];

  
    if ($editRole == "admin") {

        $exist = "SELECT COUNT(*) FROM users
                  WHERE role = 'admin'
                  AND id != :id";

        $stmt = $conn->prepare($exist);
        $stmt->execute([
            ':id' => $id
        ]);

        $count = $stmt->fetchColumn();

        if ($count > 0) {
            header("location:congrats.php?goto_page=add-users.php&message=warning--Admin already exists");
            exit;
        }
    }

    // Update query
    $updateUsers = "UPDATE users SET full_name = :fullname,
                        email = :email,
                        phone = :phone,
                        address = :address,
                        role = :role
                       WHERE id = :id";

    $stmt = $conn->prepare($updateUsers);
    $stmt->execute([
        ':fullname' => $editName,
        ':email'    => $editEmail,
        ':phone'    => $editPhone,
        ':address'  => $editAddress,
        ':role'     => $editRole,
        ':id'       => $id,
    ]);

    header("location:congrats.php?goto_page=add-users.php&message=success--User updated successfully");
    exit;
}



if(isset($_POST['submit'])){

$full_name     = $_POST['full_name'];
  $email       = $_POST['email'];
  $password    = $_POST['password'];
  $password    = password_hash($password, PASSWORD_BCRYPT);
  $phone       = $_POST['phone'];
  $address     = $_POST['address'];
  $role        = $_POST['role'];


if ($role == 'admin') {

    $checkAdmin = "SELECT COUNT(*) FROM users WHERE role = 'admin'";
    $stmt = $conn->prepare($checkAdmin);
    $stmt->execute();

    $adminCount = $stmt->fetchColumn();

    if ($adminCount > 0) {
        header("location:congrats.php?goto_page=add-users.php&message=warning--{$role} already exist");
    exit;
    }
}

  $profile_pic = "";

    if (!empty($_FILES['profile_pic']['name'])) {

        $imageName = time() . "_" . $_FILES['profile_pic']['name'];
        
        $tmpName   = $_FILES['profile_pic']['tmp_name'];

        $folder = "assets/user-img/" . $imageName;

        move_uploaded_file($tmpName, $folder);

        $profile_pic = $imageName;
    }

try {
  $conn->beginTransaction();
     $insertQuery = "INSERT INTO users(`full_name`, `email`, `password`, `phone`, `address`, `role`, `profile_pic`)VALUES(:full_name, :email, :password, :phone, :address, :role, :profile_pic);";
    $stmt = $conn->prepare($insertQuery);
    $stmt->execute([
      ':full_name'  => $full_name,
      ':email'      => $email,
      ':password'   => $password,
      ':phone'      => $phone,
      ':role'       => $role,
      ':address'    => $address,
      ':profile_pic' => $profile_pic
    ]);
    $conn->commit();
     header("Location:congrats.php?goto_page=add-users.php&message=success--User Added successfully");
    exit;
    
} catch (\Throwable $th) {
  $conn->rollback();
 header("Location:congrats.php?goto_page=add-users.php&message=warning--Something went wrong try leter");
  exit;
}

}
$selectQuery = "SELECT * FROM users;";
$stmt = $conn->prepare($selectQuery);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <script src="assets/js/sweet_alert.min.js"></script>
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
  <link href="assets/images/favicon.png" rel="shortcut icon"/>

  
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
                
  <!-- Open Modal Button -->
   <div class="d-flex justify-content-end mb-2">
  <button 
    type="button" 
    class="open-btn"
    class="text-left"
    data-bs-toggle="modal" 
    data-bs-target="#registerModal">
    Add Users
  </button>
</div>  

<!-- SHOW USERS -->
<div class="card card-default">
  <div class="card-header">
    <h2>Users Table</h2>

    <a data-toggle="collapse" href="#collapse-data-tables" role="button" aria-expanded="false"
      aria-controls="collapse-data-tables"> </a>

  </div>
  <div class="card-body">
    <div class="collapse" id="collapse-data-tables">
      <pre class="language-html mb-4">
<code>
<table id="productsTable" class="table table-hover table-product" style="width:100%">

</table>
</code>
      </pre>
    </div>
    <table id="productsTable" class="table table-product" style="width:100%">
      <thead>
         <tr>
      <th>Id</th>
      <th>UserName</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Address</th>
      <th>Role</th>
      <th>ProfilePic</th>
      <th>Edit</th>

    </tr>
      </thead>
      <tbody>
    <tr>
      <?php
      $goto_page = "add-users.php";
      $table = "users";
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
     
      ?>
      <td><?= $row['id']?></td>
      <td><?= $row['full_name']?></td>
      <td><?= $row['email']?></td>
      <td><?= $row['phone']?></td>
      <td><?= $row['address']?></td>
      <td><?= $row['role']?></td>
      <td><img src="assets/user-img./<?= $row['profile_pic']?>"<style height=30px></style></td>
      <td><button 
       type="button"
       class="editBtn"
       data-id="<?= $row['id'] ?>"
       data-name="<?= $row['full_name'] ?>"
       data-email="<?= $row['email'] ?>"
       data-phone="<?= $row['phone'] ?>"
       data-address="<?= $row['address'] ?>"
       data-role="<?= $row['role'] ?>"
       data-toggle="modal"
       data-target="#editUserModal">
       <i class="fa fa-edit"></i>
       </button>
      <a href="delete.php?goto_page=<?=($goto_page)?>&table=<?=($table)?>&id=<?= $row['id']?>" onclick="return deleteConfirm(this);"><i class="fa fa-trash"></i></a> 
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
<!-- END SHOW USERS -->



  <!-- Modal -->
  <div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Header -->
        <div class="modal-header">
          <h4 class="modal-title">Registration Users</h4>

          <button 
            type="button" 
            class="btn-close btn-close-white" 
            data-bs-dismiss="modal">
          </button>
        </div>

        <!-- Body -->
        <div class="modal-body p-4">

          <form method="post" enctype="multipart/form-data">

            <!-- Name -->
            <div class="mb-3">
              <label class="form-label fw-bold">
                Name
              </label>

              <input 
                type="text" 
                class="form-control"
                placeholder="Enter your name" name="full_name">
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label class="form-label fw-bold">
                Email
              </label>

              <input 
                type="email" 
                class="form-control"
                placeholder="Enter your email" name="email">
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label class="form-label fw-bold">
                Password
              </label>

              <input 
                type="password" 
                class="form-control"
                placeholder="Enter your password" name="password">
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">
                Phone
              </label>

              <input 
                type="text" 
                class="form-control"
                placeholder="Enter your phone" name="phone">
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">
                Address
              </label>

              <input 
                type="text" 
                class="form-control"
                placeholder="Enter your address" name="address">
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">
               Role
              </label>

              <input 
                name="role"
                type="text" 
                class="form-control"
                placeholder="Enter your role">
            </div>

            <!-- Picture -->
            <div class="mb-4">
              <label class="form-label fw-bold">
                Profile Picture
              </label>

              <input name="profile_pic"
                type="file" 
                class="form-control">
            </div>

            <!-- Submit -->
            <button name="submit"
              type="submit" 
              class="btn submit-btn text-white w-100 btn btn-success">
              Register
            </button>

          </form>

        </div>

      </div>
    </div>
  </div>

        <!-- USER EDIT MODAL -->
        <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
             <h5>Edit User</h5>
             <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control">
                    </div>
                     <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" id="address" class="form-control">
                    </div>
                     <div class="form-group">
                        <label>Role</label>
                        <input type="text" name="role" id="role" class="form-control">
                    </div>
                    <div class="text-right">
                    <button type="submit" name="update_user" class="btn btn-success">
                        Update
                </button>
                </div>
                </form>
            </div>
        </div>
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
    $('#full_name').val($(this).data('name'));
    $('#email').val($(this).data('email'));
    $('#phone').val($(this).data('phone'));
    $('#address').val($(this).data('address'));
    $('#role').val($(this).data('role'));
    

});

</script>
  </body>
</html>

<script>

function deleteConfirm(el) {
  Swal.fire({
    title: 'Are you sure?',
    text: "you want to delete this user!",
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
    text: 'User deleted successfully',
    confirmButtonColor: '#28a745'
  });
  </script>
  <?php 
  } 
  ?>
</script>