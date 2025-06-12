<?php
    if(!isset($_COOKIE['adm'])){
        if(!isset($_COOKIE['nts'])){
            session_start();
	        $_SESSION['action'] = $_SERVER['PHP_SELF'];
		    header("Location: https://webscan3d.com/login.php"); 
		    return false;
	    }   
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Webscan3D </title>
	<style type="text/css">
		@font-face {
  			font-family: Barlow Semi Condensed Medium;
  			src: url(fonts/BarlowSemiCondensed-Medium.ttf);
		}
		* { margin: 0; padding: 0; font-family: 'Barlow Semi Condensed Medium', sans-serif; }
		.m { position: absolute; width: 100%; height: 35%; left:0; right: 0; margin: auto; }
		.texture { position: absolute; width: 350px; height: 80%; top:0; bottom:0; margin:auto; left: 10px; top:-30%;  }
		.logo { position: absolute; width: 500px; height: 100px; left:0; right:0; margin: auto; top: 10px; }
		.box { position: absolute; width: 350px; padding: 5px; text-align:center; background: #1b2e29; left:10px; color: #9fa61d; bottom: 130px;}
		.areas { position: absolute; width: 500px; height: 70px; left:0; right: 0; margin:auto; bottom: 120px; }
		.areas span { width: 164px; display: inline-block; }
		.areas span:hover { cursor: pointer; }
		.areas span .thumbs { width: 50px; height: 50px; border-radius: 5px; margin-top: 0px; margin-bottom: 0px; margin:auto; padding-left: 5px; margin-top: 10px; border-radius: 25px;}
		.areas span p { width: 10px; margin-left: 65px; margin-top: -47.5px; color: #9fa61d; }
		.login { position: absolute; width: 200px; padding: 25px; right: 10px; color: #9fa61d;} 
		.login p { margin-bottom: 10px; }
		.login input { width: 100%; height: 25px; margin-top: 7.5px; margin-bottom: 7.5px; padding-left: 5px; padding-right: -5px; }
		iframe { position: absolute; width: 100%; height: 76%; top:24%; border:0; }
	</style>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".areas p").click(function(){
				var id = this.id;
				$("iframe").remove();
				$("body").append("<iframe src='"+id+".html'> </iframe>");
			});
			$("#password, #user").on('keypress',function(e) {
                if(e.which == 13) {
                    var user = $("#user").val();
                    var password = $("#password").val();
                    if(user == ""){
                    	alert("Digite o nome de usuario");
                    	$("#user").focus();
                    	return false;
                    }
                    if(password == ""){
                    	alert("Digite a senha");
                    	$("#password").focus();
                    	return false;
                    }
                    $.ajax({
                      type: "POST",
                      url: "autentica.php",
                      cache: false,
                      data: { user: user, password: password }
                    })
                    .done(function( html ) {
                        $("body").append(html);
                    });
                }
            });
		});
	</script>
</head>
<body>
	<div style="position: absolute; width: 100%; height:100%; overflow: hidden; top:0; bottom:0; left:0; right:0; margin:auto;">
		<img src="img/background.png" style="position: absolute; width: 100%; height: 100%; top:0; bottom:0; left:0; right:0; margin:auto;">
		<article class="m"> <img src="img/texture.png" class="texture">
		<img src="img/logo.png" class="logo"> </article>
		<iframe src="PE-DUQUE-DE-CAXIAS.php"></iframe>
	</div>
</body>
</html>