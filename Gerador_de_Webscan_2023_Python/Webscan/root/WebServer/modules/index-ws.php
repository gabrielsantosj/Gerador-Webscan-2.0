<!DOCTYPE html>
<html>
<head>
	<title>BRTech3D - Gerador de Webscan3D</title>
	<style type="text/css">
		*{margin:0;padding:0;font-family: 'Open Sans', sans-serif;}
		#main-menu{position:relative;width:80%;height:100px;left:0;right:0;margin:auto;background:#fff;margin-top:10px;margin-bottom:20px;}
		#main-menu .logo{position:absolute;width:300px;height:80px;top:0;bottom:0;left:0;right:0;margin:auto;}

		#content{position:absolute;width:80%;left:0;right:0;margin:auto;}
		button{font-weight:400;background:transparent;border:1px solid #c6c6c6;padding:10px;margin-top:20px;color:#fff;background:#27413a;margin-right:10px;}
		button:hover{cursor:pointer;}

		#console{margin-top:20px;}
		#console p{height:30px;line-height:30px;}

		iframe{display: none;}
	</style>
</head>
<body>
	<input type="hidden" id="project_name" value="<?php echo basename(__DIR__); ?>">
	<nav id="main-menu"><img src="img/lg_18_hor_cl.png" class="logo"></nav>
	<div id="content">
		<h2>Olá, o que você deseja fazer?</h2>
		<button id="gerar_webscan" class="action">Gerar Webscan3D</button>
		<?php
			$dh = opendir("./"); while (false !== ($filename = readdir($dh))){$files[] = $filename;if($filename != "." && $filename != ".."){if(!strstr($filename, '.php', false)){if(!is_dir($filename)){echo "<button id='atualizar_cenas' disabled class='action'>Atualizar Cenas</button>";}}}}
		?>
		<div id="console"></div>
	</div>
	<?php
		
	?>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;800&display=swap" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("button").click(function(){
				$(this).hide();$("#console").append("<p>Iniciando processo de criação do Webscan3D...</p>");
				var action = $(this).attr('id');var project_name = $("#project_name").val();
				$.post("modules/"+action+".php",{ project_name : project_name }, function(get_console_response){
					$("#console").append(get_console_response);$("button").show();$("#"+action+"").hide(); var response = $(".response").text(); $("h2").text(response);
				});
			});
		});
	</script>
</body>
</html>