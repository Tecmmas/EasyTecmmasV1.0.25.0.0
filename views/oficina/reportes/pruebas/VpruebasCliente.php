
<!DOCTYPE html>
<html class=" ">
    <head>

        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Pruebas cliente</title>
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

        <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/datepicker/css/datepicker.css" rel="stylesheet" type="text/css" media="screen"/>
        <!--        <link href="<?php echo base_url(); ?>assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>
                <link href="<?php echo base_url(); ?>assets/plugins/datepicker/css/datepicker.css" rel="stylesheet" type="text/css" media="screen"/>-->


        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->

    </head>
    <style>
        th{
            font-size: 11px;
            background-color: #383085;
            color: white;
            text-align: center;
        }
        td{
            font-size: 11px;
            text-align: center;
        }

    </style>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class="login_page" style="background: white; width: 100%">
        <div class="col-lg-12">
            <!--<section class="box ">-->
            <!--<div class="content-body"  style="background: black">-->    
            <div class="row" >
                <div class="col-lg-12 col-md-12 col-12" style="background: white; width: 100%">
                    <section class="box ">
                        <header class="panel_header">
                            <h2 class="title float-left">Pruebas cliente</h2>
                        </header>
                        <div class="content-body">
                            <table>
                                <tr>
                                    <td>
                                        <div  style="margin-top: 5px">

                                            <label style="font-weight: bold; color: grey; align-content: center " for="nombres">Fecha inicial
                                                <input type="text" class="form-control datepicker" id="fechainicial" name="fechainicial" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px" placeholder="AAAA-MM-DD">
                                            </label>
                                            <label style="font-weight: bold; color: grey; align-content: center " for="nombres">Fecha final
                                                <input type="text" class="form-control datepicker" id="fechafinal" name="fechafinal" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px" placeholder="AAAA-MM-DD">
                                            </label>

                                            <input type="submit" id="btn-descargar-tiempo-pruebas"  onclick="showSuccess('Descargando informe, por favor espere.')" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 150px; color: white" value="Descargar">
                                            <br>

                                        </div>
                                        <div style="text-align: left">
                                            <strong style="font-size: 20px" id="numRegTiempo"></strong>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <br>
                            <table class="table table-bordered" id="table-tiempo-pruebas">
                                <thead>
                                    <tr>
                                        <th>Placa</th>
                                        <th>Fecha</th>
                                        <th>Empresa</th>
                                        <th>Opciones</th>

                                    </tr>
                                </thead>
                                <tbody id="body-time-pruebas">

                                </tbody>
                            </table>
                        </div>
                        <img src="<?php echo base_url(); ?>assets/images/logo.png" />
                    </section>
                </div>
                <!--</div>-->
            </div>
            <!--</section>-->
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
        <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');</script><!--
         CORE JS FRAMEWORK - END  


         OTHER SCRIPTS INCLUDED ON THIS PAGE - START  


         OTHER SCRIPTS INCLUDED ON THIS PAGE - END  


         CORE TEMPLATE JS - START  -->        
        <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/datepicker/js/datepicker.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/datepicker/js/datepicker.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>application/libraries/table2csv/table2csv.js" type="text/javascript"></script> 

        <!-- END CORE TEMPLATE JS - END --> 


        <script type="text/javascript">
                                                var ipLocal = '<?php
echo base_url();
?>';

                                                $(document).ready(function () {
                                                    setInterval(function () {
                                                        cargardatos();
                                                    }, 2500);

                                                    function cargardatos() {
                                                        var fechainicial = $('#fechainicial').val();
                                                        var fechafinal = $('#fechafinal').val();
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/oficina/reportes/pruebas/Cpruebas/getPruebasCliente',
                                                            type: 'post',
                                                            mimeType: 'json',
                                                            data: {fechainicial: fechainicial,
                                                                fechafinal: fechafinal},
                                                            success: function (data, textStatus, jqXHR) {
                                                                console.log(data)
                                                                $('#body-time-pruebas').html('');
                                                                $('#numRegTiempo').html('');
                                                                var c = 0;
                                                                $.each(data, function (i, data) {
                                                                    c++;
                                                                    $("#numRegTiempo").html("Numero de registros:" + "<label style='color:red'>" + c + "</label");
                                                                    var form = '<div style="margin-left: 45%"><form action="' + ipLocal + 'index.php/oficina/fur/CFUR" method="post" style="width: 100px;text-align: center"><button  name="dato" class="btn btn-accent btn-block" value ="' + data.idhojapruebas + '-' + data.reinspeccion + '-0' + '" type="submit" formtarget="_blank" style="border-radius: 40px 40px 40px 40px;font-size: 14px;background-color: #393185">📄 Ver</button><button  name="dato" class="btn btn-accent btn-block" value ="' + data.idhojapruebas + '-' + data.reinspeccion + '-0' + '-1'+'" type="submit" formtarget="_blank" style="border-radius: 40px 40px 40px 40px;font-size: 14px;background-color: #393185" id="btnGuardarFur">📄 Guardar</button></form></div>';
                                                                            var body = "<tr>";
                                                                    body += "<td>" + data.Placa + "</td>";
                                                                    body += "<td>" + data.fechainicial + "</td>";
                                                                    body += "<td>" + data.nombre_empresa + "</td>";
                                                                    body += '<td>' + form + '</td>';
//                                                                    body += "<td>" + data.HORA_FINAL + "</td>";
//                                                                    body += "<td>" + data.HORA_IMPRESION + "</td>";
//                                                                    body += "<td>" + data.TIPO_VEHICULO + "</td>";
//                                                                    body += "<td>" + data.INSPECCION + "</td>";
//                                                                    body += "<td>" + data.TIEMPO_INSPECCION + "</td>";
//                                                                    body += "<td>" + data.TIEMPO_TOTAL + "</td>";
                                                                    body += "</tr>";
                                                                    $("#table-tiempo-pruebas tbody").append(body);
                                                                });
                                                            }
                                                        });
                                                    }
                                                });
                                                $("#btn-descargar-tiempo-pruebas").click(function () {
                                                    $('#table-tiempo-pruebas').table2csv({
                                                        filename: 'Informe tiempo pruebas.csv',
                                                        separator: ';',
                                                        newline: '\n',
                                                        quoteFields: true,
                                                        excludeColumns: '',
                                                        excludeRows: '',
                                                        trimContent: true
                                                    });
                                                }
                                                );
        </script>

    </body>
</html>




