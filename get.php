<?php

// Username and Password of a basecamp user you wish to connect with
include "/afs/umbc.edu/public/web/sites/sga/dev/cgi-bin/bc_cred.php";

$url = $_GET['url'];

if (empty($url)) {
    $url = 'projects.json';
}

// jSON String for request
$json_string = '';

// Initializing curl
$ch = curl_init($apiUrl);

// Configuring curl options
$options = array(
    CURLOPT_URL            => 'https://basecamp.com/2979808/api/v1/' . $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD        => $credentials, // authentication; from included file bc_cred.php
    CURLOPT_HTTPHEADER     => array('Content-type: application/json', 'User-Agent: UMBC SGA iTracker (joshua.massey@umbc.edu)'),
    CURLOPT_USERAGENT      => 'Api Client',
    CURLOPT_FAILONERROR    => true
);

// Setting curl options
curl_setopt_array($ch, $options);

// Getting results
$result = curl_exec($ch); // Getting jSON result string

// Set response type
header('Content-type: application/json');

if ($result === false) {

    // Get server protocol
    $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

    // Get status code
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

    header($protocol . ' ' . $code);

    // Get error
    $error = curl_error($ch);
    if (empty($error)) {
        $error = 'Unknown error';
    }

    // Display error
    echo $error;

} else {

    // Display result
    echo $result;
}

// Close open connection
curl_close($ch);