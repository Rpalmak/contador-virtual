function showAlert(message) {
    alert(message);
  }



  function ingresarEgresos() {
    let monto = document.getElementById('monto').value;
    let categoria = document.getElementById('categoria').value;
    let comentario = document.getElementById('comentario').value;
    let fecha = document.getElementById('fecha').value;
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ingresarEgresos.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                let respuesta = JSON.parse(this.responseText);
                if (respuesta.status === "success") {
                    alert("Nuevo registro creado exitosamente");
                } else {
                    alert("Error: " + respuesta.error);
                }
            } else {
                alert("Error: Se ha producido un error en la respuesta de la petición HTTP. Código de estado: " + this.status);
            }
        }
    };
    xhr.send("monto=" + monto + "&categoria=" + categoria + "&comentario=" + comentario + "&fecha=" + fecha);
}







            function borrarRegistro(id) {
              var monto = $(this).closest("tr").find("td:eq(1)").text();
              if (confirm("¿Está seguro de eliminar el registro?")) {
                $.ajax({
                  url: "deleteEgresos.php",
                  type: "POST",
                  data: { id: id },
                  success: function(data) {
                    location.reload();
                  }
                });
              }
            }
            $(document).ready(function() {
              $(".deleteEgresos").click(function() {
                var id = $(this).attr("id");
                borrarRegistro(id);
              });
            });