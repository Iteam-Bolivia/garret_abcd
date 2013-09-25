<!--
    Instituto Tecnologico de Zacatepec, Morelos
        Descripcion:   Archivo principal que muestra un formulario (incrustado)
        para enviar un correo o muestra un mensaje avisando
        del exito/fracaso de un envio de correo.
Author:     Gonzalo Silverio  gonzasilve@gmail.com
Archivo:    index.php
-->
 
<HTML>
<HEAD>
    
    <link type="text/css" href="css/jquery.alerts.css" rel="stylesheet" />
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.alerts.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>    
    <script type="text/javascript">
<!--
    $().ready(function() {
            //$("#comentarios").validate();
             
        $("#comentarios").validate({
            rules: {
            /*A continuacion los nombres de los campos y sus reglas a cumplir */
                nombr: {
                required: true
                },
                elcorreo: {
                required: true,
                email: true
                },
                asunt: {
                required: true
                },
                elmsg: {
                required: true
                }
            }
        });
         
             
    });
 //  -->
    </script>
     
</HEAD>
    <BODY >
    <TABLE WIDTH="95%" align="center" cellspacing="0" cellpadding="0" border=1>
    <TR>
        <TD bgcolor="#F2F9FB" align="center">
     <?php
     echo '<br><h2 align=center>Contacto</h2>';
        //Si la variable de estado existe entrar y ver que valor tiene
     if( isset( $_GET['estado'] ) )
     {
    if( $_GET['estado']=='enviado' )
    {
        echo "<br><br>Su mensaje fue enviado correctamente";
        echo "<br><br><a href='index.php'>VOLVER</a>";
    }
    else if( $_GET['estado']=='no_enviado' )
    {
        echo "<br><br><b>Upss!!,</b> Ocurrio un error. SU MENSAJE NO PUEDE SER ENVIADO EN ESTE MOMENTO.";
    }
      }
      else
      {
      echo 'Si lo deseas desde esta seccion puedes enviar un mensaje al administrador del sitio, algun comentario o sugerencia. <br>Cualquier critica constructiva sera bien recibida. <br><br>';
        //muestra el formulario para capturar los datos del correo
          require("contacto.php");
      }
          echo '   <BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>';
     ?>
        </TD>
    </TR>
    </TABLE>
</BODY>
</HTML>