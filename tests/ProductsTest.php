<?php
try {
	$parasutAuthorization = new \Parasut\API\Authorization([
		"development" => true, //development mode
		"client_id" => "YOUR_CLIENT_ID",
		"client_secret" => "YOUR_CLIENT_SECRET",
		"username" => "YOUR_EMAIL",
		"password" => "YOUR_PASSWORD",
		"redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
		"company_id" => "YOUR_COMPANY_ID"
	]);
} catch (\Parasut\API\Exception $e) {
	echo "Error code : " . $e->getCode()."<br>";
	echo "Error message : " . $e->getMessage();
	die;
}

$products = new \Parasut\API\Products($parasutAuthorization);

//product list
$productList = $products->list_products();
//product list

//show product
$product_id = 123456;
$showProduct = $products->show($product_id);
//show product

//search product
$searchProductData1 = [
	"name" => "XXXX"
];

$searchProductData2 = [
	"name" => "XXXX",
	"code" => "XXXX"
];

$searchProduct1 = $products->search($searchProductData1);
$searchProduct2 = $products->search($searchProductData2);
//search product

//create contact
$productData = [
	"data" => [
		"type" => "products",
		"attributes" => [
			"name" => "XXXX", //ürün adı
			"vat_rate" => 18, //KDV oranı
			"unit" => "Adet", //birim
			"currency" => "TRL", //döviz tipi
			"inventory_tracking" => true, //stok durumu
			"initial_stock_count" => 100 //stok adedi
		]
	]
];

$createProduct = $products->create($productData);
//create contact

//edit contact
$productData = [
	"data" => [
		"type" => "products",
		"attributes" => [
			"name" => "XXXX", //ürün adı
			"vat_rate" => 18, //KDV oranı
			"unit" => "Adet", //birim
			"currency" => "TRL", //döviz tipi
			"inventory_tracking" => true, //stok durumu
			"initial_stock_count" => 100 //stok adedi
		]
	]
];

$product_id = 123456;
$editProduct = $products->edit($product_id, $productData);
//edit contact

//delete contact
$product_id = 123456;
$deleteProduct = $products->delete($product_id);
//delete contact

