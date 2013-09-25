<?php
/*
           Instituto Tecnologico de Zacatepec, Morelos
Descripcion:    Archivo que usa la funcion mail() de php para enviar
        un correo electronico con datos que le llegan por el metodo
        POST.
Author:         Gonzalo Silverio  gonzasilve@gmail.com
Archivo:        enviar_correo.php
*/
 
    //Recuperar los datos que serviran para enviar el correo
     $seEnvio;      //Para determinar si se envio o no el correo
     $destinatario = 'jorge.medrano@iteam.com.bo';        //A quien se envia
     $elmensaje = str_replace("\n.", "\n..", $_POST['elmsg']);     //por si el mensaje empieza con un punto ponerle 2
     $elmensaje = wordwrap($elmensaje, 70);                       //dividir el mensaje en trozos de 70 cols
     //Recupear el asunto
     $asunto = $_POST['asunt'];
     //Formatear un poco el texto que escribio el usuario (asunto) en la caja
     //de comentario con ayuda de HTML
     $cuerpomsg ='
<html>
<head>
  <title>Tienes un mensaje!!</title>
</head>
<body>
<p>Holaa jorge, alguien te mando un mensaje de tu pagina web http://localhost/contactos/index.php</p>
  <table>
    <tr>
      <td><b>Tu mensaje es:</b><br></td>
    </tr>
    <tr>
      <td>'.$elmensaje.'</td>
    </tr>
    <tr>
      <td><br><a href="http://gonzaslive.aegislinux.com.mx/ejemplos/enviar_correo/responder.php?correo='.$_POST['elcorreo'].'&asunto=FW: '.$asunto.'&nombre='.$_POST['nombr'].'">Responder</a></td>
    </tr>
  </table>
</body>
</html>
 ';
//Establecer cabeceras para la funcion mail()
    //version MIME
    $cabeceras = "MIME-Version: 1.0\r\n";
    //Tipo de info
    $cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
    //direccion del remitente
    $cabeceras .= "From: ".$_POST['nombr']." <".$_POST['elcorreo'].">";
    if(mail($destinatario,$asunto,$cuerpomsg,$cabeceras))
        $seEnvio = true;
    else
        $seEnvio = false;
 
//Enviar el estado del envio (por metodo GET ) y redirigir navegador al archivo index.php
        if($seEnvio == true)
    {
        header('Location: index.php?estado=enviado');
    }
    else
    {
        header('Location: index.php?estado=no_enviado');
    }
?>
