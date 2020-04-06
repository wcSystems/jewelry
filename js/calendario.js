var fullviewcalendar;

function calendario(){
	// full calendar
		
		var date = new Date();
	    var d = date.getDate();
	    var m = date.getMonth();
	    var y = date.getFullYear();
	
	    var hdr = {
	        left: 'title',
	        center: 'month,agendaWeek,agendaDay',
	        right: 'prev,today,next'
	    };
	
	   
	
	    /* initialize the external events
		 -----------------------------------------------------------------*/
	
	
	    /* initialize the calendar
		 -----------------------------------------------------------------*/
	
	    fullviewcalendar = $('#calendar').fullCalendar({
	
	        header: hdr,
			        editable: false,
			        droppable: false, // this allows things to be dropped onto the calendar !!!
					 selectable: true,
		
				
					  eventClick: function(calEvent, jsEvent, view) {
						console.log(calEvent);
							$("#oculto").attr("href","ajax/modal/calendario.php?P=S&ID="+calEvent["id"]).click();
						},
					viewRender: function(){
						eventos();
					},
			        eventRender: function (event, element, icon) {
			            if (!event.description == "") {
			                element.find('.fc-title').append("<br/><span class='ultra-light'>" + event.description +
			                    "</span>");
			            }
			            if (!event.icon == "") {
			                element.find('.fc-title').append("<i class='air air-top-right fa " + event.icon +
			                    " '></i>");
			            }
			        },
			
			        windowResize: function (event, ui) {
			            $('#calendar').fullCalendar('render');
			        }
			    });
		
		    /* hide default buttons */
		    $('.fc-right, .fc-center').hide();

		
			$('#calendar-buttons #btn-prev').click(function () {
			    $('.fc-prev-button').click();
			    return false;
			});
			
			$('#calendar-buttons #btn-next').click(function () {
			    $('.fc-next-button').click();
			    return false;
			});
			
			$('#calendar-buttons #btn-today').click(function () {
			    $('.fc-today-button').click();
			    return false;
			});
	
}

function eventos(){
	var date = $("#calendar").fullCalendar('getDate').month() + 1;
	var ano = $("#calendar").fullCalendar('getDate').year();
	
	$.ajax({
		url:"php/evento/lista.php",
		type:"POST",
		data:{"MES":date,"ANO":ano}
	}).done(function(resp){
		resp = JSON.parse(resp);
		
		$("#calendar").fullCalendar("removeEvents");
		$.each(resp,function(indice,valor){
			var desde = tonormaldate(valor["DESDE"]);
			var hasta = tonormaldate(valor["HASTA"]);
			desde = desde.split("/");
			hasta = hasta.split("/");
			
			$('#calendar').fullCalendar('renderEvent', {
				id : valor["ID"],
				title: valor["TITULO"],
				start: new Date(desde[2],desde[1] -1,desde[0]),
				end:new Date(hasta[2],hasta[1] -1,hasta[0]),
				allDay: true,
				description: valor["CUERPO"],
				className: ["event", ""+valor["FONDO"]+" "+valor["TEXTO"]+""],
				icon: valor["ICONO"]
			});
		});
		
		
	});
	
}

function elimevento(id){
	$(".cerrar").click();
	$.SmartMessageBox({
		title : "¿Desea eliminar este Evento? ",
		buttons : "[Aceptar][Cancelar]"
	}, function(boton, valor) {
		if(boton == "Aceptar"){
			$.ajax({
				url:"php/evento/elim_evento.php",
				type:"POST",
				data: {"DATO":id}
			}).done(function(resp){
				resp = JSON.parse(resp);
				alerta(resp["ESTADO"],resp["MENSAJE"]);
				eventos();
			});
		}
	});
}
