<?php include 'header.php'; ?>
<?php 
if (isset($_SESSION['user'])) {
  unset($_SESSION['user']);
}
elseif (isset($_COOKIE['user'])) {
  setcookie('user',NULL,0);
}
	redirectTo("");
 ?>
<?php include 'footer.php'; ?>