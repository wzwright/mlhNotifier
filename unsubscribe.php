<?php
require './login.php';
$email=$_GET['email'];
if(filter_var($email, FILTER_VALIDATE_EMAIL))
{
	mysqli_query($con, "DELETE FROM emails WHERE email='$email'");
	if(mysqli_affected_rows($con)>0)
		echo "Unsubscribed";
	else
		echo "Email was not previously subscribed";
}
else
	echo "invalid email";
?>