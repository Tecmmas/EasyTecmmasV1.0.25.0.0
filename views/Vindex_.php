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
        <style>




            /*            div.main{
                            background: #0264d6;  Old browsers 
                                            background: -moz-radial-gradient(center, ellipse cover,  #0264d6 1%, #1c2b5a 100%);  FF3.6+ 
                                            background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(1%,#0264d6), color-stop(100%,#1c2b5a));  Chrome,Safari4+ 
                                            background: -webkit-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%);  Chrome10+,Safari5.1+ 
                                            background: -o-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%);  Opera 12+ 
                                            background: -ms-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%);  IE10+ 
                                            background: radial-gradient(ellipse at center,  #0264d6 1%,#1c2b5a 100%);  W3C 
                            background-image: url("<?php echo base_url(); ?>/assets/images/backlogin.png");
                            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0264d6', endColorstr='#1c2b5a',GradientType=1 );  IE6-9 fallback on horizontal gradient
                            height:calc(100vh);
                            height:100%;
                            width:100%;
                        }
            
                       
            
            
            
                        .container {
                            left: 50%;
                            position: fixed;
                            top: 50%;
                            transform: translate(-50%, -50%);
                        }
            
                         ---------- LOGIN ---------- 
            
                        #login form{
                            width: 300px;
                        }
            
                        #login{
                            border-right:1.5px solid #fff;
                            padding: 0px 22px;
                            width: 70%;
                        }
            
            
                        #login form span.fa {
                            background-color: lightgray;
                            border-radius: 3px 0px 0px 3px;
                            color: #000;
                            display: block;
                            float: left;
                            height: 49px;
                            font-size:24px;
                            line-height: 50px;
                            text-align: center;
                            width: 50px;
                        }
            
                        #login form input {
                            height: 51px;
                        }
            
                        #login form input[type="text"], input[type="password"] {
                            background-color: #fff;
                            border-radius: 0px 3px 3px 0px;
                            color: #000;
                            margin-bottom: 1em;
                            padding: 0 16px;
                            width: 250px;
                        }
            
                        .middle {
                            display: flex;
                            width: 600px;
                        }*/


            .conte {
                background-color: blue;
            }
            .hijo {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                /*background-color: red;*/
            }
            .v-line{
                border-left: thick solid whitesmoke;
                height:100%;
                left: 50%;
                position: absolute;
                width:.2vw;
            }
            a {
                background-image: linear-gradient(
                    to right,
                    #17202A,
                    #17202A 50%,
                    #17202A 50%
                    );
                background-size: 200% 100%;
                background-position: -100%;
                display: inline-block;
                position: relative;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                transition: all 0.3s ease-in-out;
            }

            a:before{
                content: '';
                background: greenyellow;
                display: block;
                position: absolute;
                bottom: -3px;
                left: 0;
                width: 0;
                height: 3px;
                transition: all 0.3s ease-in-out;
            }

            a:hover {
                background-position: 0;
            }

            a:hover::before{
                width: 100%;
            }

        </style>

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body style="background-image: url('<?php echo base_url(); ?>application/libraries/backlogin.png');">

        <div class="conte">
            <div class="hijo">
                <div class="row">
                    <div class="col-sm-5" >
                        <div style="float: left;">
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-lg"><span class="fa fa-user"></span></span>
                                </div>
                                <input type="text" id="usuario" class="form-control" placeholder="Usuario" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-lg" style="margin-top: 15px">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-lg"><span class="fa fa-lock"></span></span>
                                </div>
                                <input type="password" id="contrasena" onkeyup="validarContraTecmmas()"  placeholder="Contraseña" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
                            </div>

                            <!--<div class="container" style="margin-top: 15px">-->
                            <div class="row" style="margin-top: 15px">
                                <div class="col-sm-7"><a style=" text-decoration: none" href="" id='modal-contrasena' data-bs-toggle="modal" data-bs-target="#modal-olvide-contrasena" >Olvido su contraseña?</a></div>
                                <div class="col-sm-3"><button type="submit" id="ingresar" class="btn btn-success">Ingresar</button></div>
                            </div>
                            <!--</div>-->
                        </div>
                    </div>
                    <div class="col-sm-1" style="text-align: left">
                        <div class="v-line">
                        </div>
                    </div>
                    <div class="col-sm-6" >
                        <div style="float: left;">
                            <img src="<?php echo base_url(); ?>/assets/images/login-logo.png" style="margin-top: 40px; margin-left: 25px" alt="alt"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12" style="text-align: center" >
                        <label id="mensaje" style="color: #C0392B; font-size: 15px"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12" style="text-align: center" >
                        <label style="color: #C0392B">
                            <strong>Release  1.0.18.0.2</strong>
                        </label>
                    </div>
                </div>

            </div>

        </div>
    </body>

    <!-- MAIN CONTENT AREA ENDS -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->



    <div class="modal fade"  id="modal-olvide-contrasena" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Olvide mi contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="font-weight: bold;color: black; text-align: left">
                        Bienvenido(a) para el cambio de contraseña debe tener en cuenta:<br>
                        1.Las contraseñas deben tener 6 o mas caracteres<br>
                        2.Debe combinar letras mayúsculas, minúsculas y números.<br>
                        3.No debe ser igual a la clave anterior.<br>
                        4.Debe contener almenos un caracter especial. Ejemplo: @*,.<br>
                        5.No se pueden repetir caracteres en la contraseña.<br>
                    </p>
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Numero de documento</span>
                        </div>
                        <input type="number" class="form-control" id="numero-documento" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Contraseña</span>
                        </div>
                        <input type="password" onkeyup="validarcontrasena()"  name="contrasenna" id="contrasenna" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Confirmar contraseña</span>
                        </div>
                        <input type="password" onkeyup="validarconfcontra()"  name="confcontrasena" id="confcontrasena" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                    <div style="color: #E31F24" id="divcontra"> <?php
                        echo $this->session->flashdata('error');
                        if (isset($mensaje)) {
                            echo $mensaje;
                        }
                        ?></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-close" data-dismiss="modal">Close</button>
                    <button type="button"  onclick="actualizarContra()" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div


    



    <!-- CORE JS FRAMEWORK - START --> 
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url(); ?>assets/js/popper.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
    <script src="<?php echo base_url(); ?>assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
    <script src="<?php echo base_url(); ?>/application/libraries/package/dist/sweetalert2.all.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');</script>
    <!-- CORE JS FRAMEWORK - END --> 


    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 

    <script src="<?php echo base_url(); ?>assets/plugins/icheck/icheck.min.js" type="text/javascript"></script>
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


    <!-- CORE TEMPLATE JS - START --> 
    <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script> 
    <!-- END CORE TEMPLATE JS - END --> 

    <script type="text/javascript">
                        var IdUsuario = '<?php echo $this->session->userdata('IdUsuario'); ?>';
                        var ocultarLicencia = '<?php
                        if (isset($ocultarLicencia)) {
                            echo $ocultarLicencia;
                        } else {
                            echo'0';
                        }
                        ?>';
                        var ipLocal = '<?php
                        echo base_url();
                        ?>';

                        var hablitado = false;
                        var dominio = "";
                        var valid = false;

                        $(document).ready(function () {
                            //alert('data')
                            // if (localStorage.getItem("dominio") !== null || localStorage.getItem("dominio") !== "") {
                            //console.log(ipLocal + "system/dominio.dat")
                            document.getElementById("ingresar").disabled = true;
                            var text = new XMLHttpRequest();
                            text.open("GET", ipLocal + "system/dominio.dat", false);
                            text.send(null);
                            dominio = text.responseText;
                            localStorage.setItem('IdUsuario', IdUsuario);
                            hablitado = false;
                            valid = false;
                            ContrasenaSer();
                            //}
                        });

                        function ContrasenaSer() {
                            validarLicencia();
                            var datos = {
                                dominio: dominio,
                                function: "getPassword"
                            }
//                            var datos = {
//                                dominio: dominio,
//                                placa: "AAA001",
//                                prueba: "524",
//                                oldRegister: "dominiosdfgjnbhvhg",
//                                newRegister: "domi165156515551",
//                                function: "getAuditoria"
//                            }
                            fetch("http://updateapp.tecmmas.com/Actualizaciones/index.php/Cpassword",
                                    {
                                        method: "POST",
                                        body: JSON.stringify(datos),
                                        headers: {
                                            'Autorization': 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.Ijg5NnNkYndmZTg3dmNzZGFmOTg0bmc4ZmdoMjRvMTI5MHIi.HraZ7y3eG3dGhKngzOWge-je8Y3lxZgldXjbRbcA7cA',
                                            'Content-Type': 'application/json'
                                        },
                                    }, 200)
                                    .then(respuesta => respuesta.json())
                                    .then((rta) => {
                                        localStorage.setItem("juez", rta[0]['juez'])
                                        localStorage.setItem("fechaEncript", rta[0]['fechaencript'])
                                        if (rta[0]['VersionVigente'] !== rta[0]['version']) {
                                            Swal.fire({
                                                title: '<strong>Actualización nueva</strong>',
                                                icon: 'info',
                                                html: '<div style="font-size:15px">El sistema a detectado una nueva actualización ' + rta[0]['VersionVigente'] + ', lo invitamos a descargala tanto para celulares, como para oficina.<div>',
                                            })
                                        }
                                        if (rta !== null && rta !== "")
                                            if (rta[0]['actualizado'] == 0) {
                                                savePassword(rta[0]['html']);
                                            }
                                        //console.log(rta[0]['html']);
//                                    localStorage.setItem("pserts",rta[0]['clave'])
                                    }, 2000)

                                    .catch(error => {
                                        console.log(error.message);

                                    });

                        }

                        function savePassword(clave) {
                            //console.log(clave)
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>index.php/Cindex/savePassword",
                                mimeType: 'json',
                                async: true,
                                data: {clave: clave},
                                success: function (data, textStatus, jqXHR) {
                                    console.log(data)

                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(jqXHR.responseText)

                                }
                            });
                        }




                        function validarLicencia() {
                            localStorage.setItem('ipLocal', ipLocal);
                            $.ajax({
                                url: ipLocal + "index.php/CbajarConfiguracion/getDominio",
                                type: 'post',
                                async: false,
                                success: function (dominio) {
                                    var data = {
                                        dominio: dominio,
                                        funcion: "getLicencia",
                                        file: "license"
                                    };
                                    $.ajax({
                                        url: "<?php echo base_url(); ?>index.php/CbajarConfiguracion/getConf",
//                                        url: "http://" + dominio + "/cda/index.php/Cservicio/getLicencia",
                                        data: data,
                                        type: 'post',
                                        timeout: 8000,
                                        success: function () {
                                            validar3();
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) {
                                            console.log("validr error")
//                                            validar3();
                                            validarActivacion(localStorage.getItem("mac"))
                                            console.log(jqXHR)
                                            console.log(jqXHR.responsetext)
                                            console.log(textStatus)
                                        }
                                    });
                                },
                                timeout: 5000,
                                error: function () {
                                    validar3();
                                }
                            });

                        }

                        function validar3() {
                            $.ajax({
                                url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getMac',
                                type: 'post',
                                success: function (mac) {
                                    console.log(mac)
                                    if (mac == '' || mac == null) {
                                        $.ajax({
                                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getMacServer',
                                            type: 'post',
                                            success: function (data) {
                                                console.log(data)
                                            }
                                        })
                                    }
                                    if (mac !== '' || (localStorage.getItem("mac") !== "" && localStorage.getItem("mac") !== null)) {
                                        validarActivacion(localStorage.getItem("mac"));

                                    } else {
                                        console.log("else")
                                        validar4();
                                    }
                                }
                            });
                        }

                        function validar4() {
                            $.ajax({
                                url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getMacServer',
                                type: 'post',
                                success: function (mac) {
                                    if (localStorage.getItem("mac") == undefined || localStorage.getItem("mac") == "" || localStorage.getItem("mac") == null) {
                                        localStorage.setItem("mac", mac);
                                    }

                                    if (mac !== '' || (localStorage.getItem("mac") !== "" || localStorage.getItem("mac") !== null)) {
                                        validarActivacion(localStorage.getItem("mac"));
                                    } else {
                                        $("#mensaje").text('El sistema no reconoce la MAC de este equipo');
                                    }

                                }
                            });
                        }
