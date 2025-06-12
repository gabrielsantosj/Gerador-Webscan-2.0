<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);	
	if(isset($_POST)){
		$las_name = $_FILES['cenas']['name'];
		if(move_uploaded_file($_FILES['cenas']['tmp_name'], '../WebServer/modules/Module/'.$las_name.'')) {
			$zip = new ZipArchive;
			if($zip->open("../WebServer/modules/Module/".$las_name."") === TRUE) {
				$zip->extractTo("../WebServer/modules/Module/");
				$zip->close();
				@unlink("../WebServer/modules/Module/".$las_name."");
			}
		}
		echo "<script>$('.secondstep').hide();$('.thirdstep').show();</script>";
	}
?>