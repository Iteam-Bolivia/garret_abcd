<HTML><title>ABCD</title>
				<head>
				<script language=javascript src=js/lr_trim.js></script>
				<script languaje=javascript>
				self.resizeTo(screen.availWidth,screen.availHeight)
				self.moveTo(0,0)
				self.focus();
var neww=""

				var listabases=Array()
				var lock_db=''
				var browseby="mfn"
				var Expresion=""
				var Expre_b=""
                var typeofrecord=''
				var mfn=0
				var maxmfn=0
				var Mfn_Search=0
				var Max_Search=0
				var Search_pos=0
				var db_permiso="adm"
				var db_copies=""         // to check if the database uses the copies database
				var NombreBase='cepal1'
				var ix_basesel=0
				var ix_langsel=0
				var Marc=''
				var base="cepal1"
				var cipar="cepal1.par"
				var Formato='ALL'
				var tl=''
				var nr=''
				var xeliminar=0
				var xeditar=''
				var ModuloActivo="catalog"
				var CG_actual=''
				var CG_nuevo=''
				var prefijo_indice=""
				var formato_indice=""
				ValorCapturado=''
				var HTML=''        //FIELD TAG FOR LOADING THE FULL TEXT
				var URL=''         //FIELD TAG FOR STORING THE URL OF THE DOCUMENT STORED IN HTML
				var NombreBaseCopiarde=''
				var wks=""
				buscar=''
				lang='es'
				img_dir="";
				ep=''
				ConFormato=true
				Capturando=''
				toolbarEnabled=''      //enable/disable the toolbar
				function AbrirVentanaAyuda(){
					insWindow = window.open('../documentacion/ayuda.php?help='+lang+'/dataentry_toolbar.html', 'Ayuda', 'location=no,width=700,height=550,scrollbars=yes,top=10,left=100,resizable');
					insWindow.focus()
				}
			
function ApagarEdicion(){
     return
}

function PrenderEdicion(){
	return
}


function TipoDeRegistro(){
	top.main.location.href="typeofrecs.php?base="+base
	return
	top.frames[2].document.writeln("<html><body style='font-family:arial'>")
	top.main.document.writeln("<center><br><br>")
	top.main.document.writeln("<h4>Tipo de registro</h4><table>")
	tr=typeofrecord.split('$$$')
	ix=tr.length
	for (i=0;i<ix;i++){
		if (Trim(tr[i])!=""){
			linea=tr[i].split('|')
			top.main.document.writeln("<tr><td><a href=\"javascript:top.wks='"+tr[i]+"|"+tl+"|"+nr+"';top.Menu('crear')\"><span style='font-size:10px;font-family:arial'>"+linea[3]+"</span></a></td>")
		}
	}
	top.main.document.writeln("</table></body></html>")
	top.main.document.close()
}

function AddCopies(){
if (db_copies=="Y")
		urlcopies="&db_copies=Y"
	else
		urlcopies=""
	if (browseby=="search")
		Mfn_copy=Mfn_Search
	else
		Mfn_copy=mfn
    url='../copies/copies_add.php?base='+base+'&Mfn='+Mfn_copy+'&Formato='+Formato+urlcopies
	parent.main.document.writeln("<html>")
	parent.main.document.writeln("<body><font face=arial>")
	parent.main.document.writeln("<center><br><br>")
	parent.main.document.writeln("<h4></h4><table>\n")
parent.main.document.writeln('<tr><td><a href="'+url+'&wks=pr">Compra</a></td>')
parent.main.document.writeln('<tr><td><a href="'+url+'&wks=ex">Canje</a></td>')
parent.main.document.writeln('<tr><td><a href="'+url+'&wks=do">Donación</a></td>')
	parent.main.document.writeln("</table></body></html>")
	parent.main.document.close()

}

function ValidarIrA(){
  	xmfn=top.menu.document.forma1.ir_a.value

	var strValidChars = "0123456789";
   	if (xmfn.length == 0 || xmfn==0){
		alert("Debe introducir un  MFN")
		return false
	}
	blnResult=true
   	//  test strString consists of valid characters listed above
   	for (i = 0; i < xmfn.length; i++){
    	strChar = xmfn.charAt(i);
    	if (strValidChars.indexOf(strChar) == -1){
    		blnResult = false;
    	}
    }
	if (blnResult==false){
		alert("El valor debe ser numérico")
		return false
	}
	if (xmfn>maxmfn){
	  	alert("Número esta fuera de rango")
	  	return false
	}
	return xmfn
}

