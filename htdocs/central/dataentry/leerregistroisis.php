<?php

function LeerRegistro($base,$cipar,$from,&$maxmfn,$Opcion,$login,$password,$Formato) {
	$query="";
	if (isset($arrHttp["lock"])){
    	$query = "&base=" . $base . "&cipar=$db_path"."par/".$cipar. "&Mfn=" . $arrHttp["Mfn"]."&login=".$login;
    	include("../common/wxis_llamar.php");
    	$res=implode("|",$contenido);
    	$res=explode("|",$res);
    	$res=trim($res[0]);
    	if ($res!="LOCKGRANTED") {


    $query="";
    if (isset($arrHttp["unlock"])){
    	$IsisScript=$xWxis."unlock.xis";
    	$query = "&base=" . $base . "&cipar=$db_path"."par/".$cipar. "&Mfn=" . $arrHttp["Mfn"]."&login=".$login;
    	include("../common/wxis_llamar.php");
    	$res=implode("",$contenido);
    	$res=trim($res);
    	return $res;
    }

    //SE LEE LA FDT DE LA BASE DE DATOS PARA EXTRAER TODOS LOS CAMPOS
    $archivo="$db_path$base/def/".$_SESSION["lang"]."/$base.fdt";
	if (file_exists($archivo))
		$fpTm = file($archivo);
	else
		$fpTm=file("$db_path$base/def/".$lang_db."/$base.fdt");
	$Pft="";
	if (!$fpTm){
		echo "<script>
			if (top.window.frames.length>0) top.xeditar=''\n";

		echo "</script>\n";
		die;
	foreach ($fpTm as $linea){
		if (trim($linea)!="") {
			$t=explode('|',$linea);
			if ($t[0]=="LDR"){
				$leader_tab="$db_path$base/def/".$_SESSION["lang"]."/leader.fdt";
				if (file_exists($leader_tab))
					$fpLeader = file($leader_tab);
				else
					$fpLeader=file("$db_path$base/def/".$lang_db."/leader.fdt");
							if ($tlead[0]!="LDR")
								$Pft.="if p(v".$tlead[1].") then '".$tlead[1]." 'v".$tlead[1]."'____$$$' fi,";
						}

  			if ($t[0]!="S" and $t[0]!="H" and $t[0]!="L" and $t[0]!="LDR"){
  					$Pft.="(if p(v".$t[1].") then '".$t[1]." 'v".$t[1]."'____$$$' fi),";
  		}
  	}
	$IsisScript=$xWxis."leer.xis";
	$query = "&base=" . $base . "&cipar=$db_path"."par/".$cipar. "&Mfn=" . $arrHttp["Mfn"]."&Opcion=".$Opcion."&login=".$login."&password=".$password;

	if ($Formato!="")
		$query.="&Formato=".$arrHttp["Formato"];
	else
		if ($Pft!="") $query.="&Pft=".urlencode($Pft);
	include("../common/wxis_llamar.php");
    $cont=implode("",$contenido);
    $cont=trim($cont);
    if (substr($cont,0,7)=="MAXMFN:"){
    	$maxmfn=substr($cont,7,$ix-7);
    	//echo "************$maxmfn<p>";
		$arrHttp["Maxmfn"]=$maxmfn;
    	$cont=substr($cont,$ix+2);
    $contenido=explode('____$$$',$cont);
 	$valortag=array();
 	$ic=2;
 	foreach($contenido as $linea){
 		if (trim($linea)!=""){
				$linea=trim(substr($linea,0,strlen($linea)-4));
				$arr=explode('##',$linea);
		   		$mfn=substr(trim($arr[1]),4);
		   		$ic=2;
				$arrHttp["Mfn"]=$mfn;
				$arrHttp["Maxmfn"]=substr(trim($arr[0]),7);
				$maxmfn=$arrHttp["Maxmfn"];
		  	}else{
		   		$linea=trim($linea);
		   		if ($linea!=""){
		    		$pos=strpos($linea, " ");
		    		if (is_integer($pos)) {
		     			$tag_x=trim(substr($linea,0,$pos));
		////El formato ALL env�a un <br> al final de cada l�nea y hay que quitarselo
						if (is_numeric($tag_x) and $tag_x!=""){
				    		$linea=substr($linea, $pos+1);
				    		$tag=$tag_x;
							if ($tag==1002){
					 			$maxmfn=$linea;
							}else{
				     			if (!isset($valortag[$tag])){
				      				$valortag[$tag]=$linea;
				     			}else {
				     	 			$valortag[$tag]=$valortag[$tag]."\n".$linea;
				     			}
				    		}
						}else{
							$valortag[$tag].="\n".$linea;
						}
		   			}else{

		   			}
		  		}
		 	}
		}
	}
 	if (isset($valortag[1102])){
		 	echo "<h1>".$msgstr["recdel"]."</h1>";
		 	$record_deleted="Y";
	 		return;
	 	}
    }
    $record_deleted="N";
 	if (isset($valortag["1002"])) $maxmfn=$valortag["1002"];

}

function LeerRegistroFormateado($Formato) {

global $valortag,$xWxis,$arrHttp,$tagisis,$msgstr,$db_path,$Wxis,$wxisUrl,$lang_db,$MaxMfn,$record_deleted;
 	if ($Formato=="" or $arrHttp["Formato"]=="ALL") {
 		$arrHttp["Formato"]="ALL";
 	}else{
 		if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/" .$Formato.".pft")){
 		}else{
        }
 	}

 	$IsisScript=$xWxis."buscar.xis";
 	$query = "&cipar=$db_path"."par/".$arrHttp["cipar"]. "&Mfn=" . $arrHttp["Mfn"]."&Opcion=".$arrHttp["Opcion"]."&base=" .$arrHttp["base"]."&Formato=$Formato";
	include("../common/wxis_llamar.php");
	$salida="";
	$record_deleted="N";
 	if ($arrHttp["Formato"]=="ALL") {
 		$salida="<font size=3><xmp>";
		foreach ($contenido as $linea) {
			$linea=str_ireplace('<BR>',"\n",$linea);
			$linea=str_ireplace('<BR \>',"\n",$linea);
		 	if ($linea=='$$DELETED'){
		 		$record_deleted="Y";

		 		$salida.= $arrHttp["Mfn"]." ".$msgstr["recdel"];
		 	}else{
			 	$salida.=$linea;
		 	}
		}
		$salida.= "</xmp></font>";
	 }else{
	  	foreach ($contenido as $linea) {
	  		$lines=trim($linea);
	 			$f=explode(",",$ref);
	 			$bd_ref=trim($f[0]);
	 			$pft_ref=trim($f[1]);
	 			$expr_ref=trim($f[2]);
	 			$IsisScript=$xWxis."buscar.xis";
 				$query = "&cipar=$db_path"."par/".$arrHttp["cipar"]. "&Expresion=".$expr_ref."&Opcion=buscar&base=".$bd_ref."&Formato=$pft_ref&prologo=NNN";
				include("../common/wxis_llamar.php");
				foreach($contenido as $linea) $salida.= "$linea\n";
	  		}else{
	  			if (strpos($linea,'$$DELETED')===false){
			 		$salida.= $linea."\n";
		 		}else{
		  			$salida.= "<h1> ".$arrHttp["Mfn"]." ".$msgstr["recdel"]."</h1>";
		  			$record_deleted="Y";
				}
		 	}
	  	}
	 }
	 return $salida;
}
?>