<?php
// トップページ
require_once 'functions.php';

session_start();
redirectToLoginPageIfNotLoggedIn();

$user_login_name = $_SESSION['user_login_name'];

$database = getDatabase();
$toots = $database->query("
    SELECT *
    FROM `toot`
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- 下にindex.htmlをコピペして、index.htmlを消そう！ -->
<html>
    <head>
        <title>Yastodon(ヤストドン)</title>
        <link rel="stylesheet" href="/css/style.css">
        <meta charset="utf-8">
    </head>
    <body>
        <div class="wrapper">
            <div class="container myself-container">
                <div class="myself">
                    <div class="user-icon"></div>
                    <div class="user-name"></div>
                </div>
                <form enctype="multipart/form-data" method="post" action="/post_toot.php">
                    <textarea name="text" placeholder="今なにしてる？" required></textarea>
                    <input type="file" name="image">
                    <div class="toot-button-container">
                        <input type="submit" class="toot-button" value="トゥート!">
                        <a class="link_color" href="/icon.php">アイコンを変える</a>
                    </div>
                </form>
            </div>

            <div class="container toot-container">
                <div class="label icon-home"><img class="label-icon" src="/img/home.png" width="15" alt="Home - ">ホーム</div>
                <ul>
                  <?php
                  for ($i = 0;$i<count($toots); $i++) {
                     $user = $database->query("
                        SELECT *
                        FROM `user`
                        WHERE id = ".$toots[$i]['user_id']. "
                    ")->fetch(PDO::FETCH_ASSOC);
                    ?>
                  <li>
                    <?php if ($user['icon_url']){ ?>
                      <img width="50" src="/uploaded_image/user_image/<?php echo $user['icon_url'];?>" >
                    <?php } else{ ?>
                      <img width="50" src="https://files.slack.com/files-tmb/T02541Q7U-F55EULAEB-5f5a012488/image_uploaded_from_ios_1024.jpg" >
                    <?php }?>
                    <div>
                      <div class="user-container">
                        <div class="user-name"><?php echo $user['display_name'] ?></div>
                        <div class="user-id">@<?php echo $user['login_name'] ?></div>
                      </div>
                      <p> <?php echo $toots[$i]['text']; ?></p>
                      <?php if ($toots[$i]['image_file_name']){ ?>
                        <img class="tootsimage" src="/uploaded_image/<?php echo $toots[$i]['image_file_name'];?>" >
                      <?php } ?>
                    </div>
                  </li>
                <?php
                }
                ?>
                </ul>
            </div>

            <div class="container about-container">
                <div class="label icon-asterisk"><img class="label-icon" src="/img/asterisk.png" width="15" alt="Start - ">スタート</div>
                <div class="contents">
                    <p>
                        Yastodonとは研修のために作られた教育用ソーシャル・ネットワーキング・サービスです。<br>
                        あなただけの素敵なサービスをここから成長させていってください。
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
