<?php

/**
 * CONFIGURATION
 *
 * Configure these options with your basecamp details
 */

// Replace with your basecamp user id that you can see in your basecamp url's https://basecamp.com/1234567 when visiting basecamp in the browser
$basecampUserId = '2979808';

// Username and Password of a basecamp user you wish to connect with
include "/afs/umbc.edu/public/web/sites/sga/dev/cgi-bin/bc_cred.php";

/**
 * SAMPLE GET SCRIPT THAT USES PHP CURL
 *
 * No need to change anything beyond this line...
 *
 * @link https://github.com/37signals/bcx-api
 */

$url = $_GET['url'];

if (empty($url)) {
    $url = 'projects.json';
}

$apiUrl = 'https://basecamp.com/' . $basecampUserId . '/api/v1/' . $url;

// jSON String for request
$json_string = '';

// Initializing curl
$ch = curl_init($apiUrl);

// Configuring curl options
$options = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD        => $credentials, // authentication; from included file bc_cred.php
    CURLOPT_HTTPHEADER     => array('Content-type: application/json'),
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

curl_close($ch);