<?php
$Permiso=$_SESSION["permiso"];
if (isset($arrHttp["modulo"])) $_SESSION["modulo"]=$arrHttp["modulo"];
$lista_bases=array();
if (file_exists($db_path."bases.dat")){
	$fp = file($db_path."bases.dat");
	foreach ($fp as $linea){
		$linea=trim($linea);
		if ($linea!="") {
			$ix=strpos($linea,"|");
			$llave=trim(substr($linea,0,$ix));
			$lista_bases[$llave]=trim(substr($linea,$ix+1));
		}
	}
}
$central="";
$circulation="";
$acquisitions="";
$ixcentral=0;
foreach ($_SESSION["permiso"] as $key=>$value){
	if (substr($key,0,8)=="CENTRAL_")  	{
		$central="Y";
		$ixcentral=$ixcentral+1;
	}
	if (substr($key,0,5)=="CIRC_")  	$circulation="Y";
	if (substr($key,0,4)=="ACQ_")  		$acquisitions="Y";

}
// Se determina el nombre de la p�gina de ayuda a mostrar
if (!isset($_SESSION["modulo"])) {
	if ($central=="Y" and $ixcentral>0) {
		$arrHttp["modulo"]="catalog";
	}else{
		if ($circulation=="Y"){
			$arrHttp["modulo"]="loan";
		}else{
			$arrHttp["modulo"]="acquisitions";
		}
	}
}
else
    {
	$arrHttp["modulo"]=$_SESSION["modulo"];
}
switch ($arrHttp["modulo"]){
	case "catalog":
		$ayuda="homepage.html";
		$module_name=$msgstr["catalogacion"];
		$_SESSION["MODULO"]="catalog";
		break;
	case "acquisitions":
		$ayuda="acquisitions/homepage.html";
		$module_name=$msgstr["acquisitions"];
		$_SESSION["MODULO"]="acquisitions";
		break;
	case "loan":
		$ayuda="circulation/homepage.html";
		$module_name=$msgstr["loantit"];
		$_SESSION["MODULO"]="loan";
}
include("header.php");
?>
<script languaje=javascript>
	function CambiarLenguaje(){
		if (document.cambiolang.lenguaje.selectedIndex>0){
               lang=document.cambiolang.lenguaje.options[document.cambiolang.lenguaje.selectedIndex].value
               self.location.href="inicio.php?reinicio=s&lang="+lang
		}
	}
	function CambiarBase(Modulo){
		if (Modulo!="traducir"){
			ix=document.admin.base.selectedIndex
	    	if (ix<1){
	    		alert("<?php echo $msgstr["seldb"]?>")
	    		return
			}
	    }

	    switch(Modulo){
	    	case "toolbar":
	    		document.admin.action="../dataentry/inicio_main.php";
	    		break;
			case "utilitarios":
				document.admin.action="../dbadmin/menu_mantenimiento.php";
                   break;
   			case "estructuras":
				document.admin.action="../dbadmin/menu_modificardb.php";
                break;
    		case "reportes":
				document.admin.action="../dbadmin/pft.php";
                 break;
		}
		document.admin.submit();
	}
	function CambiarBaseAdministrador(Modulo){
		if (Modulo!="traducir"){
			ix=document.admin.base.selectedIndex
		    if (ix<1){
		    	alert("<?php echo $msgstr["seldb"]?>")
		    	return
		    }
		}
	    switch(Modulo){
			case 'table':
				document.admin.action="../dataentry/browse.php"
				break
	    	case "resetautoinc":
	    	   	document.admin.action="../dbadmin/resetautoinc.php";
	    		break;
	    	case "toolbar":
	    		document.admin.action="../dataentry/inicio_main.php";
	    		break;
			case "utilitarios":
				document.admin.action="../dbadmin/menu_mantenimiento.php";
                break;
   			case "estructuras":
				document.admin.action="../dbadmin/menu_modificardb.php";
                break;
    		case "reportes":
				document.admin.action="../dbadmin/pft.php";
                break;
    		case "traducir":
				document.admin.action="../dbadmin/menu_traducir.php";
                break;
    		case "stats":
    			document.admin.action="../statistics/tables_generate.php";
    			break;
    		case "z3950":
    			document.admin.action="../dbadmin/z3950_conf.php";
    			break;
	    }
		document.admin.submit();
	}
	function ModificarBase(){
	    ix=document.admin.base.selectedIndex
	    if (ix<1){
	    	alert("<?php echo $msgstr["seldb"]?>")
	    	return
	    }
		base_sel=document.admin.base_lista.options[ix].value
		base_sel=base_sel.substr(2)
		i=base_sel.indexOf('^')
		base_sel=base_sel.substr(0,i)
		self.location.href="dbadmin/menu_modificardb.php?base="+base_sel+"&encabezado=S"
	}
	function ModificarBaseAdministrador(){
	    ix=document.admin.base_lista.selectedIndex
	    if (ix<1){
	    	alert("<?php echo $msgstr["seldb"]?>")
	    	return
	    }
		base_sel=document.admin.base_lista.options[ix].value
		base_sel=base_sel.substr(2)
		i=base_sel.indexOf('^')
		base_sel=base_sel.substr(0,i)
		self.location.href="dbadmin/menu_modificardb.php?base="+base_sel+"&encabezado=S"
	}
	</script>

