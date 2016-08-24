<?php
require('phpQuery.php');

$emails=["winstonwright88@gmail.com"];

try{
	$curl = curl_init();
	curl_setopt ($curl, CURLOPT_URL, "https://www.reddit.com/r/PaxPassExchange/new/");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$markup = curl_exec ($curl);
	curl_close ($curl);
}
catch (Exception $e)
{
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}

$doc=phpQuery::newDocumentHtml($markup);
phpQuery::selectDocument($doc);

$wrapper=pq('#siteTable');
$timeString=pq($wrapper)['div:first']['div:first + div']['.tagline:first']['time:first']->attr('datetime');
$diff=time()-strtotime($timeString);

if($diff<300){
	$message="<a href='reddit.com/r/PaxPassExchange/new'>New pax pass post</a>";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	foreach($emails as $email)
		mail($email, 'Pax Pass Exchange', $message, $headers);
	echo 'email sent';
}
?>