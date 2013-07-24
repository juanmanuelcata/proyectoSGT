<section class="ac-container">
    <div>
 <input id="ac-1" name="accordion-1" type="radio" /><!--     si ponemos "cheked" aparece desplegado-->
        <label for="ac-1" id="menuinicio">Turnos</label>
        <article class="ac-small">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="/abm/turno.php?code=l">Listado de turnos</a>
                </li>
            </ul>
        </article>
    </div>
    <div>
        <input id="ac-2" name="accordion-1" type="radio"  />
        <label for="ac-2">Pacientes</label>
        <article class="ac-small">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="/abm/paciente.php?code=a">Alta de Paciente</a>
                </li>
                <li>
                    <a href="/abm/paciente.php?code=l">Listar Pacientes</a>
                </li>
            </ul>
        </article>
    </div>

    <div>
        <input id="ac-4" name="accordion-1" type="radio"  />
        <label for="ac-4">Especialidades</label>
        <article class="ac-small">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="/abm/especialidad.php?code=a">Alta de Especialidad</a>
                </li>
                <li>
                    <a href="/abm/especialidad.php?code=l">Listar Especialidades</a>
                </li>
            </ul>
        </article>
    </div>
        <div>
        <input id="ac-9" name="accordion-1" type="radio"  />
        <label for="ac-9">Obra Social</label>
        <article class="ac-medium">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="/abm/obraSocial.php?code=a">Alta de Obra Social</a>
                </li>
                <li>
                    <a href="/abm/obraSocial.php?code=r&orden=ASC">Reportes</a>
                </li>
                <li>
                    <a href="/abm/obraSocial.php?code=l&orden=ASC">Listar Obras Sociales</a>
                </li>
                
            </ul>
        </article>
    </div>
  
<?php if ($_SESSION['usuario']['admin'] == '1'){  
echo '
    <div>
        <input id="ac-3" name="accordion-1" type="radio"  />
        <label for="ac-3">Médicos</label>
        <article class="ac-small">
            <ul class="nav nav-pills nav-stacked" >
                <li>
                    <a href="/abm/medico.php?code=a">Alta de Médico</a>
                </li>
                <li>
                    <a href="/abm/medico.php?code=l&orden=nombre">Listar Médicos</a>
                </li>
        </article>
    </div>  
<div>
        <input id="ac-5" name="accordion-1" type="radio"  />
        <label for="ac-5">Usuarios</label>
        <article class="ac-small">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="/abm/usuario.php?code=a">Alta de Usuario</a>
                </li>
                <li>
                    <a href="/abm/usuario.php?code=l">Listar Usuarios</a>
                </li>
            </ul>
        </article>
</div>
 <div>
        <input id="ac-6" name="accordion-1" type="radio"  />
        <label for="ac-6" class="nostyle"><a href="/abm/log.php">Logs de SGT</a></label>
</div>';
  }
  ?>
 <div>
    <input id="ac-6" name="accordion-1" type="radio"  />
    <label for="ac-6" class="nostyle" id="menufin"><a href="/sesion/desloguear.php">Salir de SGT</a></label>
</div>
</section>
