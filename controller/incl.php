<?php 
function getCurURL()
{
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageURL = "https://";
    } else {
      $pageURL = 'http://';
  }
  if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
} else {
    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
}
$split = explode("?", $pageURL);
return $split[0];
}

function linkResetPass()
{
	$splited = explode("/", getCurURL());
	unset($splited[count($splited) - 1]);

	return implode("/", $splited) . "/reset-password.php";
}

function linkActiveAccount()
{
    $splited = explode("/", getCurURL());
    unset($splited[count($splited) - 1]);

    return implode("/", $splited) . "/active-account.php";
}

function redirectTo($message,$toPage="index.php"){
    if (strlen($message)>0) {
        echo "<script>alert('$message');</script>";    
    }
    echo "<script>window.location = '$toPage'; </script>";
}

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/language/phpmailer.lang-vi.php';
require 'PHPMailer/src/SMTP.php';
include 'mailer.php';

include 'connectedDB.php';
include 'banbe.php';
include 'nguoidung.php';
include 'trangthai.php';
include 'thich.php';
include 'binhluan.php';
include 'thongbao.php';
?>