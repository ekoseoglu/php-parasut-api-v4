<?php
require_once "src/Exception.php";
require_once "src/Request.php";
require_once "src/Authorization.php";
require_once "src/Contacts.php";
require_once "src/Accounts.php";
require_once "src/Products.php";
require_once "src/Invoices.php";


try {
//	$parasutAuthorization = new \Parasut\API\Authorization([
//		"development" => false, //development mode
//		"client_id" => "a6c74cc876fe40f3c1a3873a2d39b947d082b0811f465fd3b589cfb917d4deb2",
//		"client_secret" => "f7a5670f46978ba7722abe9144d644e0c06d059527449091874eb17b4d789c4c",
//		"username" => "admin@payreks.com",
//		"password" => "05372007042esaT?",
//		"redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
//		"company_id" => "275851"
//	]);

	$parasutAuthorization = new \Parasut\API\Authorization([
		"development" => true, //development mode
		"client_id" => "5sH0vKRSxvx9BNiJj23jiHZliNnDVf5sVkUFkF6UWYk",
		"client_secret" => "EO5RSliBnX_OS7BLCDYEoMyhiCzvBTFGC7OhkFrzEoE",
		"username" => "admin@payreks.com",
		"password" => "05372007042esaT?",
		"redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
		"company_id" => "2287"
	]);
} catch (\Parasut\API\Exception $e) {
	echo "Error code : " . $e->getCode()."<br>";
	echo "Error message : " . $e->getMessage();
	die;
}


$contacts = new \Parasut\API\Contacts($parasutAuthorization);
$products = new \Parasut\API\Products($parasutAuthorization);
$invoices = new \Parasut\API\Invoices($parasutAuthorization);

////Contact List
//$contactList = $contacts->list_contacts();
//var_dump($contactList->result->data);


//Contact Create
//$createContactData = [
//	"data" => [
//		"type" => "contacts",
//		"attributes" => [
//			"name" => "OYT YAZILIM TEKNOLOJILERI A.S", //*required //ad soyad
//			"email" => "iletisim@parasut.com", //e-posta
//			"contact_type" => "person", //company, person (tüzel kişi, gerçek kişi)
//			"tax_office" => "Beşiktaş", //vergi dairesi
//			"tax_number" => "6490512763", //vergi numarası
//			"district" => "Beşiktaş", //ilçe
//			"city" => "İstanbul", //il
//			"address" => "Sırakapılar mahallesi 379 sokak no:13 kat:5", //adres
//			"phone" => "02129630020", //tel no
//			"account_type" => "customer" //customer, supplier
//		]
//	]
//];
//$createContact = $contacts->create($createContactData);
//var_dump($createContact);

//Contact Edit
//$contact_id = 632095; //integer
////$editContactData = [
////	"data" => [
////		"type" => "contacts",
////		"attributes" => [
////			"name" => "Esat Köseoğlu", //*required //ad soyad
////			"email" => "ekoseoglu22@gmail.com", //e-posta
////		]
////	]
////];
////$editContact = $contacts->edit($contact_id, $editContactData);
////var_dump($editContact);

////Contact Delete
//$contact_id = 632095;
//$deleteContact = $contacts->delete($contact_id);
//var_dump($deleteContact);
//-------------------------------------------------//

//$productList = $products->list_products();
//$productCount = $products->count_products();
//var_dump($productList);
//var_dump($productCount);

////Create Product
//$productData = [
//	"data" => [
//		"type" => "products",
//		"attributes" => [
//			"name" => "Komisyon Bedeli", //ürün adı
//			"vat_rate" => 18, //KDV oranı
//			"unit" => "Adet", //birim
//			"currency" => "TRL", //döviz tipi
//			"inventory_tracking" => false, //stok durumu
////			"initial_stock_count" => 100 //stok adedi
//		]
//	]
//];
//$productCreate = $products->create($productData);
//var_dump($productCreate);
//-------------------------------------------------//

