<?php

function scorecoin_config() {
    $configarray = array(
     "FriendlyName" => array("Type" => "System", "Value"=>"scorecoin"),
     "username" => array("FriendlyName" => "RPC Username", "Type" => "text", "Size" => "20", ),
     "password" => array("FriendlyName" => "RPC Password", "Type" => "text", "Size" => "20", ),
     "host" => array("FriendlyName" => "RPC Hostname", "Type" => "text", "Size" => "20", ),
     "port" => array("FriendlyName" => "RPC Port", "Type" => "text", "Size" => "20", ),
     //"transmethod" => array("FriendlyName" => "Transaction Method", "Type" => "dropdown", "Options" => "Option1,Value2,Method3", ),
     //"instructions" => array("FriendlyName" => "Payment Instructions", "Type" => "textarea", "Rows" => "5", "Description" => "Do this then do that etc...", ),
     //"testmode" => array("FriendlyName" => "Test Mode", "Type" => "yesno", "Description" => "Tick this to test", ),
    );
	return $configarray;
}

function scorecoin_link($params) {

    # Gateway Specific Variables
	$u = $params['username'];
	$p = $params['password'];
	$h = $params['host'].':'.$params['port'];
	$rpc = 'http://'.$u.':'.$p.'@'.$h;

    # Invoice Variables
	$invoiceid = $params['invoiceid'];
	$amount = $params['amount']; # Format: ##.##
    $currency = $params['currency']; # Currency Code

    # Client Variables
	$firstname = $params['clientdetails']['firstname'];
	$lastname = $params['clientdetails']['lastname'];
	$email = $params['clientdetails']['email'];
	$address1 = $params['clientdetails']['address1'];
	$address2 = $params['clientdetails']['address2'];
	$city = $params['clientdetails']['city'];
	$state = $params['clientdetails']['state'];
	$postcode = $params['clientdetails']['postcode'];
	$country = $params['clientdetails']['country'];
	$phone = $params['clientdetails']['phonenumber'];

	# Build scorecoin Information Here
	require_once 'scorecoin/jsonRPCClient.php';
	$scorecoin = new jsonRPCClient($rpc); 
	if(!$scorecoin->getinfo()){
		die('could not connect to scored');
	}
	$address = $scorecoin->getaccountaddress($params['clientdetails']['userid'].'-'.$invoiceid);
	
	# Enter your code submit to the gateway...
	$code = 'Send Payments to: '.$address.'';

	return $code;

}

function scorecoin_refund($params) {

    # Gateway Specific Variables
	$gatewayusername = $params['username'];
	$gatewaytestmode = $params['testmode'];

    # Invoice Variables
	$transid = $params['transid']; # Transaction ID of Original Payment
	$amount = $params['amount']; # Format: ##.##
    $currency = $params['currency']; # Currency Code

    # Client Variables
	$firstname = $params['clientdetails']['firstname'];
	$lastname = $params['clientdetails']['lastname'];
	$email = $params['clientdetails']['email'];
	$address1 = $params['clientdetails']['address1'];
	$address2 = $params['clientdetails']['address2'];
	$city = $params['clientdetails']['city'];
	$state = $params['clientdetails']['state'];
	$postcode = $params['clientdetails']['postcode'];
	$country = $params['clientdetails']['country'];
	$phone = $params['clientdetails']['phonenumber'];

	# Card Details
	$cardtype = $params['cardtype'];
	$cardnumber = $params['cardnum'];
	$cardexpiry = $params['cardexp']; # Format: MMYY
	$cardstart = $params['cardstart']; # Format: MMYY
	$cardissuenum = $params['cardissuenum'];

	# Perform Refund Here & Generate $results Array, eg:
	$results = array();
	$results["status"] = "success";
    $results["transid"] = "12345";

	# Return Results
	if ($results["status"]=="success") {
		return array("status"=>"success","transid"=>$results["transid"],"rawdata"=>$results);
	} elseif ($gatewayresult=="declined") {
        return array("status"=>"declined","rawdata"=>$results);
    } else {
		return array("status"=>"error","rawdata"=>$results);
	}

}

?>