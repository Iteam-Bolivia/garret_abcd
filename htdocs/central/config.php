<?
 // Open the Central module in a new window for avoiding the use of the browse buttons
 $open_new_window="Y";
$context_menu="Y";
//USED FOR ALL THE DATE FUNCTIONS. DD=DAYS, MM=MONTH, AA=YEAR. USE / AS SEPARATOR
 $config_date_format="DD/MM/YY";
//Folder with the administration modulo
$app_path="central";
//This variable erases the left zeroes in the inventory number
$inventory_numeric ="N";
//Add Zeroes to the left for reaching the max length of the inventory number
$max_inventory_length=1;
//Add Zeroes to the left for reaching the max length of the control number
$max_cn_length=1;
//Colocar Y en esta variable si se quiere llevar un log de todas las transacciones realizadas sobre la base de datos.
//Para que funcione en la carpeta de la base de datos debe existir una subcarpeta llamada log
$log="Y";
//Path to the databases
$db_path="C:/ABCD/www/bases/";
//path where the lang file and help page are to be located
$msg_path=$db_path;
if (isset($_SESSION["DATABASE_DIR"])) {
$db_path=$_SESSION["DATABASE_DIR"];
}else{
//unset($msg_path);
}
$def = parse_ini_file($db_path."abcd.def");
//version del cisis
$cisis_ver="";
if (isset($arrHttp["base"])){
if (isset($def[$arrHttp["base"]]))
$cisis_ver=$def[$arrHttp["base"]]."/";
}
//Path to the folder where the uploaded images are to be stored (the database name will be added to this path)
$img_path="C:/ABCD/www/htdocs/bases/";
//Path to the wwwisis executable (include the name of the program)
$Wxis="C:/ABCD/www/cgi-bin/$cisis_ver"."wxis.exe";
//Path to the wxis scripts
$xWxis="C:/ABCD/www/htdocs/$app_path/dataentry/wxis/";
$mx_path="C:/ABCD/www/cgi-bin/$cisis_ver"."mx.exe";
//default language
$lang="es";
//Default langue for the databases definition
$lang_db="es";
// use este lenguaje para seguir desplegando los registros con un código de página específico aunque cambie el lenguaje de diálogo
//$display_lang="";
//Url for the execution of WXis, when using GGI in place of exec
$wxisUrl="http://localhost:9090/cgi-bin/$cisis_ver"."wxis.exe";
//Name of the institution
$institution_name=$institution_name=$def["LEGEND2"];
//Ruta hacia el archivo con la configuración del FCKeditor
$FCKConfigurationsPath="/".$app_path."/dataentry/fckconfig.js";
//Ruta hacia el FCKEditor
$FCKEditorPath="/site/bvs-mod/FCKeditor/";
//USE THIS LOGIN AND PASSWORD IN CASE OF CORRUPTION OF THE OPERATORS DATABASE OR IF YOU DELETED, BY ERROR, THE SYSTEM ADMINISTRATOR
$adm_login="abcd";
$adm_password="abcd";
//Ruta hacia el archivo con la configuración del FCKeditor
$FCKConfigurationsPath="C:/ABCD/www/htdocs//php/dataentry/fckconfig.js";
//USE THIS PARAMETER TO SHOW THE ICON THAT ALLOWS THE BASES FOLDER EXPLORATION   (0=don't show, 1=show)
$dirtree=0;
//USE THIS PARAMETER TO ENABLE/DISABLE THE MD5 PASSWORD ENCRIPTYON (0=OFF 1=ON)
$MD5=0;
$empwebservicequerylocation = "http://localhost:8086/ewengine/services/EmpwebQueryService";
$empwebservicetranslocation = "http://localhost:8086/ewengine/services/EmpwebTransactionService";
$empwebserviceobjectsdb = "objetos";$empwebserviceusersdb = "*";
?>
