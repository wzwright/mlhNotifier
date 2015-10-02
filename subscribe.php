<?php
require './login.php';
$email=$_GET['email'];
$sub=$_GET['sub'];
if(filter_var($email, FILTER_VALIDATE_EMAIL)&&strlen($sub)<10)	{
	if(isset($_GET['code']))
	{
		mysqli_query($con,"UPDATE emails SET verified=1 WHERE email='$email' AND sub='$sub' AND code=$code");
		if(mysqli_affected_rows($con)>0)
			echo "$email successfully verified";
		else
			echo "Failed";	
	}
	else
	{
	
		$code = rand(10000,99999);
		mysqli_query($con, "DELETE FROM emails WHERE email='$email' AND sub='$sub'");
		mysqli_query($con, "INSERT INTO emails (email, code, sub) VALUES ('$email',$code,'$sub')");
		if(mysqli_affected_rows($con)>0)
		{
			echo "Subscribed. You will receive an email to activate your subscription.";
			$message="wzwright.com/mlhNotifier/subscribe.php?email=$email&sub=$sub&code=$code";
			$message="<a href='$message'>$message</a>";
			$headers="From: admin@wzwright.com\r\n";
			$headers.="Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail($email, "Verify your subscription to mlhNotifier updates", $message, $headers);
		}
		else
			echo "Failed";
	}
	else
		echo "invalid email or subscription";
}
?>