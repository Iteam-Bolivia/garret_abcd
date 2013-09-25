<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
global $valortag;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

include("../common/get_post.php");
include("../config.php");



if (isset($arrHttp["cambiolang"]))  $_SESSION["lang"]=$arrHttp["lang"];
include ("../lang/admin.php");
include ("../lang/lang.php");
include("leerregistroisispft.php");

$arrHttp["IsisScript"]="ingreso.xis";
$arrHttp["Mfn"]=$_SESSION["mfn_admin"];

/*
LeerRegistroMfn("acces","acces.par",$_SESSION["mfn_admin"],&$maxmfn,"leer","","",$xWxis,"ingreso.xis");
$b=explode("\n",$valortag[100]) ;
die;
foreach($b as $value){
	$value=trim($value);
	if ($value!=""){
		$ix=strpos($value,'^',2);
		if ($ix===false) $ix=strlen($value);
		$key=substr($value,2,$ix-2);
		if (trim($key)!=""){
	//		echo $key."<br>";
			$bases[$key]=$value;
		}
	}
}
*/
$fp = file($db_path."bases.dat");
if (!$fp){
	echo "falta el archivo bases.dat";
	die;
}
echo "<script>
top.listabases=Array()\n";
foreach ($fp as $linea){
	if (trim($linea)!="") {
		$ix=strpos($linea,"|");
		$llave=trim(substr($linea,0,$ix));
		$lista_bases[$llave]=trim(substr($linea,$ix+1));
		echo "top.listabases['$llave']='".trim(substr($linea,$ix+1))."'\n";
	}

}
echo "</script>\n";
include("../common/header.php");
?>
<script>
lang='<?php echo $_SESSION["lang"]?>'

function AbrirAyuda(){
	msgwin=window.open("ayudas/"+lang+"/menubases.html","Ayuda","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=750,height=500,top=10,left=5")
	msgwin.focus()
}

Entrando="S"

function VerificarEdicion(Modulo){
	 if(top.xeditar=="S"){
		alert("<?php echo $msgstr["aoc"]?>")
		return
	}
}

function CambiarBase(){
	tl=""
   	nr=""
   	top.img_dir=""
  	i=document.OpcionesMenu.baseSel.selectedIndex
  	top.ixbasesel=i
   	if (i==-1) i=0
  	abd=document.OpcionesMenu.baseSel.options[i].value
  	top.base=abd
	if (abd.substr(0,2)=="--"){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	ix=abd.indexOf("^b");
	if (ix>0){
		base=abd.substr(2,ix-2)
	}else{
		base=abd.substr(2)
	}
	top.base=base
	if (document.OpcionesMenu.baseSel.options[i].text==""){
		return
	}
	abd=abd.substr(ix+2)
	ix=abd.indexOf("^c");
	if (ix>0){
		top.db_copies=abd.substr(ix+2)
	}else{
		top.db_copies=""
	}

	cipar=base+".par"
	top.nr=nr
	document.OpcionesMenu.base.value=base
   	document.OpcionesMenu.cipar.value=cipar
	document.OpcionesMenu.tlit.value=tl
	document.OpcionesMenu.nreg.value=nr
	top.base=base
	top.cipar=cipar
	top.mfn=0
	top.maxmfn=99999999
	top.browseby="mfn"
	top.Expresion=""
	top.Mfn_Search=0
	top.Max_Search=0
	top.Search_pos=0
	switch (top.ModuloActivo){
		case "dbadmin":

			top.menu.location.href="../dbadmin/index.php?base="+base

            break;
		case "catalog":
			i=document.OpcionesMenu.baseSel.selectedIndex
			document.OpcionesMenu.baseSel.options[i].text
			if (top.NombreBase==document.OpcionesMenu.baseSel.options[i].text) return
			top.NombreBase=document.OpcionesMenu.baseSel.options[i].text
			top.menu.document.forma1.ir_a.value=""
			top.main.location.href="inicio_base.php?base="+base+"&cipar="+cipar
			i=document.OpcionesMenu.baseSel.selectedIndex
			break
		case "Capturar":

			break
	}
}

function Modulo(){
	Opcion=document.OpcionesMenu.modulo.options[document.OpcionesMenu.modulo.selectedIndex].value
	switch (Opcion){
		case "loan":
			top.location.href="../common/change_module.php?modulo=loan"
			break
		case "acquisitions":
			top.location.href="../common/change_module.php?modulo=acquisitions"
			break

		case "dbadmin":
				document.OpcionesMenu.modulo.selectedIndex=0
				top.ModuloActivo="dbadmin"
			top.menu.location.href="../dbadmin/index.php?basesel="
			break
		case "catalog":
			top.main.location.href="inicio_base.php?inicio=s&base="+base+"&cipar="+base+".par"
			top.ModuloActivo="catalog"
			if (i>0) {
				top.menu.location.href="../dataentry/menu_main.php?Opcion=continue&cipar=acces.par&cambiolang=S&base="+base
			}else{
				top.menu.location.href="../dataentry/blank.html"
			}
			break

	}
}

function CambiarLenguaje(){
	url=top.main.location.href
	lang=document.OpcionesMenu.lenguaje.options[document.OpcionesMenu.lenguaje.selectedIndex].value
	Opcion=top.ModuloActivo
	top.encabezado.location.href="menubases.php?base="+top.base+"&base_activa="+top.base+"&lang="+lang+"&cambiolang=s"
	switch (Opcion){
		case "loan":
			break
		case "dbadmin":
			top.menu.location.href="../dbadmin/index.php?Opcion=continue&lang="+lang+"&base="+top.base
			top.main.location.href=url
			break
		case "catalog":
			break
		case "statistics":
			break

	}
}
</script>
</head>
<body bgcolor=#FFFFFF>
<form name=OpcionesMenu>
<input type=hidden name=base value="">
<input type=hidden name=cipar value="">
<input type=hidden name=marc value="">
<input type=hidden name=tlit value="">
<input type=hidden name=nreg value="">
<div class="heading">
	<div class="institutionalInfo">
		<h1><img src="../images/para Logo OfGarrett.jpg" width="118" height="102"><br>		<table cellpadding=0 cellspacing=0 border=0 align=right>
		</h1>
	</div>
	<tr><td align=right width=105><font color=white face=arial size=1></td><tr>
		  <td>
</form>

<script>
<?php
if (isset($arrHttp["inicio"]))
	$inicio="&inicio=s";
else
	$inicio="";
echo "top.menu.location.href=\"menu_main.php?base=\"+top.base+\"$inicio\"\n";?>
</script>
</body>
</html>