////Invoice Create
//$createInvoiceData = [
//	"data" => [
//		"type" => "sales_invoices",
//		"attributes" => [
//			"item_type" => "invoice",
//			"description" => "Komisyon Bedeli", //fatura açıklaması
//			"issue_date" => "2021-09-23", //düzenleme tarihi
//			"due_date" => "2021-09-23", //son tahsilat tarihi
////			"invoice_series" => "XXX", //fatura seri no
////			"invoice_id" => "XXX", //fatura sıra no
//			"currency" => "TRL", //döviz tipi // TRL, USD, EUR, GBP
//			"shipment_included" => false, //irsaliye
//		],
//		"relationships" => [
//			"details" => [
//				"data" => [
//					0 => [
//						"type" => "sales_invoice_details",
//						"attributes" => [
//							"quantity" => 1, //birim adedi
//							"unit_price" => 100, //birim fiyatı (kdv'siz fiyatı)
//							"vat_rate" => 18, //kdv oranı
//							"description" => "Komisyon Bedeli" //ürün açıklaması
//						],
//						"relationships" => [
//							"product" => [
//								"data" => [
//									"id" => 146330, //ürün id
//									"type" => "products"
//								]
//							]
//						]
//					]
//				]
//			],
//			"contact" => [
//				"data" => [
//					"type" => "contacts",
//					"id" => 632104 //müşteri id
//				]
//			]
//		]
//	]
//];
//$createInvoice = $invoices->create($createInvoiceData);
//var_dump($createInvoice);


////Pay Invoice
//$invoice_id = 907203;
//$payInvoiceData = [
//	"data" => [
//		"type" => "payments",
//		"attributes" => [
//			"account_id" => 3207, // Kasa veya Banka id
//			"date" => "2021-09-23", //ödeme tarihi
//			"amount" => 118 //ödeme tutarı
//		]
//	]
//];
//$payInvoice = $invoices->pay($invoice_id, $payInvoiceData);
//var_dump($payInvoice);

////Check VKN
//$vkn = 6490512763;
//$checkVKNType = $invoices->check_vkn_type($vkn);
//var_dump($checkVKNType->result->data[0]->attributes->e_invoice_address);

////Create E-Archive
//$invoice_id = 907199;
//$eArchiveData = [
//	"data" => [
//		"type" => "e_archives",
//		"relationships" => [
//			"sales_invoice" => [
//				"data" => [
//					"id" => $invoice_id, //invoice_id
//					"type" => "sales_invoices"
//				]
//			]
//		]
//	]
//];
//$createEArchive = $invoices->create_e_archive($eArchiveData);
//var_dump($createEArchive);

////Create E-Invoice
//$invoice_id = 907203;
//
//$vkn = 6490512763;
//$checkVKNType = $invoices->check_vkn_type($vkn);
//$eInvoiceAddress = $checkVKNType->result->data[0]->attributes->e_invoice_address;
//
//$eInvoiceData = [
//	"data" => [
//		"type" => "e_invoices",
//		"attributes" => [
//			'scenario' => 'basic', // basic veya commercial
//			'to' => $eInvoiceAddress
//		],
//		"relationships" => [
//			"invoice" => [
//				"data" => [
//					"id" => $invoice_id, //invoice_id
//					"type" => "sales_invoices"
//				]
//			]
//		]
//	]
//];
//$createEInvoice = $invoices->create_e_invoice($eInvoiceData);
//var_dump($createEInvoice);

//Show E-Invoice
$invoice_id = 907203;
$showEInvoice = $invoices->show($invoice_id);
var_dump($showEInvoice->result->data->relationships->active_e_document->data->id);

$pdf = $invoices->pdf_e_invoice(25720);
var_dump($pdf);

die;
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//die;

//
//$contacts = new \Parasut\API\Contacts($parasutAuthorization);
////contact list
//
//$accountSearchData = [
//    "tax_number" => "8670423823"
//];
//$contactList = $contacts->search($accountSearchData);
////contact list
//var_dump($contactList->result->data);
//
//die;

$invoices = new \Parasut\API\Invoices($parasutAuthorization);

//$show = $invoices->show(12259897);
//var_dump($show);
//die;

$show = $invoices->list_e_invoices();
//var_dump($show);
//die;

$count = 0;
foreach ($show->result->data as $invoice)
{
	if ($invoice->attributes->direction == "inbound")
	{
//		$count++;
//		var_dump($invoice->id);
		var_dump($invoices->pdf_e_invoice($invoice->id));
	}
}
//var_dump($count);
die;
var_dump($invoices->pdf_e_invoice($show->data->relationships->active_e_document->data->id));

die;
//invoice list
$invoiceList = $invoices->list_invoices(1,1);

foreach ($invoiceList->data as $sales_invoice)
{
	$show = $invoices->show($sales_invoice->id);
	var_dump($show->relationships);
}
