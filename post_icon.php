<?php
error_reporting(E_ALL);
require_once 'functions.php';
// トゥート投稿

session_start();
redirectToLoginPageIfNotLoggedIn();

$upload_directory = dirname(__FILE__) . "/uploaded_image/user_image/" .$_FILES["image"]["name"];
move_uploaded_file($_FILES["image"]["tmp_name"],$upload_directory);

$database = getDatabase();
$user = $database->query("
    UPDATE user SET icon_url = '".$_FILES["image"]["name"]. "' WHERE id = ".$_SESSION['user_id']."
");

header('Location: /');
