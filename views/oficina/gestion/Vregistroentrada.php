
<!DOCTYPE html>
<html class=" ">
    <head>

        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Registo entrada</title>
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
    <style>
        th{
            font-size: 12px;
            background-color: #383085; color: white;
            text-align: center;
        }
        td{
            font-size: 12px;
            text-align: center;
        }
        .select-css {
            display: block;
            font-size: 16px;
            font-family: 'Arial', sans-serif;
            /*font-weight: 400;*/
            color: #444;
            line-height: 1.3;
            padding: .4em 1.4em .3em .8em;
            width: 190px;
            height: 35px;
            max-width: 100%; 
            box-sizing: border-box;
            margin: 0;
            border: 1px solid #aaa;
            margin-top: 10px;

            /*margin-left: 188px;*/
            box-shadow: 0 1px 0 1px rgba(0,0,0,.03);
            border-radius: .3em;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            background-color: #fff;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'),
                linear-gradient(to bottom, #ffffff 0%,#f7f7f7 100%);
            background-repeat: no-repeat, repeat;
            background-position: right .7em top 50%, 0 0;
            background-size: .65em auto, 100%;
        }
        .select-css::-ms-expand {
            display: none;
        }
        .select-css:hover {
            border-color: #888;
        }
        .select-css:focus {
            border-color: #aaa;
            box-shadow: 0 0 1px 3px rgba(59, 153, 252, .7);
            box-shadow: 0 0 0 3px -moz-mac-focusring;
            color: #222; 
            outline: none;
        }
        .select-css option {
            font-weight:normal;
        }

    </style>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class="login_page" style="background: white; width: 200%">
        <div class="col-lg-12">
            <!--<section class="box ">-->
            <!--<div class="content-body"  style="background: black">-->    
            <div class="row" >
                <div class="col-lg-12 col-md-12 col-12" style="background: white; width: 200%">
                    <section class="box ">
                        <header class="panel_header">
                            <h2 class="title float-left">Registro entrada</h2>
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
                                            <label style="font-weight: bold; color: grey; align-content: center " for="nombres">Tipo inspección
                                                <select class="select-css" name='idtipoInspeccion' id="idtipoInspeccion">
                                                    <option selected="selected">Seleccione</option>
                                                    <option value="1">Certificadas</option>
                                                    <option value="2">Preventivas</option>
                                                </select>
                                            </label>

                                            <input type="submit" id="btn-descargar-regsitro-entradas"  onclick="showSuccess('Descargando informe, por favor espere.')" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 150px; color: white" value="Descargar">
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <strong id="Registros"></strong>
                            <br>
                            <table class="table table-bordered" id="table-registro">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Documento P</th>
                                        <th>Nombre P</th>
                                        <th>Dirección P</th>
                                        <th>Telefono P</th>
                                        <th>Correo Propietario</th>
                                        <th>Documento P</th>
                                        <th>Nombre C</th>
                                        <th>Dirección C</th>
                                        <th>Telefono C</th>
                                        <th>Correo Cliente</th>
                                        <th>Placa</th>
                                        <th>Tipo V</th>
                                        <th>Servicio</th>
                                        <th>Taxi</th>
                                        <th>Tipo Inpesccion</th>
                                        <th>Ocación</th>
                                        <th>Enseñanza</th>
                                    </tr>
                                </thead>
                                <tbody id="body-reg">

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
        <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');</script>
        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 

        <script src="<?php echo base_url(); ?>assets/plugins/icheck/icheck.min.js" type="text/javascript"></script>
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>application/libraries/table2csv/table2csv.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>application/libraries/sesion.js"  type="text/javascript"></script>
        <!-- END CORE TEMPLATE JS - END --> 
        <script type="text/javascript">
                                                $(document).ready(function () {
                                                    setInterval(function () {
                                                        cargardatos();
                                                    }, 2000);
                                                    function cargardatos() {
                                                        var fechainicial = $('#fechainicial').val();
                                                        var fechafinal = $('#fechafinal').val();
                                                        var idseleccion = $('#idtipoInspeccion option:selected').attr('value');
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/registroentradaselect',
                                                            type: 'post',
                                                            mimeType: 'json',
                                                            data: {fechainicial: fechainicial,
                                                                fechafinal: fechafinal,
                                                                idseleccion: idseleccion},
                                                            success: function (data, textStatus, jqXHR) {
                                                                $('#body-reg').html('');
                                                                $('#Registros').html('');
                                                                var c = 0;
//                                                    console.log(data);
                                                                $.each(data, function (i, data) {
                                                                    c++;
                                                                    $('#Registros').html('Numero de registros: ' + c);
                                                                    var body = "<tr>";
                                                                    body += "<td>" + data.Fecharegistro + "</td>";
                                                                    body += "<td>" + data.Documentopropietario + "</td>";
                                                                    body += "<td>" + data.Nombrepropietario + "</td>";
                                                                    body += "<td>" + data.Direccionpropietario + "</td>";
                                                                    body += "<td>" + data.Telefonopropietario + "</td>";
                                                                    body += "<td>" + data.Correopropietario + "</td>";
                                                                    body += "<td>" + data.Documentocliente + "</td>";
                                                                    body += "<td>" + data.Nombrecliente + "</td>";
                                                                    body += "<td>" + data.Direccioncliente + "</td>";
                                                                    body += "<td>" + data.Telefonocliente + "</td>";
                                                                    body += "<td>" + data.Correocliente + "</td>";
                                                                    body += "<td>" + data.Placa + "</td>";
                                                                    body += "<td>" + data.Tipovehiculo + "</td>";
                                                                    body += "<td>" + data.Servicio + "</td>";
                                                                    body += "<td>" + data.Taxi + "</td>";
                                                                    body += "<td>" + data.Tipoinspeccion + "</td>";
                                                                    body += "<td>" + data.Ocacion + "</td>";
                                                                    body += "<td>" + data.Ensenanza + "</td>";
                                                                    body += "</tr>";
                                                                    $("#table-registro tbody").append(body);
                                                                });
                                                            }
                                                        });
                                                    }
                                                });
                                                $("#btn-descargar-regsitro-entradas").click(function () {
                                                    $('#table-registro').table2csv({
                                                        filename: 'Informe resgitro entradas.csv',
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




