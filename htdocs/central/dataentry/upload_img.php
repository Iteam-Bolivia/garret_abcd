<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      upload_img.php
 * @desc:
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
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/soporte.php");

function NoImage(){	global $msgstr;
	echo "<font color=red face=arial size=2>".$msgstr["nouploadfile"]."<font color=black><p>";
	echo "<a href=javascript:history.back()>".$msgstr["regresar"]."<a>";
	die;}

//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
if (file_exists($db_path.$arrHttp["base"]."/dr_path.def")){
	$def = parse_ini_file($db_path.$arrHttp["base"]."/dr_path.def");
	$img_path=trim($def["ROOT"]);
}else{
	$img_path=getenv("DOCUMENT_ROOT")."/bases/".$arrHttp["base"]."/";
}

$files = $_FILES['userfile'];

if (!ereg("/$", $img_path)) $img_path = $img_path."/";
$store_in="";
if (isset($arrHttp["storein"]))
	if (!ereg("/$", $arrHttp["storein"])) $store_in = $arrHttp["storein"]."/";
if (!ereg("/$", $img_path)) $img_path = $img_path."/";

foreach ($files['name'] as $key=>$name) {
	if (trim($name)==""){		NoImage();
		break;	}
	if ($name!=""){	  	echo "$name<br>";
	  	$max=get_cfg_var ("upload_max_filesize");
	    if ((int)$files['size'][$key]==0){	    	$max=get_cfg_var ("upload_max_filesize");
	    	echo "upload_max_filesize = $max<br>";	    	echo "File to big. Could not be uploaded. Modify the parameter upload_max_filesize in php.ini";
	    	die;	    }
		if ($files['size'][$key]) {
	      // clean up file name
	   		$name = ereg_replace("[^a-z0-9._]", "",
	        	str_replace(" ", "_",
	            	str_replace("%20", "_", strtolower($name)
	            	)
	            )
	         );
	  		$location = $img_path.$store_in.$name;
	  		$location=str_replace('//',"/",$location);
	  		$loc=$store_in;
	  		if (substr($loc,0,1)=="/") $loc=substr($loc,1);
			echo "<html>\n";
			echo "<title>".$msgstr["uploadfile"]."</title>\n";
			echo "<script language=javascript src=js/lr_trim.js></script>\n";
			echo "<body>\n";
			echo "<font face=verdana>\n";
			//echo "location: ".$location;
	  		if (!copy($files['tmp_name'][$key],$location)){
			    echo "<p>". $msgstr["archivo"]." ".$location." ".$msgstr["notransferido"];
			}else{
			  	echo "<p>*** ". $msgstr["archivo"]." ".$location." ".$msgstr["transferido"];
			  	$subc_a="";
			  	if (isset($arrHttp["Tag"])){			  		if (isset($arrHttp["subc"])){			  			if (strlen($arrHttp["subc"])>1){			  				$subc_a=substr($arrHttp["subc"],0,1);			  				if ($subc_a!="-")
			  					$subc_a="^".$subc_a;
							else
								$subc_a="";
			  				$subc_b="^".substr($arrHttp["subc"],1,1);			  			}else{			  				$subc_a="";
			  				$subc_b="^".substr($arrHttp["subc"],0,1);			  			}			  		}else{			  			$subc_a="";
			  			$subc_b="^d";			  		}
				  	echo "<script>
						  campo=window.opener.document.forma1.".$arrHttp["Tag"].".value
						  if (Trim(campo)==\"\")
						  	campo+=\"".$subc_a."$loc"."$name\"\n
						  else
						  	campo+='\\r'+\"".$subc_a."$loc"."$name\"\n";
						  if (isset($arrHttp["descripcion"]) and trim($arrHttp["descripcion"])!="")
						  	echo "campo+=\"".$subc_b.$arrHttp["descripcion"]."\"\n";
			              echo "
						  window.opener.document.forma1.".$arrHttp["Tag"].".value=campo
						  window.opener.document.forma1.".$arrHttp["Tag"].".rows++
						  window.opener.top.img_dir=\"$loc\"
						  self.close()
						  </script>
				  		  ";

				}
	  			unlink($files['tmp_name'][$key]);
	  		}
	   	}
	 }
}
	echo "</body>\n";
	echo "</html>\n";
?>