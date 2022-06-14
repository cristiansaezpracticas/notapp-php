$(document).ready(function () {
	
	$("#search").click(function () {
		
		if ($("#buscador").css("display") == "block"){
			$("#buscador").css("display", "none");
		} else {
			$("#buscador").css("display", "block");
		}
		
	});
	
	document.addEventListener("keyup", e => {
		//Buscará el input con el id buscador
		if (e.target.matches('#buscador')) {
			$.ajax({
				url: "/encuentra_notas/" + e.target.value.toLowerCase(),
				method: "get",
				dataType: 'json',
				success: function(response) {
					let notasHtml = "";
					
					response.forEach(nota => {
						notasHtml += `<a href="/ver_nota/${nota.id}">
							<div class="col">
								<h2 class="titulo">${nota.titulo}</h2>	
								<p>${nota.descripcion}</p>
							</div>
						</a>`;
					});
					
					$("#wrapper").html(notasHtml);
				}
			});
		}
	});
	
});