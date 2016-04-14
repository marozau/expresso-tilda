<?php
header("Access-Control-Allow-Origin: *");
function rudr_mailchimp_subscriber_status( $email, $status, $list_id, $api_key, $merge_fields = array('FNAME' => '','LNAME' => '') ){
	$data = array(
		'apikey'        => $api_key,
    		'email_address' => $email,
		'status'        => $status,
	);
	$mch_api = curl_init(); // initialize cURL connection
 
	curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
	curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
	curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
	curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
	curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
	curl_setopt($mch_api, CURLOPT_POST, true);
	curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
 
	$result = curl_exec($mch_api);
	return $result;
}

$email = $_POST["email"];
$status = 'pending'; // "subscribed" or "unsubscribed" or "cleaned" or "pending"
$list_id = $_POST["list_id"];
$api_key = '3721ecfffca28821ed48e9e2a8e0bdcd-us9'; // where to get it read above
 
$result = rudr_mailchimp_subscriber_status($email, $status, $list_id, $api_key );
if(!$result) {
  header('Status: 500 Internal Server Error');
  echo 'Где-то закралась ошибка. Попробуй еще раз.';
} else {
  header('Status: 200 OK');
  echo 'Почти готово! Теперь проверь свой почтовый ящик.';
}

if ($_COOKIE['esearch']=='') {
  $esearch = hash('ripemd160', $_POST["email"]);
  setcookie('esearch',$esearch,time() + (86400 * 7));
}
fwrite(STDOUT, $_COOKIE['esearch'])
?>
