<?php 

$link = mysqli_connect("localhost","ericdeng_admin","2/4eji6fup","ericdeng_ntustsafood") or die("Error " . mysqli_error($link));
date_default_timezone_set("Asia/Taipei");

//驗證資料的函式
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

include('inc/posts.inc.php');
include('inc/comments.inc.php');
include('inc/search.inc.php');

?>