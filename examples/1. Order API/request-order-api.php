<?php
/**
 * Create a new order through Hipay's order API
 * Order API complete specification : https://developer.hipay.com/doc-api/enterprise/gateway/#/payments/requestNewOrder
 *
 * Please note : Using this API requires an HiPay test account with credentials.
 * You need to set those credentials in the examples/credentials.php.sample file, and rename the file to "credentials.php".
 *
 * 2019 HiPay
 *
 * NOTICE OF LICENSE
 *
 * @author    HiPay <support.tpp@hipay.com>
 * @copyright 2019 HiPay
 * @license   https://github.com/hipay/hipay-enterprise-sdk-prestashop/blob/master/LICENSE.md
 */

use HiPay\Fullservice\Gateway\Client\GatewayClient;
use HiPay\Fullservice\Gateway\Request\Info\CustomerShippingInfoRequest;
use HiPay\Fullservice\Gateway\Request\Order\OrderRequest;
use HiPay\Fullservice\HTTP\Configuration\Configuration;
use HiPay\Fullservice\HTTP\SimpleHTTPClient;
use HiPay\Fullservice\Gateway\Request\PaymentMethod\CardTokenPaymentMethod;

require_once __DIR__ . "../credentials.php";

/* First step is to create a configuration object, holding your credentials and some more configuration items
    By default Configuration object is configured in Stage mode (Configuration::API_ENV_STAGE)
    You can configure it in your production application configure it to production by using Configuration::API_ENV_PRODUCTION */
$config = new Configuration(array(
    "apiUsername" => $HIPAY_API_USER_TEST,
    "apiPassword" => $HIPAY_API_PASSWORD_TEST,
    "apiEnv" => Configuration::API_ENDPOINT_STAGE
));

/* You can customize some of the configuration, like the CURL timeouts */
//$config->setCurlTimeout(60); // Sets the global CURL timeout (no CURL call will exceed this time, in seconds)
//$config->setCurlConnectTimeout(60); // Sets the CURL connection timeout (CURL will wait this time to establish the connection to the server)

/* You can also add your proxy information if your server is behind a proxy */
//$config->setProxy(array(
//    'host' => "my.host",
//    'port' => "80",
//    'user' => "myUserName",
//    'password' => "myPassword"
//));

/* Those parameters can also be added to the Configuration on instantiation with the following array keys : [proxy], [timeout], [connect_timeout] */
//$config = new Configuration(array(
//    "apiUsername" => $HIPAY_API_USER_TEST,
//    "apiPassword" => $HIPAY_API_PASSWORD_TEST,
//    "apiEnv" => Configuration::API_ENV_PRODUCTION,
//    "proxy" => array(
//        'host' => "my.host",
//        'port' => "80",
//        'user' => "myUserName",
//        'password' => "myPassword"
//    ),
//    "timeout" => 60,
//    "connect_timeout" => 60
//));

/* Then you need to instantiate your HTTP Client */
$clientProvider = new SimpleHTTPClient($config);

/* And finally, instantiate your Gateway Client, which is the client used for all requests */
$gatewayClient = new GatewayClient($clientProvider);


/* You now need to create your Order Request with all informations related to your payment
    You can find the specification for all these fields here :
    https://developer.hipay.com/doc-api/enterprise/gateway/#/payments/requestNewOrder */
$orderRequest = new OrderRequest();

/* This is the Order Id, generated by your shop */
$orderRequest->orderid = "ORDER #123456";

/* This is the operation type :
    Sale means you want the payment to be processed immediately
    Authorization means you just want to authorize the payment without getting it processed now */
$orderRequest->operation = "Sale";

/* This is the type of payment used for the transaction */
$orderRequest->payment_product = "visa";

/* When using SEPA Direct Debit or Credit / Debit Card Payments
    You must provide an authentication indicator which will indicate if the transaction needs to be authenticated or not */
$orderRequest->authentication_indicator = 0;

/* This is a small description for the order */
$orderRequest->description = "ref_85";

/* These are some customers information, for searching purposes on your BackOffice */
$orderRequest->firstname = "Jane";
$orderRequest->lastname = "Doe";
$orderRequest->email = "jane.doe@unknow.com";
/* The cid is the customer's id in your shop. It is used in our fraud detection system */
$orderRequest->cid = null;
/* You can specify the customer's IP address. It is used in our fraud detection system */
$orderRequest->ipaddr = "172.20.0.1";
/* You can specify the customer's HTTP_ACCEPT header, for formatting purposes */
$orderRequest->http_accept = "*/*";
/* You can specify the customer's HTTP_USER_AGENT header. It is used in our fraud detection system */
$orderRequest->http_user_agent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36";

