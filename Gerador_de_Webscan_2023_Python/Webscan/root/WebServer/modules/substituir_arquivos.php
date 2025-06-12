<?php
	$dir = "./";
	foreach (glob ($dir."*", GLOB_ONLYDIR) as $pastas) {
		if (is_dir ($pastas)) {
			$a = opendir("$pastas");
			while ($m = readdir($a)) {
				if($m == "." || $m == ".."){ }else{
					if(is_dir("$pastas/$m")){
						copy("../modules/index-plugin.html", "$pastas/$m/index.php");
					}
				}
			}
		}
	}
	echo "<p class='response'>Arquivos substituidos com sucesso! Redirecionando...</p>";
	echo "<script> setTimeout(function(){ window.location.href='/'; }, 2000); </script>";
?>