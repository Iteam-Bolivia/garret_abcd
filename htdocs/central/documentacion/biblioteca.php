</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
	<head>
		<title>Abogados</title>
		<meta http-equiv="Expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />		<meta name="robots" CONTENT="NONE" />
		<meta http-equiv="keywords" content="" />

		<meta http-equiv="description" content="" />
		<!-- Stylesheets -->
		<style type="text/css">
 body
{background-color:#708090;}
.helper .helper p a strong {
	font-family: Verdana, Geneva, sans-serif;
}
</style>

		<!--[if IE]>
			<link rel="stylesheet" rev="stylesheet" href="../css/bugfixes_ie.css" type="text/css" media="screen"/>
		<![endif]-->
		<!--[if IE 6]>
			<link rel="stylesheet" rev="stylesheet" href="../css/bugfixes_ie6.css" type="text/css" media="screen"/>
		<![endif]-->
</head><script languaje=javascript>
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
	    		alert("Debe seleccionar una base de datos")
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
		    	alert("Debe seleccionar una base de datos")
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
	    	alert("Debe seleccionar una base de datos")
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
	    	alert("Debe seleccionar una base de datos")
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
<div class="sectionInfo">
	<div class="breadcrumb">
		<h1 align="center">BIBLIOTECA </h1>
	</div>
	<div class="actions"><script>
function CambiarModulo(){
	ix=document.frmModulo.modulo.selectedIndex
	if (ix<1){
		return
	}
	document.frmModulo.submit()
}
</script>	</div>
</div>
<!--- inicio codigo www.gratisparaweb.com ---><div align="center"><br><br><map name="Map"><area shape="rect" coords="48,1,90,22" href="http://www.cursosparati.com" target="_blank" alt="Cursos"></map></a></div><!--- fin codigo www.gratisparaweb.com --->
<table border="1" cellpadding="0" cellspacing="0" width="102%">
  <tr>
    <td width="96%" height="81" bgcolor="#545454"><h1><a href = "../documentacion/quienes.php" target="_blank"><strong><span style="color:#FFFFFF;"> <img src="../images/para Logo OfGarrett.jpg" alt="Obra de K. Haring" width="115" height="115" align="bottom" /></span></strong></a></h1>
      <table width="580" height="50" border="1">
        <tr>
          <td width="156"><h2><a href = "../documentacion/quienes.php" target="_blank"><strong><span style="color:#FFFFFF;">Quienes somos </span></strong></a></h2></td>
          <td width="190"><h2><a href = "../documentacion/presentacion.php" target="_blank"><strong><span style="color:#FFFFFF;">RecursosHumanos</span></strong></a></h2></td>
          <td width="104"><h2><a href = "../documentacion/biblioteca.php" target="_blank"><strong><span style="color:#FFFFFF;">Biblioteca</span></strong></a><a href = "../documentacion/presentacion.php" target="_blank"></a></h2></td>
          <td width="102"><h2><a href = "../documentacion/Contacto.php" target="_blank"><strong><span style="color:#FFFFFF;">Contacto</span></strong></a> </strong></h2></td>
        </tr>
      </table>
            
      </strong></td>
  </tr>
 
</table>
<div class="middle homepage">
    

  <div class="mainBox" onMouseOver="this.className = 'mainBox mainBoxHighlighted';" onMouseOut="this.className = 'mainBox';">
		<div class="boxTop">
			<div class="btLeft">&#160;</div>
			<div class="btRight">
			  <p>Internautas, bienvenidos al portal web de la Biblioteca Carlos Garrett Zamora.</p> 
                              <p>   En esta p&aacute;gina, los investigadores o cualquier persona con inter&eacute;s en la historia de nuestro pa&iacute;s tienen a su disposici&oacute;n una vasta cantidad de art&iacute;culos hemerogr&aacute;ficos y documentos en formato PDF. La cantidad de art&iacute;culos y documentos que se comparten ahora ir&aacute; en aumento en el corto plazo, para as&iacute; continuar con la labor de difusi&oacute;n de la historia de la naci&oacute;n, lo cual es la vocaci&oacute;n primordial de este empe&ntilde;o. </p>

                              <p>  En el paseo hemerogr&aacute;fico al que le invitamos, no s&oacute;lo encontrar&aacute; una cantidad inmensa de datos &uacute;tiles para la investigaci&oacute;n acad&eacute;mica de las diversas tem&aacute;ticas que ofrece la biblioteca, sino tambi&eacute;n gozo est&aacute;tico, pues es innegable que leer art&iacute;culos period&oacute;sticos del siglo XIX, del periodo liberal, de los tiempos de la Guerra del Chaco, de la Revoluci&oacute;n de 1952, en fin del pasado, tiene el condimento que permite apreciar c&oacute;digos lingsticos muy distintos a los actuales, cuando la opini&oacute;n del autor de una nota period&iacute;stica no intentaba ser disfrazada y cuando el periodismo no evad&iacute;a la adjetivaci&oacute;n del tema que abordaba</p>

                            <p>    Los visitantes de la biblioteca digital tendr&aacute;n la facilidad de buscar la informaci&oacute;n que necesiten fundamentalmente por un criterio tem&aacute;tico, lo que simplifica la b&uacute;squeda evitando a los usuarios el tener que conocer el nombre de las publicaciones o las fechas aproximadas de la publicaci&oacute;n. Sin embargo, el cat&oacute;logo tambi&eacute;n cuenta con otros modos para facilitar el acceso a un art&iacute;culo en espec&oacute;fico, pues la sistematizaci&oacute;n incluye:</p>
                            <p> 1)  T&iacute;tulo del art&iacute;culo.</p>
                            <p> 2)  Autor (en caso que el art&iacute;culo tenga el dato).</p>
                            <p> 3)  Peri&oacute;dico (nombre del diario donde se public&oacute; el art&iacute;culo en cuesti&oacute;n.</p>
                            <p> 4)  Fecha de publicaci&oacute;n.</p>
                            <p> 5)  Lugar de edici&oacute;n del diario.</p>
                            <p> 6)  Descriptores (palabras claves del contenido tem&aacute;tico de un art&iacute;culo determinado).</p>
                            <p> 7)  Solicitar por (dato que corresponde al c&oacute;digo del lugar de ubicaci&oacute;n de los art&iacute;culos en la estanter&iacute;a de la biblioteca (en caso de pr&eacute;stamos en sala).</p>
                            <p> 8)  Link PDF del art&iacute;culo, por donde el lector acceder&aacute; de manera directa al mismo.</p>		      
                            <p>  El cuerpo tem&aacute;tico principal de los textos est&oacute; dedicado a la miner&iacute;a boliviana (miner&iacute;a chica, cooperativas mineras, la Corporaci&oacute;n Minera de Bolivia, la nacionalizaci&oacute;n de las minas, la miner&iacute;a mediana, pol&iacute;tica minera, en fin, todo lo relacionado a esta actividad extractiva).
                                Un segundo cuerpo importante en de art&iacute;culos archivados por la biblioteca encara el tema relacionado a las relaciones bilaterales entre Bolivia y Chile y muchos otros aspectos vinculados. En efecto, cronol&oacute;gicamente, la publicaci&oacute;n de mayor antig&uacute;edad que se ofrece a los usuarios es la edici&oacute;n del 28 de febrero de 1879 del Comercio (La Paz), despu&eacute;s del inicio de la incursi&oacute;n b&iacute;lica chilena. Sin embargo, se ofrecen al p&uacute;blico cientos de art&iacute;culos de ese t&iacute;pico que van de ese tiempo hasta el presente.
			    
                                Otros temas que forman parte del archivo son los relacionados a los temas capitales de la historia del pa&iacute;s que va desde su fundaci&oacute;n hasta nuestros d&iacute;as, como la historia pol&iacute;tica, la cultura, la econom&iacute;a  
			    
                                Esperando que esta iniciativa contribuya a la investigaci&oacute;n acad&eacute;mica o sea un est&iacute;mulo para cualquier inter&eacute;s que pueda guiar la curiosidad de sus visitantes, les invitamos a navegar por la p&aacute;gina.
			    
                                <input type=hidden name=encabezado value=s>
                                <input type=hidden name=retorno value="../common/inicio.php">
                                <input type=hidden name=modulo value=catalog>
                                <input type=hidden name=newindow value=Y>
		      </p>
          </div>
		</div>
		<div class="boxContent toolSection ">
		  <div class="sectionButtons">
		    <div class="searchTitles">
		      <form name="admin" action="dataentry/inicio_main.php" method="post">
					<div class="stInput">
						<label for="searchExpr"></label>

						<div align="center">
						  <h1><font color="White">FONDO DOCUMENTAL</font>

						    <select name=base  class="textEntry singleTextEntry" >
						      <option value="Hemerografico"></option>
						      <option value="^abiblo^badm|Cepal|Y" >HEMEROGRAFICO
						        
						        
						        
						        
				            </select>
						  </h1>
                      </div>
					</div>
					<div align="center"><a href="javascript:CambiarBaseAdministrador('toolbar')" class="menuButton nextButton"><span style="font-size: 25px; line-height: normal;"><font color="White">Aceptar</font> </span><img src="../images/importDatabase.png" alt="" width="72" height="68" title="" />
					  <span><strong></strong></span>
				    </a></div>
                    </form>
			</div>

					&nbsp;
            <div align="center">
              <h1><a href="buscar_kardek.php" class="boxBottom"><font color="White">FONDO DOCUMENTAL MONOGRAFIAS</font></a></h1>
            </div>
		  </div>
			<div class="spacer"></div>
	</div>
		<div class="boxBottom"> </div>
  </div>
  
  <div align="center">
    <h1><a href="buscar_kardek.php" class="boxBottom"></a>
      <a href="buscar_kardek.php" class="boxBottom"><font color="White">FONDO DOCUMENTAL PUBLICACIONES :HEMEROTECA</font></a></h1>
  </div>
  <p><a href="https://www.facebook.com/?ref=tn_tnmn"><img src="../images/images.png" height="60" /></a><a href="https://twitter.com/"><img src="../images/twitter.jpg" alt="" width="84" height="55" /></a></p>
</div>
	</div>
	<table width="102%" border="1" cellpadding="0" cellspacing="0">
	  <tr>
	    <td width="96%" height="81" bgcolor="#545454"></strong><span class="spacer"><strong><span style="color:#FFFFFF;"><span style="font-size: 20px; line-height: normal;">La Paz - Bolivia Sopocachi Av. Carvantes N 12 Telf: 222-4949 Mail Abogados</span></strong></span></a></td>
      </tr>
	  
</table>
</body>
</html>
