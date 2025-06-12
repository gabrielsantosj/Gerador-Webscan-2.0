<!DOCTYPE html>
<html>
<head>
	<title>BRTech3D - Gerador de Webscan3D</title>
	<style type="text/css">
		*{margin:0;padding:0;font-family: 'Open Sans', sans-serif;}h2{width:100%;text-align:center;margin-bottom:30px;}p{height:30px;}
		#main-menu{position:relative;width:80%;height:100px;left:0;right:0;margin:auto;background:#fff;margin-top:10px;margin-bottom:30px;}
		#main-menu .logo{position:absolute;width:300px;height:80px;top:0;bottom:0;left:0;right:0;margin:auto;}

		.webscan_assistent{position:relative;width:100%;margin-left:0;margin-right:0;margin:auto;font-weight:thin;padding:5px;}
		.webscan_assistent p{width:100%;text-align:center;}
		button input[type="file"]{position:absolute;width:calc(100px + 50px);height:37px;margin-top:-10px;margin-left:-22px;filter:alpha(opacity=0);opacity:0;z-index:1;}
		#project_name{width:250px;height:30px;padding-left:5px;margin-top:5px;text-align:center;outline:0;}

		.secondstep,.thirdstep{display:none;}

		#content{position:absolute;width:80%;left:0;right:0;margin:auto;}
		button{font-weight:400;width:150px;background:transparent;border:1px solid #c6c6c6;padding:10px;margin-top:20px;color:#fff;background:#27413a;margin-right:10px;z-index:2;}
		.actions button{display:none;}
		button:hover{cursor:pointer;}

		#console{margin-top:20px;}
		#console p{width:100%;text-align:center;height:30px;line-height:30px;}

		iframe{display: none;}
	</style>
</head>
<body>
	<nav id="main-menu"><img src="img/lg_18_hor_cl.png" class="logo"></nav>
	<div id="content">
		<h2>Bem-vindo ao assistente de criação do Webscan3D</h2>
		<div class="webscan_assistent">
			<div class="firststep">
				<p>Não encontrei o LAS do seu projeto. Escolha uma opção abaixo</p>
				<p><button onclick="Assistent(this.id);" id="RunPointZip">Abrir Pointzip</button>
				<button><form method="post" enctype="multipart/form-data" id="uploadlas" onchange="UploadLAS();"><input type="file" id="las" name="las" accept=".las"/>Carregar LAS</button></form></p>
			</div>
			<div class="secondstep">
				<p>Selecione o ZIP que contém as cenas do seu projeto</p>
				<p><button><form method="post" enctype="multipart/form-data" id="uploadcenas" name="uploadcenas"><input type="file" id="cenas" name="cenas" accept=".zip" onchange="UploadCenas();"/>Selecionar Cenas</button></form></p>
			</div>
			<div class="thirdstep">
				<p>Agora digite o nome do projeto e clique em <strong>Gerar o Webscan</strong></p>
				<p><input type="text" id="project_name" placeholder="Nome do Projeto" maxlength="30" autofocus></p>
				<p><button id="gerar_webscan" class="actions" onclick="GerarWebscan();">Gerar o Webscan3D</button></form></p>
			</div>
		</div>
		<div class="actions"> <button id="gerar_webscan" class="action">Gerar Webscan3D</button> </div>
		<div id="console"></div>
	</div>
	<?php
		
	?>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;800&display=swap" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript">
		function UploadLAS(){
			var form = $("#uploadlas")[0];
			var formData = new FormData(form);
			$(".firststep p:first").html("Processando o LAS, este processo pode demorar um pouco, por favor aguarde...");
			$(".firststep p:nth-child(2)").html("<p><img src='data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiBzdHlsZT0ibWFyZ2luOiBhdXRvOyBiYWNrZ3JvdW5kOiByZ2IoMjU1LCAyNTUsIDI1NSk7IGRpc3BsYXk6IGJsb2NrOyBzaGFwZS1yZW5kZXJpbmc6IGF1dG87IiB3aWR0aD0iNDBweCIgaGVpZ2h0PSI0MHB4IiB2aWV3Qm94PSIwIDAgMTAwIDEwMCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ieE1pZFlNaWQiPgo8Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiBmaWxsPSJub25lIiBzdHJva2U9IiMyNzQxM2EiIHN0cm9rZS13aWR0aD0iMTUiIHI9IjI5IiBzdHJva2UtZGFzaGFycmF5PSIxMzYuNjU5MjgwNDMxMTU2IDQ3LjU1MzA5MzQ3NzA1MiI+CiAgPGFuaW1hdGVUcmFuc2Zvcm0gYXR0cmlidXRlTmFtZT0idHJhbnNmb3JtIiB0eXBlPSJyb3RhdGUiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIiBkdXI9IjFzIiB2YWx1ZXM9IjAgNTAgNTA7MzYwIDUwIDUwIiBrZXlUaW1lcz0iMDsxIj48L2FuaW1hdGVUcmFuc2Zvcm0+CjwvY2lyY2xlPgo8IS0tIFtsZGlvXSBnZW5lcmF0ZWQgYnkgaHR0cHM6Ly9sb2FkaW5nLmlvLyAtLT48L3N2Zz4='></p>");
			$.ajax({ url: '../Assistent/UploadLAS.php', type: "POST", data: formData, success: function(uploadlas_response){ $("#console").html(uploadlas_response); }, processData: false, cache: false, contentType: false });
		}
		function UploadCenas(){
			var form = $("#uploadcenas")[0];
			var formData = new FormData(form);
			$(".secondstep p:first").html("Processando cenas, este processo pode demorar um pouco, por favor aguarde...");
			$(".secondstep p:nth-child(2)").html("<p><img src='data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiBzdHlsZT0ibWFyZ2luOiBhdXRvOyBiYWNrZ3JvdW5kOiByZ2IoMjU1LCAyNTUsIDI1NSk7IGRpc3BsYXk6IGJsb2NrOyBzaGFwZS1yZW5kZXJpbmc6IGF1dG87IiB3aWR0aD0iNDBweCIgaGVpZ2h0PSI0MHB4IiB2aWV3Qm94PSIwIDAgMTAwIDEwMCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ieE1pZFlNaWQiPgo8Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiBmaWxsPSJub25lIiBzdHJva2U9IiMyNzQxM2EiIHN0cm9rZS13aWR0aD0iMTUiIHI9IjI5IiBzdHJva2UtZGFzaGFycmF5PSIxMzYuNjU5MjgwNDMxMTU2IDQ3LjU1MzA5MzQ3NzA1MiI+CiAgPGFuaW1hdGVUcmFuc2Zvcm0gYXR0cmlidXRlTmFtZT0idHJhbnNmb3JtIiB0eXBlPSJyb3RhdGUiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIiBkdXI9IjFzIiB2YWx1ZXM9IjAgNTAgNTA7MzYwIDUwIDUwIiBrZXlUaW1lcz0iMDsxIj48L2FuaW1hdGVUcmFuc2Zvcm0+CjwvY2lyY2xlPgo8IS0tIFtsZGlvXSBnZW5lcmF0ZWQgYnkgaHR0cHM6Ly9sb2FkaW5nLmlvLyAtLT48L3N2Zz4='></p>");
			$.ajax({ url: '../Assistent/UploadCenas.php', type: "POST", data: formData, success: function(uploadcenas_response){ $("#console").html(uploadcenas_response); }, processData: false, cache: false, contentType: false });
		}
		function GerarWebscan(){
			var project_name = $("#project_name").val();
			$(".thirdstep").hide();
			$("#console").append("<p>Gerando Webscan3D, por favor aguarde...</p>");
			$.post("modules/gerar_webscan.php",{ project_name : project_name }, function(get_console_response){
				$("#console").append(get_console_response);
			});
		}
		function Assistent(id){
			$.post("../Assistent/"+id+".php", function(assistent_response){
				$("#console").append(assistent_response);
			});
		}
		$(document).ready(function(){
			$(".actions button").click(function(){
				$(this).hide();$("#console").append("<p>Iniciando processo de criação do Webscan3D...</p>");
				var action = $(this).attr('id');
			});
		});
	</script>
</body>
</html>