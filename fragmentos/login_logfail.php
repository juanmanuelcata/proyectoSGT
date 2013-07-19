<?php
     if (isset($_GET['er'])){
         if($_GET['er']==1){                                
                echo '<fieldset  class="control-group error">
                            <span class="help-inline">Error! Usuario y/o Contraseña incorrectos.</span>
                            <div class="control">
                                <input type="text" placeholder="Ususario" id="inputError" name="usr">
                            </div>
                            <div class="control">
                                <input type="password" placeholder="Contraseña" id="inputError" name="pass">
                            </div>
                            <button class="btn btn-success" type="submit">Entrar</button>
                        </fieldset>';
         }
         else{
             if($_GET['er']==2){
                    echo '<fieldset  class="control-group error">
                            <span class="help-inline">No intente engañar a SGT, fue diseñado por genios. Use su usuario y contraseña. Tramposo!</span>
                            <div class="control">
                                <input type="text" placeholder="Ususario" id="inputError" name="usr">
                            </div>
                            <div class="control">
                                <input type="password" placeholder="Contraseña" id="inputError" name="pass">
                            </div>
                            <button class="btn btn-success" type="submit">Entrar</button>
                      </fieldset>';
             }
             else{
                 if($_GET['er']==3){
                  echo '<fieldset  class="control-group error">
                            <span class="help-inline">Ah expirado el tiempo de sesion, por favor identifiquese de nuevo</span>
                            <div class="control">
                                <input type="text" placeholder="Ususario" id="inputError" name="usr">
                            </div>
                            <div class="control">
                                <input type="password" placeholder="Contraseña" id="inputError" name="pass">
                            </div>
                            <button class="btn btn-success" type="submit">Entrar</button>
                        </fieldset>';
                 }
            }
         }
     }
     else {
        echo ' <fieldset>
                    <div class="clearfix">
                        <input type="text" placeholder="Ususario" name="usr">
                    </div>
                    <div class="clearfix">
                        <input type="password" placeholder="Contraseña" name="pass">
                    </div>
                    <button class="btn btn-success" type="submit">Entrar</button>
         </fieldset>';
     }
 ?>