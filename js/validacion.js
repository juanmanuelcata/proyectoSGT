function veriFormuEspecialidad() {
  var nom = (document.getElementById('input01').value);
  var le = /([a-z]|[A-Z]\s?)/;
  if (le.test(nom)) {
    var res = confirm("¿Seguro de agregar esta especialidad?");
    if (res == true)
      return true;
    else
      return false;
  }
  else{
    alert('El campo especialidad no puede estar vacio');
    return false;
  }
}

function soloLetras(e) {// 1
  tecla = (document.all) ? e.keyCode : e.which; // 2
  if (tecla == 8)
    return true; // 3
  patron = /[a-zA-Z-áéíóúüñ\s]/; // 4
  te = String.fromCharCode(tecla); // 5
  return patron.test(te); // 6
}


function justNumbers(e) {
  var keynum = window.event ? window.event.keyCode : e.which;
  if (keynum == 8)
    return true;
  patron = /[0-9]/;
  return patron.test(String.fromCharCode(keynum));
}

function justFecha(e) {
  var keynum = window.event ? window.event.keyCode : e.which;
  if (keynum == 8)
    return true;
  patron = /[0-9\-]/;
  return patron.test(String.fromCharCode(keynum));
}


/*   var nom = (document.getElementById('esp_nue').value);
 var le = [A-Z];
 var continuo = false;
 if (le.test(nom) || nom == "")
 continuo = true;
 else
 alert('El campo especialidad tiene carateres incorrectos');
 return continuo;
 }*/

function veriformuUsr() {
  var usr = (document.getElementById('user').value);
  var pass1 = (document.getElementById('pass').value);
  var pass2 = (document.getElementById('pass2').value);
  var nom = (document.getElementById('nombre').value);
  var ap = (document.getElementById('apellido').value);
  var dni = (document.getElementById('dni').value);
  var mail = (document.getElementById('mail').value);
  var le = /([a-z]|[A-Z]|[0-9]\s?)/;
  var nu = /^(?:\+|-)?\d+$/;
  var re = /^((\w|\.){2,}@)\w{3,}\.\w{2,4}((\.(\w{2}))?)?$/;
  var continuo = false;
  if (le.test(usr))
    if (le.test(pass1) && (pass1.length >= 4))
      if (pass1 === pass2)
        if (le.test(nom))
          if (le.test(ap))
              
            if ((dni.length == 8) || (dni.length == 7))
              if (re.test(mail)) {
                var res = confirm('¿Seguro de agregar este usuario?');
                return res;
              }
              else
                alert('El campo "Correo electrónico" es incorrecto');
            else
            if (nu.test(dni))
              alert('El campo "DNI" debe tener 8 dígitos');
            else
              alert('El campo "DNI" no puede estar vacío');
          else
            alert('El campo "Apellido" no puede estar vacío');
        else
          alert('El campo "Nombre" no puede estar vacío')
      else
        alert('Las contraseñas deben coincidir');
    else
    if (le.test(pass1))
      alert('El campo "Contraseña" debe tener 4 caracteres mínimo');
    else
      alert('El campo "Contraseña" no puede estar vacío');
  else
    alert('El campo "Usuario" no puede estar vacio');
  return continuo;
}

function Intervalo(num, dia, desde, hasta) {
  this.num = num;
  this.dia = dia;
  this.desde = desde;
  this.hasta = hasta;
}

function compare(a, b) {
  if (a.dia < b.dia)
    return -1;
  if (a.dia > b.dia)
    return 1;
  return 0;
}

function include(arr, obj) {
  for (var i = 0; i < arr.length; i++) {
    if (arr[i] == obj) {
      return true;
    }
  }
  return false;
}

