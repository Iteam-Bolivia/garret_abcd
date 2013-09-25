<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
	<head>
		<title>Abogados</title>
		<meta http-equiv="Expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />
<?php
	if (isset($cisis_ver) and $cisis_ver=="unicode/"){
		//echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1256\" />";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
	}else{
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" />";
	}
?>
		<meta name="robots" CONTENT="NONE" />
		<meta http-equiv="keywords" content="" />
		<meta http-equiv="description" content="" />
		<!-- Stylesheets -->
		<link rel="stylesheet" rev="stylesheet" href="../css/template.css" type="text/css" media="screen"/>
		<!--[if IE]>
			<link rel="stylesheet" rev="stylesheet" href="../css/bugfixes_ie.css" type="text/css" media="screen"/>
		<![endif]-->
		<!--[if IE 6]>
			<link rel="stylesheet" rev="stylesheet" href="../css/bugfixes_ie6.css" type="text/css" media="screen"/>
		<![endif]-->
<?php if (isset($context_menu) and $context_menu=="N"){
?>
<script>

 var isNS = (navigator.appName == "Netscape") ? 1 : 0;
  if(navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);
  function mischandler(){
   return false;
 }
  function mousehandler(e){
 	var myevent = (isNS) ? e : event;
 	var eventbutton = (isNS) ? myevent.which : myevent.button;
    if((eventbutton==2)||(eventbutton==3)) return false;
 }
 document.oncontextmenu = mischandler;
 document.onmousedown = mousehandler;
 document.onmouseup = mousehandler;

  </script>
<?php }?>
</head>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="heading">
	<div class="institutionalInfo">
		<h1><img src=../images/logoabcd.jpg><?php echo $institution_name?></h1>
	</div>
	<div class="userInfo">
		<span><?php echo $_SESSION["nombre"]?></span>,
		<?php echo $_SESSION["profile"]?> |
		<?php  $dd=explode("/",$db_path);
               if (isset($dd[count($dd)-2])){
			   		$da=$dd[count($dd)-2];
			   		echo " (".$da.") ";
				}
		?> |
<?php

if (isset($_SESSION["newindow"]) or isset($arrHttp["newindow"])){
	echo "<a href='javascript:top.location.href=\"../dataentry/logout.php\";top.close()' xclass=\"button_logout\"><span>[logout]</span></a>";
}else{
	echo "<a href=\"../dataentry/logout.php\" xclass=\"button_logout\"><span>[logout]</span></a>";
}
?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper"> 
        <a href = ../documentacion/quienes.php target=_blank>Quienes somos</a>&nbsp &nbsp;
	<a href =../documentacion/informa_a_un_amigo.php target=_blank>Informa a un Amigo</a>&nbsp &nbsp;
        <a href =../statistics/tables_generate.php target=_blank>Estadistica</a>&nbsp &nbsp;
        <a href =../documentacion/biblioteca.php target=_blank>Biblioteca</a>&nbsp &nbsp;
        <a href =../documentacion/Contacto.php target=_blank>Contactos</a>&nbsp &nbsp;
        <a href = ../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]."/$ayuda"?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
 <?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])){
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/$ayuda target=_blank>".$msgstr["edhlp"];
	echo "</a>
		<font color=white>&nbsp; &nbsp; Script: homepage.php </font>"; 
        
}
?>
</div>
<div class="middle homepage">
  <p>&nbsp;<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";//die;
include("../config.php");

include ("leerregistroisispft.php");
include ("../lang/admin.php");
// Busqueda libre



