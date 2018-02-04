<!DOCTYPE html>
<html lang="ja">
<head>
<title>Amazon APIを使って商品検索するサンプルコード</title>
<meta charset="utf-8">
<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
<body>

<?php

// Amazon APIのアクセスキーとシークレットキーを入力
// define("Access_Key_ID", "YOUR_AWS_ACCESS_KEY_ID");
// define("Secret_Access_Key", "YOUR_AWS_SECRET_ACCESS_KEY");

// アソシエイトIDの入力
define("Associate_tag", "digitlibra-22");

// Amazon APIのアクセスキーとシークレットキー設定するPHPスクリプト
include("aws_setting.php");

//checks ifthe tag post is there and if its been a proper form post
// tagで検索
if(isset($_POST['tag']) && ($_SERVER['CONTENT_TYPE'] == "application/x-www-form-urlencoded")){
	ItemSearch("Books", $_POST['tag']);
}

//Set up the operation in the request
function ItemSearch($SearchIndex, $Keywords){

	// Amazon APIの仕様に沿ったリクエスト出力用のPHPスクリプト
	include("base_request.php");

	$amazon_xml = simplexml_load_string(file_get_contents($base_request));

	foreach($amazon_xml->Items->Item as $item) {

		$item_title = $item->ItemAttributes->Title; // 商品名
		$item_author = $item->ItemAttributes->Author; // 著者
		$item_publicationdate = $item->ItemAttributes->PublicationDate; // 発売日
		$item_price = $item->OfferSummary->LowestNewPrice->FormattedPrice;
		$item_publisher = $item->ItemAttributes->Publisher; // 出版社
		$item_url = $item->DetailPageURL; // 商品のURL
		$item_image	 = $item->LargeImage->URL; // 商品の画像
		$item_isbn	 = $item->ASIN; // ASIN

		$tagValue[] = array($item_title, $item_price, $item_isbn); 

	} // foreach end

        echo json_encode(array("VALUE", $Keywords, $tagValue));
} ?>

</body>
</html>
