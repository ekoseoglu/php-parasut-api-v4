<?php
require_once "src/Base.php";
require_once "src/Connect.php";
require_once "src/Contacts.php";

try {
	$parasut = new ParasutAPI\Connect([
		"client_id" => "wREVFaWSMxe96oM0uAg0ADF3r-Izz-16ipHhGyYEUhc",
		"client_secret" => "W07XkNq0Ow_F-w3i-o46g2rQ9hxG-noESEbdTMmirGc",
		"username" => "ekoseoglu22@gmail.com",
		"password" => "05372007042esaT?",
		"grant_type" => "password",
		"redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
		"company_id" => "2103"
	]);
} catch (Exception $e) {
}

$customerShowData = [
	"data" => [
		"type" => "contacts",
		"attributes" => [
			"name" => "Esat Köseoğlu",
			"account_type" => "customer"
		]
	]
];

$account = new ParasutAPI\Contacts($parasut);
$customerShow = $account->show("", $customerShowData);
var_dump($customerShow);
die;