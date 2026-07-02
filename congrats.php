<?php
$msg = $_GET['message'];
$gotoPage = $_GET['goto_page'];

header("location:$gotoPage?message=$msg");
exit;

?>