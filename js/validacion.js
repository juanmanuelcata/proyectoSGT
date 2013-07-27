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
  else {
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


var control = true;
function individual(id) {//resive el id del div y un boolean s (true si viene desde otra fucnion y false si viene del select html)
  var horario = new Array(3);//crea un arreglo de 3 para dia desde y hasta
  var i = 0; //variable indice
  $('#' + id).find('select').each(function() {//le pido al div que encuentre sus select y para cada uno ejecuto la funcion
    horario[i] = $(this).val();//arreglo enla poicion toma el valor del select actual(quedaria "dia" "desde" "hasta")
    i++;//incremento i
  });
  var desde = horario[1];     //horario en formato "hh:mm:ss"
  var hasta = horario[2];     //horario en formato "hh:mm:ss"
  var a = desde.split(':');   //separa el tring del horario hh:mm:ss por el caracter ":"
  var b = hasta.split(':');//separa el tring del horario hh:mm:ss por el caracter ":"
  var sd = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); //pasa el hroario a segundos
  var sh = (+b[0]) * 60 * 60 + (+b[1]) * 60 + (+b[2]); //pasa el hroario a segundos
  if (sd >= sh) { //si desde es mayor o igual a hasta
    return false; //retorna false y corta
  }
  //si ese horario es valido entonces
  return true;
}

//revisar si alguno de los horarios ingresados se superpone con otro
function superpocicion(arregloDiv, n) {//resive un arreglo de divs que cada uno contiene otro arreglo de 3 con "dia" "desde" y "hasta" respectivamente
  for (var l = 0; l < n; l++) {//for que itera sobre el arreglo de divs
    var dia = arregloDiv[l][0];       //asignacion del dia "lunes" martes, etc
    var desde = arregloDiv[l][1];     //horario en formato "hh:mm:ss"
    var hasta = arregloDiv[l][2];     //horario en formato "hh:mm:ss"
    var a = desde.split(':');   //separa el tring del horario hh:mm:ss por el caracter ":"
    var b = hasta.split(':');//separa el tring del horario hh:mm:ss por el caracter ":"
    var sd = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); //pasa el hroario a segundos
    var sh = (+b[0]) * 60 * 60 + (+b[1]) * 60 + (+b[2]); //pasa el hroario a segundos
    for (var k = l; k < n; k++) {//for que itera sobre arreglo de dia desde y hasta dentro de cada div...
      var dia2 = arregloDiv[k][0];//asignacion del dia "lunes" martes, etc
      if (dia == dia2) { //si los dias son iguales entonces podria darse una superpocicion
        var desde2 = arregloDiv[k][1];//horario en formato "hh:mm:ss"
        var hasta2 = arregloDiv[k][2];//horario en formato "hh:mm:ss"
        var c = desde2.split(':'); //separa el tring del horario hh:mm:ss por el caracter ":"
        var d = hasta2.split(':'); //separa el tring del horario hh:mm:ss por el caracter ":"
        var sd2 = (+c[0]) * 60 * 60 + (+c[1]) * 60 + (+c[2]); //pasa el hroario a segundos
        var sh2 = (+d[0]) * 60 * 60 + (+d[1]) * 60 + (+d[2]); //pasa el hroario a segundos
        //este if es algo bardero pero no es complicado... solo verifica las posible superpociciones
        //si  (desde2 esta entre desde1 y hasta1)
        // O (hasta2 esta entre desde1 y hasta1)
        //  O (desde1 esta entre deade2 y hasta2)
        //   O (hasta1 esta entre desde2 y hasta2)
        if ((((sd < sd2) && (sd2 < sh)) || ((sd < sh2) && (sh2 < sh))) || (((sd2 < sd) && (sd < sh2)) || ((sd2 < sh) && (sh < sh2)))) {
          alert("el horario " + (l + 1) + " y el horario " + (k + 1) + " estan superpuestos");
         // control = false;
          return false;//devuelve falso y corta
        }
      }
    }
  }//si no se detecta ninguna superpocicion entonces esta todo bien
  return true;//devuelve true y corta
}