function EjecutarBusqueda(){
global $arrHttp,$db_path,$xWxis,$tagisis,$Wxis,$wxisUrl;
		$vienede=$arrHttp["Opcion"];
		if ($arrHttp["Opcion"]!="continuar" and $arrHttp["Opcion"]!="buscar_en_este"){
			$Expresion=PrepararBusqueda();
		}else{
		 	$Expresion=stripslashes($arrHttp["Expresion"]);
			$arrHttp["Opcion"]="busquedalibre";
		}
		$Expresion=urlencode(trim($Expresion));
		if ($arrHttp["desde"]!="dataentry"){
			if (!isset($arrHttp["from"])) $arrHttp["from"]=1;
			if (!isset($arrHttp["Mfn"])) $arrHttp["Mfn"]=$arrHttp["from"];
			if (isset($arrHttp["from"]))$arrHttp["count"]=1;
			if (!isset($arrHttp["Formato"]))$arrHttp["Formato"]="ALL";
			$Formato=$arrHttp["Formato"];
			if ($Formato!="ALL" ){
				$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$Formato;
			}
			$IsisScript=$xWxis."buscar.xis";
			$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Expresion=".$Expresion."&Opcion=".$arrHttp["Opcion"]."&count=".$arrHttp["count"]."&Mfn=".$arrHttp["Mfn"]."&Formato=$Formato";
	//			echo $query;
 			include("../common/wxis_llamar.php");
			foreach ($contenido as $linea){
				if (trim($linea)!="") {
				    echo "$linea\n";
				}
			}
		}else{
			if ($vienede=="buscar_en_este"){
				echo "<script>
						window.opener.top.browseby=\"search\"
						window.opener.top.Expresion=\"".$Expresion."\"
						window.opener.top.mfn=1
						window.opener.top.Menu(\"ejecutarbusqueda\");
						self.close()
					</script>
				";
			}else{
				echo "<script>
						top.browseby=\"search\"
						top.Expresion=\"".$Expresion."\"
						top.Expre_b=\"".urldecode($Expresion)."\"
						top.mfn=1
						top.Menu(\"ejecutarbusqueda\");
					</script>
				";
			}
		}
}


// con el login y el password suministrado, se ubica el registro que se va a actualizar
function UbicarRegistro(){
global $arrHttp,$OS,$xWxis,$Wxis;
		if ($arrHttp["Opcion"]=="ubicar"){
			$Expresion="!E".$arrHttp["login"]."*!X".$arrHttp["password"];
		}else{
			$Expresion=PrepararBusqueda();
		}
		$arrHttp["Opcion"]="buscar";

		$Expresion=urlencode(trim($Expresion));
//		if ($arrHttp["Formato"]=="") $arrHttp["Formato"]=$arrHttp["base"].".pft";
		$IsisScript="buscar.xis";
		$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&login=".$arrHttp["login"]."&password=".$arrHttp["password"]."&Expresion=".$Expresion."&Opcion=".$arrHttp["Opcion"]."&Formato=$db_path".$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["Formato"]."&Path=".$arrHttp["Path"];
		include("../common/wxis_llamar.php");
		foreach ($contenido as $linea){
			echo "$linea\n";
		}
}

// Prepara la f�rmula de b�squeda cuando viene de la b�squeda avanzada

function PrepararBusqueda(){
global $arrHttp,$matriz_c,$camposbusqueda;

	if (!isset($arrHttp["Campos"])) $arrHttp["Campos"]="";
	$expresion=explode(" ~~~ ",$arrHttp["Expresion"]);
	$campos=explode(" ~~~ ",$arrHttp["Campos"]);
	if (isset($arrHttp["Operadores"])){
		$operadores=explode(" ~~~ ",$arrHttp["Operadores"]);
	}
	if (isset($arrHttp["Prefijos"])){
		$prefijos=explode(" ~~~ ",$arrHttp["Prefijos"]);
	}
	// se analiza cada sub-expresion para preparar la f�rmula de b�squeda
	$nse=-1;
	for ($i=0;$i<count($expresion);$i++){
		$expresion[$i]=trim(stripslashes($expresion[$i]));
		if ($expresion[$i]!=""){

			$cb=$matriz_c[$prefijos[$i]];
			$cb=explode('|',$cb);
			$pref=trim($cb[2]);
			$pref1='"'.$pref;
			if (substr(strtoupper($expresion[$i]),0,strlen($pref1))==strtoupper($pref1) or substr(strtoupper($expresion[$i]),0,strlen($pref))==strtoupper($pref)){

			}else{

				$expresion[$i]=$pref.$expresion[$i];
			}
			$formula=str_replace("  "," ",$expresion[$i]);
			$subex=Array();
			if (trim($campos[$i])!="" and trim($campos[$i])!="---"){
				$id="/(".trim($campos[$i]).")";
			}else{
				$id="";
			}
			$xor="�or�$pref";
			$xand="�and�$pref";

			$formula=stripslashes($formula);
			while (is_integer(strpos($formula,'"'))){
				$nse=$nse+1;
				$pos1=strpos($formula,'"');
				$xpos=$pos1+1;
				$pos2=strpos($formula,'"',$xpos);
				$subex[$nse]=trim(substr($formula,$xpos,$pos2-$xpos));
				if ($pos1==0){
					$formula="{".$nse."}".substr($formula,$pos2+1);
				}else{
					$formula=substr($formula,0,$pos1-1)."{".$nse."}".substr($formula,$pos2+1);
				}
			}
			$formula=str_replace (" {", "{", $formula);
			$formula=str_replace (" or ", $xor, $formula);
			$formula=str_replace ("+", $xor, $formula);
			$formula=str_replace (" and ", $xand, $formula);
			$formula=str_replace ("*", $xand, $formula);
			$formula=str_replace ('\"', '"', $formula);
		//	if (substr($formula,0,strlen($pref))!=$pref)
		//		$formula=$pref.$formula;
			while (is_integer(strpos($formula,"{"))){
				$pos1=strpos($formula,"{");
				$pos2=strpos($formula,"}");
				$ix=substr($formula,$pos1+1,$pos2-$pos1-1);
				if ($pos1==0){
					$formula=$subex[$ix].substr($formula,$pos2+1);
				}else{
					$formula=substr($formula,0,$pos1)." ".$subex[$ix]." ".substr($formula,$pos2+1);
				}
			}

			$formula=str_replace ("�", " ", $formula);
//			if (substr($formula,0,strlen($pref))!=$pref) $formula=$pref.$formula;
			$expresion[$i]=trim($formula);
		}
	}
	$formulabusqueda="";
	for ($i=0;$i<count($expresion);$i++){
		if (trim($expresion[$i])!=""){
			$formulabusqueda=$formulabusqueda." (".$expresion[$i].") ";
			$resto="";
			for ($j=$i+1;$j<count($expresion);$j++){
				$resto=$resto.trim($expresion[$j]);
			}
			if (trim($resto)!="") $formulabusqueda=$formulabusqueda." ".$operadores[$i];
		}
	}
	return $formulabusqueda;

}

include("../dataentry/formulariodebusqueda.php");



// ------------------------------------------------------
// INICIO DEL PROGRAMA
// ------------------------------------------------------



if (isset($arrHttp['Tabla']) and $arrHttp["Opcion"]!="formab"){
	$arrHttp["Opcion"]="solobusqueda";
}

if (isset($arrHttp["prestamo"])) {
	    unset($arrHttp["Target"]);
	}

if (!isset($arrHttp["prologo"])) {
	    $arrHttp["prologo"]="p";
	}
if (!isset($arrHttp["desde"])) $arrHttp["desde"]="";
if (!isset($arrHttp['count'])) $arrHttp["count"]="10";
// Se carga la tabla con las opciones de b�squeda

	$a= $db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/camposbusqueda.tab";
	$fp=file_exists($a);
	if (!$fp){
		$a= $db_path.$arrHttp["base"]."/pfts/".$lang_db."/camposbusqueda.tab";
		$fp=file_exists($a);
		if (!$fp){
			echo "<br><br><h4><center>".$msgstr["faltacamposbusqueda"]."</h4>";
			die;
		}
	}
	$fp = fopen ($a, "r");
	$fp = file($a);
	foreach ($fp as $linea){
		$linea=trim($linea);
		if ($linea!=""){
            $camposbusqueda[]= $linea;
			$t=explode('|',$linea);
			$pref=$t[2];

			$matriz_c[$pref]=$linea;
		}
	}
//if ($arrHttp["Opcion"]!="cGlobal" and $arrHttp["Opcion"]!="reportes" and $arrHttp["Opcion"]!="stats")
include("../common/header.php");
//echo $arrHttp["Opcion"];
switch ($arrHttp["Opcion"]){

	case "busquedalibre":
		EjecutarBusqueda();
		break;
	case "continuar":
		EjecutarBusqueda();
		break;
	case "formab":
	    $arrHttp["Opcion"]="buscar";
		DibujarFormaBusqueda();
		break;
	case "buscar":
		EjecutarBusqueda();
		break;
	case "ubicar":
		$arrHttp["Formato"]="actual";
		UbicarRegistro();
		break;
	case "buscar_en_este":
		EjecutarBusqueda();
		break;
	case "actualizarportabla":
		$Expresion=PrepararBusqueda();
		header("Location: actualizarportabla.php?base=".$arrHttp["base"]."&cipar=".$arrHttp["cipar"]."&Expresion=".urlencode($Expresion));
		die;
	case "solobusqueda":
	    $Expresion=PrepararBusqueda();
		echo "<script>
				window.opener.document.forma1.Expresion.value=\"$Expresion\"
				self.close()
				</script>
			";
		die;
		break;
}
?></p>


</div>
		<?php

        require_once (dirname(__FILE__)."/../config.php");
        $def = parse_ini_file($db_path."abcd.def");
        //print_r($def);
        ?>

		<div class="footer">
			<div class="systemInfo">
				<strong>Abogados <?php echo $def["VERSION"] ?></strong>
				<span><?php echo $def["LEGEND1"]; ?></span>
				<a href="<?php echo $def["URL1"]; ?>" target=_blank><?php echo $def["URL1"]; ?></a>
			</div>
			<div class="distributorLogo">
				<a href="<?php echo $def["URL2"]; ?>" target=_blank><span><?php echo $def["LEGEND2"]; ?></span></a>
			</div>
			<div class="spacer">&#160;</div>
		</div>

