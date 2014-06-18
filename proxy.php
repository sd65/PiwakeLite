<?php

if (!isset($_GET['year'], $_GET['week'], $_GET['filiere']))
	exit();

$year = $_GET['year'];
$week = $_GET['week'];
$filiere = $_GET['filiere'];

// Get PHPSESSID

$url = "http://syrah.iut.u-bordeaux3.fr/gpu/sat/index.php?page_param=accueilsatellys.php&cat=0&numpage=1&niv=0&clef=/";
$postData = "modeconnect=connect&util=sdoignon&acct_pass=123";
$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, $url);  
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POST, "3");
curl_setopt($ch,CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);  
$infoResponse = curl_getinfo($ch);
curl_close($ch);  
$rawHeaders = explode("\n", substr($response, 0, $infoResponse['header_size']));
$PHPSESSID =  substr($rawHeaders[4], 12);

// And now, we MUST ping Sattelys as below... No valid reasons...

$url = "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/index.php";
$ch2 = curl_init();  
curl_setopt($ch2, CURLOPT_URL, $url);  
curl_setopt($ch2, CURLOPT_COOKIE, $PHPSESSID);  
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_exec($ch2);  
curl_close($ch2);  

// And get the calendar

$url = "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/index.php?page_param=fpfilieres.php&cat=0&numpage=1&niv=2&clef=/305/306/";

$postData = array(
    'ansemaine' => $year,
    'semaine' => $week,
    'filiere' => $filiere,
);

$postDataString = "";
foreach($postData as $key=>$value) { $postDataString .= $key.'='.$value.'&'; }
rtrim($postDataString, '&');


$ch3 = curl_init();  
curl_setopt($ch3, CURLOPT_URL, $url);  
curl_setopt($ch3,CURLOPT_POST, count($postData));
curl_setopt($ch3,CURLOPT_POSTFIELDS, $postDataString);
curl_setopt($ch3, CURLOPT_COOKIE, $PHPSESSID);  
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1);
$content = curl_exec($ch3);  
curl_close($ch3); 

// Output the page ! 

echo $content;
