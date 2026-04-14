<!DOCTYPE html>
<html class=" ">
    <head>

        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title><?php echo $this->config->item('titulo'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-57-precomposed.png">	<!-- For iPhone -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-114-precomposed.png">    <!-- For iPhone 4 Retina display -->
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-72-precomposed.png">    <!-- For iPad -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-144-precomposed.png">    <!-- For iPad Retina display -->

        <!-- CORE CSS FRAMEWORK - START -->
        <link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/> -->
        <link href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START --> 


        <link href="<?php echo base_url(); ?>assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class="login_page" style="background: white">

        <div class="container-fluid"> 
            <div class="login-wrapper row" >
                <div id="login" class="login loginpage offset-xl-3 offset-lg-3 offset-md-3 offset-0 col-12 col-md-6 col-xl-7" style="border: solid;border-color: #393185;background: whitesmoke;border-radius: 40px 40px 40px 40px" >
                    <h1><a href="#" title="Login Page" tabindex="-1">Complete Admin</a></h1>
                    <form name="loginform" id="loginform" action="<?php echo base_url(); ?>index.php/oficina/contrasenas/Ccontrasenas/updatecontra" method="post">
                        <p style="font-weight: bold;color: black; text-align: left">
                            Bienvenido(a) <?= ucwords(strtolower($user->nombres)) ?> para el cambio de contraseña debe tener en cuenta:<br>
                            1.Las contraseñas deben tener 6 o mas caracteres<br>
                            2.Debe combinar letras mayúsculas, minúsculas y números.<br>
                            3.No debe ser igual a la clave anterior.<br>
                            4.Debe contener almenos un caracter especial. Ejemplo: @*,.<br>
                            5.No se pueden repetir caracteres en la contraseña.<br>
                        </p>
                        <p>
                            <label style="font-weight: bold;color: black" for="usuario">Contraseña<br/>
                                <input  type="password" onkeyup="validarcontrasena()"  name="contrasenna" id="contrasenna" class="input"  size="20" autocomplete="off"/>
                                <strong style="color: #E31F24"><?php echo form_error('contrasena'); ?></strong>
                            </label>
                        </p>
                        <p>
                            <label style="font-weight: bold;color: black" for="contrasena">Confirmar contraseña<br />
                                <input  disabled type="password" onkeyup="validarconfcontra()"name="confcontrasena" id="confcontrasena" class="input"  size="20"  />
                                <input  type="hidden" class="input" name="iduser" id="iduser" size="20" value="<?= $user->IdUsuario ?>"  />
                                <input  type="hidden" class="input" name="idperfil" id="idperfil" size="20" value="<?= $user->idperfil ?>"  />
                                <input  type="hidden" class="input" name="fecha" id="fecha" size="20" value="<?= $user->fecha_actualizacion ?>"  />
                                <strong style="color: #E31F24"><?php echo form_error('confcontrasena'); ?></strong>
                            </label>
                        </p>
                        <div style="color: #E31F24" id="divcontra"> <?php
                            echo $this->session->flashdata('error');
                            if (isset($mensaje)) {
                                echo $mensaje;
                            }
                            ?></div>
                        <p class="submit" style="color: #E31F24">   
                            <input disabled type="submit" name="wp-submit" id="ingresar" class="btn btn-accent btn-block" style="background-color: #393185" value="Registrar" />
                        </p>
                        <label id="mensaje" style="color: brown;font-weight: bold;text-align: center"></label>
                    </form>
                    <div style="text-align: center;color: gray">
                        <?php echo $this->config->item('derechos'); ?>    
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT AREA ENDS -->
        <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


        <!-- CORE JS FRAMEWORK - START --> 
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/js/popper.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
        <script src="<?php echo base_url(); ?>assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
        <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');</script>
        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 

        <script src="<?php echo base_url(); ?>assets/plugins/icheck/icheck.min.js" type="text/javascript"></script>
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <script type="text/javascript">
                                    function validarcontrasena() {
                                        var contrasenna = $('#contrasenna').val();
                                        var iduser = $('#iduser').val();
                                        if (contrasenna.length >= 6) {
                                            var mayuscula = false;
                                            var minuscula = false;
                                            var numero = false;
                                            var caracter_raro = false;
                                            for (var i = 0; i < contrasenna.length; i++) {
                                                if (contrasenna.charCodeAt(i) >= 65 && contrasenna.charCodeAt(i) <= 90)
                                                {
                                                    mayuscula = true;
//                                                    console.log('mayuscula' + ' ' + mayuscula);
                                                } else if (contrasenna.charCodeAt(i) >= 97 && contrasenna.charCodeAt(i) <= 122)
                                                {
                                                    minuscula = true;
//                                                    console.log('minuscula' + ' ' + minuscula);
                                                } else if (contrasenna.charCodeAt(i) >= 48 && contrasenna.charCodeAt(i) <= 57)
                                                {
                                                    numero = true;
//                                                    console.log('numero' + ' ' + numero);
                                                } else
                                                {
                                                    caracter_raro = true;
//                                                    console.log('Caracter' + ' ' + caracter_raro);
                                                }
                                            }

                                        }
                                        if (mayuscula == true && minuscula == true && caracter_raro == true && numero == true) {
                                            $.ajax({
                                                url: '<?php echo base_url(); ?>index.php/oficina/contrasenas/Ccontrasenas/getpassword',
                                                type: 'post',
                                                mimeType: 'json',
                                                data: {iduser: iduser,
                                                    contrasenna: contrasenna},
                                                success: function (data) {
                                                    if (data == 1) {
                                                        $('#divcontra').html('La contraseña fue asignada anteriormente.');
                                                        $('#confcontrasena').val('');
                                                        deshabilitarComponentes();
                                                        deshabilitarinputconfcontra();
                                                    } else {
                                                        var rta = camposrepetidos(contrasenna);
                                                        console.log(rta);
                                                        if (rta === true) {
                                                            $('#divcontra').html('La contraseña no puede tener caracteres repetidos.');
                                                            deshabilitarinputconfcontra();
                                                        } else {
                                                            $('#divcontra').html('<div style="color: #1D8348">La contraseña cumple con los parametros.</div>');
                                                            inputconfcontra();
                                                        }
                                                    }
                                                }
                                            });
//                                            
                                        } else {
                                            $('#divcontra').html(' ');
                                            $('#divcontra').html('La contraseña no cumple con los parametros.');
                                            $('#confcontrasena').val('');
                                            deshabilitarinputconfcontra();
                                            deshabilitarComponentes();
                                        }
                                    }


                                    function validarconfcontra() {
                                        var confcontrasena = $('#confcontrasena').val();
                                        var contrasenna = $('#contrasenna').val();
                                        if (contrasenna == confcontrasena) {
                                            $('#divcontra').html('<div style="color: #1D8348">Las contraseñas coninciden y cumplen con los parametros.</div>');
                                            habilitarComponentes();
                                        } else {
                                            $('#divcontra').html('Las contraseñas no coinciden.');
                                            deshabilitarComponentes();
                                        }
                                    }
                                    function habilitarComponentes() {
                                        document.getElementById("ingresar").disabled = false;
                                    }
                                    function deshabilitarComponentes() {
                                        document.getElementById("ingresar").disabled = true;
                                    }
                                    function deshabilitarinputconfcontra() {
                                        document.getElementById("confcontrasena").disabled = true;
                                    }
                                    function inputconfcontra() {
                                        document.getElementById("confcontrasena").disabled = false;
                                    }
                                    function camposrepetidos(contrasenna) {
                                        var arraycontra = contrasenna.split("");
                                        var campos = arraycontra.sort();
                                        var repetido = false;
//                                        console.log(campos);
                                        for (var i = 0; i < campos.length; i++) {
                                            if (campos[i] == campos[i + 1]) {
//                                                console.log('Caracter repetido' + ' ' + campos);
                                                return repetido = true;
                                            }
                                        }
                                        return repetido;
//                                        console.log(repetido);
                                    }
        </script>

    </body>
</html>