function Menu(Opcion){
    if (toolbarEnabled=="N")  {
    	alert("Debe guardar o cancelar el proceso de copia")
    	return
    }
	if (db_copies=="Y")
		urlcopies="&db_copies=Y"
	else
		urlcopies=""
    if (lock_db=="Y") return
    switch (Opcion){
		case "cancelar":
		case "actualizar":
	 	 	ApagarEdicion()
	 	 	break;
		case "editar":
	  		break;
	}

	if (Opcion!="eliminar") xeliminar=0
	if (base=="" ){
		alert("Por favor seleccione una base  de datos")
		return
	}
	Capturando=''
    ix=top.menu.document.forma1.formato.selectedIndex
	if (ix==-1){
		ix=0
	}else{
		Formato=top.menu.document.forma1.formato.options[ix].value
	}
	FormatoActual="&Formato="+Formato+"&Diferido=N"
    if (xeditar=="S" && Opcion!="cancelar" && Opcion!="eliminar" && Opcion!="z3950"){
     	alert("Debe actualizar o cancelar la edición del registro")
  		return
 	}
 	if (Opcion=="tabla" || Opcion=="ira"){

	 	xmfn=top.menu.document.forma1.ir_a.value
		if (xmfn=="")  {
		 	top.menu.document.forma1.ir_a.value=1
		}else{
		  	t=xmfn.split("/")
			top.menu.document.forma1.ir_a.value=t[0]
		}

	}
	works=""
	if (wks!="") works="&wks="+wks

    if (Opcion!="actualizar" && Opcion!="editar" && Opcion!="eliminar" && Opcion!="z3950") xeditar=""

 	if (Opcion!="eliminar") xeliminar=0

	if (browseby=="search"){
		tope=Max_Search

	}else{
		tope=maxmfn
	}

	switch (Opcion) {
		case "editar_HTML":
		case "importarHTML":
			Tag=HTML
			Tipo="B"
			if (Opcion=="importarHTML")
				Mfn="New"
			else
				Mfn=mfn
			top.main.location.href="import_doc_mnu.php?base="+base+"&Mfn="+Mfn+"&fURL="+URL+"&Tag="+HTML+"&Tipo="+Tipo+"&fURL="+URL
		/*
			msgwin=window.open("","Upload","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=800,height=400,top=100,left=5");
			msgwin.document.close();
			msgwin.document.writeln("<html><title>Subir archivo</title><body link=black vlink=black bgcolor=white>\n");
			msgwin.document.writeln("<form name=upload action=import_doc.php method=POST enctype=multipart/form-data>\n");
			msgwin.document.writeln("<input type=hidden name=base value="+base+">");                                     i
			msgwin.document.writeln("<input type=hidden name=fURL value='"+URL+"'>")
			msgwin.document.writeln("<input type=hidden name=Tag value="+HTML+">")
			msgwin.document.writeln("<input type=hidden name=Tipo value="+Tipo+">")
			msgwin.document.writeln("<input type=hidden name=Mfn value="+Mfn+">")
			msgwin.document.writeln("<br>");
			msgwin.document.writeln("<table width=100%>");
			msgwin.document.writeln("<tr><td class=menusec1>Archivo</td>\n");
			msgwin.document.writeln("<tr><td><input name=userfile[] type=file size=50></td></td>\n");
			msgwin.document.writeln("</table>\n");
			msgwin.document.writeln("  <input type=submit value='Subir archivo'>\n");
			msgwin.document.writeln("</form>\n");
			msgwin.document.writeln("</body>\n");
			msgwin.document.writeln("</html>\n");
			msgwin.focus() */
			break
		case "edit_Z3950":
			Desplegar="N"
            xError="S"
            if (browseby=="search")
				Mfn_p=Mfn_Search
			else
				Mfn_p=mfn
           	top.main.location.href="z3950.php?Mfn="+Mfn_p+"&Opcion=edit&base="+base+"&cipar="+cipar+FormatoActual
            break
		case "addloanobjects":
		    if (browseby=="search")
				Mfn_copy=Mfn_Search
			else
				Mfn_copy=mfn
			top.main.location.href="../copies/loan_objects_add.php?base="+base+"&Mfn="+Mfn_copy
			return
		case "addcopies":  // add copies to the inventory database
			if (browseby=="search")
				Mfn_copy=Mfn_Search
			else
				Mfn_copy=mfn
			top.main.location.href="../copies/copies_add.php?base="+base+"&Mfn="+Mfn_copy+"&Formato="+Formato+urlcopies
			return
		case "editdelcopies":    //edit/delete copies from the inventory database
			if (browseby=="search")
				Mfn_copy=Mfn_Search
			else
				Mfn_copy=mfn
			top.main.location.href="../copies/copies_edit.php?base="+base+"&Mfn="+Mfn_copy+"&Formato="+Formato+urlcopies
			return
		case 'home':
			if (base!="") url="&base="+base
			top.location.href="../common/inicio.php?reinicio=s"+url+neww;
			break
		case 'stats':
			top.main.location.href="../statistics/tables_generate.php?base="+base+"&cipar="+base+".par"
			break
		case "editdv":
			top.main.location.href="default_edit.php?Opcion=valdef&ver=N&Mfn=0&base="+top.base
			top.xeditar="valdef"
			break
		case "deletedv":
			top.main.location.href="default_delete.php?Opcion=valdef&ver=N&Mfn=0&base="+top.base
			break
		case "recvalidation":
			if (mfn==0 && Mfn_Search==0){
  				alert("Debe seleecionar un registro usando las flechas o el input box [ir a]")
  				return
  			}
  			if (browseby=="search")
  				mfn_edit=Mfn_Search
  			else
  				mfn_edit=mfn
  			url="recval_display.php?&base="+base+"&cipar="+cipar+"&Mfn="+mfn_edit
  			recvalwin=window.open(url,"recval","width=550,height=300,resizable,scrollbars")
  			recvalwin.focus()
			break;
		case "ejecutarbusqueda":
			Mfn_Search=1
			mfn=1
			top.main.document.location="fmt.php?Opcion=buscar&Expresion="+Expresion+"&base="+base+"&cipar="+cipar+"&from=1&ver=N"+FormatoActual+works+urlcopies
			break;
		case "busquedalibre":
			top.main.document.location="freesearch.php?&base="+base+"&cipar="+cipar+"&from=1&ver=N"+FormatoActual
			break;
		case "administrar":
			top.main.location="administrar.php?base="+base+"&cipar="+cipar
			break;
		case "copiar_archivo":
			top.main.document.location="copiar_archivo.php?&base="+base+"&cipar="+cipar
  	  		break
  	  	case 'imprimir':
  		 	top.main.document.location="../dbadmin/pft.php?Modulo=dataentry&base="+base+"&cipar="+cipar
  	  		break
  	  	case 'global':
  		 	top.main.document.location="c_global.php?&base="+base+"&cipar="+cipar
			return;
  	  		break
		case 'tabla':
			xmfn=top.menu.document.forma1.ir_a.value
			res=ValidarIrA()
			mfn=Number(xmfn)
  			if (res){
   				Opcion="tabla"

  		 		top.main.document.location.href="actualizarportabla.php?Opcion=tabla&base="+base+"&cipar="+cipar+"&Mfn="+mfn+"&ver=N"+FormatoActual+works
   				buscar=""
   			}
  	  		break
		case 'alfa':
			formato_ix=formato_indice+"'$$$'f(mfn,1,0)"
	    	Prefijo="&prefijo="+prefijo_indice+"&formato_e="+ formato_ix
			var width = screen.width-600-100
			url="alfa.php?Opcion=autoridades&base="+base+"&cipar="+cipar+Prefijo+"&Formato="+Formato
			msgwin=window.open(url,"Indice","status=yes,resizable=yes,toolbar=no,menu=yes,scrollbars=yes,width=600,height=580,top=10,left="+width)
    		msgwin.focus()
			break
  		case 'ayuda':
    		AbrirVentanaAyuda()
   			break
		case 'z3950' :
            Desplegar="N"
            xError="S"
            if (browseby=="search")
				Mfn_p=Mfn_Search
			else
				Mfn_p=mfn
            if (xeditar=="S"){
            	top.main.location.href="z3950.php?Mfn="+Mfn_p+"&Opcion=edit&base="+base+"&cipar="+cipar+FormatoActual
            }else{
            	top.main.location.href="z3950.php?Opcion=new&base="+base+"&cipar="+cipar+FormatoActual
            }
            break
    	case 'dup_record':
    	    if (mfn==0 && Mfn_Search==0){
  				alert("Debe seleecionar un registro usando las flechas o el input box [ir a]")
  				return
  			}
			xeditar="S"
			if (browseby=="search")
  				mfn_edit=Mfn_Search
  			else
  				mfn_edit=mfn
			cnv=""
			loc="fmt.php?Opcion=presentar_captura&Mfn="+mfn_edit+"&ver=N&base="+base+"&cipar="+base+".par&basecap="+base+"&ciparcap="+base+".par"+cnv
            top.main.location.href=loc
            break
		case 'capturar_bd' :
			Capturando='S'
            Desplegar="N"
            xError="S"
            formato_ix=escape(formato_indice+"'$$$'f(mfn,1,0)" )
			width=screen.width
			msgwin=window.open("capturar_main.php?base="+base+"&cipar="+cipar+"&formato_e="+formato_ix+"&prefijo="+prefijo_indice+"&formatoactual="+FormatoActual+"&fc=cap&html=ayuda_captura.html","capturar")
			msgwin.focus()
           	break
  		case 'proximo':
			if (mfn<=0) mfn=0
   			mfn++
   			if (mfn>tope) mfn=tope
   			Opcion="leer"
   			buscar=""
   			if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
  		case 'anterior':
   			if (mfn<=0) mfn=1
   			if (mfn>1) mfn=mfn-1
   			Opcion="leer"
   			buscar=""
            if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
  		case 'primero':
   			mfn=1
   			buscar=""
   			Opcion="leer"
   			if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
  		case 'ultimo':
   			mfn=tope
   			Opcion="leer"
   			buscar=""
   			if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
   		case "same":
   			Opcion="leer"
            buscar=""
   			if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
  		case 'eliminar':
			if (mfn==0){
				alert("Por favor despliegue el registro a ser borrado")
				return
			}
   			if (xeliminar==0){
    			alert("Haga click nuevamente en 'Borrar' para confirmar la eliminación de registro")
    			xeliminar=xeliminar+1
   			}else{
				if (xeditar=="S")
					Mfn_p=top.main.document.forma1.Mfn.value
				else
					if (browseby=="search")
						Mfn_p=Mfn_Search
					else
						Mfn_p=mfn

				if (Mfn_p=="New"){
					alert("Registro nuevo. Click en Cancel si quiere descartar el registro")
					return
				}
				if (Mfn_p==0){
					alert("Por favor despliegue el registro a ser borrado")
					return
				}
				if (xeliminar==""){
					alert("Haga click nuevamente en 'Borrar' para confirmar la eliminación de registro")
					xeliminar="1"
				}else{
					xeliminar=""
					xeditar=""
					top.main.document.location="../dataentry/fmt.php?Opcion=eliminar&base="+base+"&cipar="+cipar+"&Mfn="+Mfn_p+"&ver=N"+FormatoActual+works+urlcopies

				}
			}
			return
   			break
  		case 'ira':
  		  	xmfn=ValidarIrA()
			buscar=""
  			if (xmfn){
	  			if (ConFormato==true){
            		Opcion="ver"
        		}else{
         			Opcion="leer"
     			}
				mfn=xmfn
  		 	}
  			break
 		}

		if (Opcion=="editar"){
  			if (mfn==0 && Mfn_Search==0){
  				alert("Debe seleecionar un registro usando las flechas o el input box [ir a]")
  				return
  			}
  			ix=top.menu.document.forma1.wks.selectedIndex
  			if (ix==-1){
  			}else{
  				works="&wks="+top.menu.document.forma1.wks.options[ix].value
  			}

  			xeditar="S"
  			if (browseby=="search")
  				mfn_edit=Mfn_Search
  			else
  				mfn_edit=mfn
	  		 	top.main.document.location="../dataentry/fmt.php?Opcion=editar&base="+base+"&cipar="+cipar+"&Mfn="+mfn_edit+"&ver=N"+FormatoActual+works+urlcopies
  		 	return
  		}

		if (Opcion=="ver"){
  			if (tope!=0) top.main.document.location="../dataentry/fmt.php?Opcion=ver&base="+base+"&cipar="+cipar+"&Mfn="+mfn+"&ver=S"+FormatoActual+urlcopies
  			return
  		}
		if (Opcion=="leer"){
  			if (ConFormato==true){
            	Opcion="ver"
        	}else{
         		Opcion="leer"
     		}

            if (mfn<=0) mfn=1
            if (tope==0) return
            if (browseby=="mfn"){
  		 		top.main.document.location.href="../dataentry/fmt.php?Opcion="+Opcion+"&base="+base+"&cipar="+cipar+"&Mfn="+mfn+"&ver=S"+FormatoActual+works+urlcopies
  			}else{
  				url="../dataentry/fmt.php?Opcion=buscar&Expresion="+Expresion+"&base="+base+"&cipar="+cipar+"&from="+Search_pos+FormatoActual+"&Mfn="+Mfn_Search+urlcopies
  				top.main.document.location.href=url
  			}
  			return
  		}

        if (Opcion=="cancelar") {
        	if (mfn<=0) mfn=1
            if (browseby=="mfn"){
  		 		top.main.document.location.href="../dataentry/fmt.php?Opcion="+Opcion+"&base="+base+"&cipar="+cipar+"&Mfn="+mfn+"&ver=S"+FormatoActual+works+"&unlock=S"+urlcopies
  			}else{
  				url="../dataentry/fmt.php?Opcion=cancelar&base="+base+"&cipar="+cipar+"&from="+Search_pos+"&Mfn="+Mfn_Search+FormatoActual+urlcopies
  				url+="&unlock=S";
  				top.main.document.location.href=url
  			}
  			return
        }
  		if (Opcion=="nuevo" || Opcion=="crear"){
			tipom=""
			if (typeofrecord!="" && Opcion=="nuevo"){
				top.main.document.close()
				TipoDeRegistro()
			}else{
			    xeditar="S"
	 			top.main.document.location="../dataentry/fmt.php?Opcion=nuevo&base="+base+"&cipar="+cipar+"&Mfn=New&ver=N"+FormatoActual+"&tipom="+tipom+works+urlcopies
	 		}
  			return
  		}

  		if (Opcion=="actualizar"){
  			if (xeditar!="S"){
  				alert("Debe seleccionar la opción de edición antes de actualizar el registro")
    			return
  			}

  			xeditar=''
  			top.main.document.forma1.Opcion.value="actualizar"
  			top.main.document.forma1.submit()
  		}

 		if (Opcion=="buscar"){

  			top.buscar='S'
  			top.Search_pos=1
			top.main.document.location="../dataentry/buscar.php?Opcion=formab&prologo=prologoact&desde=dataentry&base="+base+"&cipar="+cipar+FormatoActual
  			return
  		}
  		if (Opcion=="cancelar")
     			ApagarEdicion()
     		else
     			PrenderEdicion()

	}

