function notas(){
	$.ajax({
		url:"php/sticky/notas.php",
	}).done(function(resp){
		resp = JSON.parse(resp);
		$("#NPUBLICAS").empty();
		$.each(resp["NOTAS"],function(indice,valor){
			var point = (valor["CUERPO"].length > 55)? "..." : "" ;
			var clip = (valor["FOTO"] != "NA")? "src='img/clip.png'":"";
			$("#NPUBLICAS").append("<li><a href='ajax/modal/sticky.php?ID="+valor["ID"]+"&P=N' data-toggle='modal' data-target='#detalle'><h2>"+valor["TITULO"]+"</h2><p>"+valor["CUERPO"].substr(0,60)+point+" </p><img "+clip+"><label class='fecha'>"+tonormaldate(valor["FECHA"])+"</label><label class='autor'>Atte: "+valor["NOMBRE"]+"</label></a></li>");
			
		});
		$("#NPROPIAS").empty();
		$.each(resp["PROPIAS"],function(indice,valor){
			var point = (valor["CUERPO"].length > 55)? "..." : "" ;
			console.log(valor["FOTO"]);
			var clip = (valor["FOTO"] != "NA")? "src='img/clip.png'":"";
			$("#NPROPIAS").append("<li><a href='ajax/modal/sticky.php?ID="+valor["ID"]+"&P=S' data-toggle='modal' data-target='#detalle'><label onclick='elim_sticky("+valor["ID"]+")' class='close'><i class='fa fa-times'></i></label><h2>"+valor["TITULO"]+"</h2><p>"+valor["CUERPO"].substr(0,60)+point+" </p><img "+clip+"><label class='fecha'>"+tonormaldate(valor["FECHA"])+"</label><label class='autor'>Atte: "+valor["NOMBRE"]+"</label></a></li>");
			
		});
	});
	
}

function elim_sticky(id){
	$.SmartMessageBox({
		title : "¿Desea eliminar la Nota? ",
		buttons : "[Aceptar][Cancelar]"
	}, function(boton, valor) {
		if(boton == "Aceptar"){
			$.ajax({
				url:"php/sticky/elim_sticky.php",
				type:"POST",
				data: {"DATO":id}
			}).done(function(resp){
				resp = JSON.parse(resp);
				alerta(resp["ESTADO"],resp["MENSAJE"]);
				notas();
			});
		}
	});
}