//funcion que se llama al presionar "enviar"
function verificarHorario() {
  var n = $('#grillahoraria').find('div').length;//obtener la cantidad de "div_horarios"
  if (n == 0) {
    control = false;
    alert("Por favor defina al menos un horario, sino no, no tiene sentido dar de alta un medico que no atiende nunca, chanta!!!! ñoqui!!!");
  }
  else{
  var arregloDiv = new Array(n); //creo arreglo del largo de los divs
  for (var k = 0; k < n; k++) //para cada posicion del arreglo de divs creo un 
    arregloDiv[k] = new Array(3);//arreglo de 3 para el dia, desde y hasta
  var p = 0;//indice del arreglo divs_horaio
  $('#grillahoraria').find('div').each(function() { //le pido al div general que encuentre todos sus divs y para cada uno hago la funcion
    var i = 0; //indive para el arreglo interno dia desde hasta
    $(this).find('select').each(function() {//a cada div dentro del general le pido que encuentre sus select y pra cada uno hago la funcion
      arregloDiv[p][i] = $(this).val(); //simplemente armo la matriz utilizando los indices p , i, que declare anteriormente     
      i++;//incremento indice i
    });
    var oID = $(this).attr("id");//obtengo el id del div en el que estoy actualmente
    if (n == 1) { //si solo hay un horario verifico que sea valido
      if (!individual(oID)) { //si desde > hasta
        alert("Solo ingreso un horario y lo hizo mal... por favor... puede hacerlo mejor ¬¬ inutil!!! >.<")
        control = false;
        return false;//devuelve false y corta
      }
    }
    else{
        if (!individual(oID)) {//si individual da falso es que este horario esta mal definido
          alert("el horario " + (p + 1) + " esta mal definido a");
          control = false;
          return false;//devuelvo false y corta
        }
        else{
          //si aparece el valor 'Elija un día' o 'Elija un horario' es que aun no se termino de elegir el horario.
          if (arregloDiv[p][0] === 'Elija un día' || arregloDiv[p][1] === 'Elija un horario' || arregloDiv[p][2] === 'Elija un horario') {
            alert("el horario " + (p + 1) + " no esta definido. a");
            control = false;
            return false; // devuleve falso y corta
          }
        }
    }
    p++;//incremento indice j
  });
  if (control) {
    //si hay mas de un horario
    return superpocicion(arregloDiv, n);//retorno lo que devuelva la funcion superpocicion
  }}
  return control;
}
//se llama siempre que cambia un select horario
function propio(id) {//recive el id de quien lo llama
  array = new Array(3);//creo arreglo de 3
  l = 0;//indice 0
  var n = id.split('_'); //separa el tring del id div_horario_X por el caracter "_"
  $('#horario_div_' + n[2]).find('select').each(function() {//al div con id (ese) le pido sus select y para cada uno hago
    array[l] = $(this).val();//asigno en la posicion l
    l++;//incremento l
  });
  //si se cumple alguno de esas condiciones es que falta definir el horario
  if (array[0] == 'Elija un día' || array[1] == 'Elija un horario' || array[2] == 'Elija un horario') {
    return false; // devuleve falso y corta
  }
  //si eso esta bien entonces que verifique si hay superposicion
  if (!individual('horario_div_' + n[2])) {
    alert("este horario esta mal definido");
  }

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
              if (verificarHorario()) {
                var res = confirm("¿Seguro de agregar este medico?");
                if (res == true)
                  return true
                else
                  return false
              }
              else {
                control = true;
              }
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

function verificarLicencia() {
  var desde = (document.getElementById('desde').value);
  var hasta = (document.getElementById('hasta').value);
  fecha_actual = new Date(10, 8, 1999);
  // NO HACE FALTA   fecha_actual = document.write(fecha_actual.getDate() + "/" + (fecha_actual.getMonth() +1) + "/" + fecha_actual.getFullYear());
  if (desde > hasta) {
    alert('El intervalo está mal definido');
    return false;
  }
  else
  if (desde <= fecha_actual) {
    alert('La fecha de inicio de la licencia es incorrecto');
    return false;
  }
  else
    return true;
}