function Unload(){
	self.location.href="unload.php"
	alert("Fin de Sesión")
}

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
<p>hola </p>
<div class="sectionInfo">
	<div class="breadcrumb">
		<h3>Inicio - Catalogación</h3>
	</div>
	<div class="actions">
		<form name=frmModulo method=post action=../common/change_module.php>
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

</form>
<script>
function CambiarModulo(){
	ix=document.frmModulo.modulo.selectedIndex
	if (ix<1){
		return
	}
	document.frmModulo.submit()
}
</script>	</div>
	<div class="spacer">&#160;</div>
</div>
<!--- inicio codigo www.gratisparaweb.com ---><div align="center"><br><br><map name="Map"><area shape="rect" coords="48,1,90,22" href="http://www.cursosparati.com" target="_blank" alt="Cursos"></map></a></div><!--- fin codigo www.gratisparaweb.com --->
    
<div class="helper"><a href = ../documentacion/quienes.php target=_blank>Quienes somos</a>&nbsp &nbsp;&nbsp; &nbsp;
        <a href =../documentacion/biblioteca.php target=_blank>Biblioteca</a>&nbsp &nbsp;

        <a href =../documentacion/Contacto.php target=_blank>Contactos</a>&nbsp &nbsp;
        <a href = ../documentacion/ayuda.php?help=es/homepage.html target=_blank>Ayuda</a>&nbsp </div>
