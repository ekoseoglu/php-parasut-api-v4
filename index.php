<?php
require_once "src/Exception.php";
require_once "src/Request.php";
require_once "src/Authorization.php";
require_once "src/Contacts.php";

try {
	$pstAPI = new \Parasut\API\Authorization([
		"development" => false,
		"client_id" => "wREVFaWSMxe96oM0uAg0ADF3r-Izz-16ipHhGyYEUhc", //wREVFaWSMxe96oM0uAg0ADF3r-Izz-16ipHhGyYEUhc
		"client_secret" => "W07XkNq0Ow_F-w3i-o46g2rQ9hxG-noESEbdTMmirGc", //W07XkNq0Ow_F-w3i-o46g2rQ9hxG-noESEbdTMmirGc
		"username" => "ekoseoglu22@gmail.com",
		"password" => "05372007042esaT?",
//		"grant_type" => "password",
		"redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
		"company_id" => 2103
	]);
} catch (\Parasut\API\Exception $e) {
	echo "Error code : " . $e->getCode()."<br>";
	echo "Error message : " . $e->getMessage();
	die;
}


$createCustomerData = [
	"data" => [
		"type" => "contacts",
		"attributes" => [
			"name" => "Halil Ömer Tekin",
			"email" => "info@ilinerteknoloji.com",
			"contact_type" => "person",
			"tax_number" => "38944959832",
			"district" => "Ataşehir",
			"city" => "İstanbul",
			"address" => "Barbaros Mah. Begonya Sk. NidaKule Ataşehir Batı No: 1 İç Kapı No: 2Ataşehir/ İstanbul",
			"phone" => "05345620214",
			"account_type" => "customer"
		]
	]
];

$customer = new \Parasut\API\Contacts($pstAPI);
$createCustomer = $customer->create($createCustomerData);
var_dump($createCustomer);
die;

$editCustomerData = [
	"data" => [
		"type" => "contacts",
		"attributes" => [
			"name" => "Esat Köseoğlu",
			"email" => "ekoseoglu22@gmail.com",
			"contact_type" => "person",
			"tax_number" => "33181156020",
			"district" => "Merkezefendi",
			"city" => "Denizli",
			"address" => "Sırakapılar mahallesi 379 sokak no:13 kat:5",
			"phone" => "05050546692",
			"account_type" => "customer"
		]
	]
];

$contact = new \Parasut\API\Contacts($pstAPI);
$customerShow = $contact->delete(576343);
var_dump($customerShow);
//print_r($customerShow);
die;



