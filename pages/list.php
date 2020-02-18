<?php
require_once("../db/database.php");
$address = -1;
if (isset($_GET["address"])) {
    $address =$_GET["address"];
}
//database connect
$pdo = connectDatabase();
// sql set
$sql = "select * from hotels where pref like ? or city like ? or address like ?";
//sql run
$pstmt = $pdo->prepare($sql);
$pstmt->bindValue(1,"%".$address."%");
$pstmt->bindValue(2,"%".$address."%");
$pstmt->bindValue(3,"%".$address."%");
$pstmt->execute();
//結果
$rs = $pstmt->fetchAll();
disconnectDatabase($pdo);
//list
require_once("../db/classes.php");
$hotels = [];
foreach ($rs as $record){
    $id = intval($record["id"]);
    $name = $record["name"];
    $price = intval($record["price"]);
    $pref = $record["pref"];
    $city = $record["city"];
    $address = $record["address"];
    $memo = $record["memo"];
    $image = $record["image"];
    $hotel = new Hotel($id,$name,$price,$pref,$city,$address,$memo,$image);
    $hotels[] = $hotel;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ホテル検索結果一覧</title>
<link rel="stylesheet" href="../assets/css/style.css" />
<link rel="stylesheet" href="../assets/css/hotels.css" />
</head>
<body>
<header>
<h1>ホテル検索結果一覧</h1>
<p><a href="./entry.php">検索ページに戻る</a></p>
</header>
<main>
<article>
<table>
   <?php foreach ($hotels as $ht) { ?>
<tr>
<td>
<img src="../images/<?= $ht->getImage() ?>" width="100" />
</td>
<td>
<table class="detail">
<tr>
<td><?= $ht->getName() ?><br /></td>
</tr>
<tr>
<td><?= $ht->getPref() ?><?= $ht->getCity() ?><?= $ht->getAddress() ?></td>
</tr>
<tr>
<td>宿泊料：&yen;<?= $ht->getPrice() ?></td>
</tr>
<tr>
<td></td>
</tr>
</table>
</td>
</tr>
<?php } ?>
</table>
</article>
</main>
<footer>
<div id="copyright">(C) 2019 The Web System Development Course</div>
</footer>
</body>
</html>