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

function horariosSuperpuestos(intervalos) {
  intervalos.sort(compare); //los ordena por dia
  var ok = true;
  var iGeneral = 0;
  var anterior;
  var arregloHorarios;
  var n;
  while ((iGeneral < intervalos.length) && ok) {
    var i = 0;
    anterior = intervalos[iGeneral].dia;
    arregloHorarios = new Array();
    while ((intervalos[i + iGeneral].dia == anterior) && (i + iGeneral < intervalos.length) && ok) {
      n = intervalos[i + iGeneral].desde;
      while ((n < intervalos[i + iGeneral].hasta) && ok) {
        if (!(include(arregloHorarios, n))) {
          arregloHorarios[arregloHorarios.length] = n; //en la ultima posicion coloca el horario "n"
          arregloHorarios.sort();
          n++;
        } else { //si la hora está incluida significa que ese horario ya esta, es decir esta mal definido
          ok = false;
          alert('En el horario ' + intervalos[i + iGeneral].num + ' el médico ya se encuentra ocupado. Corrija los horarios');
        }
      }
      if (i + iGeneral + 1 >= intervalos.length) {
        return ok;
      }
      anterior = intervalos[i + iGeneral].dia;
      i++;
    }
    if (iGeneral < intervalos.length) {
      iGeneral = iGeneral + i
    }
    ;
  }
  return ok;
}

function verificarHorario(numHorario) {
  var dia;
  var desde;
  var hasta;
  var i = 0;
  var ok = true;
  var intervalos = new Array();
  while ((i < numHorario) && (ok)) {
    var txt ="document.horario_div_"+i;
    if(!txt == null){
      i++;
    } else{
    i++;
    dia = (document.getElementById('dia' + i).value);
    desde = (document.getElementById('horarios' + i).value);
    hasta = (document.getElementById('horariosHasta' + i).value);
    if (dia != "Elija un dia") {
      if (desde != "Elija un horario") {
        if (hasta != "Elija un horario") {
          if ((parseInt(desde, 10)) >= (parseInt(hasta, 10))) {
            alert('El intervalo del horario ' + i + ' está mal definido');
            ok = false;
          } else {
            intervalos[i - 1] = new Intervalo(i, dia, parseInt(desde, 10), parseInt(hasta, 10));
          }
        } else {
          alert('El campo "hasta" del intervalo del horario ' + i + ' está vacio');
          ok = false;
        }
      } else {
        alert('El campo "desde" del intervalo del horario ' + i + ' está vacio');
        ok = false;
      }
    } else {
      alert('Seleccione un "día" en el horario ' + i);
      ok = false;
    }
  }}
  if (ok) {
    ok = horariosSuperpuestos(intervalos);
  }
  return ok;
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
                if (verificarHorario(numeroHorario)) {
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