<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");

include("../lang/admin.php");
echo "<html><title>Test FDT</title>
<link rel=stylesheet href=../styles/basic.css type=text/css>\n";
echo "<font size=1 face=arial> &nbsp; &nbsp; Script: default_update.php<BR>";
global $ValorCapturado;
include("actualizarregistro.php");
require_once ('plantilladeingreso.php');

function VariablesDeAmbiente($var,$value){
global $arrHttp;


		if (substr($var,0,3)=="tag") {
			$ixpos=strpos($var,"_");
			if ($ixpos!=0) {
				$occ=explode("_",$var);
				if (trim($value)!=""){
					$value="^".trim($occ[2]).$value;
					$var=$occ[0]."_".$occ[1];
					if (is_array($value)) {
						$value = implode("\n", $value);
					}
					if (isset($arrHttp[$var])){
						$arrHttp[$var].=$value;
					}else{
						$arrHttp[$var]=$value;
					}
				}
			}else{
				if (is_array($value)) {
			   		$value = implode("\n", $value);
				}
				if (isset($arrHttp[$var])){
					$arrHttp[$var].="\n".$value;
				}else{
					$arrHttp[$var]=$value;
				}
			}
		}else{
			if (trim($value)!="") $arrHttp[$var]=$value;
		}
}

if (isset($_GET)){
	foreach ($_GET as $var => $value) {
		VariablesDeAmbiente($var,$value);
	}
}if (isset($_POST)){
	foreach ($_POST as $var => $value) {
		VariablesDeAmbiente($var,$value);
	}
}


foreach ($arrHttp as $var => $value) {
	if (substr($var,0,3)=="tag" ){
		$tag=explode("_",$var);
		if (substr($var,0,3)=="sta" ){
			$tag[0]="tag".substr($tag[0],3);
		}
		if (isset($variables[$tag[0]])){

			$variables[$tag[0]].="\n".$value;
			$valortag[substr($tag[0],3)].="\n".$value;
		}else{
			$variables[$tag[0]]=$value;
			$valortag[substr($tag[0],3)]=$value;
		}
   	}

}
//foreach ($valortag as $key => $value) echo "$key=$value<br>";
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";

//foreach ($variables as $tag=>$value)  echo "$var=$value<br>";
include("../config.php");
$base=$arrHttp["base"];
$arrHttp["cipar"]="$base.par";
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
$fp=file($archivo);
global $vars;
$ix=-1;
foreach ($fp as $value){

	$ix=$ix+1;
	$vars[$ix]=$value;
}
$default_values="S";
ActualizarRegistro();
$_SESSION["valdef"]=$ValorCapturado;
echo "<br><br><h4>".$msgstr["valdef"]." ".$msgstr["actualizados"]."</h4>";
//echo $ValorCapturado;




?>