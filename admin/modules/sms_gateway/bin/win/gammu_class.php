<?php
class gammu {

	function __construct(){
	$this->gammu = PATH;
		if (!file_exists($this->gammu)) {
			$this->error("<div class='warning'>".PATH."Can not found <b><u>{$this->gammu}</u></b> or Gammu is not installed\r\n</div>");
		} else {
			$this->Identify();
		}
	}

	function Identify(){
	    $cmd = shell_exec(PATH."gammu -c ".PATH."\gammurc identify");
	    $cmd_arr = explode("\n", $cmd);
	    $this->msg = '<div class="infoBox" style="color:black;"><ol>';
	    foreach ($cmd_arr as $key => $value) {
	        $this->msg .= '<li>'.$value."</li>";
	     }
	     $this->msg .='</ol>';

	     if (substr_count($this->msg, 'Device')){
	     	$this->msg .= '<b>Device Ready Connected, klik start button to start service</b>'; 
	     	//$this->msg .= $status;
	     }
	     elseif (substr_count($this->msg, 'exist')){
	     	$this->msg .= '<b>Device Not Found</b>'; 
	     }
	     else{
	     	$this->msg .= '<b>Please Insert Phone Modem or Check Setting Phone/Modem</b>'; }
	     
	     $this->msg .='</div>';
	     $_SESSION['identify'] = $this->msg;
	    return $this->msg;
	}


    function status(){   
	    exec("net start > ".PATH."service.log");
	    $handle = fopen(PATH."service.log", "r");
	    $baristeks = '';
	    while (!feof($handle)) { $baristeks .= fgets($handle);}
	    fclose($handle);
	    $html = substr_count($baristeks, 'Gammu SMSD Service (SLiMS_Gateway)')?true:false;
	    return $html;
	}

    function start(){  	
    	if($this->status() == false){
        $cmd .= exec(PATH."gammu-smsd -c ".PATH."smsdrc -n SLiMS_Gateway -i")."\n";
        $cmd .= exec("sc config SLiMS_Gateway start= auto")."\n";
        $cmd .= exec("sc start SLiMS_Gateway")."\n";
        $html = true;
    	}
    	else{
    	$html = true;
    	}
        return $html;
    }

	function stop(){
		$cmd  = exec("sc stop SLiMS_Gateway"); 
        $cmd .= exec(PATH."gammu-smsd -c ".PATH."smsdrc -n SLiMS_Gateway -u");
        return $cmd;

	}

    function error($e,$exit=0) {
		echo $e."\n";
		if ($exit == 1) { exit; }
	}


}
