<!DOCTYPE html>
<html class=" ">

<head>

    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>VEHICULO FINALIZADO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" type="image/x-icon" /> <!-- Favicon -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-57-precomposed.png"> <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-114-precomposed.png"> <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-72-precomposed.png"> <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-144-precomposed.png"> <!-- For iPad Retina display -->

    <!-- CORE CSS FRAMEWORK - START -->
    <link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/> -->
    <link href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->


    <link href="<?php echo base_url(); ?>assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen" />

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE CSS TEMPLATE - START -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login_page" style="background: white">

    <div class="col-xl-12">
        <section class="box ">
            <div class="content-body" style="background: lightblue">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">Vehiculo finalizado</h2>
                            </header>
                            <div class="content-body">
                                <table class="table table-bordered" accesskey="">
                                    <thead>
                                        <tr>
                                            <th>Id control</th>
                                            <th>Placa</th>
                                            <th>Ocasión</th>
                                            <th>Estado</th>
                                            <th>FUR</th>
                                            <th>Tamaño hoja</th>
                                            <th>Medio</th>
                                            <th>LLAMAR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <?php
                                                echo $idhojapruebas;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $vehiculo->placa;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $ocacion;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($res == '7') {
                                                    echo 'RECHAZADO';
                                                } else {
                                                    echo 'APROBADO';
                                                }
                                                ?>
                                            </td>
                                            <form action="<?php echo base_url(); ?>index.php/oficina/fur/CFUR" method="post" style="width: 100px;text-align: center">
                                                <td>
                                                    <button name="dato" class="btn btn-accent btn-block" value="<?php echo $dato; ?>" type="submit" formtarget="_blank" style="border-radius: 40px 40px 40px 40px;font-size: 14px;background-color: #393185">📄 Ver</button>
                                                </td>
                                                <td>
                                                    <select name="tamano" class="form-control input-lg m-bot15">
                                                        <option value="oficio" selected>Oficio</option>
                                                        <option value="carta">Carta</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="medio" id="medioSelect" class="form-control input-lg m-bot15" onchange="guardarMedio()">
                                                        <option value="0" selected>Impreso</option>
                                                        <option value="1">Digital</option>
                                                    </select>
                                                </td>
                                            </form>
                                            <td>
                                                <form action="<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/Cllamar" method="post">
                                                    <input name="llamar" type="hidden" value="1" />
                                                    <button name="dato" class="btn btn-warning btn-block" value="<?php echo $dato; ?>" type="submit" style="border-radius: 40px 40px 40px 40px;font-size: 14px;background-color: goldenrod;width: ">📣 LLAMAR</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <form action="<?php echo base_url(); ?>index.php/oficina/CGestion" method="post">
                                    <input name="button" class="btn btn-accent btn-block" style="width: 100px;background: #393185" type="submit" value="Atras" />
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
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
    <script>
        window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');
    </script>
    <!-- CORE JS FRAMEWORK - END -->


    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <script src="<?php echo base_url(); ?>assets/plugins/icheck/icheck.min.js" type="text/javascript"></script>
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE TEMPLATE JS - START -->
    <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>application/libraries/sesion.js" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS - END -->
    <script>
        document.addEventListener('DOMContentLoaded', cargarMedioGuardado);

        function guardarMedio() {
            const select = document.getElementById('medioSelect');
            const valorSeleccionado = select.value;

            // Guardar en localStorage
            localStorage.setItem('medioPreferido', valorSeleccionado);

            console.log('Medio guardado:', valorSeleccionado);
        }

        function cargarMedioGuardado() {
            const medioGuardado = localStorage.getItem('medioPreferido');

            if (medioGuardado !== null) {
                const select = document.getElementById('medioSelect');

                // Establecer el valor guardado
                select.value = medioGuardado;

                console.log('Medio cargado desde localStorage:', medioGuardado);
            }
        }
    </script>




</body>

</html>