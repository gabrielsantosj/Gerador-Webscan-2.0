<?php
	/*
	if(!isset($_COOKIE[''])){
		if(!isset($_COOKIE['administrator'])){
			if(!isset($_COOKIE['convidado'])){
		        session_start();
	            $_SESSION['action'] = $_SERVER['PHP_SELF'];
			    header("Location: https://webscan3d.com/login.php"); 
			    return false;
		    }
	    }
	}   
	/* SCRIPT TO GET POSITION OF TXT */
	$fp = fopen("modules/position.txt","r");
	$dt = fgets($fp);
	echo "<input type='hidden' class='txt_position_data' value='".$dt."'>";
    fclose($fp);
	/* ------------------ */
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="sortcut icon" href="/img/icon.png" type="image/png" />
    <link rel="stylesheet" type="text/css" href="libs/potree/potree.css">
	<link rel="stylesheet" type="text/css" href="libs/jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="libs/perfect-scrollbar/css/perfect-scrollbar.css">
	<link rel="stylesheet" type="text/css" href="libs/openlayers3/ol.css">
	<link rel="stylesheet" type="text/css" href="libs/spectrum/spectrum.css">
	<link rel="stylesheet" type="text/css" href="libs/jstree/themes/mixed/style.css">
	<style type="text/css">
        *{margin:0;padding:0;overflow:hidden;}
		body{font-family: 'Barlow', sans-serif;overflow:hidden;background:#000;}
		input,textarea{outline:none;border:1px solid #c6c6c6;}li{list-style:none;}
	
	    #potree_annotation_container,#menu_about,#menu_classification,.tl{display:none;}
	    .close_f { position: absolute; padding:5px;float: right; right: 35px; top: 4px; color: #000; z-index:999; font-family: Arial; cursor: pointer; font-size: 14px; background: #fff; border-radius:10px; border:1px solid #999; font-weight:bold; }
		iframe {position: absolute;width:100%;height:100%;top:0; bottom:0; left:0; right:0; margin: auto; background: #fff; z-index: 2; border-radius: 5px;}

        iframe{position:absolute;width:100%;height:100%;border:0;}

        .bottom_nav_left{position:absolute;padding-left:000000.1px;z-index:3;float:right;bottom:10px;left:10px;}
        .right_nav{position:absolute;padding-left:000000.1px;z-index:3;float:right;bottom:10px;right:10px;}

        .right_nav li{list-style:none;margin-top:10px;}
        ul li,.send_email,.mask:hover{cursor:pointer;}
        ul li img{width:37.5px;z-index:999;}

		#update_model,.potree_menu_toggle,.annotation-label{display:none;}

		.mask{position:absolute;width:100%;height:calc(100% + 10px);background:#000;filter:alpha(opacity=60);opacity:0.6;z-index:999;top:-10px;display:none;}
		
		.login_section{position:absolute;width:300px;height:220px;background:#ffffff;border-radius:10px;z-index:1001;top:0;bottom:0;
		left:0;right:0;margin:auto;display:none;}
		.login_section input{width:calc(90% - 20px);margin-left:5%;height:40px;border:1px solid #000;margin-top:25px;padding-left:10px;padding-right:10px;}
		.login_section input[type=button]{width:90%;background:#98e05f;border:0;font-size:14px;font-weight:bold;}
		.login_section input[type=button]:hover{cursor:pointer;}

		.other_examples{position:absolute;bottom:0;width:100%;height:160px;background:#fff;z-index:3;display:flex;justify-content:center;bottom:-160px;}
		.other_examples li{width:80px;text-align:center;margin-top:30px;font-size:12px;color:#000;}
		.other_examples li img{width:60px;height:60px;border-radius:60px;padding:2px;}

		.leads{position:absolute;width:400px;height:160px;padding-top:10px;padding-bottom:10px;left:0;right:0;margin:auto;bottom:-180px;z-index:999;background:#fff;border-radius:5px 5px 0px 0px;}
		.leads_c{position:absolute;width:90%;margin-left:5%;font-size:18px;line-height:30px;}
		.leads_c input{position:relative;width:calc(100% - 82px);height:40px;margin-top:15px;float:left;padding-left:10px;text-transform:italic;font-size:15px;}
		.send_email{position:relative;width:70px;height:42px;float:right;margin-top:15px;}

		.bottom_logo{position:absolute;width:50%;height:60px;left:0;right:0;margin:auto;bottom:10px;z-index:3;}
		.bottom_logo img{position:absolute;left:0;right:0;margin:auto;}

		input{border:1px solid #c6c6c6;outline:0;}
		
		/* FILE MANAGER CSS */
		a,.close_modal,.files_manager tbody td img:hover{cursor:pointer;}
		
		.mask{position:absolute;width:100%;height:calc(100% + 100px);background:#001A00;filter:alpha(opacity=90);opacity:0.9;z-index:999;display:none;}

        .top_nav{position:relative;width:100%;height:100px;background:#00ab65;top:-20px;}
        .top_nav .logo{position:absolute;float:left;width:150px;top:0px;bottom:0;margin:auto;left:20px;}
        
        .top_nav .right_menu{width:auto;height:30px;float:right;margin-right:20px;margin-top:35px;overflow:hidden;}
        .top_nav .right_menu img{width:25px;margin-left:10px;margin-right:0px;margin-top:1.5px;}
        
        .modal_files_manager {position:absolute;width:90%;height:300px;left:0;right:0;margin:auto;top:110px;background:#ffffff;z-index:1000;border:1px solid #cccccc;border-radius:10px;}
        .modal_files_manager .modal_title{float:left;margin-left:15px;width:calc(95% - 30px);height:50px;line-height:50px;overflow-y:hidden;font-weight:bold;}
        .modal_files_manager .close_modal{float:right;margin-right:15px;height:15px;line-height:15px;border-radius:25px;padding:5px;margin-top:12.5px;color:#001A00;font-weight:bold;}
        .modal_files_manager .modal_content{position:relative;margin-left:15px;width:calc(100% - 30px);height:150px;border-top:1px solid #cccccc;margin-top:15px;}
        .modal_files_manager .btn_upload_input{margin-top:15px;padding:5px;background:#001A00;color:#ffffff;border-radius:10px;}
        
        .files_manager{display:none;}
        .files_manager .modal_content{height:230px;}
        .files_manager table{width:100%;height:auto;margin-top:10px;border-collapse: collapse;border-radius:5px;border:1px solid #c6c6c6;font-size:14px;}
        .files_manager thead{height:100px;height:30px;line-height:30px;background:#f2f2f2;border-bottom:1px solid #c6c6c6;}
        .files_manager tbody{height:100px;width:100%;}
   
        .files_manager tbody td{height:30px;line-height:30px;text-align:center;border-bottom:1px solid #cccccc;}
        .files_manager tbody td img{width:25px;margin-top:10px;}
        .files_manager .no_uploads{margin-top:25px;text-align:center;}
        .files_manager .delete_file{margin-left:5px;}
        
        .modal_uploading_file{display:none;}
        .modal_uploading_file{margin-top:20px;}
        .modal_uploading_file #uploading_progress{width:100%;height:50px;margin-top:15px;}
		
		/* COMMENT DIV CSS */
		#comment_button{position:absolute;width:15px;height:15px;padding:30px;background:#000000;margin-left:10px;z-index:1000;color:#ffffff;border-radius:30px;}
		
		.modal{position:absolute;width:300px;height:400px;top:0;word-wrap:wrap;background:#ffffff;z-index:1002;border:1px solid #c6c6c6;border-radius:5px;top:-30px;bottom:0;left:0;right:0;margin:auto;display:none;}
		.modal .header{height:50px;border-bottom:1px solid #c6c6c6;margin-bottom:10px;} 
		.modal p{position:absolute;width:280px;height:50px;line-height:50px;margin-left:10px;}
		.modal span{margin-left:10px;margin-right:10px;font-weight:bold;}
		.modal span:hover{cursor:pointer;background:#f2f2f2;}
		
		.form_comment{width:300px;height:calc(310px - 15px);background:#ffffff;z-index:1003;top:0;bottom:0;left:0;right:0;margin:auto;}
		.form_comment label{margin-left:5%;}
		.form_comment .input{width:calc(90% - 5px);margin-left:5%;height:30px;margin-top:15px;margin-bottom:15px;font-size:12px;padding-left:5px;}
		textarea { padding-top:5px; }
		.form_comment button{width:calc(90% + 2px);margin-left:5%;height:35px;background:#001A00;color:#ffffff;margin-bottom:5px;border-radius:5px;}
		.form_comment button:hover{cursor:pointer;}
		.form_comment .insert {text-transform:uppercase;}
		#edit{height:calc(450px);}
		#modal_edit .delete{background:red;border:1px solid red;}
		
		.exitBoxMode{display:none;position:absolute;width:100%;height:50px;left:0px;right:0;margin:auto;top:0px;background:#ffffff;border:1px solid #c6c6c6;text-align:center;line-height:50px;font-size:1em;z-index:99999999999;}
		.exitBoxMode:hover{cursor:pointer;}
		.exitBoxMode .close_boxMode{width:30px;height:30px;line-height:25px;background:#c6c6c6;float:right;margin-right:10px;border-radius:30px;color:#000000;border:1px solid #c6c6c6;font-size:1.5em;margin-top:10px;}
		
		/* COMMENTS LIST MODAL */
		.comments_list_modal{position:absolute;width:1280px;height:300px;left:0;right:0;margin:auto;top:110px;background:#ffffff;border:1px solid #c6c6c6;border-radius:5px;z-index:9999;padding:10px;display:none;}
		.comments_list_modal .head{padding-bottom:10px;border-bottom:1px solid #c6c6c6;}
		.comments_list_modal .head h2{width:calc(100% - 30px);float:left;padding-bottom:2.5px;}
		.comments_list_modal .head .comments_list_modal_close{width:30px;height:30px;line-height:25px;float:right;border-radius:30px;background:#666666;text-align:center;margin-top:2.5px;color:#ffffff;}
		.comments_list_modal .head .comments_list_modal_close:hover{cursor:pointer;background:#999999;color:#ffffff;}
		
		.comments_list_modal .content table{width:100%;height:250px;border-collapse:collapse;display: inline-block; overflow: auto;font-size:14px;}
		.comments_list_modal .content table thead{background:#f2f2f2;text-align:left;font-style:italic;}
		.comments_list_modal .content table th{border:1px solid #c6c6c6;height:30px;line-height:30px;padding-left:5px;}
		.comments_list_modal .content table tr{height:30px;line-height:30px;}
		
		.comments_list_modal .content table tbody td{border:1px solid #c6c6c6;background:#ffffff;height:30px;line-height:30px;padding-left:5px;}
		.comments_list_modal .content table tbody td a img{float:left;width:20px;margin-top:4.5px;padding-right:5px;}
		/* -------------------- */
		
		@media screen and (min-width: 320px) and (max-width:1279px){
			#ground_control,#flight_control, #keyboard_control{display:none;}
			.leads{position:absolute;width:320px;height:160px;padding-top:10px;padding-bottom:10px;left:0;right:0;margin:auto;bottom:-180px;z-index:999;background:#fff;border-radius:5px 5px 0px 0px;}
			.leads_c{font-size:16px;}
			.modal_files_manager,.comments_list_modal{width:95%;}
		}
		@media screen and (min-width: 720px){
            .modal_files_manager{width:600px;}
        }
	</style>
</head>
<body>
	@method("PUT")
	<div class="mask"></div>
	<div class="comments_list_modal">
	    <div class="head">
	        <h2>Gerenciador de Comentários</h2>
	        <div class="comments_list_modal_close">x</div>
	    </div>
	    <div class="content">
	        <table>
	            <thead>
                    <tr>
                        <th style="width:495px;">Título</th>
                        <th style="width:495px;">Descrição</th>
                        <th style="width:200px;">Categoria</th>
                        <th style="width:82.5px;">Visualização</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
	    </div>
	</div>
    <nav class="top_nav">
        <div class="right_menu">
            <a id="comments_list_button" title="Gerenciador de Comentários" alt="Gerenciador de Comentários"><img src="assets/comments_list.svg"/></a>
            <?php
                if(isset($_COOKIE['administrator'])){
                    echo "<a id='files_manager' title='Gerenciador de Arquivos' alt='Gerenciador de Arquivos'><img src='assets/files.svg'></a>";
                }
            ?>
            <a href='/logout.php' class="logout" title="Finalizar Sessão" alt="Finalizar Sessão"><img src='assets/logout_white_24dp.svg'></a>
        </div>
        <a href="https://webscan3d.com" target="_blank"><img class="logo" src="img/logo-webscan-em-branco.svg"></a>
    </nav>
    <div class="modal_files_manager files_manager">
        <p class="modal_title">Gerenciador de Arquivos<button alt="Adicionar Arquivo" title="Adicionar Arquivo" class="btn_upload_input" style="margin-left:15px;margin-top:-5px;"><input type="file" name="file" id="upload_input" style="position:absolute;margin-left:-6px;margin-top:-6px;height:27px;width:115px;opacity:0;filter:alpha(opacity=0);">+ ADICIONAR</button><p class="close_modal">x</p></p>
        <div class="modal_content">
            <?php
                $uploads_path = "assets/uploads/";
                $uploads = glob("$uploads_path{*}", GLOB_BRACE);
                if(count($uploads)>0){
                    echo "<table><thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                    </thead><tbody>";
                    $diretorio = dir($uploads_path);
                    while($arquivo = $diretorio -> read()){
                        if($arquivo != "." && $arquivo != ".."){
                            $arc_name = explode(".", $arquivo);
                            echo "<tr>
                                <td>$arquivo</td>
                                <td><a href='$uploads_path$arquivo' download><img src='assets/download.svg'></a><a onclick='delete_file(this.id);' id='$arquivo'><img src='assets/delete.svg' class='delete_file' id='$arquivo'></a></td>
                            </tr>";
                        }
                    }
                    echo "</tbody></table>";
                }else{
                    echo '<p class="no_uploads">Nenhum arquivo encontrado.</p>';
                }
            ?>
        </div>
    </div>
    <div class="modal_files_manager modal_uploading_file">
        <p class="modal_title">Enviando Arquivo (<span class="progress_percent">0%</span>)</p>
        <div class="modal_content">
            <p class="txt_uploading">Estamos fazendo o upload do arquivo <b class="upload_filenamename"></b>, por favor aguarde.</p>
            <progress id="uploading_progress" value="0" max="100"></progress>
        </div>
    </div>
	<script src="libs/jquery/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
	<script src="libs/spectrum/spectrum.js"></script>
	<script src="libs/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
	<script src="libs/jquery-ui/jquery-ui.min.js"></script>
	<script src="libs/three.js/build/three.min.js"></script>
	<script src="libs/other/OBJLoader.js"></script>
	<script src="libs/other/PLYLoader.js"></script>
	<script src="libs/other/BinaryHeap.js"></script>
	<script src="libs/tween/tween.min.js"></script>
	<script src="libs/d3/d3.js"></script>
	<script src="libs/proj4/proj4.js"></script>
	<script src="libs/openlayers3/ol.js"></script>
	<script src="libs/i18next/i18next.js"></script>
	<script src="libs/jstree/jstree.js"></script>
	<script src="libs/potree/potree.js"></script>
	<script src="libs/plasio/js/laslaz.js"></script>
	<div class="potree_container" style="position: absolute; width: 100%; height: calc(100% - 100px); left: 0px; top: 100px; ">
	    <!--
		<div class="modal" id="modal_create">
	        <div class="header">
	            <p style="width:245px;position:relative;float:left;">Inserir Comentário</p>
	            <span class="close_modal" style="position:relative;width:25px;height:25px;float:right;background:#f2f2f2;border-radius:10px;text-align:center;margin-top:12.5px;">x</span>
	        </div>
	        <div class="content form_comment" id="create">
	            <label for="comment">Comentário</label><br>
	            <input type="text" name="comment" id="comment" class="input" pattern="[a-zA-Z0-9]+">
	            <label for="details">Detalhes (Opcional)</label><br>
    	        <textarea name="details" id="details" class="input" rows="4" cols="50" style="height:100px;resize:none;"></textarea>
    	        <button class="insert">Inserir Comentário</button>
	        </div>
	    </div>
	    <div class="modal" id="modal_edit">
	        <div class="header">
	            <p style="width:245px;position:relative;float:left;">Editar Comentário</p>
	            <span class="close_modal" style="position:relative;width:25px;height:25px;float:right;background:#f2f2f2;border-radius:10px;text-align:center;margin-top:12.5px;">x</span>
	        </div>
	        <div class="form_comment" id="edit">
    	        <input type="hidden" id="comment_id">
    	        <label for="comment">Comentário</label><br>
    	        <input type="text" id="comment_update" class="input" value="">
    	        <label for="details">Detalhes (Opcional)</label><br>
    	        <textarea name="details" id="details" class="input" rows="4" cols="50" style="height:100px;resize:none;"></textarea>
    	        <span><b class="edit_coordinate"></b></span>
    	        <button class="update">Salvar alterações</button><button class="delete">Remover Comentário</button>
	        </div>
	    </div>
		-->
        <div id="potree_render_area"></div>
        <div id="potree_sidebar_container"></div>
        <input type="hidden" id="cloud_name" value="<?php $dh = opendir("./modules/"); while (false !== ($filename = readdir($dh))){$files[] = $filename;if($filename != "." && $filename != ".."){if(!strstr($filename, '.', false)){if(!is_dir($filename)){if($filename != "error_log"){echo "$filename";}}}}} ?>">
	    <input type="hidden" id="model_name" value="<?php $dh = opendir("./assets/uploads"); while (false !== ($filename = readdir($dh))){$files[] = $filename;if($filename != "." && $filename != ".."){if(strstr($filename, '.obj', true)){if(!is_dir($filename)){if($filename != "error_log"){echo "$filename";}}}}} ?>">
	    <input type="hidden" id="scenes_path" value="<?php if(file_exists("modules/ScansData.js")){ echo "ScansData.js"; }?>">
	</div>
	<script>
	    function getRandomColor() {
          var letters = '0123456789ABCDEF';
          var color = '0x';
          for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
          }
          return color;
        }
	    var cloud_name = $("#cloud_name").val(); var path_name = $("#path_name").val(); var camera_position = $("#camera_position").val();
	    var m; var model_name_list = $("#model_name").val(); var model_loaded = 0; var model_name = [];
	    if(model_name_list != ""){
            var model_name = model_name_list.split(".obj");
			var loader = new THREE.OBJLoader();	
	        for (var mn = 0; mn < model_name.length-1; mn++) {
				obj_options = model_name[mn].split("_");
	   		    loader.load("assets/uploads/"+model_name[mn]+'.obj', (a) => {
	   		        model_color = getRandomColor();
					a.traverse(function(child){
						if(child instanceof THREE.Mesh){
							child.material.color.setHex(model_color);
						}
					});
					a.scale.multiplyScalar(1);
					viewer.scene.scene.add(a);
					a.visible = true;
					$(".3d_model").attr('src','assets/Webscan__mostrar-e-ocultar modelo-3D_active.svg');
        		    document.getElementById("update_model").addEventListener("click", update_model, false);
        		    function update_model(){
						if(a.visible == false){
							$(".3d_model").attr('src','assets/Webscan__mostrar-e-ocultar modelo-3D_active.svg');
							a.visible = true;
						}else{
							$(".3d_model").attr('src','assets/Webscan__mostrar-e-ocultar modelo-3D.svg');
							a.visible = false;
						}
        		    }
        		    model_loaded++;
        	    });
            }
	    };
	    window.viewer = new Potree.Viewer(document.getElementById("potree_render_area")); 
		viewer.setFOV(100);
		viewer.setPointBudget(10*1000*1000);
		viewer.setMinNodeSize(0);
		document.title = "WebScan 3D";
		viewer.setEDLEnabled(true);
		viewer.setBackground("gradient");
		viewer.loadSettingsFromURL();
		viewer.loadGUI(() => {
			viewer.setLanguage('pt');
			$("#menu_appearance").next().show();
			/* viewer.toggleSidebar(); */
		});
		Potree.loadPointCloud("pointclouds/"+cloud_name+"/cloud.js", ""+cloud_name+"", e => {
			let pointcloud = e.pointcloud;
			let material = pointcloud.material;
			viewer.scene.addPointCloud(pointcloud);
			material.pointColorType = Potree.PointColorType.RGB; // any Potree.PointColorType.XXXX 
			material.size = 1;
			material.pointSizeType = Potree.PointSizeType.ATTENUATED;
			material.shape = Potree.PointShape.CIRCLE;
			/* BLACK AND WRITE 
			let pointcloud = e.pointcloud;
			let material = pointcloud.material;
			viewer.scene.addPointCloud(pointcloud);
			material.pointColorType = Potree.PointColorType.COLOR = "(255,255,255)"; // any Potree.PointColorType.XXXX 
			material.size = 1;
			material.pointSizeType = Potree.PointSizeType.ATTENUATED;
			material.shape = Potree.PointShape.CIRCLE;
			*/
			var url = window.location.href;
			if(url.indexOf('#') > -1){
			    var cord = url.split("#");
				var c = cord[1].split(",");
			    var x = parseInt(c[0] + '.' + c[1]);
				var y = parseInt(c[2] + '.' + c[3]);
				var z = parseInt(c[4] + '.' + c[5]);
				viewer.scene.view.position.set(x,y,z);
				viewer.scene.view.pitch = 0;
				viewer.scene.view.yaw = 0;  /* LEFT-RIGHT */
			}else if($(".txt_position_data").val() != ""){
				txt_position_data = $(".txt_position_data").val().split("_");
				x = parseFloat(txt_position_data[0]), y = parseFloat(txt_position_data[1]),z = parseFloat(txt_position_data[2]);
				viewer.scene.view.position.set(x,y,z);
				viewer.scene.view.pitch = txt_position_data[3];
				viewer.scene.view.yaw = txt_position_data[4];  /* LEFT-RIGHT */
			}else{
				viewer.fitToScreen();
			}
		});
		$("#potree_render_area").append("<div class='exitBoxMode'><input type='checkbox' id='boxMode' name='boxMode' checked/><label for='boxMode' style='padding-left:5px;'>MODO BOX</label><div class='close_boxMode'>x</div></div>");
		$("#potree_render_area").append("<ul class='right_nav'>");
		$(".right_nav").append('<li><img src="assets/WEbscan_nuvem-de-pontos-ativo.svg" alt="Nuvem De Pontos" title="Nuvem De Pontos" class="pointcloud hidden"></li>');
		$(".right_nav").append('<li><img src="assets/Webscan_cenas-360.svg" alt="Imagens 360º" title="Imagens 360º" class="360_images hidden"></li>');
		$(".right_nav").append('<li><img src="assets/Webscan__mostrar-e-ocultar modelo-3D.svg" alt="Modelo 3D" title="Modelo 3D" class="3d_model hidden" id="update_model"></li>');
		$(".right_nav").append('<li id="ground_control"><img src="assets/Webscan_agarrar-arrastar.svg" alt="Controle Terrestre" title="Controle Terrestre" class="ground_control hidden"></li>');
		$(".right_nav").append('<li id="flight_control"><img src="assets/Webscan_eixo-central.svg" alt="Controle de Vôo" title="Controle de Vôo" class="flight_control hidden"></li>');
		$(".right_nav").append('<li id="keyboard_control"><img src="assets/Webscan_controle-por-teclas.svg" alt="Controle por Teclas" title="Controle por Teclas" class="keyboard_control hidden"></li>');
		$(".right_nav").append('<li><img src="assets/Webscan_enquadrar-nuvem.svg" alt="Extensão Total" title="Extensão Total" class="total_extension hidden"></li>');
		$(".right_nav").append('<li><img src="assets/Webscan_cubo-de-navegacao.svg" alt="Cubo de Navegação" title="Cubo de Navegação" class="navigation_cube hidden"></li>');
		$(".right_nav").append('<li><img src="assets/Webscan_configuracoes-da-nuvem.svg" alt="Configurações da Nuvem" title="Configurações da Nuvem" class="cloud_configuration hidden"></li>');
        $(".right_nav").append('<li><img src="assets/Webscan_fechar-menu.svg" alt="Menu" title="Menu" class="menu" style="margin-top:15px;"></li>');
	</script>
	<div class="bottom_logo">
		<a href="https://brtech3d.com.br" target="_blank"><img alt="Brtech3D Logo" title="Brtech3D Logo" src="assets/logo_white.png" style="width:200px;"></a>
	</div>
    <script>
		var nav_cube_visible = false; var keyboard_control = false; var flight_control = false;
		var ground_control = false; var scenes_images = false; var pointcloud_visible = true;
		var portrait_mode = false; var ar_mode = false;
		if(model_name.length != 0){
			IsModelLoaded();
		}else{
			$(".3d_model").remove();
		}
        function IsModelLoaded() {
            setTimeout(function () {
                if(model_loaded != model_name.length-1){
                    IsModelLoaded();
                }else{
					$(".3d_model").show();
                }
            }, 1000);
        }
        function edit_comment(comment_id){
            $.ajax({
                url: 'comments/'+comment_id+'.json', 
                type: 'GET',
                success: function(data){
		            $('#modal_edit,.mask').toggle();
                    $('#comment_update').val(data['comment']); 
                    $('#edit #details').val(data['details']); 
                    $('#edit #comment_id').val(comment_id);
                }
            });
        }
		function updateTumbnail(){
			portrait_mode = true;
			console.log("Modo retrato: Ativado!");
			$(".bottom_nav_left,.right_nav,.other_examples,.top_nav,.bottom_logo,#potree_sidebar_container").hide();
			$(".potree_container").css({"top":"-=100px","height":"calc(100% + 100px)"});
			$("body").css("cursor","none");
			var dataURL = viewer.renderer.domElement.toDataURL();
			$.ajax({ 
				type: "POST", 
				url: 'assets/update_tumbnail.php',
				dataType: 'text',
				data: {
					base64data : dataURL,
				},
				success: function(response){
					portrait_mode = false;
					$(".bottom_nav_left,.right_nav,.other_examples,.top_nav,.bottom_logo,#potree_sidebar_container").show();
					$(".potree_container").css({"top":"100px","height":"calc(100% - 100px)"});
					$("body").css("cursor","inherit");
					console.log("Modo retrato: Desativado!");
				}
			});     
		}
		function delete_file(fname){
            var filename = fname;
            if(confirm("Tem certeza que deseja excluir o arquivo "+filename+"?") == true) {
                $.ajax({
                    url: 'assets/php/delete_file.php', 
                    type: 'POST',
                    data: {'filename': filename},
                    fail: function(){
                        alert("Não foi possível excluir o arquivo. Tente novamente mais tarde.");
                    },
                    success: function(data){
                        window.localStorage.setItem('opened_modal', 0);
                        document.location.reload(true);
                    }
                });
            }
        }
        $(function(){
            /* FILES MANAGER */
            if(window.localStorage.getItem('opened_modal')==1){
               $(".mask,.files_manager").show();
            }
            $(".modal_files_manager .close_modal").click(function(){
                window.localStorage.setItem('opened_modal', 0);
                $(".files_manager,.mask").hide();  
            });
            $("#files_manager").click(function(){
                $(".files_manager,.mask").toggle();        
            });
            $(".mask").click(function(){
                $(".files_manager,.comments_list_modal,.mask").hide();        
            });
            $(document).on('change','#upload_input' , function(){
               var data = new FormData();
               data.append('file', $('#upload_input')[0].files[0]);
               $(".upload_filenamename").html($('#upload_input')[0].files[0].name);
               if($('#upload_input')[0].files[0]){
                   if($('#upload_input')[0].files[0].size < 104857600){
                        $.ajax({
                            url: 'assets/php/upload_file.php',
                            data: data,
                            type: 'POST',
                            beforeSend: function(){
                                $(".modal_uploading_file, .files_manager").toggle();
                            },
                            xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {
                                        var percentComplete = evt.loaded / evt.total;
                                        $(".progress_percent").html(Math.round(percentComplete * 100)+'%');
                                        $("#uploading_progress").attr('value', Math.round(percentComplete * 100));
                                    }
                                }, false);
                                return xhr;
                            },
                            success: function(data){
                                window.localStorage.setItem('opened_modal', 1);
                                document.location.reload(true);
                            },
                            processData: false,
                            contentType: false,
                            cache: false,
                        });
                   }else{
                       alert("Arquivo muito grande. Só permitimos arquivos até 15MB");
                   }
               }
            });
            $("#boxMode").change(function(){
                if ($('#boxMode').prop('checked')) {
                    let volume = new Potree.Volume();
                    volume.name = 'Visible';
                    volume.scale.set(15, 15, 10);
                    volume.position.set(coordinate[0], coordinate[1], coordinate[2]);
                    volume.clip = true;
                    volume.visible = false;
                    viewer.scene.addVolume(volume);
                    viewer.setClipTask(Potree.ClipTask.SHOW_INSIDE);
                    $('#potree_annotation_container').hide();
		            $(".360_images").attr('src', 'assets/Webscan_cenas-360.svg');
                    scenes_image = false;
                }else{
                    for(let volume of viewer.scene.volumes){
			            viewer.scene.removeVolume(volume);
		            }
		            $(".exitBoxMode").hide();
                    $('.potree_container').css({'top':'+=100px','height':'calc(100% - 100px)'});
                    $(".top_nav,#potree_annotation_container").show();
		            $(".360_images").attr('src', 'assets/WEbscan_cenas-360-ativo.svg');
                    scenes_image = true;
                }
            });
            $(".close_boxMode").click(function(){
                for(let volume of viewer.scene.volumes){
			        viewer.scene.removeVolume(volume);
		        }
                $(".exitBoxMode").hide();
                $('.potree_container').css({'top':'+=100px','height':'calc(100% - 100px)'});
                $(".top_nav,#potree_annotation_container").show();
                $(".360_images").attr('src', 'assets/WEbscan_cenas-360-ativo.svg');
                scenes_image = true;
            });
			$(".annotation").hover(function(){
                $(this).find(".annotation-label").toggle(); //.annotation-titlebar
            });
            $(".menu").click(function(){
                if($(".hidden").css("display") == "none"){
					$(".menu").attr('src', 'assets/Webscan_fechar-menu.svg');
					$(".hidden").slideToggle(100);
				}else{
					$(".menu").attr('src', 'assets/Webscan_abrir-menu.svg');
					$(".hidden").slideToggle(100);
				}
            });
            $(".cloud_configuration").click(function(){
				if($("#potree_render_area").css("left") == "0px"){
					$(".potree_menu_toggle").click();
					$(".top_nav,.client_area,.other_examples,.bottom_logo").hide();
					$('.potree_container').css({'top':'-=100px','height':'calc(100%)'});
					$(".cloud_configuration").attr('src', 'assets/WEbscan_configuracoes-da-nuvem-ativo.svg');
				}else{
					$(".potree_menu_toggle").click();
					$(".top_nav,.client_area,.other_examples,.bottom_logo").show();
					$('.potree_container').css({'top':'+=100px','height':'calc(100% - 100px)'});
					$(".cloud_configuration").attr('src', 'assets/Webscan_configuracoes-da-nuvem.svg');
				}
            });
            $(".insert_comment_button").click(function(){
                if(comments_tool_active){
                    let measurements = this.viewer.scene.measurements;
        			let measurement_l = 1;
        			for (let measurement of measurements) {
        				if(measurement_l == measurements.length){
        				    viewer.scene.removeMeasurement(measurement);
        				}
        				measurement_l++;
        			}
				    comments_tool_active = false;
                }else{
                    $(".insert_comment_button").attr('src', 'assets/comments-ativo.svg');
                    let measuringTool = new Potree.MeasuringTool(viewer);
            		$('#menu_measurements').next().slideDown();
            		let measurement = measuringTool.startInsertion({
            			showDistances: false,
            			showAngles: false,
            			showCoordinates: true,
            			showArea: false,
            			closed: true,
            			maxMarkers: 1,
            			name: 'Point'
            		});
            		let measurementsRoot = $("#jstree_scene").jstree().get_json("measurements");
            		let jsonNode = measurementsRoot.children.find(child => child.data.uuid === measurement.uuid);
            		$.jstree.reference(jsonNode.id).deselect_all();
            		$.jstree.reference(jsonNode.id).select_node(jsonNode.id);
                    comments_tool_active = true;
                }
        		
            });
			$(".navigation_cube").click(function(){
				if(nav_cube_visible == false){
					$(".navigation_cube").attr('src', 'assets/WEbscan_cubo-de-navegacao-ativo.svg');
					viewer.toggleNavigationCube();
					nav_cube_visible = true;
				}else{
					$(".navigation_cube").attr('src', 'assets/Webscan_cubo-de-navegacao.svg');
					viewer.toggleNavigationCube();
					nav_cube_visible = false;
				}
			});
			$(".total_extension").click(function(){
				$(this).attr('src', 'assets/WEbscan_enquadrar-nuvem-ativo.svg');
				viewer.fitToScreen();
				setTimeout(function () { $(".total_extension").attr('src', 'assets/Webscan_enquadrar-nuvem.svg'); }, 1000);
			});
			$(".keyboard_control").click(function(){
				if(keyboard_control == false){
					$(".keyboard_control").attr('src', 'assets/WEbscan_controle-por-teclas-ativo.svg');
					viewer.setNavigationMode(Potree.FirstPersonControls);viewer.fpControls.lockElevation = false;
					keyboard_control = true;
				}else{
					$(".keyboard_control").attr('src', 'assets/Webscan_controle-por-teclas.svg');
					viewer.setNavigationMode(Potree.OrbitControls);
					keyboard_control = false;
				}
			});
			$(".flight_control").click(function(){
				if(flight_control == false){
					$(".flight_control").attr('src', 'assets/WEbscan_eixo-central-ativo.svg');
					viewer.setNavigationMode(Potree.FirstPersonControls);viewer.fpControls.lockElevation = true;
					flight_control = true;
				}else{
					$(".flight_control").attr('src', 'assets/Webscan_eixo-central.svg');
					viewer.setNavigationMode(Potree.OrbitControls);
					flight_control = false;
				}
			});
			$(".ground_control").click(function(){
				if(ground_control == false){
					$(".ground_control").attr('src', 'assets/WEbscan_agarrar-arrastar-ativo.svg');
					viewer.setNavigationMode(Potree.EarthControls);
					ground_control = true;
				}else{
					$(".ground_control").attr('src', 'assets/Webscan_agarrar-arrastar.svg');
					viewer.setNavigationMode(Potree.OrbitControls);
					ground_control = false;
				}
			});
			$(".360_images").click(function(){
				if(scenes_images == false){
					$(".360_images").attr('src', 'assets/WEbscan_cenas-360-ativo.svg');
					$("#potree_annotation_container").show();
					scenes_images = true;
				}else{
					$(".360_images").attr('src', 'assets/Webscan_cenas-360.svg');
					$("#potree_annotation_container").hide();
					scenes_images = false;
				}
			});
			$(".pointcloud").click(function(){
				if(pointcloud_visible == false){
					$(".pointcloud").attr('src', 'assets/WEbscan_nuvem-de-pontos-ativo.svg');
					viewer.scene.pointclouds[0].visible = true;
					pointcloud_visible = true;
				}else{
					$(".pointcloud").attr('src', 'assets/Webscan_nuvem-de-pontos.svg');
					viewer.scene.pointclouds[0].visible = false;
					pointcloud_visible = false;
				}
			});
			$(".mask,.insert_comment_no,.close_modal").click(function(){
			    let measurements = viewer.scene.measurements;
        		let measurement_l = 1;
        		for (let measurement of measurements) {
        			if(measurement_l == measurements.length){
        				viewer.scene.removeMeasurement(measurement);
        			}
        			measurement_l++;
        		}
				comments_tool_active = false;
				$(".mask,#modal_edit,#modal_create").hide();
				$(".insert_comment_button").attr('src', 'assets/comments.svg');
			});
			$(document).keyup(function(e){
			    if($(".modal").is(":hidden")){
    				if(e.keyCode == 80){ //p
    					if(portrait_mode == false){
    						portrait_mode = true;
    						console.log("Modo retrato: Ativado!");
    						$(".bottom_nav_left,.right_nav,.other_examples,.top_nav,.bottom_logo").hide();
    						$("body").css("cursor","none");
    					}else{
    						portrait_mode = false;
    						$(".bottom_nav_left,.right_nav,.other_examples,.top_nav,.bottom_logo").show();
    						$("body").css("cursor","inherit");
    						console.log("Modo retrato: Desativado!");
    					}
    				}
    				if(e.keyCode == 73){
    				    let camera = viewer.scene.getActiveCamera();
    				    yaw = viewer.scene.view.yaw, pitch = viewer.scene.view.pitch;
    					let target = camera.position.toArray();
    					var coord_x = target[0], coord_y = target[1], coord_z = target[2], pitch = pitch.toFixed(2), yaw = yaw.toFixed(2);
    					$.ajax({
    						url: 'assets/update_position.php', 
    						type: 'POST',
    						data: { x: coord_x, y:coord_y, z:coord_z, pitch:pitch, yaw:yaw },
    						success: function(data){
    						    updateTumbnail();
    							console.log("Coordenada salva com sucesso!");
    						}
                    	});
    				}
    				if(e.keyCode == 71){
    					let coordinates = prompt("Digite a coordenada X,X e Z do ponto que deseja visualizar.\nA coordenada deve ser separada por espaços.\nExemplo: 1.23 4.56 7.89")
    					if(coordinates != null || coordinates != "") {
    						let coordinate = coordinates.split(" ");
    						viewer.scene.view.position.set(coordinate[0],coordinate[1],coordinate[2]);
    						viewer.scene.view.lookAt(new THREE.Vector3(coordinate[0], coordinate[1], coordinate[2]));
    						viewer.scene.view.pitch = 0;
    						viewer.scene.view.yaw = 0;
    					}
    				}
			    }
			});
			$(".insert").click(function(){
			    let aRoot = viewer.scene.annotations; 
			    var comment = $("#comment").val();
			    var details = $("#details").val();
			    if(comment == ""){
			        $("#comment").css({"border":"1px solid red"});
			        $("#comment").focus();
			        alert("Por favor, insira um comentário!");
			        return false;
			    }
				$(".mask,#modal_create").toggle();
			    var coord_x = comment_coordinate.x, coord_y = comment_coordinate.y, coord_z = comment_coordinate.z;
                $.ajax({
                    url: 'comments/insert_comment.php', 
                    type: 'POST',
                    data: {coord_x:coord_x, coord_y:coord_y, coord_z:coord_z, comment:comment, details:details},
                    success: function(data){
		                //add_comment = new Potree.Annotation({ title: comment, description: data,position: [coord_x,coord_y,coord_z], cameraPosition: [coord_x,coord_y+1,coord_z], cameraTarget: [coord_x,coord_y-1,coord_z], 'actions': [{ 'icon': 'assets/Webscan_configuracoes-da-nuvem.svg', 'onclick': function(){ $('#modal_edit,.mask').toggle(); $('#modal_edit #comment').val(comment); $('#modal_edit #details').val(details); $('#modal_edit #comment_id').val(data); } }] });
		                add_comment = new Potree.Annotation({ title: comment, description: details, position: [coord_x,coord_y,coord_z], cameraPosition: [coord_x,coord_y+1,coord_z], cameraTarget: [coord_x,coord_y-1,coord_z], 'actions': [{ 'icon': 'assets/Webscan_configuracoes-da-nuvem.svg', 'onclick': function(){ edit_comment(data); } }] });
		                aRoot.add(add_comment);
		                document.location.reload(true);
                    }
                });
                $('#potree_annotation_container').show();
			});
			/*
			$(".update").click(function(){
			    let aRoot = viewer.scene.annotations; 
			    var comment = $("#comment_update").val();
			    var details = $("#modal_edit #details").val();
			    var id = $("#modal_edit #comment_id").val();
			    if(comment == ""){
			        $("#comment_update").css({"border":"1px solid red"});
			        $("#comment_update").focus();
			        alert("Por favor, insira um comentário!");
			        return false;
			    }
                $.ajax({
                    url: 'comments/update_comment.php', 
                    type: 'POST',
                    data: {comment:comment, details:details, id:id},
                    success: function(data){
                        console.log("Comentário:"+id+" atualizado.");
                        let annotations = viewer.scene.getAnnotations();
                        annotations.children.forEach(anno => {
                            if(anno.description == id){
                                anno.title = comment;
                        	    anno.dispose();
                            }
                        });
                        document.location.reload(true);
                    }
                });
                $(".mask,#modal_edit").toggle();
                $('#potree_annotation_container').show();
			});
			$(".delete").click(function(){
			    var id = $("#modal_edit #comment_id").val();
			    let annotations = viewer.scene.getAnnotations();
                annotations.children.forEach(anno => {
                    if(anno.description == id){
                        annotations.remove(anno);
                	    anno.dispose();
                    }
                });
				$(".mask,#modal_edit").toggle();
                $.ajax({
                    url: 'comments/delete_comment.php', 
                    type: 'POST',
                    data: {id:id},
                    success: function(data){
                        console.log("Comentário:"+id+" removido.");
                        document.location.reload(true);
                    }
                });
			});
			$("#comment_button").click(function(){
			    let measuringTool = new Potree.MeasuringTool(viewer);
			    let measurement = measuringTool.startInsertion({
					showDistances: false,
					showAngles: false,
					showCoordinates: true,
					showArea: false,
					closed: true,
					maxMarkers: 1,
					name: 'Point'});

				let measurementsRoot = $("#jstree_scene").jstree().get_json("measurements");
				let jsonNode = measurementsRoot.children.find(child => child.data.uuid === measurement.uuid);
				$.jstree.reference(jsonNode.id).deselect_all();
				$.jstree.reference(jsonNode.id).select_node(jsonNode.id);
			});
			/* COMMENTS LIST */
			$("#comments_list_button").click(function(){
			    $(".comments_list_modal, .mask").show();
			    $(".comments_list_modal .content tbody tr").remove();
                $.ajax({
                    url: 'comments/comments_list.php', 
                    type: 'POST',
                    fail: function(){
                        alert("Não foi possível recuperar os comentários. Recarregue a página e tente novamente.");
                    },
                    success: function(data){
                        $.each(JSON.parse(data), function (key, c) {
                            if(c.category == "image"){
                                $(".comments_list_modal .content tbody").append('<tr><td>'+c.comment+'</td><td title="'+c.description+'">'+c.description+'</td><td title="Panorâmica">Panorâmica</td><td><a href="'+c.link_to_cloud+'" alt="Ver na Nuvem" title="Ver na Nuvem" target="_blank"><img src="assets/Webscan_nuvem-de-pontos.svg"/></a><a href="'+c.link_to_image+'" alt="Ver imagem 360º" title="Ver imagem 360º" target="_blank"><img src="assets/Webscan_cenas-360.svg"/></a></td></tr>');
                            }else if(c.category == "cloud"){
								if(c.link_to_image != "-"){
                                    $(".comments_list_modal .content tbody").append('<tr><td>'+c.comment+'</td><td title="'+c.description+'">'+c.description+'</td><td title="Nuvem de Pontos">Nuvem de Pontos</td><td><a href="'+c.link_to_cloud+'" alt="Ver na Nuvem" title="Ver na Nuvem" target="_blank"><img src="assets/Webscan_nuvem-de-pontos.svg"/></a><a href="'+c.link_to_image+'" alt="Ver imagem 360º" title="Ver imagem 360º" target="_blank"><img src="assets/Webscan_cenas-360.svg"/></a></td></tr>');
                                }else{
                                    $(".comments_list_modal .content tbody").append('<tr><td>'+c.comment+'</td><td title="'+c.description+'">'+c.description+'</td><td title="Nuvem de Pontos">Nuvem de Pontos</td><td><a href="'+c.link_to_cloud+'" alt="Ver na Nuvem" title="Ver na Nuvem" target="_blank"><img src="assets/Webscan_nuvem-de-pontos.svg"/></a></td></tr>');
                                }
							}
                        });
                    }
                    
                });
			});
			$(".comments_list_modal .head .comments_list_modal_close").click(function(){
			    $(".comments_list_modal, .mask").hide(); 
			});
			/* --------------- */
        });
    </script>
    <?php
    	if(file_exists("modules/ScansData.js"))
    		echo "<script>$('.360_images').show();</script><script src='modules/ScansData.js'></script>";
        else
    	    echo "<script>
    			$('.360_images').remove();
    		</script>";
    ?>
	<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300&display=swap" rel="stylesheet">
	<!-- SCRIPT TO LOAD ANNOTATIONS -->
	<?php
    	$files = glob("comments/*.json");
    	if(count($files)>0){
    	    echo "<script>let aRoot = viewer.scene.annotations;</script>";
            foreach($files as $file) {
                $filename = basename($file, '.json');
                $comment_id = basename($file, '.json');
                $str = file_get_contents($file);
                $data = json_decode($str, true);
                $x = $data['coord_x']; $y = $data['coord_y']; $z = $data['coord_z']; $comment = $data['comment']; $details = $data['details'];
                //echo "<script>let ".$filename." = new Potree.Annotation({ title: '".$comment."', description:'".$filename."', position: [$x,$y,$z], cameraPosition: [$x,$y+1,$z], cameraTarget: [$x,$y-1,$z], 'actions': [{ 'icon': 'assets/Webscan_configuracoes-da-nuvem.svg', 'onclick': function(){ $('#modal_edit,.mask').toggle(); $('#comment_update').attr('value',".json_encode($comment)."); $('#modal_edit #details').html(".json_encode($details)."); $('#modal_edit #comment_id').val('$filename'); } }] }); aRoot.add($filename); </script>";
                echo "<script>let ".$filename." = new Potree.Annotation({ title: '".$comment."', description:'".$filename."', position: [$x,$y,$z], cameraPosition: [$x,$y+1,$z], cameraTarget: [$x,$y-1,$z], 'actions': [{ 'icon': 'assets/Webscan_configuracoes-da-nuvem.svg', 'onclick': function(){ edit_comment('".$filename."'); } }] }); aRoot.add($filename); </script>";
            }
            echo "<script>$('#potree_annotation_container').show();$('.360_images').attr('src', 'assets/WEbscan_cenas-360-ativo.svg');scenes_image = true;</script>";
    	}
    ?>
	<!-- -->
  </body>
</html>