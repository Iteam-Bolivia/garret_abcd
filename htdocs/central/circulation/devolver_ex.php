<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      devolver_ex.php
 * @desc:      Returns a loan
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");
date_default_timezone_set('UTC');
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
//die;

//función para calcular la diferencia de tiempo entre dos fecha
function compareDate ($FechaP){
global $arrHttp,$config_date_format;	$dia=substr($FechaP,6,2);
	$mes=substr($FechaP,4,2);
	$year=substr($FechaP,0,4);
	$exp_date=$year."-".$mes."-".$dia;
	if (isset($arrHttp["fecha_dev"])){		$f=explode("/",$arrHttp["fecha_dev"]);		if ($config_date_format=="DD/MM/YY"){			$todays_date=$f[2]."-".$f[1]."-".$f[0];		}else{			$todays_date=$f[2]."-".$f[0]."-".$f[1];		}
	}else{		$todays_date = date("Y-m-d");	}
	$today = strtotime($todays_date);
	$expiration_date = strtotime($exp_date);
	$diff=$expiration_date-$today;
	$diff=$diff/(60 * 60 * 24);
    return $diff;
}//end Compare Date

function ReservesAssign($key){
global $xWxis,$Wxis,$db_path,$msgstr;
	echo $key;
	$IsisScript=$xWxis."cipres_usuario.xis";
	$Formato=$db_path."reserve/pfts/".$_SESSION["lang"]."/tbreserve.pft";
	$Pft="v10'|',v30,'|'ref(['users']l(['users']'CO_'v10),v30),/" ;
	$query="&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=".$key."&Pft=$Pft";
	include("../common/wxis_llamar.php");
	foreach ($contenido as $value) echo "$value<br>";
	die;
}

