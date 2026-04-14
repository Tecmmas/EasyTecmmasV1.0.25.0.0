<!DOCTYPE html>
<html class=" ">
    <head>
        <!-- 
         * @Package: Complete Admin - Responsive Theme
         * @Subpackage: Bootstrap
         * @Version: BS4-1.0
         * This file is part of Complete Admin Theme.
        -->
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>ADMINISTRAR VEHICULO</title>
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
        <link href="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/tecmmas.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <!--<form action="<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/gestionar" method="post">-->
    <body class=" ">


        <!-- END TOPBAR -->

        <!-- START CONTENT -->
        <section class="wrapper main-wrapper row" style=''>
            <label id="mensaje"></label>

        </section>

        <!-- CORE JS FRAMEWORK - START --> 
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/js/popper.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
        <script src="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
        <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');</script>
        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 

        <script src="<?php echo base_url(); ?>assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script> 
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <script type="text/javascript">

            var consultaRunt = '<?php
if (isset($consultaRunt)) {
    echo $consultaRunt;
} else {
    echo'0';
}
?>';
            var activoSicov = '<?php
if (isset($activoSicov)) {
    echo $activoSicov;
} else {
    echo'0';
}
?>';
            var ipSicovAlternativo = '<?php
if (isset($ipSicovAlternativo)) {
    echo $ipSicovAlternativo;
} else {
    echo'0';
}
?>';
            var sicovModoAlternativo = '<?php
if (isset($sicovModoAlternativo)) {
    echo $sicovModoAlternativo;
} else {
    echo'0';
}
?>';
            var ipSicov = '<?php
if (isset($ipSicov)) {
    echo $ipSicov;
} else {
    echo'0';
}
?>';
            var usuarioSicov = '<?php
if (isset($usuarioSicov)) {
    echo $usuarioSicov;
} else {
    echo'0';
}
?>';
            var claveSicov = '<?php
if (isset($claveSicov)) {
    echo $claveSicov;
} else {
    echo'0';
}
?>';
            var sicov = '<?php
if (isset($sicov)) {
    echo $sicov;
} else {
    echo'0';
}
?>';
            $(document).ready(function () {
                buscarVehiculo();
            });

//            var vehiculo = new Object();

            var buscarVehiculo = function () {
                $("#mensaje").text('INICIANDO');
                var proceso = setInterval(function () {
                    $.ajax({
                        url: '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/buscarVehCRT',
                        type: 'post',
                        async: false,
                        success: function (datos) {
                            if (datos !== '') {
                                var v = JSON.parse(datos);
                                consultarRuntxCi2(v);
                            } else {
                                $("#mensaje").text('PROCESO FINALIZADO, POR FAVOR CIERRE ESTA VENTANA');
                                clearInterval(proceso);
                            }
                        }
                    });
                }, 5000);
            };

            var consultarRuntxCi2 = function (ve) {
                data = {
                    placa: ve.numero_placa,
                    usuario: usuarioSicov,
                    clave: claveSicov
                };
                $.ajax({
                    url: '<?php echo base_url() ?>index.php/OFCConsultarRunt/ConsultarXCi2',
                    data: data,
                    type: 'post',
                    async: false,
                    timeout: 3000,
                    success: function (respuesta) {
                        var v = JSON.parse(respuesta);
                        if (v.ConsultaRUNTResult.CodigoRespuesta === '0000') {
                            var data = {
                                idlinearunt: v.ConsultaRUNTResult.idLinea,
                                idcolorrunt: v.ConsultaRUNTResult.idColor,
                                numero_placa: ve.numero_placa,
                                fechainicial: ve.fechainicial
                            };
                            $.ajax({
                                url: '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/guardarCRT',
                                type: 'post',
                                data: data,
                                async: false,
                                success: function (rta) {
                                    $("#mensaje").text(rta);
                                }
                            });
                        } else {
                            var data = {
                                idlinearunt: "0",
                                idcolorrunt: "0",
                                numero_placa: ve.numero_placa,
                                fechainicial: ve.fechainicial
                            };
                            $.ajax({
                                url: '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/guardarCRT',
                                type: 'post',
                                data: data,
                                async: false,
                                success: function (rta) {
                                    $("#mensaje").text(rta);
                                }
                            });
                        }
                    }
                });
                return ve;
            };


        </script>
        <!-- General section box modal start -->

        <!-- modal end -->
    </body>
    <!--</form>-->
</html>



