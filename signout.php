<?php
session_start();
session_destroy();
header("Location: login.php");
//echo "<script type='text/javascript'>\n";
	//	echo "window.location.href = 'login.php';\n";
		//echo "</script>";
?>