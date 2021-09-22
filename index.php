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
		"client_id" => "X",
		"client_secret" => "X",
		"username" => "X",
		"password" => "X",
		"redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
		"company_id" => "XX"
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
