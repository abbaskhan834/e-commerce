<!-- PLUGINS CSS STYLE -->

<?php 
    $MSG = $_GET['message'] ?? '';
?>





  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/font-awsome.min.css" rel="stylesheet" />
  <link href="assets/plugins/nprogress/nprogress.css" rel="stylesheet" />
  <link href="assets/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
  <link href="assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />
  <link href="assets/plugins/toaster/toastr.min.css" rel="stylesheet" />
  
  
  <!-- MONO CSS -->
  <link id="main-css-href" rel="stylesheet" href="assets/css/style.css" />
   
  <title>Bootstrap Modal Form</title>

  <style>
    body{
      height:100vh;
      display:flex;
      justify-content:center;
      align-items:center;
      
    }

    .open-btn{
      padding:10px 20px;
      border:none;
      border-radius:12px;
      background:#fff;
      color:#764ba2;
      font-size:18px;
      font-weight:bold;
      transition:0.3s;
    }
    

    .open-btn:hover{
      transform:scale(1.05);
    }

    .modal-content{
      border-radius:20px;
      border:none;
      overflow:hidden;
    }

    .modal-header{
      color:#fff;
      border:none;
    }

    .form-control{
      border-radius:10px;
      padding:12px;
    }

    .form-control:focus{
      box-shadow:none;
      border-color:#764ba2;
    }

    .submit-btn{
      /* background: linear-gradient(135deg,#667eea,#764ba2); */
      border:none;
      padding:12px;
      border-radius:10px;
      font-weight:bold;
      transition:0.3s;
    }

    .submit-btn:hover{
      opacity:0.9;
    }
  </style>

