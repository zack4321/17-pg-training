<?php
error_reporting(E_ALL);
require_once 'functions.php';
// トゥート投稿

session_start();
redirectToLoginPageIfNotLoggedIn();

$database = getDatabase();
$user = $database->query("
    INSERT INTO `toot`(`user_id`, `text`, `image_file_name`, `created_at`) VALUES (" .$_SESSION['user_id'].",'".$_POST['text']."',0,20170501)
");

header('Location: /');