</head>
<body>
<div class="language"></div>
<div class="sectionInfo">
	<div class="breadcrumb">
		<h3><a href = "../documentacion/quienes.php" target="_blank"><strong><span style="color:#FFFFFF;"><img src="../images/para Logo OfGarrett.jpg" alt="Obra de K. Haring" width="115" height="115" align="bottom" /></span></strong></a></h3>
	</div>
	<div class="actions"></div>
	<div class="spacer">&#160;</div>
</div>
<!--- inicio codigo www.gratisparaweb.com ---><div align="center"><br><br><map name="Map"><area shape="rect" coords="48,1,90,22" href="http://www.cursosparati.com" target="_blank" alt="Cursos"></map></a></div><!--- fin codigo www.gratisparaweb.com --->
    
<div class="helper"><a href = ../documentacion/quienes.php target=_blank>Quienes somos</a>&nbsp;
        <a href = ../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]."/$ayuda"?> target=_blank><?php echo $msgstr["help"]?></a></div>
<div class="middle homepage">
    
<?php
$Permiso=$_SESSION["permiso"];
switch ($_SESSION["MODULO"]){
	case "catalog":
		AdministratorMenu();
		break;
	case "loan":
		MenuLoanAdministrator();
		break;
	case "acquisitions":
		MenuAcquisitionsAdministrator();
		break;
}
echo "		</div>
	</div>";
include("footer.php");
echo "	</body>
</html>";

///---------------------------------------------------------------

