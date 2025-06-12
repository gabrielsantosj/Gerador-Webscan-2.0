<?php
    $full_url = explode("/", $_SERVER["REQUEST_URI"]);
    array_splice($full_url, count($full_url) -2, 2);
    $base_url = "https://".$_SERVER["HTTP_HOST"].implode("/", $full_url);
    /* CLOUD COMMENTS */
	$cloud_comments_path = "./";
    $comments = glob("$cloud_comments_path{*}", GLOB_BRACE);
    $comments_array = [];
    if(count($comments)>0){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            echo "<h3>Comentários de Nuvem</h3>";
        }
        $diretorio = dir($cloud_comments_path);
        while($arquivo = $diretorio -> read()){
            if($arquivo != "." && $arquivo != ".."){
                if(!strpos($arquivo, ".php") !== false) {
                    $report = array();
                    $json = file_get_contents($arquivo); 
                    $json_data = json_decode($json,true);
                    $full_coordinate = str_replace(".",",", $json_data["coord_x"]).",".str_replace(".",",", $json_data["coord_y"]).",".str_replace(".",",", $json_data["coord_z"]);
                    $link_to_cloud = $base_url."/index.php#".$full_coordinate;
                    //IDENTIFICAR CENA
                    $scenes_list = fopen("../modules/ScansData.txt","r");
                    if($scenes_list){
                        while (($line = fgets($scenes_list)) !== false) {
                            $coord = explode("=", $line);
                            $coords = explode(",", $coord[1]);
                            $distance = sqrt(pow(floatval($json_data["coord_x"]) - floatval($coords[0]) ,2) + pow(floatval($json_data["coord_y"]) - floatval($coords[1]), 2) + pow(floatval($json_data["coord_z"]) - floatval($coords[2]), 2));
                            array_push($report, ["distance" => $distance, "name" => $coord[0]]);
                        }
                        sort($report);
                        $link_to_image = $base_url."/modules/md/".$report[0]["name"]."/index.php";
                        array_push($comments_array, ["scene" => "-","comment" => $json_data["comment"], "description" => @$json_data["details"], "coordinate" => $full_coordinate, "link_to_image" => $link_to_image, "link_to_cloud" => $link_to_cloud, "category" => "cloud"]);
                        fclose($scenes_list);
                    }else{
                        $link_to_image = "-";
                        array_push($comments_array, ["scene" => "-","comment" => $json_data["comment"], "description" => @$json_data["details"], "coordinate" => $full_coordinate, "link_to_image" => $link_to_image, "link_to_cloud" => $link_to_cloud, "category" => "cloud"]);
                    }
                    if($_SERVER['REQUEST_METHOD'] != 'POST'){
                        if(@$json_data["details"] != ""){
                            echo "Comentário: ".$json_data["comment"]." | Descrição: ".$json_data["details"]." | Coordenada (X,Y,Z): ".$full_coordinate." | <a href='$link_to_cloud' target='_blank'>Ver na Nuvem</a><br>";
                        }else{
                            echo "Comentário: ".$json_data["comment"]." | Coordenada (X,Y,Z): ".$full_coordinate." | <a href='$link_to_cloud' target='_blank'>Ver na Nuvem</a><br>";
                        }   
                    }
                }
            }
        }
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            echo "<br><hr/>";
        }
    }
    /* -------------------- */
    $dir = "../modules/md/";
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        echo "<h3>Comentários de Imagens 360º</h3>";
    }
	foreach (glob ($dir."*", GLOB_ONLYDIR) as $pastas) {
		if (is_dir ($pastas)) {
		    $directory_splitted = explode("/", $pastas);
			$a = opendir("$pastas"."/hotspots/comments");
			while ($m = readdir($a)) {
			    if($m == "." || $m == ".."){ }else{
			        if(strpos($m, ".json") !== false) {
			            $report = array();
			            $json = file_get_contents("$pastas"."/hotspots/comments/".$m); 
                        $json_data = json_decode($json,true);
                        $link_to_image = $base_url."/modules/md/".$directory_splitted[3]."/index.php";
                        //IDENTIFICAR CENA
                        $scenes_list = fopen("../modules/ScansData.txt","r");
                        if($scenes_list){
                            while (($line = fgets($scenes_list)) !== false) {
                                $coord = explode("=", $line);
                                if($coord[0] == $directory_splitted[3]) {
                                    $link_to_cloud = $base_url."/index.php#".str_replace(".",",", $coord[1]);
                                }
                            }
                            fclose($scenes_list);
                        }
                        array_push($comments_array, ["scene" => $directory_splitted[3], "comment" => $json_data["text"], "description" => @$json_data["description"], "coordinate" => str_replace(".",",", $coord[1]), "link_to_cloud" => $link_to_cloud, "link_to_image" => $link_to_image, "category" => "image"]);
                        if($_SERVER['REQUEST_METHOD'] != 'POST'){
                            if(@$json_data["description"] != ""){
                                echo "Cena: ".$directory_splitted[3]." | Comentário: ".$json_data["text"]." | Descrição: ".@$json_data["description"]." | <a href='$link_to_image' target='_blank'>Imagem 360º</a><br>";   
                            }else{
                                echo "Cena: ".$directory_splitted[3]." | Comentário: ".$json_data["text"]." | <a href='$link_to_image' target='_blank'>Imagem 360º</a><br>";
                            }  
                        }
			        }
			    }
			    /*
				if($m == "." || $m == ".."){ }else{
					if(is_dir("$pastas/$m")){
						copy("../modules/index-plugin.html", "$pastas/$m/index.php");
					}
				}
				*/
			}
		}
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	    echo json_encode($comments_array);
	}
?>