/* Here are the money related information
    You must specify the transaction's currency and its total amount */
$orderRequest->currency = "EUR";
$orderRequest->amount = "21.60";
/* You can specify the shipping and tax amounts*/
$orderRequest->shipping = "0.00";
$orderRequest->tax = "3.6";

/* These are the URLs to which the system must redirect after your payment processing */
$orderRequest->accept_url = "http:/www.my-shop.fr/checkout/accept";
$orderRequest->decline_url = "http:/www.my-shop.fr/checkout/decline";
$orderRequest->pending_url = "http:/www.my-shop.fr/checkout/pending";
$orderRequest->exception_url = "http:/www.my-shop.fr/checkout/exception";
$orderRequest->cancel_url = "http:/www.my-shop.fr/checkout/cancel";

/* You can specify an URL for HiPay's notifications. this will override the URL provided in your HiPay's BackOffice */
$orderRequest->cancel_url = "http:/www.my-shop.fr/notify";

/* You can specify some custom data which will be displayed in your HiPay's BackOffice transactions details,
    and sent back by the API and in notifications for your usage.
    This data must be sent in JSON format */
$orderRequest->custom_data = '{"shipping_description":"Flat rate","payment_code":"visa","display_iframe":0}';


/* We can now provide the Payment Method information */
$paymentMethod = new CardTokenPaymentMethod();
/* The card token is generated by the HiPay Enterprise Secure Vault API. Please refer to the
    HiPay Enterprise Tokenization API documentation for more details */
$paymentMethod->cardtoken = "61f92d7a135db52dbd583b2aad208e73978196392357f674bacf39f549042f14";
/* The ECI (Electronic Commerce Indicator) is used in SEPA Direct Debit or Credit / Debit Card Payments
    Its value is defined as followed :

    - Credit or debit card
        1: MO/TO (Mail Order/Telephone Order)
        2: MO/TO – Recurring
        7: E-commerce with SSL/TLS Encryption
        9: Recurring E-commerce
        10: TPE payment

    - SEPA Direct Debit
        7: First transaction/one-shot transaction
        9: Recurring transaction

    This value can be defined in your Hipay BackOffice, and will be override if you specify it in the request */
$paymentMethod->eci = 7;
/* When using SEPA Direct Debit or Credit / Debit Card Payments
    You must provide an authentication indicator which will indicate if the transaction needs to be authenticated or not */
$paymentMethod->authentication_indicator = 0;

$orderRequest->paymentMethod = $paymentMethod;


/* We can also add the shipping information to the order */
$customerShippingInfo = new CustomerShippingInfoRequest();
$customerShippingInfo->shipto_firstname = "Jane";
$customerShippingInfo->shipto_lastname = "Doe";
$customerShippingInfo->shipto_streetaddress = "56 avenue de la paix";
$customerShippingInfo->shipto_streetaddress2 = "";
$customerShippingInfo->shipto_city = "Paris";
$customerShippingInfo->shipto_state = "";
$customerShippingInfo->shipto_zipcode = "75000";
$customerShippingInfo->shipto_country = "FR";
$customerShippingInfo->shipto_phone = "0130811322";
$customerShippingInfo->shipto_msisdn = "0600000000";
$customerShippingInfo->shipto_gender = "M";

$orderRequest->customerShippingInfo = $customerShippingInfo;

/* Once everything is in place, we can actually make the transaction */
$transactionResponse = $gatewayClient->requestNewOrder($orderRequest);

/* The payment will return with a transaction ID generated by our system,
    a status code and description, the redirection URL depending on the transaction's status
    and some other details on the transaction */
print_r("Transaction Result:\n");
print_r("- Transaction Reference: " . $transactionResponse->getTransactionReference() . "\n");
print_r("- Transaction state: " . $transactionResponse->getState() . "\n");
print_r("- Transaction status: " . $transactionResponse->getStatus() . "\n");
print_r("- Transaction forward URL: " . $transactionResponse->getForwardUrl() . "\n");
print_r("- Transaction fraud screening: " . $transactionResponse->getFraudScreening() . "\n");