<div class="middle homepage">
    

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
				<h4><strong>Base de datos</strong></h4>
			</div>

			<div class="sectionButtons">
            	<div class="searchTitles">
					<form name="admin" action="dataentry/inicio_main.php" method="post">
					<input type=hidden name=encabezado value=s>
					<input type=hidden name=retorno value="../common/inicio.php">
					<input type=hidden name=modulo value=catalog>
					<input type=hidden name=newindow value=Y>
					<div class="stInput">

						<label for="searchExpr">Seleccionar:</label>

						<select name=base  class="textEntry singleTextEntry" >
							<option value=""></option>
<option value="^abiblo^badm|Cepal|Y" >Cepal
<option value="^akardek^badm|kardek" >kardek
<option value="^aprens^badm|prens" >prens

<option value="^acepal1^badm|cepal1" >cepal1
						</select>
					</div>
					<a href="javascript:CambiarBaseAdministrador('toolbar')" class="menuButton nextButton">

						<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
						<span><strong>Entrada de datos</strong></span>
					</a>
					</form>
				</div>

					&nbsp;
			</div>
			<div class="spacer">&#160;</div>

	  </div>
			<div class="boxBottom">
			<div class="bbLeft">&#160;</div>
			<div class="bbRight">&#160;</div>
		</div>
	</div>
