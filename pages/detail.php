<?php
/** リクエストパラメータを取得 */
isset($_GET["id"]) ? $id = $_GET["id"] : $id = "";
//var_dump($id); //作業-1
/** データベース接続情報を設定 */
$dsn = "mysql:host=localhost;dbname=restaurantdb;charset=utf8";
$user = "restaurantdb_admin";
$password = "admin123";
// データベース接続オブジェクトを取得
$pdo = new PDO($dsn, $user, $password);
// 実行するSQLを設定
$sql = "select * from restaurants where id = ?";
// SQL実行オブジェクトを取得
$pstmt = $pdo->prepare($sql);
// プレースホルダにリクエストパラメータを設定
$pstmt->bindValue(1, $id);
// SQLを実行
$pstmt->execute();
// SQL実行結果を配列に取得
$records = $pstmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($records); // 作業-2
$sql = "select * from reviews where id = ?";
// SQL実行オブジェクトを取得
$pstmt = $pdo->prepare($sql);
// プレースホルダにリクエストパラメータを設定
$pstmt->bindValue(1, $id);
// SQLを実行
$pstmt->execute();
// SQL実行結果を配列に取得
$records1 = $pstmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($records1); // 作業-3

function stars($arg1){
    if($arg1 == 5){
    	echo"★★★★★";
    }else if($arg1 == 4){
    	echo"★★★★☆";
    }
    else if($arg1 == 3){
    	echo"★★★☆☆";
    }
    else if($arg1 == 2){
    	echo"★★☆☆☆";
    }else {
    	echo"★☆☆☆☆";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title>レストランレビュサイト - 小テスト</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/detail.css" />
</head>
<body id="detail">
	<div class="p-wrapper">
	<header>
		<h1><a href="list.php">レストラン レビュ サイト</a></h1>
	</header>
	<main>
		<article class="detail">
			<h2>レストラン詳細</h2>
			<section>
				<table class="list">
				    <?php foreach ($records as $record): ?>
					<tr>
						<td class="photo"><img name="image" alt = [<?= $record["name"] ?>] src="../pages/img/<?= $record["image"] ?>" /></td>
						<td class="info">
							<dl>
								<dt name="name"><?= $record["name"] ?></dt>
								<dd name="description">
									<?= $record["description"] ?>
								</dd>
							</dl>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</section>
		</article>
		<article class="reviews">
			<h2>レビュ一覧</h2>
			<?php if (count($records1) > 0): ?>
			<section>
				<dl class="review">
				    <?php foreach ($records1 as $record): ?>
					<dt name="point"><?= stars($record[point]) ?><dt>
					<dd name="description">
					    <?= $record["comment"] ?>
							<div name="posted">
								（<span name="posted_at"> <?= $record["posted_at"] ?></span><span name="reviewer"> <?= $record["reviewer"] ?></span>さん）
							</div>
					</dd>
				</dl>
				<?php endforeach; ?>
			</section>
			<?php endif; ?>
		</article>
		<article class="entry">
			<h2>レビュを書き込む</h2>
			<section>
				<form action="detail.php" method="post">
					<table class="entry">
						<tr>
							<th>お名前</th>
							<td>
								<input type="text" name="name" />
							</td>
						</tr>
						<tr>
							<th>ポイント</th>
							<td>
								<input type="radio" name="point" value="1">1
								<input type="radio" name="point" value="2">2
								<input type="radio" name="point" value="3" checked>3
								<input type="radio" name="point" value="4">4
								<input type="radio" name="point" value="5">5
							</td>
						</tr>
						<tr>
							<th>レビュ</th>
							<td>
								<textarea name="comment"></textarea>
							</td>
						</tr>
					</table>
					<div class="buttons">
						<input type="submit" value="投稿" />
						<input type="reset" value="クリア" />
					</div>
				</form>
			</section>
		</article>
	</main>
	<footer>
		<div class="copyright">&copy; 2020 the applied course of web system development</div>
	</footer>
	</div>
</body>
</html>