function superpocicion(arregloDiv, n) {
  for (var l = 0; l < n; l++){
    var dia = arregloDiv[l][0];
    var desde = arregloDiv[l][1];
    var hasta = arregloDiv[l][2];
    var a = desde.split(':');
    var b = hasta.split(':');
    var sd = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
    var sh = (+b[0]) * 60 * 60 + (+b[1]) * 60 + (+b[2]);
    for (var k = l; k < n; k++){
      var dia2 = arregloDiv[k][0];
      if (dia == dia2){
        var desde2 = arregloDiv[k][1];
        var hasta2 = arregloDiv[k][2];
        var c = desde2.split(':'); // split it at the colons
        var d = hasta2.split(':'); // split it at the colons
        var sd2 = (+c[0]) * 60 * 60 + (+c[1]) * 60 + (+c[2]);
        var sh2 = (+d[0]) * 60 * 60 + (+d[1]) * 60 + (+d[2]);
        if (((( sd < sd2 ) && ( sd2 < sh )) || (( sd < sh2 ) && ( sh2 < sh ))) || ((( sd2 < sd ) && ( sd < sh2)) || (( sd2 < sh ) && ( sh < sh2 )))){
            alert("el horario "+(l+1)+" y el horario "+(k+1)+" estan superpuestos")
            return false;
        }
      }
    }   
  }
  return true;
}

function verificarHorario() {
  var n = $('#grillahoraria').find('div').length;
  var arregloDiv = new Array(n);
  for (var k = 0; k < n; k++)
    arregloDiv[k] = new Array(3);
  var p = 0;
  $('#grillahoraria').find('div').each(function() {
    var i = 0;
    $(this).find('select').each(function() {
      arregloDiv[p][i] = $(this).val();
      i++;
    });
    p++;
  });
  return superpocicion(arregloDiv, n);
}

function veriformuMed() {
  var nom = (document.getElementById('nombre').value);
  var ap = (document.getElementById('apellido').value);
  var dni = (document.getElementById('dni').value);
  var matricula = (document.getElementById('matricula').value);
  var mail = (document.getElementById('mail').value);
  var telefono = (document.getElementById('tel').value);
  var le = /([a-z]|[A-Z]\s?)/;
  var nu = /^(?:\+|-)?\d+$/;
  var re = /^((\w|\.){2,}@)\w{3,}\.\w{2,4}((\.(\w{2}))?)?$/;
  var continuo = false;
  if (le.test(nom))
    if (le.test(ap))
      if ((dni.length == 8) || (dni.length == 7))
        if (nu.test(matricula))
          if (re.test(mail))
            if (nu.test(telefono) && (telefono.length == 10))
              if (cantHorarios != 0) {
                if (verificarHorario()) {
                  var res = confirm("¿Seguro de agregar este medico?");
                  if (res == true)
                    return true
                  else
                    return false
                }
              }
              else
                alert('Ingrese al menos un horario.');
            else
            if (nu.test(telefono))
              alert('El campo "Teléfono" debe tener 10 dígitos');
            else
              alert('El campo "Teléfono" no puede estar vacío');
          else
            alert('El campo "Correo electrónico" es incorrecto');
        else
          alert('La Matrícula es incorrecta');
      else
      if (nu.test(dni))
        alert('El campo "DNI" debe tener 8 dígitos');
      else
        alert('El campo "DNI" no puede estar vacío');
    else
      alert('El campo "Apellido" no puede estar vacío.');
  else
    alert('El campo "Nombre" no puede estar vacío');
  return continuo;
}

function veriformuPaciente() {
  var nom = (document.getElementById('nombre').value);
  var ap = (document.getElementById('apellido').value);
  var dni = (document.getElementById('dni').value);
  var fechaNac = (document.getElementById('fechaNac').value);
  var localidad = (document.getElementById('localidad').value);
  var calle = (document.getElementById('calle').value);
  var altura = (document.getElementById('altura').value);
  var mail = (document.getElementById('mail').value);
  var telefono = (document.getElementById('tel').value);
  var le = /([a-z]|[A-Z]\s?)/;//verifica letras
  var nu = /^(?:\+|-)?\d+$/;// verifica que solo se usen numeros
  var re = /^((\w|\.){2,}@)\w{3,}\.\w{2,4}((\.(\w{2}))?)?$/; //para mails
  var fe = /^((?:19|20)\d\d)\-((?:0?[1-9])|(?:1[0-2]))\-((?:0?[1-9])|(?:[12]\d)|(?:3[01]))$/; // fechas
  var continuo = false;
  if (le.test(nom))
    if (le.test(ap))
      if ((dni.length == 8) || (dni.length = 7))
        if (fe.test(fechaNac))
          if (le.test(localidad))
            if (calle != "")
              if (altura != "")
                if (re.test(mail))
                  if (telefono.length == 10) {
                    var res = confirm("¿Seguro de agregar este paciente?");
                    if (res == true)
                      return true
                    else
                      return false
                  }
                  else
                  if (nu.test(telefono))
                    alert('El campo "Teléfono" debe tener 10 caracteres');
                  else
                    alert('El campo "Teléfono" no puede estar vacio');
                else
                  alert('El correo electrónico es incorrecto');
              else
                alert('el campo "Altura" no puede estar vacio');
            else
              alert('El campo "Calle" no puede estar vacío');
          else
            alert('El campo "Localidad" no puede estar vacío');
        else
          alert('Error en el campo "Fecha de nacimiento"');
      else
        alert('El DNI es incorrecto');
    else
      alert('El campo "Apellido" no puede estar vacio');
  else
    alert('El campo "Nombre" no puede estar vacio');
  return continuo;
}


