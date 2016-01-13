<?php

require_once('config.php');
require_once('function.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $name = $_POST['name'];
  $title = $_POST['title'];
  $image = $_FILES['image']['name'];
  $created_at = $_POST['created_at'];
  $errors = array();
  if(empty($name))
  {
    $errors['name'] = '投稿者が未入力です!';
  }
  if(empty($title))
  {
    $errors['title'] = '画像タイトルが未入力です!';
  }

  if(empty($image))
  {
    $errors['image'] = '画像ファイルが選択されていません!';
  }
  elseif(!exif_imagetype($_FILES['image']['tmp_name']))
    {
    $errors['image'] = '画像ファイルの形式をjpgかpngにしてください';
    }



  if(empty($errors))
  {
  $dbh = connectDb();
  $sql = "insert into posts (name, title, created_at) values
            (:name, :title, now())";
  $stmt = $dbh->prepare($sql);

  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":title", $title);
  $stmt->execute();
  }

}

$dbh = connectDb();
$sql = "select * from posts";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($row);

$msg = null;



if ($_FILES['image']['name'] && $title)
{
  move_uploaded_file($_FILES['image']['tmp_name'], './album/'.$title);
}


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>画像投稿掲示板</title>
    <link type="text/css" rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>画像投稿掲示板トップ画面</h1>
    <p>投稿者と画像タイトルを入力し、画像ファイルを選択して下さい</p>
    <form action="" method="post" enctype="multipart/form-data">
      投稿者: <input type="text" name="name">
      <?php if ($errors['name']) : ?>
        <div class="example1"><?php echo h($errors['name']) ?></div>
      <?php endif ?>
      <br>
      画像タイトル: <input type="text" name="title">
      <?php if ($errors['title']) : ?>
        <div class="example1"><?php echo h($errors['title']) ?></div>
      <?php endif ?>
      <br>
      画像ファイル: <input type="file" name="image">
      <?php if ($errors['image']) : ?>
        <div class="example1"><?php echo h($errors['image']) ?></div>
      <?php endif ?>
      <br>
      <input type="submit" value="投稿する">
    </form>
    <hr>
    <?php if(count($row)) : ?>
      <?php foreach ($row as $post) : ?>
        <li>
        <?php echo h($post['title']); ?>@<?php echo h($post['name']); ?>
        投稿日時<?php echo h($post['created_at']); ?>
        <br>
        <img src="./album/<?php echo h($post['title']); ?>" width="100" height="100">
        </li>
      <?php endforeach; ?>
    <?php else :?>
      現在、投稿された画像はありません。
    <?php endif; ?>
  </body>
      <footer>
        <p><a href="http://nowall.co.jp">株式会社スパルタ</a></p>
        <small>©2015SPARTA,Inc.All Rights Reserved.</small>
      </footer>
</html>