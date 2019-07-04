<?php	
	
	function api_get_plugin_chamilo_bridge_access_url($plugin, $variable,$accessUrl){
		
		$variableName = $plugin.'_'.$variable.$accessUrl;
		
		$params = [
			'category = ? AND subkey = ? AND variable = ?' => [
				'Plugins',
				$plugin,
				$variableName,
			],
		];
		$table = Database::get_main_table(TABLE_MAIN_SETTINGS_CURRENT);
		
		$result = Database::select(
			'selected_value',
			$table,
			array('where' => $params),
			'one'
		);
		if ($result) {
			$result = $result['selected_value'];
			return $result;
		}
		return null;
	}
	
	function url_origin_chamilo_bridge_access_url( $s, $use_forwarded_host = false ){
		$ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
		$sp       = strtolower( $s['SERVER_PROTOCOL'] );
		$protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
		$port     = $s['SERVER_PORT'];
		$port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
		$host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
		$host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
		return $protocol . '://' . $host;
	}

	function full_url_chamilo_bridge_access_url( $s, $use_forwarded_host = false ){
		return url_origin_chamilo_bridge_access_url( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
	}

	function get_url_chamilo_bridge_url($clp){

		$directory = '';
		$path = '';

		$req = "SELECT course.directory,c_lp.path FROM c_lp
		INNER JOIN course ON course.id = c_lp.c_id 
		WHERE c_lp.id = $clp " ;
		
		$resultset = Database::query($req);
		
		while ($row = Database::fetch_array($resultset)){

			$directory = $row['directory'];
			$path = $row['path'];
			
		}
		
		$result = array();

		$path =  str_replace("/.", "",$path);
		$path =  str_replace('/.', "",$path);

		$src = "app/courses/$directory/scorm/$path";
		
		$src =  str_replace("/.", "",$src);
		$src =  str_replace('/.', "",$src);
		
		$src =  str_replace("//main//", "/",$src);
		$src =  str_replace('//main//', "/",$src);

		$result["WEB_PATH"] = api_get_path(WEB_CODE_PATH).$src;


		$result["WEB_PATH"] = str_replace("/main/", "/",$result["WEB_PATH"]);
		$result["WEB_PATH"] = str_replace("/main/", "/",$result["WEB_PATH"]);

		$result["SYS_PATH"] = api_get_path(SYS_CODE_PATH).$src;
		$result["SYS_PATH"] = str_replace("/main/", "/",$result["SYS_PATH"]);
		$result["SYS_PATH"] = str_replace("/main/", "/",$result["SYS_PATH"]);

		$result["DIR_PATH"] = api_get_path(SYS_CODE_PATH);
		$result["DIR_PATH"] = str_replace("/main/", "/",$result["DIR_PATH"]);
		$result["DIR_PATH"] = str_replace("/main/", "/",$result["DIR_PATH"]);
		
		$result["DIRECTORY"] = $directory;
		$result["PATH"] = $path;

		return $result;

	}

	function rewriteHtmlToLocal($srH,$basePath){

		$srH =  str_replace('javascript" src="','javascript" src="'.$basePath.'/',$srH);
		
		$srH =  str_replace('rel="stylesheet" href="css/','rel="stylesheet" href="'.$basePath.'/css/',$srH);

		return $srH;
	}

	function recurseCopyToLocal($src,$dst){ 
		
		$dir = opendir($src);

		@mkdir($dst); 
		
		while(false !== ( $file = readdir($dir)) ) { 
			if (( $file != '.' ) && ( $file != '..' )) { 
				if(is_dir($src.'/'.$file)){
					recurseCopyToLocal($src . '/' . $file,$dst . '/' . $file); 
				}else{ 
					$fileCtr = $src.'/'.$file;
					if(strrpos($fileCtr,".xsd")===false){
						if(strrpos($fileCtr,"index.html")===false){
							if(strrpos($fileCtr,".xsd")===false){
								if(strrpos($fileCtr,"imsmanifest.xml")===false){
									if(!file_exists($dst.'/'.$file)){
										copy($fileCtr,$dst.'/'.$file);
									}
								}
							}
						}
					}
					

					
				} 
			} 
		}
		
		closedir($dir); 
	
	}