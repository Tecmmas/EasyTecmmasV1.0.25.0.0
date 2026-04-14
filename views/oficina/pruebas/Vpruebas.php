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

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" type="image/x-icon" />
    <!-- Favicon -->
    <link rel="apple-touch-icon-precomposed"
        href="<?php echo base_url(); ?>assets/images/apple-touch-icon-57-precomposed.png"> <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="<?php echo base_url(); ?>assets/images/apple-touch-icon-114-precomposed.png">
    <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="<?php echo base_url(); ?>assets/images/apple-touch-icon-72-precomposed.png"> <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="<?php echo base_url(); ?>assets/images/apple-touch-icon-144-precomposed.png">
    <!-- For iPad Retina display -->




    <!-- CORE CSS FRAMEWORK - START -->
    <link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css"
        media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <!-- <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/> -->
    <link href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css"
        media="screen" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet"
        type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/select2/select2.css" rel="stylesheet" type="text/css"
        media="screen" />

    <link href="<?php echo base_url(); ?>assets/plugins/datatables/css/datatables.min.css" rel="stylesheet"
        type="text/css" media="screen" />
    <!--<link href="<?php echo base_url(); ?>assets/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.min.css" rel="stylesheet" type="text/css" media="screen"/>-->
    <!--        <link href="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" media="screen"/>
                  <link href="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css" media="screen"/>-->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE CSS TEMPLATE - START -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/tecmmas.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->

</head>
<!-- END HEAD -->
<!--<form action="<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/gestionar" method="post" >-->
<!-- BEGIN BODY -->

