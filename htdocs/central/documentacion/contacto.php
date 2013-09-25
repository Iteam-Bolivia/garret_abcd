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
<style type="text/css">
 body
{background-color:#5C3317;}
.helper .helper p a strong {
	font-family: Verdana, Geneva, sans-serif;
}
.middle.homepage p strong {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
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
<div class="middle homepage">
  <p>
  <table border="1" cellpadding="0" cellspacing="0" width="102%">
    <tr>
      <td width="96%" height="81" bgcolor="#545454"><h1>&nbsp;</h1>
        <table width="580" height="50" border="1">
          <tr>
            <td width="156"><h2><a href = "../documentacion/quienes.php" target="_blank"><strong><span style="color:#FFFFFF;">Quienes somos </span></strong></a></h2></td>
            <td width="190"><h2><a href = "../documentacion/presentacion.php" target="_blank"><strong><span style="color:#FFFFFF;">RecursosHumanos</span></strong></a></h2></td>
            <td width="104"><h2><a href = "../documentacion/biblioteca.php" target="_blank"><strong><span style="color:#FFFFFF;">Biblioteca</span></strong></a><a href = "../documentacion/presentacion.php" target="_blank"></a></h2></td>
            <td width="102"><h2><a href = "../documentacion/Contacto.php" target="_blank"><strong><span style="color:#FFFFFF;">Contacto</span></strong></a> </strong></h2></td>
          </tr>
        </table>
            <?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])){
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/$ayuda target=_blank>".$msgstr["edhlp"];
	echo "</a>
		<font color=white>&nbsp; &nbsp; Script: homepage.php </font>"; 
        
}
?>
      </strong></td>
    </tr>
    <tr>
      <td width="96%" height="26"></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p align="center"><strong>
  <div style="color:#FFFFFF;">
    <div align="center">Complete el Formulario de Contactos </div>
  </div></strong><br />
  </p>
  <p>&nbsp;</p>
<div class="content">
  <p>&nbsp;</p>
  <table width="378" border="1">
    
    <tr>
      <td><h1>Datos Personales </h1></td>
    </tr>
  </table>
  <p><div class="middle homepage">
  
  <FORM id="comentarios" name="comentarios" method="POST" action="enviar_correo.php" >
<table bgcolor="#C2E5FF" border="1">
<tr><td>
    <table bgcolor="#C2E5FF"> 
        <tr>
        <td>Su nombre:</td><td><input type="text" id="nombr" name="nombr" value="" maxlength="90" size="30"><br></td>
        </tr>
        <tr>
        <td>Su correo electronico:</td><td><input type="text" id="elcorreo" name="elcorreo" value="" maxlength="50"  size="30"><br></td>
        </tr>
        <tr>
        <td>Asunto:</td><td><input type="text" id="asunt" name="asunt" maxlength="50"  size="30"><br></td>
        </tr>
        <tr>
        <td>Su mensaje:<br><br></td><td><textarea  rows="10" cols= "23" id="elmsg" name="elmsg" >Su comentario...</textarea><br></td>
        </tr>
        <tr>
        <td colspan="2" align="right"><input type="submit" style="background:#C0C0C0"value="Enviar Comentario" name="enviar"><br></td>
        </tr>
     
    </table>
</td></tr>
</table>
</FORM>
</div>
  <div class="footer">
		<div class="systemInfo"></div>
			<div class="distributorLogo"></div>
			<div class="spacer">&#160;</div>
	</div>
&nbsp;</p>
  <!-- end .content --></div>
</div>
<table border="1" cellpadding="0" cellspacing="0" width="102%">
  <tr>
    <td width="96%" height="81" bgcolor="#545454"></strong><a href="https://www.facebook.com/?ref=tn_tnmn"><img src="../images/images.png" height="60" /></a><a href="https://twitter.com/"><img src="../images/twitter.jpg" alt="" width="84" height="55" /> <span class="spacer"><strong><span style="color:#FFFFFF;">La Paz - Bolivia Sopocachi Av. Carvantes N 12 Telf: 222-4949 Mail Abogados</span></strong></span></a></td>
  </tr>
  <tr>
    <td width="96%" height="26"></td>
  </tr>
</table>
<p>&nbsp;</p