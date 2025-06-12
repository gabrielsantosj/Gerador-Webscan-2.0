<?php
	echo "<iframe src='modules/".$_POST['project_name']."/SiteMap.htm'></iframe>";
	echo "<p class='response'>Cenas atualizadas com sucesso! Redirecionando...</p>";
	echo "<script> setTimeout(function(){ window.location.href='/'; }, 2000); </script>";
?>