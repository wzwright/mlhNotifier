<html>
<head>
	<title>MLH Notifier</title>
</head>
<script>
 document.getElementById("subscribe").onclick = function () {
 	var email=document.getElementById("email").value;
 	var select=document.getElementById("sub");
 	var sub=select.options[select.selectedIndex].value;
    location.href = "www.wzwright.com/mlhNotifier/subscribe.php?email="+email+"&sub="+sub;
    };
</script>
<body style="margin-left:20px;margin-top:20px;">
	<h3>MLH Notifier</h3>
	<p>Checks daily for new hackathons posted on MLH</p>
	<input id="email" placeholder="email"></input>
	<select id="sub" style="margin-left:5px;">
		<option value="f2015">Fall 2015</option>
		<option value="f2015-eu">Fall 2015 eu</option>
	</select>
	<button id="subscribe" style="margin-left:5px;">Subscribe</button>
</body>
</html>