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

$invoices = new \Parasut\API\Invoices($parasutAuthorization);

//invoice list
$invoiceList = $invoices->list_invoices();
//invoice list

//show invoice
$invoice_id = 123456; //integer
$showInvoice = $invoices->show($invoice_id); //active_e_document,contact parametreleri ile beraber gelir
//show invoice

//search invoice
$searchInvoiceData1 = [
	"invoice_id" => "XXXX"
];

$searchInvoiceData2 = [
	"invoice_id" => "XXXX",
	"contact_id" => "XXXX"
];

$searchInvoiceData3 = [
	"issue_date" => "XXXX",
	"due_date" => "XXXX",
	"contact_id" => "XXXX",
	"invoice_id" => "XXXX",
	"invoice_series" => "XXXX",
	"item_type" => "invoice",
	"print_status" => "printed", //printed, not_printed, invoices_not_sent, e_invoice_sent, e_archive_sent, e_smm_sent
	"payment_status" => "paid" //overdue, not_due, unscheduled, paid
];
$searchInvoice1 = $invoices->search($searchInvoiceData1);
$searchInvoice2 = $invoices->search($searchInvoiceData2);
$searchInvoice3 = $invoices->search($searchInvoiceData3);
//search invoice

//create invoice
$createInvoiceData = [
	"data" => [
		"type" => "sales_invoices",
		"attributes" => [
			"item_type" => "invoice",
			"description" => "XXXX XXXX XXXX", //fatura açıklaması
			"issue_date" => "YYYY-MM-DD", //düzenleme tarihi
			"due_date" => "YYYY-MM-DD", //son tahsilat tarihi
			"invoice_series" => "XXX", //fatura seri no
			"invoice_id" => "XXX", //fatura sıra no
			"currency" => "TRL", //döviz tipi // TRL, USD, EUR, GBP
			"shipment_included" => false, //irsaliye
		],
		"relationships" => [
			"details" => [
				"data" => [
					0 => [
						"type" => "sales_invoice_details",
						"attributes" => [
							"quantity" => 1, //birim adedi
							"unit_price" => 100, //birim fiyatı (kdv'siz fiyatı)
							"vat_rate" => 18, //kdv oranı
							"description" => "XXXXX" //ürün açıklaması
						],
						"relationships" => [
							"product" => [
								"data" => [
									"id" => 123456, //ürün id
									"type" => "products"
								]
							]
						]
					],
//					1 => [
//						"type" => "sales_invoice_details",
//						"attributes" => [
//							"quantity" => 1, //birim adedi
//							"unit_price" => 100, //birim fiyatı (kdv'siz fiyatı)
//							"vat_rate" => 18, //kdv oranı
//							"description" => "XXXXX" //ürün açıklaması
//						],
//						"relationships" => [
//							"product" => [
//								"data" => [
//									"id" => 123456, //ürün id
//									"type" => "products"
//								]
//							]
//						]
//					]
				]
			],
			"contact" => [
				"data" => [
					"type" => "contacts",
					"id" => 123456 //müşteri id
				]
			]
		]
	]
];
$createInvoice = $invoices->create($createInvoiceData);
//create invoice

//edit invoice
$editInvoiceData = [
	"data" => [
		"type" => "sales_invoices",
		"attributes" => [
			"item_type" => "invoice",
			"description" => "XXXX XXXX XXXX", //fatura açıklaması
			"issue_date" => "YYYY-MM-DD", //düzenleme tarihi
			"due_date" => "YYYY-MM-DD", //son tahsilat tarihi
			"invoice_series" => "XXX", //fatura seri no
			"invoice_id" => "XXX", //fatura sıra no
			"currency" => "TRL", //döviz tipi // TRL, USD, EUR, GBP
			"shipment_included" => false, //irsaliye
		],
		"relationships" => [
			"details" => [
				"data" => [
					0 => [
						"type" => "sales_invoice_details",
						"attributes" => [
							"quantity" => 1, //birim adedi
							"unit_price" => 100, //birim fiyatı (kdv'siz fiyatı)
							"vat_rate" => 18, //kdv oranı
							"description" => "XXXXX" //ürün açıklaması
						],
						"relationships" => [
							"product" => [
								"data" => [
									"id" => 123456, //ürün id
									"type" => "products"
								]
							]
						]
					],
//					1 => [
//						"type" => "sales_invoice_details",
//						"attributes" => [
//							"quantity" => 1, //birim adedi
//							"unit_price" => 100, //birim fiyatı (kdv'siz fiyatı)
//							"vat_rate" => 18, //kdv oranı
//							"description" => "XXXXX" //ürün açıklaması
//						],
//						"relationships" => [
//							"product" => [
//								"data" => [
//									"id" => 123456, //ürün id
//									"type" => "products"
//								]
//							]
//						]
//					]
				]
			],
			"contact" => [
				"data" => [
					"type" => "contacts",
					"id" => 123456 //müşteri id
				]
			]
		]
	]
];

