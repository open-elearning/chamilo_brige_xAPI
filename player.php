<?php

    require_once __DIR__.'/../../main/inc/global.inc.php';
    
    require_once("inc/fonctions.php");

    $cidReq = isset($_GET['cidReq']) ? Security::remove_XSS($_GET['cidReq']):'';
    $lp_id = isset($_GET['lp_id']) ? Security::remove_XSS($_GET['lp_id']):0;
    
    //app/courses/USINAGE/scorm/qui-mange-qui/index.html

    $result = get_url_chamilo_bridge_url($lp_id);
    
    //echo $result["WEB_PATH"].'/index.html<br>';
    //echo $result["SYS_PATH"].'/index.html<br>';

    if(file_exists($result["SYS_PATH"].'/index.html')){
        
        $directory = strtolower($result["DIRECTORY"]);

        $courseCache = 'player/'.$directory;
        if(!file_exists($courseCache)){
            mkdir('player/'.$directory.'/', 0777, true);
        }
        $finalCache = 'player/'.$directory.'/'.strtolower($result["PATH"]);
        if(!file_exists($finalCache)){
            mkdir('player/'.$directory.'/'.strtolower($result["PATH"]), 0777, true);
        }

        $finalPathCache =  $result["DIR_PATH"].'/plugin/chamilo_brige_xapi/player/'.$directory.'/'.strtolower($result["PATH"]);
        $finalCache = $finalPathCache.'/cache.php';

        $srcH = file_get_contents($result["SYS_PATH"].'/index.html');
        $srcH = rewriteHtmlToLocal($srcH,$result["WEB_PATH"]);

        recurseCopyToLocal($result["SYS_PATH"],$finalPathCache);

        $fd = fopen( $finalCache ,'w');	
        fwrite($fd,$srcH);
        fclose($fd);

    }


