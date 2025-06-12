<?php
	set_time_limit(60000);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);	
	$las_name = $_FILES['las']['name'];
	if (move_uploaded_file($_FILES['las']['tmp_name'], ''.$las_name.'')) {
		shell_exec('start cmd.exe /c cmd.exe /c CloudConverter.exe '.$las_name.' -o ../WebServer/pointclouds/Nuvem/');
		unlink("".$las_name."");
    	echo "<script>$('.firststep').hide();$('.secondstep').show();</script>";
	}
?>