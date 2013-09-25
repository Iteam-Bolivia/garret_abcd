<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      rs02.php
 * @desc:      Reservations with users overdued or with fines or suspended
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

//date_default_timezone_set('UTC');
$debug="";
if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=>$value<br>";  //die;
if (!isset($arrHttp["vp"])) $arrHttp["vp"]="";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");
include("../reserve/reserves_read.php");

$bd=$arrHttp["base"];
$Nombre=$msgstr[$arrHttp["code"]];

function LlamarWxis($IsisScript,$query){global $db_path,$Wxis,$wxisUrl,$xWxis;
	include("../common/wxis_llamar.php");
	return $contenido;}
include("../common/header.php");
include("../common/institutional_info.php");

?>
	<div class="sectionInfo">
	<div class="breadcrumb">
	</div>
	<div class="actions">
		<a href="../circulation/estado_de_cuenta.php?reserve=S" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"];?></strong></span></a>
	</div>

<div class="spacer">&#160;</div>
<div class="middle form">
	<div class="formContent">
<?php
echo "<H3>$Nombre ";
echo "<br>".$msgstr["o_issued"].": ".date("d-m-Y")."</h3>";
echo "<p><table border=0 width=80% bgcolor=#cccccc>";
//SE LEEN LAS RESERVAS VIGENTES
$rows_title="tit_reserve_01.tab";
$rows=$db_path."reserve/pfts/".$_SESSION["lang"]."/".$rows_title;
if (!file_exists($rows)){
	$rows=$db_path."reserve/pfts/".$lang_db."/".$rows_title;
}
$data="";
if (!file_exists($rows)){
	$msgerr= $rows. " ** ".$msgstr["falta"];
}else{	$fp=file($rows);
	foreach ($fp as $value){		if (trim($value)!=""){			$t=explode("|",$value);
			foreach($t as $head){
				echo "<td>$head</td>";
			}
			break;
		}	}
	echo "<td>".$msgstr["vence"]."</td>"."<td>".$msgstr["suspen"]."</td>"."<td>".$msgstr["multas"]."</td><td></td><tr>";
}
$Disp_format="reserve_01.pft";
$Pft=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$Disp_format;
if (!file_exists($Pft)){
	$Pft=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$Disp_format;
}
if (!file_exists($Pft)){
	$msgerr= $Disp_format. " ** ".$msgstr["falta"];
}
$Sort="V10";
$Pft="v10".'`$$$`f(mfn,1,0)`$$$`,@'.$Pft;
$query = "&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=ST_0 or ST_3&Opcion=buscar&Formato=".$Pft;
if ($Sort==""){
	$IsisScript=$xWxis."imprime.xis";
}else{
	$query.='&sortkey='.urlencode($Sort);
	$IsisScript=$xWxis."sort.xis";
}
$contenido=LlamarWxis($IsisScript,$query);

foreach ($contenido as $value){	$value=trim($value);	if ($value!=""){
		$v=explode('$$$',$value);
		//SE LEEN LOS PRESTAMOS PENDIENTES DEL USUARIO PARA EXTRAER LA FECHA DE DEVOLUCION
		$arrHttp["usuario"]=$v[0];
		$Mfn=$v[1];
		$v[2]=strip_tags($v[2]);
		$query = "&Expresion=TRU_P_".$arrHttp["usuario"]."&base=trans&cipar=$db_path"."par/trans.par&Pft=V40/";
		$IsisScript=$xWxis."cipres_usuario.xis";
		$pp=LlamarWxis($IsisScript,$query);
		$vencidos=0;
		foreach ($pp as $prestamo)  {			$prestamo=trim($prestamo);			if ($prestamo!=""){				if ($prestamo<date("Ymd")){
					$vencidos=$vencidos+1;
				}			}		}
		//SE LEEN LAS SUSPENSIONES DEL USUARIO
		$Expresion="(TR_S_".$arrHttp["usuario"]." or TR_M_".$arrHttp["usuario"].")";
		$query = "&Expresion=$Expresion&base=suspml&cipar=$db_path"."par/suspml.par&Pft=v1'|',v60/";
		$IsisScript=$xWxis."cipres_usuario.xis";
		$total_multa=0;
		$total_susp=0;
		$sm=LlamarWxis($IsisScript,$query);
		foreach ($sm as $suspml)  {			$suspm=trim($suspml);
			if ($suspml!=""){				$vdate=explode('|',$suspml);
				switch ($vdate[0]){					case "S":
						if ($vdate[1]>=date("Ymd"))
							$total_susp=$total_susp+1;
						break;
					case "M":
						$total_multa=$total_multa+1;
						break;				}
			}		}
		$reservas=explode("|",$v[2]);
		$continuar="S";
		if ($arrHttp["code"]=="rs02") {			if ($total_susp==0 and $total_multa==0 and $vencidos==0)
				$continuar="N";		}
		if ($continuar=="S"){
			echo "<tr>";
			foreach ($reservas as $rr)
				echo "<td bgcolor=white valign=top>$rr</td>";			echo "<td bgcolor=white valign=top width=10 align=center>" ;
			echo "$vencidos</td><td bgcolor=white valign=top width=10 align=center>$total_susp</td><td bgcolor=white valign=top align=center>$total_multa</td>";
			echo "</td>";
			echo "<td bgcolor=white nowrap valign=top><a href=javascript:DeleteReserve(".$Mfn.")><img src=../dataentry/img/toolbarDelete.png alt='".$msgstr["delete"]."' title='".$msgstr["delete"]."'></a>";
			echo "&nbsp;<a href=javascript:CancelReserve(".$Mfn.")><img src=../dataentry/img/toolbarCancelEdit.png alt='".$msgstr["cancel"]."' title='".$msgstr["cancel"]."'></a>";
			echo "</td>";
			echo "</tr>";
		}
	}}

?>
</table>
</div></div>
</body>

</html>

<form name=reservas method=post action=../reserve/delete_reserve.php>
<input type=hidden name=Mfn_reserve>
<input type=hidden name=Accion>
<input type=hidden name=usuario value=<?php echo $arrHttp["usuario"]?>>
<input type=hidden name=retorno value="../circulation/usuario_prestamos_presentar.php">
<?php if (isset($arrHttp["reserve"])) echo "<input type=hidden name=reserve value=".$arrHttp["reserve"].">\n";?>
</form>
<script>
function  DeleteReserve(Mfn){	alert(Mfn)
	return
	document.reservas.Accion.value="delete"
	document.reservas.Mfn_reserve.value=Mfn
	document.reservas.submit()
}
function  CancelReserve(Mfn){
	alert(Mfn)
	Return
	document.reservas.Accion.value="cancel"
	document.reservas.Mfn_reserve.value=Mfn
	document.reservas.submit()
}


</script>