$invoice_id = 123456;
$editInvoice = $invoices->edit($invoice_id, $editInvoiceData);
//edit invoice

//delete invoice
$invoice_id = 123456;
$deleteInvoice = $invoices->delete($invoice_id);
//delete invoice

//cancel invoice
$invoice_id = 123456;
$cancelInvoice = $invoices->cancel($invoice_id);
//cancel invoice

//pay invoice
$invoice_id = 123456;
$payInvoiceData = [
	"data" => [
		"type" => "payments",
		"attributes" => [
			"account_id" => 1234, // Kasa veya Banka id
			"date" => "YYYY-MM-DD", //ödeme tarihi
			"amount" => 123 //ödeme tutarı
		]
	]
];
$invoices->pay($invoice_id, $payInvoiceData);
//pay invoice

//check vkn type (vkn'nin e-fatura sistemine kayıtlı olup olmadığını sorgular)
$vkn = 12345678912;
$checkVKNType = $invoices->check_vkn_type($vkn);
//check vkn type

//create e archive (vkn e-fatura sistemine kayıtlı ise e-arşiv olarak kesilir)
$eArchiveData = [
	"data" => [
		"type" => "e_archives",
		"relationships" => [
			"sales_invoice" => [
				"data" => [
					"id" => 123456, //invoice_id
					"type" => "sales_invoices"
				]
			]
		]
	]
];
$createEArchive = $invoices->create_e_archive($eArchiveData);
//create e archive

//show e archive
$e_archive_id = 123456; //invoice_id değildir.
$showEArchive = $invoices->show_e_archive($e_archive_id);
//show e archive

//pdf e archive (resmileşen faturayı PDF olarak görüntüleme)
$e_archive_id = 123456; //invoice_id değildir.
$pdfEArchive = $invoices->pdf_e_archive($e_archive_id);
//pdf e archive

//create e invoice (vkn e-fatura sistemine kayıtlı değil ise e-fatura olarak kesilir)
$vkn = 12345678912;
$checkVKNType = $invoices->check_vkn_type($vkn);
$eInvoiceAddress = $checkVKNType->result->data[0]->attributes->e_invoice_address;

$eInvoiceData = [
	"data" => [
		"type" => "e_invoices",
		"attributes" => [
			'scenario' => 'basic', // basic veya commercial (temel veya ticari)
			'to' => $eInvoiceAddress
		],
		"relationships" => [
			"invoice" => [
				"data" => [
					"id" => 123456, //invoice_id
					"type" => "sales_invoices"
				]
			]
		]
	]
];
$createEInvoice = $invoices->create_e_invoice($eInvoiceData);
//create e invoice

//show e invoice
$e_invoice_id = 123456; //invoice_id değildir.
$showEArchive = $invoices->show_e_invoice($e_invoice_id);
//show e invoice

//pdf e invoice (resmileşen faturayı PDF olarak görüntüleme)
$e_invoice_id = 123456; //invoice_id değildir.
$pdfEArchive = $invoices->pdf_e_invoice($e_invoice_id);
//pdf e invoice

//upload PDF from URL
$pdfURL = "PDF_URL";
$uploadPath = "data/xxxxx.pdf";
$uploadPDF = $invoices->upload_pdf($pdfURL, $uploadPath);  //bool : true or false
//upload PDF from URL

//check trackable jobs (resmileşen faturayı sorgular)
$trackable_id = "xxxxxxxxxxxx";
$checkTrackableJobs = $invoices->trackable_jobs($trackable_id);
//check trackable jobs
