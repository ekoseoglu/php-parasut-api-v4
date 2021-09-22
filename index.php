<?php
require_once "src/Exception.php";
require_once "src/Request.php";
require_once "src/Authorization.php";
require_once "src/Contacts.php";
require_once "src/Accounts.php";
require_once "src/Products.php";
require_once "src/Invoices.php";


try {
	$parasutAuthorization = new \Parasut\API\Authorization([
		"development" => false, //development mode
		"client_id" => "a6c74cc876fe40f3c1a3873a2d39b947d082b0811f465fd3b589cfb917d4deb2",
		"client_secret" => "f7a5670f46978ba7722abe9144d644e0c06d059527449091874eb17b4d789c4c",
		"username" => "admin@payreks.com",
		"password" => "05372007042esaT?",
		"redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
		"company_id" => "275851"
	]);
} catch (\Parasut\API\Exception $e) {
	echo "Error code : " . $e->getCode()."<br>";
	echo "Error message : " . $e->getMessage();
	die;
}


//$contacts = new \Parasut\API\Contacts($parasutAuthorization);
////contact list
//$contactList = $contacts->count_contacts();
////contact list
//var_dump($contactList);
//
//die;

$invoices = new \Parasut\API\Invoices($parasutAuthorization);

$show = $invoices->list_e_invoices();
foreach ($show->result->data as $invoice)
{
	var_dump($invoice);
//	if ($invoice->attributes->direction == "inbound")
//	{
//		var_dump($invoices->pdf_e_invoice($invoice->id)->result->data->attributes->url);
//	}
}
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
