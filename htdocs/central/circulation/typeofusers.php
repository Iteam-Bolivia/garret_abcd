<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
include("../lang/prestamo.php");

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

$rows_title=array();
$rows_title[0]=$msgstr["usertype"];
$rows_title[1]=$msgstr["description"];
$rows_title[2]=$msgstr["tit_np"];

include("../common/header.php");
?>
<link rel="STYLESHEET" type="text/css" href="../css/dhtmlXGrid.css">
<link rel="STYLESHEET" type="text/css" href="../css/dhtmlXGrid_skins.css">
<script  src="../dataentry/js/dhtml_grid/dhtmlXCommon.js"></script>
<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid.js"></script>
<script  src="../dataentry/js/dhtml_grid/dhtmlXGridCell.js"></script>
<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid_drag.js"></script>
<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid_excell_link.js"></script>
<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid_start.js"></script>
<script  src="../dataentry/js/lr_trim.js"></script>
<script>
	function Capturar_Grid(){
			cols=mygrid.getColumnCount()
			rows=mygrid.getRowsNum()
			VC=""
			for (i=0;i<rows;i++){
				if (Trim(mygrid.cells2(i,0).getValue())!=""){
					if (VC!="") VC=VC+"\n"
					for (j=0;j<cols;j++){
						cell=mygrid.cells2(i,j).getValue()
						if (j!=13) VC=VC+cell+'|'
					}
				}
			}
			return VC

		}


	function Enviar(){
		document.forma1.ValorCapturado.value=Capturar_Grid()
		document.forma1.submit()
	}

	function doBeforeRowDeleted(rowId){
  		VC=""
		for (j=0;j<3;j++){
			cell=mygrid.cells(rowId,j).getValue()
			VC=VC+cell
		}
		if (VC=="")
			return true
		else
			return confirm("Are you sure you want to delete row");

	}

</script>

<?php
$encabezado="";
include("../common/institutional_info.php");
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["typeofusers"]."
			</div>
			<div class=\"actions\">\n";

				echo "

					<a href=\"configure_menu.php?encabezado=s\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>
				<a href=javascript:Enviar() class=\"defaultButton saveButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>".$msgstr["update"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/circulation/loans_typeofusers.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/loans_typeofusers.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: circulation/typeofusers.php </font>";
echo "  </div>
		<div class=\"middle form\">
			<div class=\"formContent\">";
?>
		<br>
			<a href="javascript:void(0)" onclick="mygrid.addRow((new Date()).valueOf(),['','',''],mygrid.getRowIndex(mygrid.getSelectedId()))"><?php echo $msgstr["addrowbef"]?></a>
			&nbsp; &nbsp; &nbsp;<a href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()"><?php echo $msgstr["remselrow"]?></a>

	<table   id=tblToGrid class="dhtmlxGrid">
<?php
	echo "<tr>";
	foreach ($rows_title as $cell) echo "<td>".str_replace(","," ",$cell)."</td>\n";
  	echo "</tr>";

	unset($fp);
	$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/typeofusers.tab";
	if (!file_exists($archivo))
		$archivo=$db_path."circulation/def/".$lang_db."/typeofusers.tab";
	if (file_exists($archivo)){
		$fp=file($archivo);
	}else{		$fp=array();
		for ($i=0;$i<20;$i++){
			$fp[$i]='|||||';
		}
		$tope=20;	}
	$nfilas=0;
	$i=-1;
	$t=array();
	$i=-1;
	$IN=array();
	foreach ($fp as $value){		$value=trim($value);
		if (trim($value)!=""){
	    	$nfilas=$nfilas+1;
			echo "\n<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">\n";
			$i=$i+1;
			$value.='||||||';
			$t=explode("|",$value);
			echo "<td width=200>".$t[0]."</td><td width=300>".$t[1]."</td><td align=center>".$t[2]."</td>";
      		echo " </tr>";
		}

	}

?>

	</table>
	<a href=javascript:Enviar()><?php echo $msgstr["update"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;
	<a href=configure_menu.php?encabezado=s><?php echo $msgstr["cancel"]?></a>
<script>

    nfilas=<?php echo $nfilas."\n"?>
    var mygrid = new dhtmlXGridFromTable('tblToGrid');

    mygrid.setSkin("modern");
	mygrid.setImagePath("../imgs/");
	mygrid.setInitWidths("100,200,100")

	mygrid.setColAlign("left,left,center")
	mygrid.setColTypes("ed,ed,ed");
    mygrid.enableAutoWidth(true);
    mygrid.enableAutoHeigth(true,350);
 	mygrid.setOnBeforeRowDeletedHandler(doBeforeRowDeleted);
 //	mygrid.setOnEditCellHandler(doOnCellEdit);
 	mygrid.setColSorting("")
	nfilas++
	for (j=nfilas;j<nfilas+10;j++){
		mygrid.addRow((new Date()).valueOf(),['','',''],j)
	}

	mygrid.clearSelection()
	mygrid.setSizes();


</script>
<br><br>
</form>
<form name=forma1 action=typeofusers_update.php method=post>
<input type=hidden name=ValorCapturado>
<input type=hidden name=desc>
<input type=hidden name=Opcion value=>
<input type=hidden name=base value=users>
</form>



<?php

echo "</div></div></div>";
include("../common/footer.php");
echo "</body></html>" ;

?>