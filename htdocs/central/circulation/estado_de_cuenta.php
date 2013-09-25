<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["base"]="users";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");

function LeerPft($pft_name,$base){
global $arrHttp,$db_path,$lang_db;
	$pft="";
	$archivo=$db_path.$base."/loans/".$_SESSION["lang"]."/$pft_name";
	if (!file_exists($archivo)) $archivo=$db_path.$base."/loans/".$lang_db."/$pft_name";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$pft.=$value;
		}

	}
    return $pft;
}
//se lee la configuraci�n del usuario
$us_tab=LeerPft("loans_uskey.tab","users");
$t=explode("\n",$us_tab);
$prefijo_codigo=$t[0];
if (isset($t[1]))
	$prefijo_nombre=$t[1];
else
	$prefijo_nombre="";
if (isset($t[2]))
	$formato_nombre=$t[2];
else
	$formato_nombre="";
if ($prefijo_codigo=="") $prefijo_codigo="CO_";
if ($prefijo_nombre=="") $prefijo_nombre="NO_";
if ($formato_nombre=="") $formato_nombre="v30";
# Se lee el formato para extraer el c�digo de usuario
$codigo=LeerPft("loans_uskey.pft","users");
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>
document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13) EnviarForma("")
    return true;
  }

function EnviarForma(Proceso){	if (Trim(document.usersearch.code.value)=="" && Trim(document.inventorysearch.inventory.value)==""){		alert("<?php echo $msgstr["falta"]." ".$msgstr["usercode"]."/".$msgstr["inventory"]?>")
		return	}
	if (Proceso==""){
		if (Trim(document.usersearch.code.value)!=""){
			document.EnviarFrm.usuario.value=document.usersearch.usercode.value
			document.EnviarFrm.action="usuario_prestamos_presentar.php"
		}else{
			if (Trim(document.inventorysearch.inventory.value)!=""){
				document.EnviarFrm.inventory.value=document.inventorysearch.inventory.value
				document.EnviarFrm.action="numero_inventario.php"
			}
		}
	}else{
		switch (Proceso){			case "U":
				document.EnviarFrm.usuario.value=document.usersearch.usercode.value
				document.EnviarFrm.action="usuario_prestamos_presentar.php"
				break
			case "I":
				document.EnviarFrm.inventory.value=document.inventorysearch.inventory.value
				document.EnviarFrm.action="numero_inventario.php"
				document.EnviarFrm.submit()
				break		}
	}
	document.EnviarFrm.submit()
}

function AbrirIndiceAlfabetico(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,repetible,Formato){
		Ctrl_activo=xI
		lang="en"
	    Separa="&delimitador="+Separa
	    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo
	    ancho=200
		url_indice="capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+Prefijo+"&postings="+postings+"&lang="+lang+"&repetible=0&Formato="+Formato
		msgwin=window.open(url_indice,"Indice","width=480, height=425,scrollbars")
		msgwin.focus()
}

function AbrirIndice(TipoI,Ctrl){

	switch (TipoI){
		case "U":
			db="users"
			Formato="<?php echo trim($formato_nombre)?>,`$$$`,<?php echo str_replace("'","`",trim($codigo))?>"
			prefijo="<?php echo trim($prefijo_nombre)?>"
			AbrirIndiceAlfabetico(Ctrl,"<?php echo trim($prefijo_nombre)?>","","","users","users.par","30",1,"0",Formato)
			break
 		case "I":
			db="trans"
			prefijo="!Z"
   			AbrirIndiceAlfabetico(Ctrl,"TR_P","","","trans","trans.par","10",1,"","v10,`$$$`,v10")
			break
	}
}

function Output(code){	switch (code){
		case "rs01":
			document.output.action="../output_circulation/rs02.php"
			break;		case "rs02":
			document.output.action="../output_circulation/rs02.php"
			break;
		case "rs03":
			document.output.action="../output_circulation/rs03.php"
			break;
	}
	document.output.code.value=code
	document.output.submit()}
</script>
<?php
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
if (isset($arrHttp["reserve"]) and $arrHttp["reserve"]=="S")
	$ayuda="reserve.html";
else
	$ayuda="user_statment.html"
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php if (!isset($arrHttp["reserve"]))
				echo $msgstr["statment"];
			  else
			  	echo $msgstr["reservas"];
		?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/loans/<?php echo $ayuda?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/loans/".$ayuda." target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: estado_de_cuenta.php</font>\n";
?>
	</div>
<div class="middle list">
	<div class="searchBox">
	<form name=usersearch action="" method=post onsubmit="javascript:return false">
	<input type=hidden name=Indice>
	<table width=100%>
		<td width=100>
		<label for="searchExpr">
			<strong><?php echo $msgstr["usercode"]?></strong>
		</label>
		</td><td>
		<input type="text" name="usercode" id="code" value="<?php if (isset($arrHttp["usuario"])) echo $arrHttp["usuario"]?>" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />

		<input type="button" name="index" value="<?php echo $msgstr["list"]?>" class="submit" onClick="javascript:AbrirIndice('U',document.usersearch.usercode)" />
		<input type="button" name="buscar" value="<?php echo $msgstr["search"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma('U')"/>
		</td></table>
	</form>
	</div>
	<div class="spacer">&#160;</div>
<?php if (!isset($arrHttp["reserve"])){?>
	<div class="searchBox">
	<strong><i><?php echo $msgstr["ec_inv"]?></i></strong>
	<form name=inventorysearch action=numero_inventario.php method=post onsubmit="javascript:return false">
	<table width=100%>
		<td width=100>
		<label for="searchExpr">
			<strong><?php echo $msgstr["inventory"]?></strong>
		</label>
		</td><td>
		<input type="text" name="inventory" id="searchExpr" value="" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry';" />

		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndice('I',document.inventorysearch.inventory)"/>
		<input type="button" name="buscar" value="<?php echo $msgstr["search"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma('I')"/>
		</td></table>
	</form>

	</div>
<?php } ?>
	<br><br><dd>
		<?php echo $msgstr["clic_en"]." <i>".$msgstr["search"]."</i> ".$msgstr["para_c"];
		if ($arrHttp["reserve"]=="S") {			echo "<p>";
			echo "<h4>".$msgstr["reports"]."</h4>";
			echo "<input type=button name=rs01 value=\"".$msgstr["rs01"]."\" onClick=javascript:Output('rs01') style='width:400px'><p>";			echo "<input type=button name=rs02 value=\"".$msgstr["rs02"]."\" onClick=javascript:Output('rs02') style='width:400px'><p>";
			echo "<input type=button name=rs03 value=\"".$msgstr["rs03"]."\" onClick=javascript:Output('rs03') style='width:400px'><p>";
			echo "<input type=button name=rs04 value=\"".$msgstr["rs04"]."\" onClick=javascript:Output('rs04') style='width:400px'><p>";
			echo "<br><br>";		}
?>
</div>

<form name=EnviarFrm method=post>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=usuario value="">
<input type=hidden name=inventory>
<input type=hidden name=ecta value=Y>
<?php if (isset($arrHttp["reserve"])){	echo "<input type=hidden name=reserve value=S>\n";}
?>
</form>
<form name=output method=post>
<input type=hidden name=base value=reserve>
<input type=hidden name=code>
</form>
<?php include("../common/footer.php");
echo "</body></html>" ;
if (isset($arrHttp["error"]) and $arrHttp["inventory"]!=""){	echo "
	<script>
	alert('".$arrHttp["inventory"].": El n�mero de inventario no est� prestado')
	</script>
	";}
?>