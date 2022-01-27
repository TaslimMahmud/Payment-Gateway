<?php

$post_data = array();
$post_data['store_id'] = "asttr61f16540f0fd1";
$post_data['store_passwd'] = "asttr61f16540f0fd1@ssl";
$post_data['total_amount'] = "$amount";
$post_data['currency'] = "BDT";
$post_data['tran_id'] = "SSLCZ_TEST_".uniqid();
$post_data['success_url'] = "http://localhost/new_sslcz_gw/success.php";
$post_data['fail_url'] = "http://localhost/new_sslcz_gw/fail.php";
$post_data['cancel_url'] = "http://localhost/new_sslcz_gw/cancel.php";



# CUSTOMER INFORMATION
$post_data['cus_name'] = "$name";
$post_data['cus_email'] = "$email";
$post_data['cus_add1'] = "$address";
$post_data['cus_add2'] = "$address";
$post_data['cus_city'] = "$address";
$post_data['cus_state'] = "$address";
$post_data['cus_postcode'] = "1000";
$post_data['cus_country'] = "Bangladesh";
$post_data['cus_phone'] = "01711111111";
$post_data['cus_fax'] = "01711111111";




# REQUEST SEND TO SSLCOMMERZ
$direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $direct_api_url );
curl_setopt($handle, CURLOPT_TIMEOUT, 30);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($handle, CURLOPT_POST, 1 );
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


$content = curl_exec($handle );

$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if($code == 200 && !( curl_errno($handle))) {
   curl_close( $handle);
   $sslcommerzResponse = $content;
} else {
   curl_close( $handle);
   echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
   exit;
}

# PARSE THE JSON RESPONSE
$sslcz = json_decode($sslcommerzResponse, true );

if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
        # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
        # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
   echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
   # header("Location: ". $sslcz['GatewayPageURL']);
   exit;
} else {
   echo "JSON Data parsing error!";
}