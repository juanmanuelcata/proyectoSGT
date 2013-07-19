function verifFormuEspecialidad(){
    var nom = (document.getElementById('nombre').value);
    var ape = (document.getElementById('apellido').value);
    var mai = (document.getElementById('mail').value);
    var re=/^((\w|\.){2,}@)\w{3,}\.\w{2,4}((\.(\w{2}))?)?$/;
    var le=/([a-z]|[A-Z]\s?)/;
    var com = (document.getElementById('comen').value);
    var continuo = false;  
    if (le.test(nom))     
        if(le.test(ape))        
            if (re.test(mai))         
                if(le.test(com))
                    continuo = true;
                else 
                    alert('completar campo de comentario');              
            else 
                alert("La dirección de email es incorrecta.");         
        else    
            alert('completar campo de Apellido');          
    else 
        alert('completar campo de Nombre'); 
    return continuo;
}

function validfecha(){
    var fe= /^((?:19|20)\d\d)\-((?:0?[1-9])|(?:1[0-2]))\-((?:0?[1-9])|(?:[12]\d)|(?:3[01]))$/;
    var fecha = (document.getElementById('fech2').value);
    var continuo = false;     
    if (fe.test(fecha))
        continuo = true;
    else
        alert ('no es una fecha correcta.');
    return continuo;
}

function verif(){
    var autor= (document.getElementById('aut').value);
    var ae=/[a-z]|[A-Z]\s?/;  
    var fecha = (document.getElementById('fech').value);
    var clave = (document.getElementById('clav').value);
    var fe= /^((?:19|20)\d\d)\-((?:0?[1-9])|(?:1[0-2]))\-((?:0?[1-9])|(?:[12]\d)|(?:3[01]))$/;
    var continuo = false; 
    if ((autor != '') || (fecha != '') || (clave != '')){
        switch(autor, fecha) {
            case (!(ae.test(autor)) && !(fe.test(fecha))):
                alert ('autor y fecha incorrectos');
            case !(ae.test(autor)): alert ('autor invalido');
                break;
            case !(fe.test(fecha)):
                alert ('fecha incorrecta');
                break;
            default: continuo = true;
        }

    }
    else
        alert('Complete al menos un campo.');
    return continuo;
}

function noticia(){
    var ord = (document.getElementById('ord').value);
    var tit = (document.getElementById('tit').value);
    var res = (document.getElementById('res').value);
    var con = (document.getElementById('con').value);
    var continuo = false; 
    if (ord != '')
        if (tit != '')
            if (res != '')
                if (con != '')
                    continuo = true;
                else
                    alert ('Completar campo contenido.');
            else
                alert ('Completar campo reseña.');
        else
            alert ('Completar campo título.');
    else
        alert ('Completar campo orden.');
    return continuo;
}


$(function(){
	$('#menu li a').click(function(event){
		var elem = $(this).next();
		if(elem.is('ul')){
			event.preventDefault();
			$('#menu ul:visible').not(elem).slideUp();
			elem.slideToggle();
		}
	});
});