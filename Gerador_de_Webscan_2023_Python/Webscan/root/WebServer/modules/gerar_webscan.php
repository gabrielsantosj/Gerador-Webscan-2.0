<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	set_time_limit(1800);
	$url_old_name = explode("/", $_SERVER['REQUEST_URI']);
	$old_name = $url_old_name[1];
	$filename = $_POST['project_name'];
	echo "<p>Renomeando diretórios...</p>";
	@rename("../pointclouds/Nuvem", "../pointclouds/".$filename."");
	@rename("Module", "".$filename."");
	$verify_modules = (count(glob("".$filename."/*", GLOB_ONLYDIR)) === 0) ? 'Empty' : 'Not empty';
	if($verify_modules == "Empty"){ echo "<p class='response'>Cenas não encontradas... <p>Operação cancelada por erro!</p>";return false; }else{ echo "<p>Cenas encontradas! Limpando e processando cenas 360º...</p>";}
	$verify_pointclouds = (count(glob("../pointclouds/".$filename."/*", GLOB_ONLYDIR)) === 0) ? 'Empty' : 'Not empty';
	if($verify_pointclouds == "Empty"){ echo "<p class='response'>[ERRO] Nuvem de Pontos não encontrada... <p>Operação cancelada por erro!</p>";return false; }else{ echo "<p>Nuvem de pontos encontrada...</p>";}
	$path = "./";
	foreach (glob ("*", GLOB_ONLYDIR) as $modulos) {
		$scenes = glob ("$modulos/*", GLOB_ONLYDIR);
		$number_of_scenes = count($scenes);
		foreach($scenes as $cenas) {
			if(is_dir($cenas)){
				@array_map('unlink', glob("$cenas/Images/*"));
				@rmdir("$cenas/Images");
				@rename("$cenas/CubeMapMeta.xml", "$cenas/ScanWorlds.txt");
				@array_map('unlink', glob("$cenas/*.bmp"));
				@array_map('unlink', glob("$cenas/*.ini"));
				@array_map('unlink', glob("$cenas/*.DAT"));
				@array_map('unlink', glob("$cenas/*.xslt"));
				@array_map('unlink', glob("$cenas/*.xml"));
				@array_map('unlink', glob("$cenas/*.css"));
				@array_map('unlink', glob("$cenas/*.js"));
				@array_map('unlink', glob("$cenas/*.PNG"));
				@unlink("$cenas/Img_0_64.JPG");@unlink("$cenas/Img_1_64.JPG");@unlink("$cenas/Img_2_64.JPG");@unlink("$cenas/Img_3_64.JPG");@unlink("$cenas/Img_4_64.JPG");@unlink("$cenas/Img_5_64.JPG");
				@unlink("$cenas/Img_0_128.JPG");@unlink("$cenas/Img_1_128.JPG");@unlink("$cenas/Img_2_128.JPG");@unlink("$cenas/Img_3_128.JPG");@unlink("$cenas/Img_4_128.JPG");@unlink("$cenas/Img_5_128.JPG");
				@unlink("$cenas/Img_0_256.JPG");@unlink("$cenas/Img_1_256.JPG");@unlink("$cenas/Img_2_256.JPG");@unlink("$cenas/Img_3_256.JPG");@unlink("$cenas/Img_4_256.JPG");@unlink("$cenas/Img_5_256.JPG");
				@unlink("$cenas/Img_0_512.JPG");@unlink("$cenas/Img_1_512.JPG");@unlink("$cenas/Img_2_512.JPG");@unlink("$cenas/Img_3_512.JPG");@unlink("$cenas/Img_4_512.JPG");@unlink("$cenas/Img_5_512.JPG");
				@unlink("$cenas/Rgb_0_1024.JPG");@unlink("$cenas/Rgb_1_1024.JPG");@unlink("$cenas/Rgb_2_1024.JPG");@unlink("$cenas/Rgb_3_1024.JPG");@unlink("$cenas/Rgb_4_1024.JPG");@unlink("$cenas/Rgb_5_1024.JPG");
				@array_map('unlink', glob("$modulos/*.htm"));
				@array_map('unlink', glob("$modulos/*.html"));
				@array_map('unlink', glob("$modulos/*.png"));
				@array_map('unlink', glob("$modulos/*.xml"));
				copy("gerar_scandata.php", "$cenas/gerar_scandata.php");
				copy("index-nuvem.php", "../index2.php");
                copy("index-plugin.html", "$cenas/index.php");
				include "$cenas/gerar_scandata.php";
			}
		}
	}
	echo "<p>".$number_of_scenes." cenas processadas...<br><p class='response'>Conversão completa!</p></p>";
	echo "<p>Tudo pronto, redirecionando...</p>";
	echo "<script> setTimeout(function(){ window.location.href ='/'; }, 2000); </script>";
?>