function AdministratorMenu(){
global $msgstr,$db_path,$arrHttp,$lista_bases,$Permiso,$dirtree;
	$_SESSION["MODULO"]="catalog";
?>

	<div class="mainBox" onMouseOver="this.className = 'mainBox mainBoxHighlighted';" onMouseOut="this.className = 'mainBox';">
		<div class="boxTop">
			<div class="btLeft">&#160;</div>
			<div class="btRight">&#160;</div>
		</div>
		<div class="boxContent toolSection ">
			<div class="sectionIcon">
				&#160;
			</div>
			<div class="sectionTitle">
				<h4><strong><?php echo $msgstr["database"]?></strong></h4>
			</div>
			<div class="sectionButtons">
            	<div class="searchTitles">
					<form name="admin" action="dataentry/inicio_main.php" method="post">
					<input type=hidden name=encabezado value=s>
					<input type=hidden name=retorno value="../common/inicio.php">
					<input type=hidden name=modulo value=catalog>
					<?php if (isset($arrHttp["newindow"]))
					echo "<input type=hidden name=newindow value=Y>\n";?>
					<div class="stInput">
						<label for="searchExpr"><?php echo $msgstr["seleccionar"]?>:</label>
						<select name=base  class="textEntry singleTextEntry" >
							<option value=""></option>
<?php
$i=-1;
foreach ($lista_bases as $key => $value) {
	$xselected="";
	$t=explode('|',$value);
	if (isset($Permiso["db_".$key]) or isset($_SESSION["permiso"]["db_ALL"])){
		if (isset($arrHttp["base"]) and $arrHttp["base"]==$key or count($lista_bases)==1) $xselected=" selected";
		echo "<option value=\"^a$key^badm|$value\" $xselected>".$t[0]."\n";
	}
}
?>
						</select>
					</div>
					<a href="javascript:CambiarBaseAdministrador('toolbar')" class="menuButton nextButton">
						<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
						<span><strong><?php echo $msgstr["dataentry"]?></strong></span>
					</a>
					</form>
				</div>
					&nbsp;
<?php
if (isset($Permiso["CENTRAL_STATGEN"]) or isset($Permiso["CENTRAL_ALL"])){
?>
				<a href="javascript:CambiarBaseAdministrador('stats')" class="menuButton statButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["statistics"]?></strong></span>
				</a>
<?php
}
if (isset($Permiso["CENTRAL_PREC"]) or isset($Permiso["CENTRAL_ALL"])){
?>
				<a href="javascript:CambiarBase('reportes')" class="menuButton reportButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["reports"]?></strong></span>
				</a>
<?php
}
if (isset($Permiso["CENTRAL_MODIFYDEF"]) or isset($Permiso["CENTRAL_ALL"])){
?>
				<a href="javascript:CambiarBaseAdministrador('estructuras')" class="menuButton update_databaseButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["updbdef"]?></strong></span>
				</a>
<?php
}
if (isset($Permiso["CENTRAL_DBUTILS"]) or isset($Permiso["CENTRAL_ALL"])){
?>

				<a href="javascript:CambiarBaseAdministrador('utilitarios')" class="menuButton utilsButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["maintenance"]?></strong></span>
				</a>
<?php
}
if (isset($Permiso["CENTRAL_Z3950CONF"])  or isset($Permiso["CENTRAL_ALL"])){
?>
				<a href="javascript:CambiarBaseAdministrador('z3950')"  class="menuButton z3950Button">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["z3950"]?></strong></span>
				</a>
<?php
}
?>
			</div>
			<div class="spacer">&#160;</div>
			</div>
			<div class="boxBottom">
			<div class="bbLeft">&#160;</div>
			<div class="bbRight">&#160;</div>
		</div>
	</div>
<?php

if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_CRDB"])  or isset($Permiso["CENTRAL_URDADM"])
  or isset($Permiso["CENTRAL_RESETLIN"])  or isset($Permiso["CENTRAL_TRANSLATE"])  or isset($Permiso["CENTRAL_EXDBDIR"]))
{
?>
			<div class="mainBox" onMouseOver="this.className = 'mainBox mainBoxHighlighted';" onMouseOut="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent toolSection ">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
						<h4><strong><?php echo $msgstr["admtit"]?></strong></h4>
					</div>
					<div class="sectionButtons">
<?Php
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_CRDB"])){
?>
                    <a href="../dbadmin/menu_creardb.php?encabezado=S" class="menuButton databaseButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["createdb"]?></strong></span></a>
<?Php
}
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_URADM"])){
?>
				<a href="../dbadmin/users_adm.php?encabezado=s&base=acces&cipar=acces.par" class="menuButton userButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["usuarios"]?></strong></span>
				</a>
<?Php
}
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_RESETLIN"])){
?>
				<a href="../dbadmin/reset_inventory_number.php?encabezado=s" class="menuButton resetButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["resetinv"]?></strong></span>
				</a>
<?Php
}
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_TRANSLATE"])){
?>
				<a href="javascript:CambiarBaseAdministrador('traducir')" class="menuButton exportButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["translate"]?></strong></span>
				</a>
<?Php
}
if ($dirtree==1){
	if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_EXDBDIR"])){
?>
				<a href="../dbadmin/dirtree.php?encabezado=s" class="menuButton exploreButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["expbases"]?></strong></span>
				</a>
<?Php }
}?>
					</div>
					<div class="spacer">&#160;</div>
				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
<div><a href="https://www.facebook.com/?ref=tn_tnmn"><img src="../images/images.png" height="60"></a> <a href="https://twitter.com/"><img src="../images/twitter.jpg" width="84" height="55"></a> </div>

<?php
	}
}
// end function Administrador



function MenuAcquisitionsAdministrator(){
	include("menuacquisitions.php");
}

function MenuLoanAdministrator(){
   include("menucirculation.php");
}
