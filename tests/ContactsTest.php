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

$contacts = new \Parasut\API\Contacts($parasutAuthorization);

//contact list
$contactList = $contacts->list_contacts();
//contact list

//show contact
$contact_id = 123456; //integer
$showContact = $contacts->show($contact_id);
//show contact

//search contact
$searchContactData1 = [
	"name" => "XXXX"
];

$searchContactData2 = [
	"name" => "XXXX",
	"email" => "XXXX"
];

$searchContactData3 = [
	"name" => "XXXX",
	"email" => "XXXX",
	"tax_number" => "XXXX",
	"tax_office" => "XXXX",
	"city" => "XXXX",
	"account_type" => "customer" //customer, supplier
];
$searchContact1 = $contacts->search($searchContactData1);
$searchContact2 = $contacts->search($searchContactData2);
$searchContact3 = $contacts->search($searchContactData3);
//search contact

//create contact
$createContactData = [
	"data" => [
		"type" => "contacts",
		"attributes" => [
			"name" => "XXXX", //*required //ad soyad
			"email" => "XXXX", //e-posta
			"contact_type" => "person", //company, person (tüzel kişi, gerçek kişi)
			"tax_office" => "XXX", //vergi dairesi
			"tax_number" => "XXX", //vergi numarası
			"district" => "XXX", //ilçe
			"city" => "XXX", //il
			"address" => "XXX", //adres
			"phone" => "0XXXXXXXXXX", //tel no
			"account_type" => "customer" //customer, supplier
		]
	]
];
$createContact = $contacts->create($createContactData);
//create contact

//edit contact
$contact_id = 123456; //integer
$editContactData = [
	"data" => [
		"type" => "contacts",
		"attributes" => [
			"name" => "XXXX", //*required //ad soyad
			"email" => "XXXX", //e-posta
			"contact_type" => "person", //company, person (tüzel kişi, gerçek kişi)
			"tax_office" => "XXX", //vergi dairesi
			"tax_number" => "XXX", //vergi numarası
			"district" => "XXX", //ilçe
			"city" => "XXX", //il
			"address" => "XXX", //adres
			"phone" => "0XXXXXXXXXX", //tel no
			"account_type" => "customer" //customer, supplier
		]
	]
];
$editContact = $contacts->edit($contact_id, $editContactData);
//edit contact

//delete contact
$contact_id = 123456; //integer
$deleteContact = $contacts->delete($contact_id);
//delete contact