function veriformuPacienteMod() {
  var nom = (document.getElementById('nombre').value);
  var ap = (document.getElementById('apellido').value);
  var dni = (document.getElementById('dni').value);
  var fechaNac = (document.getElementById('fechaNac').value);
  var localidad = (document.getElementById('localidad').value);
  var calle = (document.getElementById('calle').value);
  var altura = (document.getElementById('altura').value);
  var mail = (document.getElementById('mail').value);
  var telefono = (document.getElementById('tel').value);
  var le = /([a-z]|[A-Z]\s?)/;//verifica letras
  var nu = /^(?:\+|-)?\d+$/;// verifica que solo se usen numeros
  var re = /^((\w|\.){2,}@)\w{3,}\.\w{2,4}((\.(\w{2}))?)?$/; //para mails
  var fe = /^((?:19|20)\d\d)\-((?:0?[1-9])|(?:1[0-2]))\-((?:0?[1-9])|(?:[12]\d)|(?:3[01]))$/; // fechas
  var continuo = false;
  if (le.test(nom))
    if (le.test(ap))
      if (nu.test(dni) && dni.length == 8)
        if (fe.test(fechaNac))
          if (le.test(localidad))
            if (calle != "")
              if (altura != "")
                if (re.test(mail))
                  if (telefono.length == 10) {
                    var res = confirm("¿Seguro de modificar este paciente?");
                    if (res == true)
                      return true
                    else
                      return false
                  }
                  else
                  if (nu.test(telefono))
                    alert('El campo "Teléfono" debe tener 10 caracteres');
                  else
                    alert('El campo "Teléfono" no puede estar vacio');
                else
                  alert('El correo electrónico es incorrecto');
              else
                alert('el campo "Altura" no puede estar vacio');
            else
              alert('El campo "Calle" no puede estar vacío');
          else
            alert('El campo "Localidad" no puede estar vacío');
        else
          alert('Error en el campo "Fecha de nacimiento"');
      else
        alert('El DNI es incorrecto');
    else
      alert('El campo "Apellido" no puede estar vacio');
  else
    alert('El campo "Nombre" no puede estar vacio');
  return continuo;
}




function verifObra() {
  var obra = (document.getElementById('input01').value);
  var le = /([a-z]|[A-Z]\s?)/;
  var continuo = false;
  if (le.test(obra)) {
    var res = confirm("¿Seguro de agregar esta obra social?");
    if (res == true)
      return true
    else
      return false
  }
  else
    alert('El campo de obra social no debe estar vacio');
  return continuo;
}

function veriMod() {

  {
    var x;
    var r = confirm("¿seguro de aplicar los cambios?");
    if (r == true)
    {
      x = '<input type="hidden" name="ok" value="1"/>';
    }
    else
    {
      x = '<input type="hidden" name="" value="1"/>';
    }
    document.getElementById("conf").innerHTML = x;
  }
}

function verificarLicencia(){
    var desde = (document.getElementById('desde').value);
    var hasta = (document.getElementById('hasta').value);
    fecha_actual = new Date(10,8,1999);
 // NO HACE FALTA   fecha_actual = document.write(fecha_actual.getDate() + "/" + (fecha_actual.getMonth() +1) + "/" + fecha_actual.getFullYear());
    if (desde > hasta) {
        alert('El intervalo está mal definido');
        return false;
    }
     else
         if (desde <= fecha_actual){
             alert('La fecha de inicio de la licencia es incorrecto');
             return false;
         }
         else
             return true;
    }