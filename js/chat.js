var HISTORIALES = {};
			
			function mensajes(){
				var ESTADO = {
					1 : "incognito",
					2 : "online",
					3 : "busy"
				};
				
				$.ajax({
					url:"php/chat/Uchat.php",
					type:"POST"
				}).done(function(resp){
					resp = JSON.parse(resp);
					
					$.each(resp["MENSAJE"]["CHAT"],function(indice,valor){
						if($("#chat"+valor["ORIGEN"]).length){
							$("#C"+valor["ORIGEN"]+"").click();
							$("#chat"+valor["ORIGEN"]).chatbox("option", "boxManager").addMsg(""+valor["NOMBRE"]+" "+valor["APELLIDO"]+"", valor["MENSAJE"]);
						}else{
							$("#C"+valor["ORIGEN"]+"").click();
							historial("chat"+valor["ORIGEN"],""+valor["NOMBRE"]+" "+valor["APELLIDO"]+"",valor["MENSAJE"],valor["ORIGEN"]);
							
							
						}
					});
					
					
					$.each(resp["MENSAJE"]["ESTADO"],function(indice,valor){
						$("#C"+valor["ID"]).attr("data-chat-status",ESTADO[valor["ESTADO"]]);
					});
				});
				
			}

function historial(e,a = "",b = "",c = ""){
				if(typeof HISTORIALES[c] === 'undefined'){
					
					$.ajax({
						url:"php/chat/Hchat.php",
						type:"POST",
						data:{"PARTNER":e}
					}).done(function(resp){
						resp = JSON.parse(resp);
						if(typeof HISTORIALES[resp["ORIGEN"]] === 'undefined'){
						$.each(resp["MENSAJE"],function(indice,valor){
							$("#chat"+resp["ORIGEN"]).chatbox("option", "boxManager").addMsg(""+valor["NOMBRE"]+" "+valor["APELLIDO"]+"", valor["MENSAJE"]);
						});
						}
						HISTORIALES[resp["ORIGEN"]] = "ok";
						if(a != "" && b != ""){
							$("#chat"+resp["ORIGEN"]).chatbox("option", "boxManager").addMsg(a,b );
						}
					});
				}
			}
			
			function enviamensaje(a,b,c){
				$.ajax({
					url:"php/chat/Echat.php",
					type:"POST",
					data:{"DESTINO":a,"MENSAJE":c}
				});
			};
