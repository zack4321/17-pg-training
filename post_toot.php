<?php
error_reporting(E_ALL);
require_once 'functions.php';
// トゥート投稿

session_start();
redirectToLoginPageIfNotLoggedIn();

$upload_directory = dirname(__FILE__) . "/uploaded_image/" .$_FILES["image"]["name"];
move_uploaded_file($_FILES["image"]["tmp_name"],$upload_directory);

$database = getDatabase();
$user = $database->query("
    INSERT INTO `toot`(`user_id`, `text`, `image_file_name`, `created_at`) VALUES (" .$_SESSION['user_id'].",'".$_POST['text']."','".$_FILES["image"]["name"]."',20170501)
");

header('Location: /');
