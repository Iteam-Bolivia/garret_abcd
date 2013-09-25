<?php
$rows_title[0]=$msgstr["tit_tm"];
$rows_title[1]=$msgstr["tit_tu"];
$rows_title[2]=$msgstr["tit_np"];
$rows_title[3]=$msgstr["tit_lpn"];
$rows_title[4]=$msgstr["tit_lpr"];
$rows_title[5]=$msgstr["tit_unid"];
$rows_title[6]=$msgstr["tit_renov"];
$rows_title[7]=$msgstr["tit_multa"];
$rows_title[8]=$msgstr["tit_multar"];
$rows_title[9]=$msgstr["tit_susp"];
$rows_title[10]=$msgstr["tit_suspr"];
$rows_title[11]=$msgstr["tit_reserva"];
$rows_title[12]=$msgstr["tit_permitirp"];
$rows_title[13]=$msgstr["tit_permitirr"];
$rows_title[14]=$msgstr["tit_copias"];
$rows_title[15]=$msgstr["tit_limusuario"];
$rows_title[16]=$msgstr["tit_limobjeto"];
$rows_title[17]=$msgstr["tit_inf"];

$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/typeofitems.tab";
if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/typeofitems.tab";
if (file_exists($archivo)){
	$fp=file($archivo);
}else{
	echo "Falta definir las políticas de préstamo";
	die;
}
$ix=0;
$total_prestamos_politica=0;
$can_reserve=array();
foreach ($fp as $value) {	if (trim($value)!=""){
		//echo $value.'<br>';
		$Ti=explode('|',$value);
		$politica[strtoupper($Ti[0])][strtoupper($Ti[1])]=trim($value);
		$total_prestamos_politica=$total_prestamos_politica+$Ti[2];  //EL TOTAL DE PRESTAMOS QUE PUEDE RECIBIR UN USUARIO TOMADO DE LA POLÍTICA
		$total_individual_politica[$Ti[0]]=$Ti[2];
		//SE CONSTRUYE UNA TABLE QUE TIENE EL TIPO DE MATERIAL Y SI SE PUEDE O NO RESERVAR
		if ($Ti[11]=="Y")
			$can_reserve[$Ti[0]]=$Ti[11];
		else
			$can_reserve[$Ti[0]]="N";
  	}
}
//var_dump($can_reserve);
if ($total_prestamos_politica==0)  $total_prestamos_politica=1;

$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/typeofusers.tab";
if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/typeofusers.tab";
if (file_exists($archivo)){
	$fp=file($archivo);
}else{
	echo "Falta definir los tipos de usuario";
	die;
}
$ix=0;
foreach ($fp as $value) {
	if (trim($value)!=""){
		$value.="||";
		$Ti=explode('|',$value);
		$tipo_u[strtoupper($Ti[0])]["pp"]=$Ti[3];
		// SI NO SE HA ESPECIFICADO EL NUMERO DE PRESTAMOS TOTALES QUE PUEDE RECIBIR UN USUARIO, SE TOMAN LOS VALORES
		// INDIVIDUALES DE LAS DIFERENTES POLÍTICAS
		if ($Ti[3]=="")
			$tipo_u[strtoupper($Ti[0])]["Tp"]=$total_prestamos_politica;
		else
			$tipo_u[strtoupper($Ti[0])]["Tp"]=$Ti[2];


  	}

}
?>