<body class=" ">

    <!-- START TOPBAR -->
    <div class='page-topbar '>
        <div class='logo-area'>

        </div>
        <div class='quick-area'>
            <div class='float-left'>
                <ul class="info-menu left-links list-inline list-unstyled">
                    <li class="message-toggle-wrapper list-inline-item">
                        <ul class="dropdown-menu messages animated fadeIn">
                            <li class="list dropdown-item">
                            </li>
                        </ul>
                    </li>
            </div>
        </div>

    </div>
    <!-- END TOPBAR -->
    <br><br>
    <!-- START CONTENT -->

    <section class="box ">
        <header class="panel_header">
            <h2 class="title pull-left">GESTION DE PRUEBAS</h2>
        </header>
        <div class="content-body">
            <input type="button" class="btn btn-block bot_azul" style="width: 100px"
                onclick="location.href = '../CPrincipal';" value="Atras" /><br>
            <table style="width: 100%;text-align: left">
                <tr>

                    <td style="text-align: left;width: 100px">
                        <label for="placa">PLACA<br />
                            <input type="text" id="placa" name="placa" class="form-control" value="<?php
                                                                                                    if (isset($placa)) {
                                                                                                        echo $placa;
                                                                                                    }
                                                                                                    ?>" />
                        </label>
                    </td>
                    <td style="text-align: left;width: 200px">
                        <input type="button" onclick="consultar();" name="button" class="btn bot_azul btn-block"
                            style="width: 150px" value="Consultar" />
                    </td>
                </tr>
            </table>
            <br>
            <div class="col-xs-12">
                <table id="example-1" class="table table-striped dt-responsive display">
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Tipo</th>
                            <th>Clase</th>
                            <th>Combustible</th>
                            <th>RTMec</th>
                            <th>Preventiva</th>
                            <th>Prueba libre</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Placa</th>
                            <th>Tipo</th>
                            <th>Clase</th>
                            <th>Combustible</th>
                            <th>RTMec</th>
                            <th>Preventiva</th>
                            <th>Prueba libre</th>
                        </tr>
                    </tfoot>
                    <tbody id="resulVehiculo">
                    </tbody>
                </table>
                <div id="div_error"></div>
            </div>
        </div>
    </section>
    </section>
    <!-- END CONTENT -->


    <!-- END CONTAINER -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->

    <!-- CORE JS FRAMEWORK - START -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/popper.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"
        type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>
    <script>
        window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');
    </script>
    <!-- CORE JS FRAMEWORK - END -->

    <script src="<?php echo base_url(); ?>assets/plugins/autosize/autosize.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/icheck/icheck.min.js" type="text/javascript"></script>
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <script src="<?php echo base_url(); ?>assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js"
        type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.js" type="text/javascript">
    </script>
    <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/js/dataTables.min.js" type="text/javascript">
    </script>
    <!--    <script src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.js" type="text/javascript"></script>-->
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE TEMPLATE JS - START -->
    <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>

    <!-- END CORE TEMPLATE JS - END -->


    <!-- General section box modal start -->
    <div class="modal" id="RTmecModal" s tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog animated bounceInDown">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titulo_">REVISION TECNICOMECÁNICA</h4>
                </div>
                <div class="modal-body" style="background: whitesmoke">
                    <table class="table">
                        <tr id="facturacion">
                            <td style="width: 25%;text-align: right">
                                FACTURA No
                            </td>
                            <td style="width: 30%;text-align: left;padding-left: 10px">
                                <input id="noFactura" type="text" class="form-control" />
                            </td>
                            <td style="width: 20%;text-align: right">
                                COSTO $
                            </td>
                            <td style="width: 25%;text-align: left;padding-left: 10px">
                                <input id="costo" type="text" class="form-control" />
                            </td>
                        </tr>
                        <tr id="pin">
                            <td style="text-align: right">
                                PIN
                            </td>
                            <td colspan="3" style="text-align: left;padding-left: 10px">
                                <input id="pin_" type="text" class="form-control" />
                            </td>
                        </tr>
                        <tr id="pinQuemado">
                            <td style="text-align: right">
                                <input id="chkpinQuemado" tabindex="1" type="checkbox" style="transform: scale(2.0)" />
                            </td>
                            <td style="text-align: left;padding-left: 10px" colspan="3">
                                PIN QUEMADO DESDE AUDIWEB
                            </td>
                        </tr>
                        <tr id="moduloPrerevision">
                            <td style="text-align: right">
                                <input id="chkModuloPre" tabindex="1" type="checkbox" style="transform: scale(2.0)" />
                            </td>
                            <td style="text-align: left;padding-left: 10px" colspan="4">
                                PREREVISION FÍSICA
                            </td>
                        </tr>

                        <tr id="aplicares2703">
                            <td style="text-align: right">
                                <input id="chkAplicaRes2703" tabindex="1" type="checkbox"
                                    style="transform: scale(2.0)" />
                            </td>
                            <td style="text-align: left;padding-left: 10px" colspan="2">
                                Aplica Resolución 2703 de 2023 <a
                                    href="https://www.alcaldiabogota.gov.co/sisjur/normas/Norma1.jsp?i=152048"
                                    target="_blank">Más información</a><br>
                            </td>
                        </tr>
                        <tr id="autoregulado">
                            <td style="text-align: right">
                                <input id="chkAutoregulado" tabindex="1" onchange="chkAutoregulado(this.value)"
                                    type="checkbox" style="transform: scale(2.0)" />
                            </td>
                            <td style="text-align: left;padding-left: 10px" colspan="2">
                                El vehículo pertenece al programa de autoregulación.<br>
                            </td>
                        </tr>
                        <tr id="infoRes">
                            <td style="text-align: justify">
                                <label><strong>Nota: </strong> Para dar cumplimiento con la resolución 2703 de 2023
                                    asegúrese de realizar la prueba de opacidad con la versión >= 1.0.20.0.0 en los
                                    dispositivos móviles.</label>
                            </td>
                        </tr>
                    </table><br>
                    <label id="mensaje" style="background: white;
                           width: 100%;
                           text-align: center;
                           font-weight: bold;
                           font-size: 15px;
                           padding: 5px;border: solid gray 2px;
                           border-radius:  15px 15px 15px 15px;color: gray">ESPERANDO ASIGNACIÓN</label>
                    <br>
                    <h5 id="titPruebas">Pruebas</h5>
                    <table id="tabPruebas" class="table">
                        <tr>

                            <td><input type="checkbox" style="transform: scale(2.0)" id="luxometro" disabled /></td>
                            <td style="padding-left: 10px">LUXÓMETRO</td>
                            <td><input type="checkbox" style="transform: scale(2.0)" id="opacidad" disabled /></td>
                            <td style="padding-left: 10px">OPACIDAD</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="transform: scale(2.0)" id="gases" disabled /></td>
                            <td style="padding-left: 10px">GASES</td>
                            <td><input type="checkbox" style="transform: scale(2.0)" id="camara" disabled /></td>
                            <td style="padding-left: 10px">CAMARA</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="transform: scale(2.0)" id="taximetro" disabled /></td>
                            <td style="padding-left: 10px">TAXIMETRO</td>
                            <td><input type="checkbox" style="transform: scale(2.0)" id="frenometro" disabled /></td>
                            <td style="padding-left: 10px">FRENOMETRO</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="transform: scale(2.0)" id="visual" disabled /></td>
                            <td style="padding-left: 10px">VISUAL</td>
                            <td><input type="checkbox" style="transform: scale(2.0)" id="suspension" disabled /></td>
                            <td style="padding-left: 10px">SUSPENSIÓN</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="transform: scale(2.0)" id="alineacion" disabled /></td>
                            <td style="padding-left: 10px">ALINEACIÓN</td>
                            <td><input type="checkbox" style="transform: scale(2.0)" id="sonometro" disabled /></td>
                            <td style="padding-left: 10px">SONOMETRIA</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">CANCELAR</button>
                    <button id="btnAsignar" class="btn btn-success" type="button"
                        onclick="asignarPrueba()">ASIGNAR</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="Modal-token" s tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog animated bounceInDown">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titulo_">Validar Token</h4>
                </div>
                <div class="modal-body">
                    <label style="color: black; justify-content: center">Para poder ejecutar este comando, por favor
                        comuniquese con el area de desarrollo para que le entregue un token y pueda continuar con el
                        proceso</label>
                    <br>
                    <br>
                    <div style="text-align: center">
                        <input type="text" placeholder="Token" class="input" id="token" autocomplete="off">
                    </div>
                    <div id="valid-token" style="color: red"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" onclick="location.reload()">CANCELAR</button>
                    <button id="btnAsignar" class="btn btn-success" type="button" onclick="Validar()">Validar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal end -->
    <!--<script src="<?php echo base_url(); ?>assets/sesion.js"  type="text/javascript"></script>-->}
    <!--<script src="<?php echo base_url(); ?>application/libraries/sesion.js"  type="text/javascript"></script>-->
    <script type="text/javascript">
        var facturacion = '<?php
                            if (isset($facturacion)) {
                                echo $facturacion;
                            } else {
                                echo '0';
                            }
                            ?>';
        var valorRtmecLiviano = '<?php
                                    if (isset($valorRtmecLiviano)) {
                                        echo $valorRtmecLiviano;
                                    } else {
                                        echo '0';
                                    }
                                    ?>';
        var valorRtmecPesado = '<?php
                                if (isset($valorRtmecPesado)) {
                                    echo $valorRtmecPesado;
                                } else {
                                    echo '0';
                                }
                                ?>';
        var valorRtmecMoto = '<?php
                                if (isset($valorRtmecMoto)) {
                                    echo $valorRtmecMoto;
                                } else {
                                    echo '0';
                                }
                                ?>';
        var valorPreventivaLiviano = '<?php
                                        if (isset($valorPreventivaLiviano)) {
                                            echo $valorPreventivaLiviano;
                                        } else {
                                            echo '0';
                                        }
                                        ?>';
        var valorPreventivaPesado = '<?php
                                        if (isset($valorPreventivaPesado)) {
                                            echo $valorPreventivaPesado;
                                        } else {
                                            echo '0';
                                        }
                                        ?>';
        var valorPreventivaMoto = '<?php
                                    if (isset($valorPreventivaMoto)) {
                                        echo $valorPreventivaMoto;
                                    } else {
                                        echo '0';
                                    }
                                    ?>';
        var valorPreventivaMoto = '<?php
                                    if (isset($valorPreventivaMoto)) {
                                        echo $valorPreventivaMoto;
                                    } else {
                                        echo '0';
                                    }
                                    ?>';
        var activoSicov = '<?php
                            if (isset($activoSicov)) {
                                echo $activoSicov;
                            } else {
                                echo '0';
                            }
                            ?>';
        var idCdaRUNT = '<?php
                            if (isset($idCdaRUNT)) {
                                echo $idCdaRUNT;
                            } else {
                                echo '0';
                            }
                            ?>';
        var idSoftwareRunt = '<?php
                                if (isset($idSoftwareRunt)) {
                                    echo $idSoftwareRunt;
                                } else {
                                    echo '0';
                                }
                                ?>';
        var idConsecutivoRunt = '<?php
                                    if (isset($idConsecutivoRunt)) {
                                        echo $idConsecutivoRunt;
                                    } else {
                                        echo '0';
                                    }
                                    ?>';
        var ipSicovAlternativo = '<?php
                                    if (isset($ipSicovAlternativo)) {
                                        echo $ipSicovAlternativo;
                                    } else {
                                        echo '0';
                                    }
                                    ?>';
        var sicovModoAlternativo = '<?php
                                    if (isset($sicovModoAlternativo)) {
                                        echo $sicovModoAlternativo;
                                    } else {
                                        echo '0';
                                    }
                                    ?>';
        var ipSicov = '<?php
                        if (isset($ipSicov)) {
                            echo $ipSicov;
                        } else {
                            echo '0';
                        }
                        ?>';
        var usuarioSicov = '<?php
                            if (isset($usuarioSicov)) {
                                echo $usuarioSicov;
                            } else {
                                echo '0';
                            }
                            ?>';
        var claveSicov = '<?php
                            if (isset($claveSicov)) {
                                echo $claveSicov;
                            } else {
                                echo '0';
                            }
                            ?>';
        var moduloPrerevision = '<?php
                                    if (isset($moduloPrerevision)) {
                                        echo $moduloPrerevision;
                                    } else {
                                        echo '0';
                                    }
                                    ?>';
        var sicov = '<?php
                        if (isset($sicov)) {
                            echo strtoupper($sicov);
                        } else {
                            echo '0';
                        }
                        ?>';
        var asignarNoFactura = '<?php
                                if (isset($asignarNoFactura)) {
                                    echo $asignarNoFactura;
                                } else {
                                    echo '0';
                                }
                                ?>';
        var numFactura = '<?php
                            if (isset($numFactura)) {
                                echo $numFactura;
                            } else {
                                echo '0';
                            }
                            ?>';
        var moduloCaptador = '<?php
                                if (isset($moduloCaptador)) {
                                    echo $moduloCaptador;
                                } else {
                                    echo '1';
                                }
                                ?>';
        var pedirSonometro = '<?php
                                if (isset($pedirSonometro)) {
                                    echo $pedirSonometro;
                                } else {
                                    echo '0';
                                }
                                ?>';
        var salaEspera = '<?php
                            if (isset($salaEspera2)) {
                                echo $salaEspera2;
                            } else {
                                echo '0';
                            }
                            ?>';
        var ipCAR = '<?php
                        if (isset($ipCAR)) {
                            echo $ipCAR;
                        } else {
                            echo '0';
                        }
                        ?>';
        var eTh = '<?php
                    if (isset($eTh)) {
                        echo $eTh;
                    } else {
                        echo '0';
                    }
                    ?>';
        var idCdaRUNT = '<?php
                            if (isset($idCdaRUNT)) {
                                echo $idCdaRUNT;
                            } else {
                                echo '0';
                            }
                            ?>';
        var facturaCero = '<?php
                            if (isset($facturaCero)) {
                                echo $facturaCero;
                            } else {
                                echo '0';
                            }
                            ?>';
        var obligatorio2703 = '<?php
                                if (isset($obligatorio2703)) {
                                    echo $obligatorio2703;
                                } else {
                                    echo '0';
                                }
                                ?>';
        var verificarPin = '<?php
                            if (isset($verificarPinIndra)) {
                                echo $verificarPinIndra;
                            } else {
                                echo '1';
                            }
                            ?>';
        var ipLocal = '<?php
                        echo base_url();
                        ?>';


        var facturaActual;


        $(document).ready(function() {
            evalTh();
            document.getElementById('aplicares2703').style.display = 'none';
            document.getElementById('aplicares2703').style.position = 'absolute';
            document.getElementById('autoregulado').style.display = 'none';
            document.getElementById('autoregulado').style.position = 'absolute';
            document.getElementById('infoRes').style.display = 'none';
            document.getElementById('infoRes').style.position = 'absolute';
            let date = new Date()
            if (localStorage.getItem("contador") == undefined || localStorage.getItem("contador") == "NAN" ||
                localStorage.getItem("contador") == 0) {
                localStorage.setItem("contador", 0);
            }
            // let day = date.getDate()
            // let month = date.getMonth() + 1
            // let year = date.getFullYear()

            // var hora = date.getHours();
            // var min = date.getMinutes();
            // var horaMinuto = `${hora}:${min}`;
            // if (horaMinuto <= '07:00' && (localStorage.getItem("contador") !== null && localStorage.getItem("contador") !== 0)) {
            //     // let fecha = "";
            //     // if (month < 10) {
            //     //     fecha = `${year}-0${month}-${day}`;
            //     // } else {
            //     //     fecha = `${year}-${month}-${day}`;
            //     // }
            //     // localStorage.setItem('fechaAnterior', fecha);
            //     localStorage.setItem('contador', "0");
            // }
        });
        var getNumFactura = function() {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/getNumFactura',
                type: 'post',
                async: false,
                success: function(numFactura) {
                    $('#noFactura').val(numFactura);
                    facturaActual = parseInt(numFactura) - 1;
                }
            });
        };
        var ifRemolque = false;
        var consultar = function() {
            unChekedAll();
            var placa = $("#placa").val();
            if (placa !== '') {
                var data = {
                    placa: placa
                };
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/consultar',
                    data: data,
                    type: 'post',
                    success: function(rta) {
                        document.getElementById("resulVehiculo").innerHTML = rta;
                        if (rta.includes("REMOLQUE") || rta.includes("SEMIREMOLQUE")) {
                            ifRemolque = true;
                        }
                    }
                });
            }
        };

        var vehiculo;
        var tipoTipoInspeccion;
        var reinspeccion;

        var evalTh = function() {
            //        alert(eTh);
            if (eTh !== "0") {
                //                $("#RTmecModal").hide();
                Swal.fire({
                    html: "<label style='font-size: 22px'>Verificación importante</label> <br><br><div style='text-align: justify' ><strong>Para continuar con la inspección debe comunicarse con TECMMAS para una verificación en la actualización del software.</strong></div>",
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false
                }).then((result) => {
                    history.back();
                });
            }
        };

        var configurar2703 = function() {
            const date1 = Date.parse('2024-06-01');
            const date2 = Date.now();
            //            console.log(vehiculo);
            //            console.log(date1);
            //            console.log(date2);
            if (date2 >= date1) {
                document.getElementById('aplicares2703').style.display = 'none';
                document.getElementById('aplicares2703').style.position = 'absolute';
                document.getElementById('autoregulado').style.display = 'none';
                document.getElementById('autoregulado').style.position = 'absolute';
                document.getElementById('infoRes').style.display = 'none';
                document.getElementById('infoRes').style.position = 'absolute';
                if (vehiculo.idtipocombustible === '1') {
                    document.getElementById('aplicares2703').style.display = 'block';
                    document.getElementById('aplicares2703').style.position = 'relative';
                    document.getElementById('autoregulado').style.display = 'block';
                    document.getElementById('autoregulado').style.position = 'relative';
                    document.getElementById('infoRes').style.display = 'block';
                    document.getElementById('infoRes').style.position = 'relative';
                    document.getElementById('chkAplicaRes2703').checked = false;
                    document.getElementById('chkAutoregulado').checked = false;
                    if (vehiculo.aplicares2703 === "1")
                        document.getElementById('chkAplicaRes2703').checked = true;
                    if (vehiculo.autoregulado === "1")
                        document.getElementById('chkAutoregulado').checked = true;
                    if (obligatorio2703 === '1') {
                        document.getElementById('chkAplicaRes2703').checked = true;
                        document.getElementById('chkAplicaRes2703').disabled = true;
                    }
                }
            }
        };
        var chkAutoregulado = function(value) {
            if (value)
                document.getElementById('chkAplicaRes2703').checked = true;
        };


        var asignarRTMec1ra = function(e) {

            mostrarComponente();
            $('#titulo_').text("REVISION TECNICOMECANICA");
            tipoTipoInspeccion = 'RTMec';
            reinspeccion = '0';
            idhojapruebas = '';
            var placa = e.title.toString().replace("A-", "");
            var data = {
                numero_placa: e.title
            };
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/asignarRTMec1ra',
                data: data,
                type: 'post',
                success: function(r) {

                    var v = JSON.parse(r);

                    vehiculo = new Object();
                    vehiculo = v;
                    configurar2703();

                    if ($('#libre-' + vehiculo.numero_placa).val() !== 'Prueba libre') {
                        setMensaje('El vehículo con placa ' + vehiculo.numero_placa +
                            ' se encuentra actualmente en proceso de prueba libre y no se le puede asignar un tipo de inspección diferente',
                            '');
                        ocultarComponente();
                    } else {
                        setMensaje('PRIMERA VEZ PARA ' + vehiculo.numero_placa, '');
                        if (v.tipo_vehiculo === 'Liviano') {
                            $('#costo').val(valorRtmecLiviano);
                            setLiviano();
                        } else if (v.tipo_vehiculo === 'Moto') {
                            $('#costo').val(valorRtmecMoto);
                            setMoto();
                        } else {
                            $('#costo').val(valorRtmecPesado);
                            setPesado();
                        }
                        if (facturacion === '0') {
                            document.getElementById('facturacion').style.display = 'none';
                            document.getElementById('facturacion').style.position = 'absolute';
                        }
                        if (moduloPrerevision === '0') {
                            document.getElementById('moduloPrerevision').style.display = 'none';
                            document.getElementById('moduloPrerevision').style.position = 'absolute';
                        }

                        if (activoSicov === '1' && sicov === 'CI2') {} else {
                            document.getElementById('pinQuemado').style.display = 'none';
                            document.getElementById('pinQuemado').style.position = 'absolute';
                            document.getElementById('pin').style.display = 'none';
                            document.getElementById('pin').style.position = 'absolute';
                        }
                        if (asignarNoFactura === '1') {
                            getNumFactura();
                        }
                    }

                }
            });
        };
        var idhojapruebas;

        var asignarRTMec2da = function(placa, idhojatrabajo) {

            mostrarComponente();
            $('#titulo_').text("REVISION TECNICOMECANICA");
            tipoTipoInspeccion = 'RTMec';
            reinspeccion = '1';
            idhojapruebas = idhojatrabajo;
            var data = {
                numero_placa: placa,
                idhojapruebas: idhojatrabajo
            };
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/asignarRTMec2da',
                data: data,
                type: 'post',
                success: function(r) {
                    var dat = JSON.parse(r);
                    vehiculo = new Object();
                    vehiculo = dat.vehiculo;
                    configurar2703();
                    if ($('#libre-' + vehiculo.numero_placa).val() !== 'Prueba libre') {
                        setMensaje('El vehículo con placa ' + vehiculo.numero_placa +
                            ' se encuentra actualmente en proceso de prueba libre y no se le puede asignar un tipo de inspección diferente',
                            '');
                        ocultarComponente();
                    } else {
                        setMensaje('SEGUNDA VEZ PARA ' + vehiculo.numero_placa, '');
                        document.getElementById('facturacion').style.display = 'none';
                        document.getElementById('facturacion').style.position = 'absolute';
                        if (moduloPrerevision === '0') {
                            document.getElementById('moduloPrerevision').style.display = 'none';
                            document.getElementById('moduloPrerevision').style.position = 'absolute';
                        }
                        if (activoSicov === '1' && sicov === 'CI2') {
                            $('#pin_').val(dat.pruebas[0].pin);
                        } else {
                            document.getElementById('pinQuemado').style.display = 'none';
                            document.getElementById('pinQuemado').style.position = 'absolute';
                            document.getElementById('pin').style.display = 'none';
                            document.getElementById('pin').style.position = 'absolute';

                        }
                        dat.pruebas[0].camara = '1';
                        dat.pruebas[0].visual = '1';
                        setPrueba("luxometro", dat.pruebas[0].luxometro);
                        setPrueba("opacidad", dat.pruebas[0].opacidad);
                        setPrueba("gases", dat.pruebas[0].gases);
                        setPrueba("sonometro", dat.pruebas[0].sonometro);
                        setPrueba("camara", dat.pruebas[0].camara);
                        setPrueba("taximetro", dat.pruebas[0].taximetro);
                        setPrueba("frenometro", dat.pruebas[0].frenometro);
                        setPrueba("visual", dat.pruebas[0].visual);
                        setPrueba("suspension", dat.pruebas[0].suspension);
                        setPrueba("alineacion", dat.pruebas[0].alineacion);
                    }
                }
            });
        };


        var mostrarComponente = function() {
            var btnAsignar = document.getElementById("btnAsignar");
            btnAsignar.disabled = false;
            document.getElementById('facturacion').style.display = 'block';
            document.getElementById('facturacion').style.position = 'relative';
            document.getElementById('pinQuemado').style.display = 'block';
            document.getElementById('pinQuemado').style.position = 'relative';
            document.getElementById('pin').style.display = 'block';
            document.getElementById('pin').style.position = 'relative';
            document.getElementById('moduloPrerevision').style.display = 'block';
            document.getElementById('moduloPrerevision').style.position = 'relative';
        };

        var ocultarComponente = function() {
            //            var btnAsignar = document.getElementById("btnAsignar");
            //            btnAsignar.disabled = true;
            document.getElementById('titPruebas').style.display = 'none';
            document.getElementById('titPruebas').style.position = 'abosolute';
            document.getElementById('tabPruebas').style.display = 'none';
            document.getElementById('tabPruebas').style.position = 'abosolute';
            document.getElementById('btnAsignar').style.display = 'none';
            document.getElementById('btnAsignar').style.position = 'abosolute';
            document.getElementById('facturacion').style.display = 'none';
            document.getElementById('facturacion').style.position = 'abosolute';
            document.getElementById('pinQuemado').style.display = 'none';
            document.getElementById('pinQuemado').style.position = 'abosolute';
            document.getElementById('pin').style.display = 'none';
            document.getElementById('pin').style.position = 'abosolute';
            document.getElementById('moduloPrerevision').style.display = 'none';
            document.getElementById('moduloPrerevision').style.position = 'abosolute';
        };



        var asignarPreventiva1ra = function(e) {
            mostrarComponente();
            $('#titulo_').text("PREVENTIVA");
            tipoTipoInspeccion = 'Preventiva';
            reinspeccion = '4444';
            idhojapruebas = '';
            var data = {
                numero_placa: e.title
            };
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/asignarRTMec1ra',
                data: data,
                type: 'post',
                success: function(r) {
                    var v = JSON.parse(r);
                    vehiculo = new Object();
                    vehiculo = v;
                    configurar2703();
                    if ($('#rtmec-' + vehiculo.numero_placa).val() !== 'Primera vez') {
                        setMensaje('El vehículo con placa ' + vehiculo.numero_placa +
                            ' se encuentra actualmente en proceso de inspección tecnicomecánica y no se le puede asignar un tipo de inspección diferente',
                            '');
                        ocultarComponente();
                    } else {
                        setMensaje('PRIMERA VEZ PARA ' + vehiculo.numero_placa, '');
                        if (v.tipo_vehiculo === 'Liviano') {
                            $('#costo').val(valorPreventivaLiviano);
                        } else if (v.tipo_vehiculo === 'Moto') {
                            $('#costo').val(valorPreventivaMoto);
                        } else {
                            $('#costo').val(valorPreventivaPesado);
                        }
                        setPl();
                        if (facturacion === '0') {
                            document.getElementById('facturacion').style.display = 'none';
                            document.getElementById('facturacion').style.position = 'absolute';
                        }
                        document.getElementById('moduloPrerevision').style.display = 'none';
                        document.getElementById('moduloPrerevision').style.position = 'absolute';
                        document.getElementById('pinQuemado').style.display = 'none';
                        document.getElementById('pinQuemado').style.position = 'absolute';
                        document.getElementById('pin').style.display = 'none';
                        document.getElementById('pin').style.position = 'absolute';
                        if (asignarNoFactura === '1') {
                            getNumFactura();
                        }
                    }
                }
            });
        };


        var asignarPreventiva2da = function(placa, idhojatrabajo) {
            mostrarComponente();
            $('#titulo_').text("PREVENTIVA");
            tipoTipoInspeccion = 'Preventiva';
            reinspeccion = '44441';
            idhojapruebas = idhojatrabajo;
            var data = {
                numero_placa: placa,
                idhojapruebas: idhojatrabajo
            };
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/asignarRTMec2da',
                data: data,
                type: 'post',
                success: function(r) {
                    var dat = JSON.parse(r);
                    vehiculo = new Object();
                    vehiculo = dat.vehiculo;
                    configurar2703();
                    if ($('#rtmec-' + vehiculo.numero_placa).val() !== 'Primera vez') {
                        setMensaje('El vehículo con placa ' + vehiculo.numero_placa +
                            ' se encuentra actualmente en proceso de inspección tecnicomecánica y no se le puede asignar un tipo de inspección diferente',
                            '');
                        ocultarComponente();
                    } else {
                        setMensaje('SEGUNDA VEZ PARA ' + vehiculo.numero_placa, '');
                        document.getElementById('facturacion').style.display = 'none';
                        document.getElementById('facturacion').style.position = 'absolute';
                        document.getElementById('moduloPrerevision').style.display = 'none';
                        document.getElementById('moduloPrerevision').style.position = 'absolute';
                        document.getElementById('pinQuemado').style.display = 'none';
                        document.getElementById('pinQuemado').style.position = 'absolute';
                        document.getElementById('pin').style.display = 'none';
                        document.getElementById('pin').style.position = 'absolute';
                        dat.pruebas[0].camara = '1';
                        dat.pruebas[0].visual = '1';
                        setPrueba("luxometro", dat.pruebas[0].luxometro);
                        setPrueba("opacidad", dat.pruebas[0].opacidad);
                        setPrueba("gases", dat.pruebas[0].gases);
                        setPrueba("camara", dat.pruebas[0].camara);
                        setPrueba("sonometro", dat.pruebas[0].sonometro);
                        setPrueba("taximetro", dat.pruebas[0].taximetro);
                        setPrueba("frenometro", dat.pruebas[0].frenometro);
                        setPrueba("visual", dat.pruebas[0].visual);
                        setPrueba("suspension", dat.pruebas[0].suspension);
                        setPrueba("alineacion", dat.pruebas[0].alineacion);
                    }

                }
            });
        };


        var asignarPruebaLibre = function(e) {
            //            console.log($('#rtmec-' + vehiculo.numero_placa));
            mostrarComponente();
            $('#titulo_').text("PRUEBA LIBRE");
            tipoTipoInspeccion = 'Prueba libre';
            reinspeccion = '8888';
            idhojapruebas = '';
            var data = {
                numero_placa: e.title
            };
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/asignarRTMec1ra',
                data: data,
                type: 'post',
                success: function(r) {
                    //                    console.log('hola');
                    var v = JSON.parse(r);
                    vehiculo = new Object();
                    vehiculo = v;
                    configurar2703();
                    if ($('#rtmec-' + vehiculo.numero_placa).val() !== 'Primera vez') {
                        setMensaje('El vehículo con placa ' + vehiculo.numero_placa +
                            ' se encuentra actualmente en proceso de inspección tecnicomecánica y no se le puede asignar un tipo de inspección diferente',
                            '');
                        ocultarComponente();
                    } else {
                        setMensaje('PRUEBA LIBRE PARA ' + vehiculo.numero_placa, '');
                        setPl();
                        document.getElementById('facturacion').style.display = 'none';
                        document.getElementById('facturacion').style.position = 'absolute';
                        document.getElementById('moduloPrerevision').style.display = 'none';
                        document.getElementById('moduloPrerevision').style.position = 'absolute';
                        document.getElementById('pinQuemado').style.display = 'none';
                        document.getElementById('pinQuemado').style.position = 'absolute';
                        document.getElementById('pin').style.display = 'none';
                        document.getElementById('pin').style.position = 'absolute';
                    }


                }
            });
        };

        var setPrueba = function(prueba, valor) {
            switch (valor) {
                case '1':
                    habilitarComponente(prueba, true);
                    checkComponente(prueba, true);
                    break;
                case '2':
                    habilitarComponente(prueba, true);
                    checkComponente(prueba, false);
                    break;
                case '3':
                    habilitarComponente(prueba, false);
                    checkComponente(prueba, false);
                    break;
            }
        };

        var setMoto = function() {
            habilitarComponente('luxometro', false);
            checkComponente('luxometro', true);
            habilitarComponente('opacidad', false);
            checkComponente('opacidad', false);
            if (pedirSonometro === "1") {
                habilitarComponente('sonometro', false);
                checkComponente('sonometro', true);
            } else {
                habilitarComponente('sonometro', true);
                checkComponente('sonometro', false);
            }
            if (vehiculo.tipo_combustible !== 'Gasolina') {
                habilitarComponente('gases', true);
                checkComponente('gases', false);
                habilitarComponente('sonometro', true);
                checkComponente('sonometro', true);
            } else {
                habilitarComponente('gases', false);
                checkComponente('gases', true);
            }
            habilitarComponente('camara', false);
            checkComponente('camara', true);
            habilitarComponente('taximetro', false);
            checkComponente('taximetro', false);
            habilitarComponente('frenometro', false);
            checkComponente('frenometro', true);
            habilitarComponente('visual', false);
            checkComponente('visual', true);
            habilitarComponente('suspension', false);
            checkComponente('suspension', false);
          //  if (vehiculo.idclase == 30) {
           //     habilitarComponente('alineacion', false);
           //     checkComponente('alineacion', true);
           // } else {
                habilitarComponente('alineacion', false);
                checkComponente('alineacion', false);
           // }

        };



        var setLiviano = function() {

            habilitarComponente('luxometro', false);
            checkComponente('luxometro', true);
            if (pedirSonometro === "1") {
                habilitarComponente('sonometro', false);
                checkComponente('sonometro', true);
            } else {
                habilitarComponente('sonometro', true);
                checkComponente('sonometro', false);
            }
            if (vehiculo.tipo_combustible === 'Diesel') {
                habilitarComponente('opacidad', false);
                checkComponente('opacidad', true);
            } else {
                if (vehiculo.tipo_combustible !== 'Gasolina') {
                    habilitarComponente('gases', true);
                    checkComponente('gases', false);
                    habilitarComponente('sonometro', true);
                    checkComponente('sonometro', true);
                    if (vehiculo.idtipocombustible === '4' || vehiculo.idtipocombustible === '3') {
                        checkComponente('gases', true);
                        checkComponente('sonometro', true);
                    }
                } else {
                    habilitarComponente('gases', false);
                    checkComponente('gases', true);
                }
            }
            habilitarComponente('camara', false);
            checkComponente('camara', true);
            habilitarComponente('taximetro', false);
            if (vehiculo.taximetro === '1') {
                checkComponente('taximetro', true);
            } else {
                checkComponente('taximetro', false);
            }
            habilitarComponente('frenometro', false);
            checkComponente('frenometro', true);
            habilitarComponente('visual', false);
            checkComponente('visual', true);
            habilitarComponente('suspension', false);
            checkComponente('suspension', true);
            habilitarComponente('alineacion', false);
            checkComponente('alineacion', true);
        };

        var setPesado = function() {
            habilitarComponente('luxometro', false);
            checkComponente('luxometro', true);
            if (pedirSonometro === "1") {
                habilitarComponente('sonometro', false);
                checkComponente('sonometro', true);
            } else {
                habilitarComponente('sonometro', true);
                checkComponente('sonometro', false);
            }
            if (vehiculo.tipo_combustible === 'Diesel') {
                habilitarComponente('opacidad', false);
                checkComponente('opacidad', true);
            } else {
                if (vehiculo.tipo_combustible !== 'Gasolina') {
                    habilitarComponente('gases', true);
                    checkComponente('gases', false);
                    habilitarComponente('sonometro', true);
                    checkComponente('sonometro', true);
                    if (vehiculo.idtipocombustible === '4' || vehiculo.idtipocombustible === '3') {
                        checkComponente('gases', true);
                        checkComponente('sonometro', true);
                    }
                } else {
                    habilitarComponente('gases', false);
                    checkComponente('gases', true);
                }
            }

            habilitarComponente('camara', false);
            checkComponente('camara', true);
            habilitarComponente('taximetro', false);
            if (vehiculo.taximetro === '1') {
                checkComponente('taximetro', true);
            } else {
                checkComponente('taximetro', false);
            }
            habilitarComponente('frenometro', false);
            checkComponente('frenometro', true);
            habilitarComponente('visual', false);
            checkComponente('visual', true);
            habilitarComponente('suspension', false);
            checkComponente('suspension', false);
            habilitarComponente('alineacion', false);
            checkComponente('alineacion', true);
        };

        var setPl = function() {
            habilitarComponente('luxometro', true);
            checkComponente('luxometro', false);
            habilitarComponente('opacidad', true);
            checkComponente('opacidad', false);
            habilitarComponente('gases', true);
            checkComponente('gases', false);
            habilitarComponente('sonometro', true);
            checkComponente('sonometro', false);
            habilitarComponente('camara', true);
            checkComponente('camara', true);
            habilitarComponente('taximetro', true);
            checkComponente('taximetro', false);
            habilitarComponente('frenometro', true);
            checkComponente('frenometro', false);
            habilitarComponente('visual', true);
            checkComponente('visual', true);
            habilitarComponente('suspension', true);
            checkComponente('suspension', false);
            habilitarComponente('alineacion', true);
            checkComponente('alineacion', false);
        };

        var habilitarComponente = function(id, valor) {
            if (valor) {
                document.getElementById(id).disabled = false;
            } else {
                document.getElementById(id).disabled = true;
            }
        };

        var checkComponente = function(id, valor) {
            if (valor) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }



        };

        var unChekedAll = function() {
            checkComponente('luxometro', false);
            checkComponente('opacidad', false);
            checkComponente('gases', false);
            checkComponente('camara', true);
            checkComponente('sonometro', true);
            checkComponente('taximetro', false);
            checkComponente('frenometro', true);
            checkComponente('visual', true);
            checkComponente('suspension', false);
            checkComponente('alineacion', false);
        };

        var asignarPrueba = function() {
            // if (ifRemolque) {
            // 		alert("Remolques y semiremolques no pueden ser inspeccionados en este módulo.");
            // 		return;
            // }
            var asignar = true;
            var btnAsignar = document.getElementById("btnAsignar");
            btnAsignar.disabled = true;
            switch (tipoTipoInspeccion) {
                case 'RTMec':
                    if (facturacion === '1' && reinspeccion === '0') {
                        if ($("#noFactura").val() === '') {
                            setMensaje('INGRESE EL NÚMERO DE FACTURA', 'salmon');
                            asignar = false;
                            btnAsignar.disabled = false;
                        }
                        if (!$.isNumeric($("#costo").val())) {
                            setMensaje('INGRESE UN VALOR DE COSTO VÁLIDO', 'salmon');
                            asignar = false;
                            btnAsignar.disabled = false;
                        }
                        if ($("#costo").val() === '' || $("#costo").val() === '0') {
                            setMensaje('INGRESE EL COSTO DE LA INSPECCION', 'salmon');
                            asignar = false;
                            btnAsignar.disabled = false;
                        }
                        //                        validarFactura();
                        //                        if (existeFactura === "1") {
                        //                            setMensaje('EXISTE UNA FACTURA ASOCIADA A ESTE NÚMERO, INTENTE CON EL SIGUIENTE.', 'salmon');
                        //                            asignar = false;
                        //                            btnAsignar.disabled = false;
                        //                        }
                        //
                        //                        if (parseInt($('#noFactura').val()) - (parseInt(facturaActual)) > 5) {
                        //                            setMensaje('EL NÚMERO DE FACTURA SUPERA EL RANGO PERMITIDO, ACTUAL: ' + (parseInt(facturaActual) + 1), 'salmon');
                        //                            asignar = false;
                        //                            btnAsignar.disabled = false;
                        //                        }

                    }

                    if (moduloPrerevision === '1') {
                        validarPrerevision();
                        if (existePrerevision === '0' && !document.getElementById('chkModuloPre').checked) {
                            setMensaje(
                                'EL VEHÍCULO NO TIENE PREREVISIÓN DIGITAL ASIGNADA, PARA CONTINUAR, HABILITE "PREREVISIÓN FÍSICA"',
                                'salmon');
                            asignar = false;
                            btnAsignar.disabled = false;
                        }
                    }

                    if (activoSicov === '1' && sicov === 'CI2' && $("#pin_").val() === '') {
                        setMensaje('INGRESE EL PIN', 'salmon');
                        asignar = false;
                    }
                    //                    var btnAsignar = document.getElementById("btnAsignar");
                    //                    btnAsignar.disabled = true;
                    var segundos = 1;
                    if (asignar) {

                        //EVALUAR SEGURIDAD TH


                        if (activoSicov === '1' && sicov === 'CI2') {
                            var proceso = setInterval(function() {
                                setMensaje('Por favor espere...', 'black');
                                if (segundos === 0) {
                                    clearInterval(proceso);
                                    var e = document.getElementById('chkpinQuemado');
                                    if (!e.checked) {
                                         quemarPin();
                                    } else {
                                        consultarPinQuemado();
                                    }
                                }
                                segundos--;
                            }, 500);
                        } else if (activoSicov === '1' && sicov === 'INDRA') {
                            var proceso = setInterval(function() {
                                setMensaje('Por favor espere...', 'black');
                                if (segundos === 0) {
                                    clearInterval(proceso);
                                    if (verificarPin === "1")
                                        verificarPinIndra();
                                    else
                                        insertarPruebas();
                                }
                                segundos--;
                            }, 500);
                        } else {
                            var proceso = setInterval(function() {
                                setMensaje('Por favor espere...', 'black');
                                if (segundos === 0) {
                                    clearInterval(proceso);
                                    insertarPruebas();
                                    //                                    btnAsignar.disabled = false;
                                }
                                segundos--;
                            }, 500);
                        }
                    }
                    break;
                case 'Preventiva':
                    if (facturacion === '1' && (reinspeccion === '4444')) {
                        if ($("#noFactura").val() === '') {
                            setMensaje('INGRESE EL NÚMERO DE FACTURA', 'salmon');
                            asignar = false;
                        }
                        if (!$.isNumeric($("#costo").val())) {
                            setMensaje('INGRESE UN VALOR DE COSTO VÁLIDO', 'salmon');
                            asignar = false;
                            btnAsignar.disabled = false;
                        }
                        if ($("#costo").val() === '' || $("#costo").val() === '0') {
                            setMensaje('INGRESE EL COSTO DE LA INSPECCION', 'salmon');
                            asignar = false;
                            btnAsignar.disabled = false;
                        }
                        //                        validarFactura();
                        //                        if (existeFactura === "1") {
                        //                            setMensaje('EXISTE UNA FACTURA ASOCIADA A ESTE NÚMERO, INTENTE CON EL SIGUIENTE.', 'salmon');
                        //                            asignar = false;
                        //                        }
                        //                        if (parseInt($('#noFactura').val()) - (parseInt(facturaActual)) > 5) {
                        //                            setMensaje('EL NÚMERO DE FACTURA SUPERA EL RANGO PERMITIDO, ACTUAL: ' + (parseInt(facturaActual) + 1), 'salmon');
                        //                            asignar = false;
                        //                        }
                    }

                    if (asignar) {
                        insertarPruebas();
                    }
                    break;
                case 'Prueba libre':
                    // var text = new XMLHttpRequest();
                    // text.open("GET", ipLocal + "system/dominio.dat", false);
                    // text.send(null);
                    // var dominio = text.responseText;
                    // if (dominio === "cdalamesa.tecmmas.com" ||
                    //     dominio === "cdalaestacion.tecmmas.com" ||
                    //     dominio === "cdacarreraexpress.tecmmas.com"
                    // ) {
                    //     $('#RTmecModal').hide();
                    //     $('#Modal-token').show();
                    // } else
                    insertarPruebas();
                    break;
                default:

                    break;
            }
        };
        var tokenval = "";


        function Validar() {
            var token = $("#token").val();
            $("#valid-token").html('');
            $.ajax({
                url: 'https://atalayasoft.tecmmas.com/atalaya/index.php/Ctriguer/validToken',
                type: 'post',
                mimeType: 'json',
                data: {
                    token: token
                },
                success: function(data, textStatus, jqXHR) {
                    if (data === 1) {
                        tokenval = token;
                        $('#Modal-token').hide();
                        insertarPruebas();
                    } else {
                        $("#valid-token").html('El token no es correcto');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + jqXHR);
                }
            });
        }
        var setMensaje = function(msj, color) {
            document.getElementById("mensaje").style.color = color;
            $("#mensaje").text(msj);
        };
        var existePrerevision = '0';

        var validarPrerevision = function() {
            var numero_placa = vehiculo.numero_placa;
            var data = {
                numero_placa: numero_placa
            };
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/validarPrerevision',
                data: data,
                type: 'post',
                async: false,
                success: function(rta) {
                    existePrerevision = rta;
                }
            });
        };

        var existeFactura = '0';
        var validarFactura = function() {
            var noFactura = $('#noFactura').val();
            if (noFactura !== '0') {
                var data = {
                    noFactura: noFactura
                };

                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/validarFactura',
                    data: data,
                    type: 'post',
                    async: false,
                    success: function(rta) {
                        existeFactura = rta;
                    }
                });
            }
        };

        var quemarPin = function () {
            var pin = $('#pin_').val();
            var tipo_rtm = '1';
            if (reinspeccion === '1') {
                tipo_rtm = '2';
            }
			const url = '<?php echo base_url(); ?>index.php/oficina/ci2/Cci2/utilizar_pin';
            var data = {
				tipoRtm: tipo_rtm,
                pPin: pin,
                pPlaca: vehiculo.numero_placa.toUpperCase(),
            };
            $.ajax({
                url: url,
                data: JSON.stringify(data),
                type: 'post',
                contentType: 'application/json; charset=UTF-8',
                dataType: 'json',
                processData: false,
                async: false,
                success: function (rta) {
					if(rta.codigo==="0000"){
						setMensaje(rta.mensaje, 'green');
						insertarPruebas();
					}else{
						setMensaje(rta.mensaje, 'red');
					}
                }
            });
        };

		function consultarPinQuemado() {
			const url = '<?php echo base_url(); ?>index.php/oficina/ci2/Cci2/consulta_pin';
            var data = {
                pPin: $('#pin_').val(),
                pPlaca: vehiculo.numero_placa.toUpperCase(),
            };
            $.ajax({
                url: url,
                data: JSON.stringify(data),
                type: 'post',
                contentType: 'application/json; charset=UTF-8',
                dataType: 'json',
                processData: false,
                async: false,
                success: function (rta) {
					if(rta.success && rta.codigo==="2007"){
						insertarPruebas();
						// quemadoSICOV();
					}else{
						setMensaje(rta.mensaje, 'red');
					}
                }
            });
		}

		


        var verificarPinIndra = function () {
            setMensaje('POR FAVOR ESPERE....', 'black');
            //            var pin = $('#pin_').val();
            //            var tipo_rtm = '1';
            //            if (reinspeccion === '1') {
            //                tipo_rtm = '2';
            //            }

            var data = {
                placa: vehiculo.numero_placa,
                codigoRUNT: idCdaRUNT,
                sicovModoAlternativo: localStorage.getItem("sicovModoAlternativo"),
                ipSicovAlternativo: localStorage.getItem("ipSicovAlternativo"),
                // sicovModoAlternativo: sicovModoAlternativo,
                // ipSicovAlternativo: ipSicovAlternativo,
                ipSicov: ipSicov
            };
            console.log(data);
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/verificarPIN',
                data: data,
                type: 'post',
                async: false,
                success: function(rta) {
                    if (rta !== "") {
                        var pin = JSON.parse(rta);
                        if (parseInt(pin.codRespuesta) === 1) {
                            insertarPruebas();
                        } else {
                            setMensaje("MENSAJE DE SICOV INDRA PIN: " + pin.msjRespuesta, 'salmon');
                        }
                    } else {
                        setMensaje("NO HAY CONEXIÓN CON SICOV PARA VERIFICACIÓN DE PIN", 'salmon');
                    }

                    // insertarPruebas();
                }
            });
        };

        var quemadoSICOV = function() {
            var data = {
                idhojapruebas: idhojapruebas,
                placa: vehiculo.numero_placa,
                reinspeccion: reinspeccion
            };
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/quemadoSICOV',
                data: data,
                type: 'post',
                async: false
            });
        };

        var insertarPruebas = function() {
            var pruebas = new Object();
            pruebas.luxometro = document.getElementById('luxometro').checked;
            pruebas.opacidad = document.getElementById('opacidad').checked;
            pruebas.gases = document.getElementById('gases').checked;
            pruebas.sonometro = document.getElementById('sonometro').checked;
            pruebas.camara = document.getElementById('camara').checked;
            pruebas.taximetro = document.getElementById('taximetro').checked;
            pruebas.frenometro = document.getElementById('frenometro').checked;
            pruebas.visual = document.getElementById('visual').checked;
            pruebas.suspension = document.getElementById('suspension').checked;
            pruebas.alineacion = document.getElementById('alineacion').checked;
            //            if ((reinspeccion === '0' || reinspeccion === '1' || reinspeccion === '8888') && pruebas.visual) {
            if (pruebas.visual) {
                if (pruebas.gases || pruebas.opacidad) {
                    pruebas.termohigrometro = true;
                    if (moduloCaptador === '1')
                        pruebas.captador = true;
                    else
                        pruebas.captador = false;
                } else {
                    pruebas.captador = false;
                    pruebas.termohigrometro = false;
                    //                    checkComponente('sonometro', true);
                    //                    pruebas.sonometro = true;
                    //                    alert('Entra');
                    //                    pruebas.sonometro = false;
                    //                    document.getElementById('sonometro').checked = true;
                }
                pruebas.profundimetro = true;
                if (vehiculo.tipo_combustible === 'Diesel') {
                    pruebas.piederey = true;
                } else {
                    pruebas.piederey = false;
                }
                if (vehiculo.tipo_vehiculo === 'Moto' && vehiculo.clase === 'MOTOCICLETA') {
                    pruebas.elevador = true;
                    pruebas.detectorholguras = false;
                } else {
                    pruebas.elevador = false;
                    pruebas.detectorholguras = true;
                }
            } else {
                pruebas.piederey = false;
                pruebas.profundimetro = false;
                pruebas.termohigrometro = false;
                pruebas.detectorholguras = false;
                pruebas.elevador = false;
                pruebas.captador = false;
            }

            //            pruebas.piederey = false;
            //            pruebas.profundimetro = false;
            //            pruebas.termohigrometro = false;
            //            pruebas.detectorholguras = false;
            //            pruebas.elevador = false;
            //            pruebas.captador = false;

            pruebas.idvehiculo = vehiculo.idvehiculo;
            pruebas.reinspeccion = reinspeccion;
            if (reinspeccion === '0' || reinspeccion === '4444') {
                pruebas.factura = $('#noFactura').val();
                pruebas.pin1 = $('#costo').val();
            } else {
                pruebas.factura = '';
                pruebas.pin1 = '';
            }
            pruebas.pin0 = $('#pin_').val();
            pruebas.idhojapruebas = idhojapruebas;

            var data = {
                pruebas: pruebas,
                aplicares2703: document.getElementById('chkAplicaRes2703').checked,
                autoregulado: document.getElementById('chkAutoregulado').checked,
                numero_placa: vehiculo.numero_placa
            };

            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/insertarPruebas',
                data: data,
                type: 'post',
                mimeType: 'json',
                async: false,
                success: function(rta) {
                    console.log(rta)
                    if (rta.cadena !== "") {
                        envioBasicCAr(rta.cadena, rta.idhojapruebas);
                    }
                    var idHPr = rta.idhojapruebas;
                    if (idHPr === "FALSE") {
                        //                        location.reload();
                    } else {
                        $.ajax({
                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getDominio',
                            type: 'post',
                            success: function(dominio) {
                                var tipo_inspeccion = "1";
                                if (tipoTipoInspeccion === 'Preventiva') {
                                    tipo_inspeccion = '2';
                                } else if (tipoTipoInspeccion === 'Prueba libre') {
                                    tipo_inspeccion = '3';
                                }
                                var reins = reinspeccion;
                                if (reinspeccion === '4444' || reinspeccion === '8888') {
                                    reins = '0';
                                } else if (vehiculo.reinspeccion === '44441') {
                                    reins = '1';
                                }

                                var data = {
                                    placa: vehiculo.numero_placa + "-" + reins,
                                    tipo_vehiculo: vehiculo.idtipo_vehiculo,
                                    clase: vehiculo.idclase,
                                    servicio: vehiculo.idservicio,
                                    taximetro: vehiculo.taximetro,
                                    tipo_inspeccion: tipo_inspeccion,
                                    valor: $('#costo').val()

                                };
                                console.log(data)

                                if (parseInt(localStorage.getItem("contador")) < parseInt(
                                        localStorage.getItem("actualizado")) && data
                                    .tipo_inspeccion == "2") {
                                    console.log("entra por if");

                                    //if (dominio == "cdatecmmas.tecmmas.com" && localStorage.getItem("contador") < 80 && data.tipo_inspeccion == "2") {
                                    console.log("entras");
                                    localStorage.setItem("contador", parseInt(localStorage
                                        .getItem("contador")) + 1)
                                    $.ajax({
                                        url: "http://" + dominio +
                                            "/cda/index.php/Cservicio/insertMercadeo",
                                        data: data,
                                        type: 'post',
                                        async: false,
                                        success: function(rta) {}
                                    });
                                } else {
                                    console.log(data.tipo_inspeccion);
                                    if (data.tipo_inspeccion !== "2") {
                                        console.log("entra por else");
                                        $.ajax({
                                            url: "http://" + dominio +
                                                "/cda/index.php/Cservicio/insertMercadeo",
                                            data: data,
                                            type: 'post',
                                            async: false,
                                            success: function(rta) {}
                                        });
                                    }

                                }

                                //                                console.log(salaEspera);
                                if (salaEspera === "1") {
                                    var vehiculo_ = new Object();
                                    vehiculo_.idhojapruebas = idHPr;
                                    vehiculo_.placa = vehiculo.numero_placa;
                                    vehiculo_.marca = vehiculo.marca;
                                    vehiculo_.linea = vehiculo.linea;
                                    vehiculo_.modelo = vehiculo.ano_modelo;
                                    vehiculo_.clase = vehiculo.clase;
                                    vehiculo_.color = vehiculo.color;
                                    vehiculo_.servicio = vehiculo.idservicio;
                                    vehiculo_.reinspeccion = reinspeccion;

                                    if (pruebas.luxometro)
                                        vehiculo_.luces = "1";
                                    else
                                        vehiculo_.luces = "0";
                                    if (pruebas.opacidad)
                                        vehiculo_.opacidad = "1";
                                    else
                                        vehiculo_.opacidad = "0";
                                    if (pruebas.gases)
                                        vehiculo_.gases = "1";
                                    else
                                        vehiculo_.gases = "0";
                                    if (pruebas.sonometro)
                                        vehiculo_.sonometro = "1";
                                    else
                                        vehiculo_.sonometro = "0";
                                    if (pruebas.camara)
                                        vehiculo_.camara = "1";
                                    else
                                        vehiculo_.camara = "0";
                                    if (pruebas.taximetro)
                                        vehiculo_.taximetro = "1";
                                    else
                                        vehiculo_.taximetro = "0";
                                    if (pruebas.frenometro)
                                        vehiculo_.frenos = "1";
                                    else
                                        vehiculo_.frenos = "0";
                                    if (pruebas.visual)
                                        vehiculo_.visual = "1";
                                    else
                                        vehiculo_.visual = "0";
                                    if (pruebas.suspension)
                                        vehiculo_.suspension = "1";
                                    else
                                        vehiculo_.suspension = "0";
                                    if (pruebas.alineacion)
                                        vehiculo_.alineacion = "1";
                                    else
                                        vehiculo_.alineacion = "0";
                                    vehiculo_.certificado = "0";
                                    vehiculo_.llamar = "0";
                                    var data_ = {
                                        vehiculo: vehiculo_
                                    };
                                    //                                    $.ajax({
                                    //                                        url: "<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas/insertVisor",
                                    //                                        data: data_,
                                    //                                        type: 'post',
                                    //                                        mimeType: 'json',
                                    //                                        async: false,
                                    //                                        success: function (data, textStatus, jqXHR) {
                                    //
                                    //                                        }, error: function (jqXHR, textStatus, errorThrown) {
                                    //                                            $('#div_error').html('Error:' + jqXHR.responseText + " - " + textStatus);
                                    //                                        }
                                    ////                                        ,
                                    ////                                        success: function (rta) {
                                    ////                                        }
                                    //                                    });
                                    $.ajax({
                                        url: "http://" + dominio +
                                            "/cda/index.php/Csala/insertar",
                                        data: data_,
                                        type: 'post',
                                        async: false
                                        //                                        ,
                                        //                                        success: function (rta) {
                                        //                                        }
                                    });

                                }
                            }
                        });
                        var segundos = 2;
                        var proceso = setInterval(function() {
                            setMensaje('ASIGNADO EXITOSAMENTE.', 'green');
                            if (segundos === 0) {
                                clearInterval(proceso);
                                location.reload();
                            }
                            segundos--;
                        }, 1000);
                    }
                },
                error(rta) {
                    console.log(rta.responseText);
                }
            });
        };


        function envioBasicCAr(basic, idprueba) {
            $.ajax({
                type: "POST",
                url: "http://" + ipCAR + "/cdapp/rest/basico/registro",
                headers: {
                    "Authorization": "b56c19aa217e36a6c182be3ce6fab1851c32a6860f74a312f2cf6d230f6c1573",
                    "Content-Type": "application/json"
                },
                timeout: 3000,

                data: basic,
                success: function(rta) {
                    console.log(rta)
                    if (rta.resp == "OK") {
                        var estado = 1;
                        var tipo = 'Envio basic exitoso.';
                        guardarTabla(estado, tipo, idprueba);
                    } else {
                        var estado = 0;
                        var tipo = 'Envio basic fallido.';
                        guardarTabla(estado, tipo, idprueba);
                    }
                },
                errors: function(rta) {
                    console.log(rta);
                }
            });
        }

        function guardarTabla(estado, tipo, idprueba) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/oficina/fur/CFUR/saveControl",
                data: {
                    estado: estado,
                    tipo: tipo,
                    idprueba: idprueba
                },
                success: function(rta) {
                    console.log(rta);
                },
                errors: function(rta) {
                    console.log(rta);
                }
            });
        }
    </script>
    <script src="<?php echo base_url(); ?>/application/libraries/package/dist/sweetalert2.all.min.js"></script>
</body>
<!--</form>-->

</html>
