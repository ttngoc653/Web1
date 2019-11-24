<?php include 'header.php'; ?>
<?php 
if (isset($_SESSION['user'])) {
  unset($_SESSION['user']);
}
elseif (isset($_COOKIE['user'])) {
  setcookie('user',NULL,0);
}
header('Location: index.php');
 ?>
<?php include 'footer.php'; ?>