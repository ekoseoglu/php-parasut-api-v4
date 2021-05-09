<?php
require_once "src/Exception.php";
require_once "src/Request.php";
require_once "src/Authorization.php";
require_once "src/Contacts.php";
require_once "src/Invoices.php";
require_once "src/Products.php";
require_once "src/Accounts.php";

try {
	$pstAPI = new \Parasut\API\Authorization([
		"development" => true,
		"client_id" => "wREVFaWSMxe96oM0uAg0ADF3r-Izz-16ipHhGyYEUhc", //wREVFaWSMxe96oM0uAg0ADF3r-Izz-16ipHhGyYEUhc //a6c74cc876fe40f3c1a3873a2d39b947d082b0811f465fd3b589cfb917d4deb2
		"client_secret" => "W07XkNq0Ow_F-w3i-o46g2rQ9hxG-noESEbdTMmirGc", //W07XkNq0Ow_F-w3i-o46g2rQ9hxG-noESEbdTMmirGc //f7a5670f46978ba7722abe9144d644e0c06d059527449091874eb17b4d789c4c
		"username" => "ekoseoglu22@gmail.com",
		"password" => "05372007042esaT?",
		"redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
		"company_id" => 2103 //2103 //275851
	]);
} catch (\Parasut\API\Exception $e) {
	echo "Error code : " . $e->getCode()."<br>";
	echo "Error message : " . $e->getMessage();
	die;
}

$accounts = new \Parasut\API\Accounts($pstAPI);

//$searchData = [
//	"name" => "Kasa Hesabı"
//];
//var_dump($accounts->search($searchData)->data);

//$createData = [
//	"data" => [
//		"type" => "accounts",
//		"attributes" => [
//			"name" => "Kasa2",
//			"currency" => "TRL",
//			"account_type" => "cash",
//			""
//		]
//	]
//];
//var_dump($accounts->create($createData));

//$showAccount = $accounts->show(2396);
//var_dump($showAccount);

//$editData = [
//		"data" => [
//		"type" => "accounts",
//		"attributes" => [
//			"name" => "Kasa3",
//			"currency" => "TRL",
//			"account_type" => "cash",
//			""
//		]
//	]
//];
//$editAccount = $accounts->edit(2396, $editData);
//var_dump($editData);

//$deleteAccount = $accounts->delete(2396);
//var_dump($deleteAccount);

//$transactions = $accounts->transactions(2384);
//foreach ($transactions->data as $row)
//{
//	var_dump($row);
//}

//$transactionData = [
//	"data" => [
//		"type" => "transactions",
//		"attributes" => [
//			"date" => "2021-05-08",
//			"amount" => "150",
//			"description" => "Birikim"
//		]
//	]
//];
//$createDebitTransaction = $accounts->export_transactions(2384, $transactionData);
//var_dump($createDebitTransaction);

//$showTransaction = $accounts->show_transactions(1008441);
//var_dump($showTransaction);

$deleteTransaction = $accounts->delete_transactions(1008438);
var_dump($deleteTransaction);
die;

//$products = new \Parasut\API\Products($pstAPI);
////$showProduct = $products->show(133269);
////var_dump($showProduct);
////die;
//
//$productData = [
//	"data" => [
//		"type" => "products",
//		"attributes" => [
//			"name" => "Panel Hizmeti2",
//			"vat_rate" => 18,
//			"unit" => "Adet",
//			"currency" => "TRL",
//			"inventory_tracking" => false
//		]
//	]
//];
//$createProduct = $products->delete(131197);
//var_dump($createProduct);
//
//die;
//$searchData = [
//	"name" => "Komisyon Bedeli"
//];
//var_dump($products->search($searchData)->data);
//die;
//foreach ($products->list_products() as $key => $row)
//{
//	var_dump($row);
//}
//
//
//die;

$invoices = new \Parasut\API\Invoices($pstAPI);

var_dump($invoices->cancel(816364));
die;

$payData = [
	"data" => [
		"type" => "payments",
		"attributes" => [
			"account_id" => 2384, // bank account id on Parasut
			"date" => "2021-05-08",
			"amount" => 1892.28
		]
	]
];
$pay = $invoices->pay(840765,$payData);
var_dump($pay);
die;
//$showInvoice = $invoices->show(840756);
//var_dump($showInvoice);
//die;

$invoiceData = [
	"data" => [
		"type" => "sales_invoices",
		"attributes" => [
			"item_type" => "invoice",
			"issue_date" => "2021-05-09",
			"due_date" => "2021-05-08",
			"currency" => "TRL",
			"cash_sale" => false,
			"shipment_included" => false, //İrsaliye
			"payment_status" => "paid",
			"payment_date" => "2021-05-08"
		],
		"relationships" => [
			"details" => [
				"data" => [
					0 => [
						"type" => "sales_invoice_details",
						"attributes" => [
							"quantity" => 1,
							"unit_price" => 1603.63,
							"vat_rate" => 18,
							"description" => "Komisyon Bedeli"
						],
						"relationships" => [
							"product" => [
								"data" => [
									"id" => "131197",
									"type" => "products"
								]
							]
						]
					]
				]
			],
			"contact" => [
				"data" => [
					"type" => "contacts",
					"id" => "576104"
				]
			]
		]
	]
];
$createSalesInvoice = $invoices->create($invoiceData);
echo "<pre>";
print_r($createSalesInvoice);
echo "<pre>";
die;

$invoice = new \Parasut\API\Invoices($pstAPI);
//$checkVKNType = $invoice->check_vkn_type("38944959832");
//var_dump($checkVKNType);

//$createEArchive = $invoices->create_e_archive(840765);

$showInvoice = $invoices->show(840765);
$showEArchive = $invoices->show_e_archive($showInvoice->data->relationships->active_e_document->data->id);
var_dump($showEArchive);
$showEArchivePDF = $invoices->pdf_e_archive(132307);
var_dump($showEArchivePDF);
die;
$searchData = [
	"contact_id" => "555829"
];

$invoice = new \Parasut\API\Invoices($pstAPI);
$checkVKNType = $invoice->check_vkn_type("33181156020");
var_dump($checkVKNType);
die;

$payData = [
	"data" => [
		"type" => "payments",
		"attributes" => [
			"description" => "TEST",
			"date" => "",
			"amount" => "",
			"exchange_rate" => "1.0",
			"currency" => "TRL",
		]
	]
];

$invoiceDetail = $invoice->payments(816355, $payData);
var_dump($invoiceDetail);
die;

$listInvoice = $invoice->list_invoice();

$contacts = new Parasut\API\Contacts($pstAPI);
foreach ($listInvoice->data as $invoiceRow)
{
	$payData = [
		"data" => [
			"type" => "payments"
		]
	];
	$invoiceDetail = $invoice->payments($invoiceRow->id, $payData);

	var_dump($invoiceDetail);
//	$contact = $contacts->show($invoiceDetail->data->relationships->contact->data->id);
//	var_dump($contact->data->attributes->name);
//	var_dump($invoiceDetail->data->relationships->active_e_document->data);
}
//var_dump($listInvoice->data->relationships->active_e_document->data->type);
die;

$searchData = [
	"tax_number" => "33181156020"
];

$customer = new \Parasut\API\Contacts($pstAPI);
$createCustomer = $customer->search($searchData);
var_dump($createCustomer->data);
die;


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



