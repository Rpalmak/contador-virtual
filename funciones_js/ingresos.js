function showAlert(message) {
  alert(message);
}

function ingresarSueldo() {
  let sueldo = document.getElementById("sueldo").value;
  if (sueldo === "") {
    event.preventDefault();
    alert("Debe ingresar un valor");
    return;
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ingresarSueldo.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      let respuesta = JSON.parse(this.responseText);
      if (respuesta.status === "success") {
        alert("Nuevo registro creado exitosamente");
      } else {
        alert("Error: " + respuesta.error);
      }
    }
  };
  xhr.send("sueldo=" + sueldo);
}




function ingresarOtros(monto, nombre) {
  if (!monto || !nombre) {
    event.preventDefault();
    alert("Debe ingresar valores en los campos monto y nombre");
    return;
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ingresarOtros.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      let respuesta = JSON.parse(this.responseText);
      if (respuesta.status === "success") {
        alert("Nuevo registro creado exitosamente");
      } else {
        alert("Error: " + respuesta.error);
      }
    }
  };
  xhr.send("monto=" + monto + "&nombre=" + nombre);
}







function borrarRegistro(id) {
  var monto = $(this).closest("tr").find("td:eq(1)").text();
  if (confirm("¿Está seguro de eliminar el registro?")) {
    $.ajax({
      url: "deleteIngresos.php",
      type: "POST",
      data: {
        id: id
      },
      success: function(data) {
        location.reload();
      }
    });
  }
}
$(document).ready(function() {
  $(".deleteIngresos").click(function() {
    var id = $(this).attr("id");
    borrarRegistro(id);
  });
});