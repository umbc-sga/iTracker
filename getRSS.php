<?php

// Username and Password of a basecamp user you wish to connect with
include "/afs/umbc.edu/public/web/sites/sga/dev/cgi-bin/bc_cred.php";

$id = $_GET['id'];

// Initializing curl
$ch = curl_init();

// Configuring curl options
$options = array(
	CURLOPT_URL            => 'https://basecamp.com/2979808/projects/' . $id . '.atom',
	CURLOPT_USERPWD		   => $credentials,
	CURLOPT_USERAGENT      => 'spider',
	CURLOPT_TIMEOUT        => 120,
	CURLOPT_CONNECTTIMEOUT => 30,
	CURLOPT_RETURNTRANSFER => TRUE,
	CURLOPT_ENCODING       => 'UTF-8',
    CURLOPT_FAILONERROR    => true
);

// Setting curl options
curl_setopt_array($ch, $options);

// Getting results
$data = curl_exec($ch);

// Close open connection
curl_close($ch);

//	Parse resulting XML string
// $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
//die('<pre>' . print_r($xml], TRUE) . '</pre>');

echo $data;

// foreach ($xml->entry as $item) {
// 	echo 'Title: <strong>'.$item->title.'</strong><br/>';
// 	echo 'Author: '.$item->author->name.'<br/>';
// 	echo 'Time: '.$item->published.'<br/>';
// 	echo '<br/>';
// }
?>