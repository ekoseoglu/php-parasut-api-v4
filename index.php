<?php
require_once "src/Exception.php";
require_once "src/Request.php";
require_once "src/Authorization.php";
require_once "src/Contacts.php";
require_once "src/Accounts.php";
require_once "src/Products.php";
require_once "src/Invoices.php";


try {

} catch (\Parasut\API\Exception $e) {
	echo "Error code : " . $e->getCode()."<br>";
	echo "Error message : " . $e->getMessage();
	die;
}

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

$show = $invoices->list_e_invoices(1,1);
//var_dump($show);
//die;

$count = 0;
foreach ($show->result->data as $invoice)
{
	if ($invoice->attributes->direction == "inbound")
	{
//		$count++;
		var_dump($invoice->id);
		var_dump($invoices->pdf_e_invoice($invoice->id)->result->data);
//		sleep(1);
	}
}
var_dump($count);
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
