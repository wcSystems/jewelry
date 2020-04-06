function callajax(URL,DATOS,BLOQUEO = "noaplicado",ALERTA = "sinalerta"){
	$.ajax({
		url: URL,
		type : "POST",
		data : {"DATO" : JSON.stringify(DATOS)},
		beforeSend : function(){
			if(BLOQUEO != "noaplicado"){$(BLOQUEO).attr("disabled","disabled");};
			if(ALERTA != "sinalerta"){alerta("envio",ALERTA);};
		}
	}).done(function(resp){
		if(BLOQUEO != "noaplicado"){$(BLOQUEO).removeAttr("disabled");}
		resp = JSON.parse(resp);
		return resp;
	});	
}

function archivo(URL,FILE,ID,MENSAJE = "sindefinir"){
	var resultado = "";
	var datos = new FormData();
	datos.append("archivo",FILE);	
	datos.append("tipo",ID);	
	$.ajax({
        url: URL,  
        type: 'POST',
        async: true,
        xhr: function() {
			var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = evt.loaded / evt.total;
                    var percentComplete = Math.round(percentComplete * 100);
                    if(percentComplete == 0){
						$('.'+ID+'-progress').removeClass("bg-color-green").addClass("bg-color-darken");
					}
                    $('.'+ID+'-progress').css("width",percentComplete+"%");
                    if(percentComplete == 100){
						$('.'+ID+'-progress').removeClass("bg-color-darken").addClass("bg-color-green");
					}
                }
            }, false);
            return xhr;
        },
        data: datos,
        processData: false, 
        contentType: false
    }).done(function(resp){
		resp = JSON.parse(resp);
		if(resp["ESTADO"] == "error"){
			alerta("error",resp["MENSAJE"]["MENSAJE"]);
		}else{
			$("."+ID+"-progress-file").val(resp["MENSAJE"]["FILE"]);
			if(MENSAJE != "sindefinir"){
				alerta("success",MENSAJE);
			}
			return resp["MENSAJE"]["FILE"];
		}
	});
}

function checknumero(myString) {
	return /\d/.test(myString);
}
function checkemail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}
function tonormaldate(date){
	var newdate = date.split("-");
	newdate = newdate[2]+"/"+newdate[1]+"/"+newdate[0];
	return newdate;
}
function fileexist(url){
	var http = new XMLHttpRequest();
	http.open('HEAD', url, false);
	http.send();
	return http.status!=404;
}

function alerta(tipo,mensaje) {
	var temp = {
		"success" : {"color":"#739E73","icono":"fa fa-check bounce animated"},
		"envio" : {"color":"#3276B1","icono":"fa fa-send bounce animated"},
		"error" : {"color":"#C46A69","icono":"fa fa-times bounce animated"}
	};
	$.smallBox({
		title : mensaje,
		content : "<i class='fa fa-clock-o'></i> <i>hace 1 segundo...</i>",
		color : temp[tipo]["color"],
		iconSmall : temp[tipo]["icono"],
		timeout : 5000
	});
};

function smartmesaje(TITULO,MENSAJE = "",CAMPO = "",LISTADO = "",PLACEHOLDER = "",CALLBACK = ""){
	$.SmartMessageBox({
		title : TITULO,
		content : MENSAJE,
		input : CAMPO,
		placeholder : PLACEHOLDER,
		options : LISTADO,
		buttons : "[Aceptar][Cancelar]"
	}, function(boton, valor) {
		if(boton == "Aceptar"){
			
			if(CAMPO == ""){ return true ;}else{ return valor;console.log("empty");if(CALLBACK != ""){
				
				eval(CALLBACK);
			}};
			
			
		}else{
			return false;
		}
	});
}

function bandeja(){
				
				$.ajax({
					url:"php/mensajeria/Ubandeja.php",
					type:"POST"
				}).done(function(resp){
					$(".sinleer").text(resp);
					
					
				});
				
			}

function isFunction(variableToCheck){
				//If our variable is an instance of "Function"
				if (v instanceof Function) {
					return true;
				}
				return false;
			}

function simplenotes(val){
	localStorage.setItem("NOTES",val);
}

function getnotes(){
	if(localStorage.getItem("NOTES") != undefined){
		
		$("#simplenote").val(localStorage.getItem("NOTES"));
	}
};

function savenotas(){
	
}

function notif(){
	$.ajax({
		url:"php/notificaciones/check.php",
		type:"POST"
	}).done(function(resp){
		resp = JSON.parse(resp);
		
		var cont = 0;
		$.each(resp,function(indice,valor){
			
			noti[valor["ID"]] = {"NOTIFICACION":valor["NOTIFICACION"]};
			cont++;
		});
		$(".notification-body").empty();
		$.each(noti,function(indice,valor){
			
			$(".notification-body").prepend(valor["NOTIFICACION"]);
		});
		//var t = parseInt($("#activity b").text());
		$("#activity b").text(cont);
	});
}

function Hnotif(){
	$.ajax({
		url:"php/notificaciones/historico.php",
		type:"POST"
	}).done(function(resp){
		resp = JSON.parse(resp);
		
		//var cont = 0;
		$.each(resp,function(indice,valor){
			
			noti[valor["ID"]] = {"NOTIFICACION":valor["NOTIFICACION"]};
			//cont++;
		});
		//$(".notification-body").empty();
		$.each(noti,function(indice,valor){
			
			$(".notification-body").prepend(valor["NOTIFICACION"]);
		});
		//var t = parseInt($("#activity b").text());
		//$("#activity b").text(cont);
	});
}

function money(n, c, d, t) {
		  var c = isNaN(c = Math.abs(c)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
			j = (j = i.length) > 3 ? j % 3 : 0;

		  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
		};

function readed(){
	$.ajax({
		url:"php/notificaciones/readed.php",
		type:"POST"
	}).done(function(resp){
		
	});
	
};