//                       

                        function validarActivacion(mac) {
                            console.log('mac:' + mac)
                            var data = {
                                mac: mac
                            };
                            $.ajax({
                                url: "<?php echo base_url(); ?>index.php/Clogin/validar",
                                type: 'post',
                                data: data,
                                timeout: 5000,
                                success: function (rta) {
                                    console.log(rta);
                                    var dispositivo = JSON.parse(rta);
                                    if (dispositivo.activo === '0') {
                                        valid = false;
                                        deshabilitarComponentes();
                                        $("#mensaje").text("Este dispositivo no se encuentra habilitado para el uso de este software");
                                    } else if (dispositivo.cdaactivo === '0') {
                                        deshabilitarComponentes();
                                        $("#mensaje").text("Este CDA no se encuentra habilitado para el uso de este software, por favor comuníquese con TECMMAS SAS.");
                                    } else if (dispositivo.dias <= 0) {
                                        if (ocultarLicencia === '1') {
                                            habilitarComponentes();
                                            hablitado = true;
                                            valid = true;
                                            $("#mensaje").text("");
                                        } else {
                                            deshabilitarComponentes();
                                            $("#mensaje").text("Su licencia a expirado, por favor comuníquese con TECMMAS SAS.");
                                        }
                                    } else if (dispositivo.cron_audit !== 'OK' || dispositivo.auditres_jz !== 'OK' || dispositivo.auditpru_jz !== 'OK') {
                                        deshabilitarComponentes();
                                        valid = false;
                                        $("#mensaje").text("Se detectó un procedimiento indebido y por su seguridad el sistema se ha bloqueado. Comuníquese con TECMMAS SAS.");
                                    } else {
                                        habilitarComponentes();
                                        hablitado = true;
                                        valid = true;
                                        if (ocultarLicencia === '1') {
                                            $("#mensaje").text("");
                                        } else {
                                            if (dispositivo.dias === '1')
                                                $("#mensaje").text("Su licencia expira en un día, por favor comuníquese con TECMMAS SAS.");
                                            else
                                                $("#mensaje").text("Su licencia expira en " + dispositivo.dias + " días");
                                        }

                                    }
                                    localStorage.setItem('mensaje', $("#mensaje").text())
                                }, error: function (jqXHR, textStatus, errorThrown) {
                                    console.log("error peticion validar")
                                    $("#mensaje").text(localStorage.getItem("mensaje"));
                                    hablitado = true;
                                    valid = true;
                                    habilitarComponentes();
                                    console.log(jqXHR)
                                    console.log(jqXHR.responsetext)
                                    console.log(textStatus)
                                }
                            });
                        }

                        function validarUserTecmmas() {
                            if ($('#usuario').val() === 'tecmmas' && $('#contrasena').val() === '1q2w3e4r**') {
                                habilitarComponentes();
                                hablitado = true;
                                valid = true;
                            } else {
                                if (!hablitado)
                                    deshabilitarComponentes();
                            }
                        }

                        function deshabilitarComponentes() {
                            document.getElementById("ingresar").disabled = true;
                        }

                        function habilitarComponentes() {
                            document.getElementById("ingresar").disabled = false;
                        }

                        $("#ingresar").click(function (ev) {
                            validarUserTecmmas();
                            if ($('#usuario').val() === 'tecmmas' && $('#contrasena').val() === '1q2w3e4r**') {
                                habilitarComponentes();
                                hablitado = true;
                                valid = true;
                            }
                            ev.preventDefault();
                            if (!valid) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'El sistema no esta habilitado aun para funcionamiento, o detecto una alteración del mismo.',
                                })
                            } else {
                                var bol = true;
                                var mes = "";
                                var user = $("#usuario").val();
                                console.log(user)

                                var contra = $("#contrasena").val();
                                console.log(contra)
                                if (contra.length < 0 || contra == "") {
                                    bol = false;
                                    mes += "Debe ingrear la contraseña." + "<br>"
                                }
                                if (user.length < 0 || user == "") {
                                    bol = false;
                                    mes += "Debe ingresar el usuario. <br>"
                                }
                                if (contra.length < 6) {
                                    bol = false;
                                    mes += "La contraseña no cumple con la longitud minima. <br>"
                                }
                                if (!bol) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'info',
                                        html: mes,
                                        showConfirmButton: true,
                                    })
                                } else {
                                    $.ajax({
                                        url: "<?php echo base_url(); ?>index.php/Cindex/validar",
                                        type: 'post',
                                        data: {usuario: user,
                                            contrasena: contra},
                                        success: function (rta) {
                                            console.log(rta)
                                            switch (rta) {
                                                case "1":
                                                    window.location.href = "<?php echo base_url(); ?>index.php/oficina/login/Cconf";
                                                    break;
                                                case "2":
                                                    Swal.fire({
                                                        position: 'center',
                                                        icon: 'info',
                                                        html: 'Usuario inactivo',
                                                        showConfirmButton: true,
                                                    })
                                                    break;
                                                case "3":
                                                    window.location.href = "<?php echo base_url(); ?>index.php/oficina/contrasenas/Ccontrasenas";
                                                    break;
                                                case "4":
                                                    window.location.href = "<?php echo base_url(); ?>index.php/oficina/CPrincipal";
                                                    break;
                                                case "6":
                                                    Swal.fire({
                                                        position: 'center',
                                                        icon: 'info',
                                                        html: 'Se detectó una alteración en los registros de su usuario, debe dar click en olvide mi contraseña y hacer el proceso.',
                                                        showConfirmButton: true,
                                                    })
                                                    break;
                                                default:
                                                    Swal.fire({
                                                        position: 'center',
                                                        icon: 'info',
                                                        html: 'Nombre de usuario o contraseña inválidos',
                                                        showConfirmButton: true,
                                                    })
                                                    break;
                                            }
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) {
                                            console.log(jqXHR)
                                            Swal.fire({
                                                html: "Error en el servidor: " + jqXHR.statusText + " comuniquese con soporte.",
                                                icon: 'error',
                                                confirmButtonColor: '#3085d6',
                                                confirmButtonText: 'Aceptar'
                                            })
                                        }
                                    })
                                }

                            }

                        })

                        $("#modal-contrasena").click(function (ev) {
                            ev.preventDefault();
                            $("#modal-olvide-contrasena").modal('show')
                        })

                        function validarcontrasena() {
                            var contrasenna = $('#contrasenna').val();
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
                                    data: {iduser: 0,
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

                        var actualizarContra = function () {
                            var numero = $("#numero-documento").val();
                            var contrasenna = $('#contrasenna').val();
                            if (numero == "" || numero == null) {
                                $("#btn-close").click();
                                Swal.fire({
                                    html: "Los campos no pueden estar vacios.",
                                    icon: 'info',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Aceptar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#modal-olvide-contrasena").modal('show')
                                    } else {
                                        $("#modal-olvide-contrasena").modal('show')
                                    }
                                })
                            } else {
                                $.ajax({
                                    url: '<?php echo base_url(); ?>index.php/oficina/contrasenas/Ccontrasenas/updateContraVindex',
                                    type: 'post',
                                    mimeType: 'json',
                                    data: {numero: numero,
                                        contrasenna: contrasenna},
                                    success: function (data) {
                                        $("#btn-close").click();
                                        if (data == 1) {
                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Contraseña actualizada.',
                                                showConfirmButton: false,
                                                timer: 2000
                                            })
                                        } else {
                                            Swal.fire({
                                                html: data,
                                                icon: 'info',
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Aceptar'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $("#modal-olvide-contrasena").modal('show')
                                                } else {
                                                    $("#modal-olvide-contrasena").modal('show')
                                                }
                                            })
                                        }

                                    }, error: function (jqXHR, textStatus, errorThrown) {
                                        $("#btn-close").click();
                                        Swal.fire({
                                            html: jqHXR,
                                            icon: 'info',
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Aceptar'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $("#modal-olvide-contrasena").modal('show')
                                            } else {
                                                $("#modal-olvide-contrasena").modal('show')
                                            }
                                        })
                                    }
                                });
                            }

                        }

                        var validarContraTecmmas = function () {
                            if ($('#usuario').val() === 'tecmmas' && $('#contrasena').val() === '1q2w3e4r**') {
                                habilitarComponentes();
                            }
                        }

    </script>

</body>
</html>



