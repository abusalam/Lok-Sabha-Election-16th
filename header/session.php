<?php
if(!isset($_SESSION))
{
	session_start();
}
    $now = time(); // checking the time now when home page starts
	if(isset($_SESSION['expire']))
	{
		if($now > $_SESSION['expire'])
		{
			session_destroy();
			echo "<body>\n";
			echo "Your session has expired ! <a href='login.php?redirect=$_SERVER[REQUEST_URI]'>Login Here</a>\n";
			echo "</body>\n";
			echo "</html>";
			exit;
		}
		else
			$_SESSION['expire'] = $now + (30 * 60) ;
	}
	else
		$_SESSION['expire'] = $now + (30 * 60) ;
?>