//Calculo de la sanción por atraso
include("sanctions_inc.php");
if (isset($arrHttp["vienede"])){   // viene del estado de cuenta	$items=explode('$$',trim(urldecode($arrHttp["searchExpr"])));}else{
	$items=explode("\n",trim(urldecode($arrHttp["searchExpr"])));
}
$resultado="";
$recibo="";
$Mfn_rec="";
$errores="";
$devueltos="";
$cn_l="";
foreach ($items as $num_inv){
//Se ubica el ejemplar prestado en la base de datos de transacciones
	$num_inv=trim($num_inv);
	$inven=$num_inv;
	if ($num_inv!=""){
		$num_inv="TR_P_".$num_inv;
		if (!isset($arrHttp["base"])) $arrHttp["base"]="trans";
		$Formato="v10'|$'v20'|$'v30'|$'v35'|$'v40'|$'v45'|$'v70'|$'v80'|$'v100,'|$',v40,'|$'v400,'|$'v500,'|$',v95,'|$',v98/";
		$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&count=1&Expresion=".$num_inv."&Pft=$Formato";
		$contenido="";
		$IsisScript=$xWxis."buscar_ingreso.xis";
		include("../common/wxis_llamar.php");
		$Total=0;
		foreach ($contenido as $linea){			$linea=trim($linea);
			if ($linea!="") {
				$l=explode('|$',$linea);
				if (substr($linea,0,6)=="[MFN:]"){					$Mfn=trim(substr($linea,6));				}else{					if (substr($linea,0,8)=="[TOTAL:]"){						$Total=trim(substr($linea,8));					}else{						$prestamo=$linea;					}
				}
			}
		}
		$error="";
		if ($Total==0){
			$errores.=";".$inven;
		}
// se extrae la información del ejemplar a devolver
		if ($Total>0){
			$p=explode('|$',$prestamo);
			$cod_usuario=$p[1];
			$arrHttp["usuario"]=$cod_usuario;
			$inventario=$p[0];
			$fecha_p=$p[2];
			$hora_p=$p[3];
			$fecha_d=$p[9];   //fecha de devolución en formato ISO
			$hora_d=$p[5];
			$tipo_usuario=$p[6];
			$tipo_objeto=$p[7];
			$referencia=$p[8];
			$ppres=$p[10];
			$ncontrol=$p[12];
			$bd=$p[13];
			// se lee la política de préstamos
			include_once("loanobjects_read.php");
			// se lee el calendario
			include_once("calendario_read.php");
			// se lee la configuración local
			include_once("locales_read.php");

			//se determina la política a aplicar
			if ($ppres==""){				if (isset($politica[$tipo_objeto][$tipo_usuario])){
	    			$ppres=$politica[$tipo_objeto][$tipo_usuario];
				}
				if (trim($ppres)==""){
					if (isset($politica[0][$tipo_usuario])) {
						$ppres=$politica[0][$tipo_usuario];
					}
				}
				if (trim($ppres)==""){
					if (isset($politica[$tipo_usuario][0])){
	    				$ppres=$politica[$tipo_usuario][0];
	  				}
				}
				if (trim($ppres)==""){
					if (isset($politica["0"]["0"])){
						$ppres=$politica["0"]["0"];
					}
				}
			}
			$p=explode('|',$ppres);
			$lapso=$p[3];
			$unidad=$p[5];
			$u_multa= $p[7];      //unidades de multa
			$u_multa_r= $p[8];    //unidades de multa si el libro está reservado
			$u_suspension=$p[9];  //unidades de suspensión
			$u_suspension=$p[10];  //unidades de suspensión si el libro está reservado
		    $devolucion=date("Ymd");
			$ValorCapturado="0001X\n0500$devolucion\n";
			$ValorCapturado.="0130^a".$_SESSION["login"]."^b".date("Ymd H:i:s");
			$ValorCapturado=urlencode($ValorCapturado);
			$IsisScript=$xWxis."actualizar_registro.xis";
			$Formato="";

			if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/r_return.pft")){
				$Formato=$db_path."trans/pfts/".$_SESSION["lang"]."/r_return";
			}else{
				if (file_exists($db_path."trans/pfts/".$lang_db."/r_return.pft")){
					$Formato=$db_path."trans/pfts/".$lang_db."/r_return";
				}
			}
			if ($Formato!="") {                $Formato="&Formato=$Formato";
			}
			$query = "&base=trans&cipar=$db_path"."par/trans.par&login=".$_SESSION["login"]."&Mfn=".$Mfn."&ValorCapturado=".$ValorCapturado."$Formato";
			include("../common/wxis_llamar.php");
            if ($Formato!=""){
            	foreach ($contenido as $r){            		$recibo.=trim($r);            	}
            }
            $resultado.=";".$inventario;
            $Mfn_rec.=";".$Mfn;
			// si está atrasado se procesan las multas y suspensiones
			$atraso=compareDate ($fecha_d);
			if ($politica==""){				$error="&error=".$msgstr["nopolicy"]." $tipo_usuario / $tipo_objeto";			}else{
				if ($atraso<0){
					$atraso=abs($atraso);
					Sanciones($fecha_d,$atraso,$arrHttp["usuario"],$inventario,$ppres);
					$resultado.=" ".$msgstr["overdue"];
				}
			}
			//SE LEEN LAS RESERVAS Y AL PRIMER USUARIO DE LA COLA SE LE COLOCA LA FECHA DE DEVOLUCION QUE NO TENGA
			//FECHA DE DEVOLUCION SE LE ASIGNA ESTA FECHA
			$cn_l.=";CN_".$bd."_".$ncontrol;

		}
	}
}
//die;
$cu="";
$recibo="";


if (isset($arrHttp["usuario"]))
	$cu="&usuario=".$arrHttp["usuario"];
else
	$cu="&usuario=$cod_usuario";
if (isset($arrHttp["reserve"])){
	$reserve="&reserve=\"S\"";
}else{
	$reserve="";
}
if (isset($arrHttp["vienede"]) or isset($arrHtp["reserve"])){
	header("Location: usuario_prestamos_presentar.php?devuelto=S&encabezado=s&resultado=".urlencode($resultado)."$cu&rec_dev=$Mfn_rec"."&inventario=".$arrHttp["searchExpr"]."&lista_control=".$cn_l.$reserve);}else{
	header("Location: devolver.php?devuelto=S&encabezado=s$error$cu&rec_dev=$Mfn_rec"."&inventario=".$devueltos."&errores=$errores"."&lista_control=".$cn_l);
}
die;

function ImprimirRecibo($recibo_arr){
	$salida="";
	foreach ($recibo_arr as $Recibo){
		$salida=$salida.$Recibo;
	}
?>
<script>
	msgwin=window.open("","recibo","width=400, height=300, scrollbars, resizable")
	msgwin.document.write("<?php echo $salida?>")
	msgwin.focus()
	msgwin.print()
	msgwin.close()
</script>
<?php
}

?>
?>