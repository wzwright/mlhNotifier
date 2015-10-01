<?php
require('../phpQuery.php');
require('./login.php');

checkUpdates('f2015');
// change email schema to include subs
$emails=[];
$result = mysqli_query($con, "SELECT email, subs, verified FROM $page");
while($row = mysqli_fetch_array($result))
{
	if(intval($row['verified'])!=0)
		$emails[$result['email']]=explode("|",$result['subs']);	
}

function checkUpdates($page)
{
	try{
		$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, "https://mlh.io/seasons/$page/events");
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
	$events=[];
	$eventsInDb=[];
	$result = mysqli_query($con, "SELECT name, link FROM $page");
	while($row = mysqli_fetch_array($result))
		$eventsInDb[$row['name']]=$row['link'];

	$emailString="";
	foreach(pq('.event-wrapper') as $div)
	{
		$name=pq($div)['h3']->text();
		$link=pq($div)['a']->attr('href');
		$events[$title]=$link;
		if(!array_key_exists($title, $eventsInDb)or$eventsInDb[$title]!=$link)
		{
			mysqli_query($con, "INSERT into $page (name, link) VALUES ('$name', '$link')");
			$emailString.="<a href='$link'>$title</a> ".pq($div)['p']->text()."<br>";
		}
	}

	if(strlen($emailString)>0)
	{
		foreach($emails as $email=>$subs)
		if(in_array($page,$subs))
		{
			$unsubString.="<a href='wzwright.com/mlhNotifier/unsubscribe.php?e=$email'>unsubscribe</a>";
			$headers="From: admin@wzwright.com\r\n";
			$headers.="Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail($email, "New MLH event", $emailString.$unsubString, $headers); //add unsub link
		}
		sleep(1); //try to reduce blocking
	}
}
?>