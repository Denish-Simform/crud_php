<?php

// We start a session to access
// the captcha externally!
session_start();
if(isset($_SESSION['expire']) && $_SESSION['expire'] < time()) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['expire'] = time() + 30;
  // Generate captcha code
  $random_num    = md5(random_bytes(64));
  $captcha_code  = substr($random_num, 0, 6);
  // Assign captcha in session
  $_SESSION['CAPTCHA_CODE'] = $captcha_code;
  // Create captcha image
  $layer = imagecreatetruecolor(168, 37);
  $captcha_bg = imagecolorallocate($layer, 247, 174, 71);
  imagefill($layer, 0, 0, $captcha_bg);
  $captcha_text_color = imagecolorallocate($layer, 0, 0, 0);
  imagestring($layer, 5, 55, 10, $captcha_code, $captcha_text_color);
  header("Content-type: image/jpeg");
  imagejpeg($layer);
?>
