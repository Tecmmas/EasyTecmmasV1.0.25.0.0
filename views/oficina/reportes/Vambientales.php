<?php $this->load->view('./header'); ?>
<?php $informeNewAnt; ?>
<!-- START CONTENT -->
<script type="text/javascript">
    window.onload = function() {

        <?php if ($this->session->userdata('mesajeError')) { ?>;
            var mensaje = "<?php echo $this->session->userdata('mesajeError'); ?>";
            Swal.fire({
                icon: "error",
                title: 'Error',
                text: mensaje,
                showConfirmButton: true,
            });
        <?php
            $this->session->unset_userdata('mesajeError');
        }
        ?>;
    };
</script>
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row">
        <!--        <div class='col-12'>
                    <div class="page-title">
                    </div>
                </div>
                <div class="clearfix">
        
                </div>-->
        <!-- MAIN CONTENT AREA STARTS -->
        <div class="col-xl-12">
            <section class="box ">
                <?php $this->load->view('./nav'); ?>
                <div class="content-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <section class="box ">

                                <header class="panel_header">
                                    <h2 class="title float-left">Informe ambiental <?= $tipoinforme ?></h2>
                                    <div class="title float-right" style="margin-right: 30px">
                                        <?php if ($FugasCal == "NA") { ?>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        Tipo informe
                                                    </tr>
                                                    <tr>
                                                        <select id="sel-tipo-informe-fugas-cal">
                                                            <option value="0">Gases Anterior</option>
                                                            <option value="1">Gases Nuevo</option>
                                                        </select>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </header>

                                <div class="content-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <?php if ($tipoinforme == 'Dagma') { ?>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Pista</th>
                                                            <th>Equipo</th>
                                                            <th>Generar informe</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $c = 0;
                                                        foreach ($maquina as $item) :
                                                        ?>

                                                            <?php if (($item->prueba == 'analizador' || $item->prueba == 'opacidad') && $item->activo == 1) { ?>
                                                                <tr>
                                                                    <td><?= $item->idconf_maquina ?></td>
                                                                    <td><?php
                                                                        if ($item->idconf_linea_inspeccion == 1 || $item->idconf_linea_inspeccion == 7 || $item->idconf_linea_inspeccion == 8) {
                                                                            echo 'Liviano';
                                                                        } elseif ($item->idconf_linea_inspeccion == 4 || $item->idconf_linea_inspeccion == 11 || $item->idconf_linea_inspeccion == 12) {
                                                                            echo 'Mixta';
                                                                        } else {
                                                                            echo 'Moto';
                                                                        }
                                                                        ?></td>
                                                                    <td><?= $item->nombre . '-' . $item->marca . '<br>' . $item->serie_maquina . '-' . $item->serie_banco ?></td>

                                                                    <td>
                                                                        <form action="<?php echo base_url(); ?>index.php/oficina/reportes/Cambientales/informe_dagma" method="post">
                                                                            <div class="row">
                                                                                <div class="col-md-3 col-lg-3 col-sm-3">
                                                                                    <div class="form-group">
                                                                                        <label style="font-weight: bold; color: grey" for="nombres">Fecha inicial</label>
                                                                                        <input type="text" class="form-control datepicker" id="fechainicial" name="fechainicial" data-format="yyyy-mm-dd " autocomplete="off">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 col-lg-3 col-sm-3">
                                                                                    <div class="form-group">
                                                                                        <label style="font-weight: bold; color: grey" for="nombres">Fecha final</label>
                                                                                        <input type="text" class="form-control datepicker" id="fechainicial" name="fechafinal" data-format="yyyy-mm-dd " autocomplete="off">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 col-lg-3 col-sm-3" style="align-content:  center">
                                                                                    <div class="form-group">
                                                                                        <input name="check-cvc" type="checkbox" class="form-check-input" id="exampleCheck1" value="1" style="margin-top: 40px">
                                                                                        <label class="form-check-label" for="exampleCheck1" style="margin-top: 35px">Informe para la CVC</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 col-lg-3 col-sm-3" style="align-content:  center">
                                                                                    <div class="form-group">
                                                                                        <label></label>
                                                                                        <input type="hidden" id="idconf_maquina" name="idconf_maquina" value="<?= $item->idconf_maquina ?>">
                                                                                        <input type="submit" id="btn-informe-dagma" name="consultar" id="btn-generar-carder" class="btn btn-accent btn-block" onclick="showSuccess('Generando el informe, por favor espere.')" style="background-color: #393185;border-radius: 40px 40px 40px 40px" value="Generar">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                    <?php $c++; ?>
                                                                <?php }; ?>
                                                            <?php endforeach; ?>
                                                                </tr>
                                                    </tbody>
                                                </table>
                                            <?php } elseif ($tipoinforme == 'Superintendencia') { ?>
                                                <form action="<?php echo base_url(); ?>index.php/oficina/reportes/Cambientales/informes" method="post">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Generar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="form-group mx-sm-5" style="margin-top: 10px">
                                                                            <label style="font-weight: bold; color: grey" for="nombres">Fecha inicial<br />
                                                                                <input type="text" class="form-control datepicker" id="fechainicial" name="fechainicial" data-format="yyyy-mm-dd " autocomplete="off">
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-group mx-sm-5" style="margin-top: 10px">
                                                                            <label style="font-weight: bold; color: grey" for="nombres">Fecha final<br />
                                                                                <input type="text" class="form-control datepicker" id="fechafinal" name="fechafinal" data-format="yyyy-mm-dd " autocomplete="off">
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-group mx-sm-5" style="margin-top: 10px">
                                                                            <?php if ($tipoinforme == 'Corantioquia') : ?>
                                                                                <div class="form-group col-md-2" style="margin-top: 22px;">
                                                                                    <select id="tipo_inspeccion" name="tipo_inspeccion" style="height: 35px">
                                                                                        <option value="1">Certificadas</option>
                                                                                        <option value="8888">Pruebas libres</option>
                                                                                        <option value="4444">Preventivas</option>
                                                                                    </select>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="form-group mx-sm-4">
                                                                            <label style="font-weight: bold; color: black"></label>
                                                                            <input type="hidden" id="tipoinforme" name="tipoinforme" value="<?= $tipoinforme ?>">
                                                                            <div type="hidden" id="div-informeNewAnt2" name="div-informeNewAnt"></div>
                                                                            <input type="submit" name="consultar" id="btn-generar-ambiental" class="btn btn-accent btn-block" onclick="showSuccess('Generando el informe, por favor espere.')" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px" value="Generar">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            <?php } elseif ($tipoinforme == 'Corantioquia' || $tipoinforme == 'Corpocesar' || $tipoinforme == 'Corpouraba' || $tipoinforme == 'Epa') { ?>
                                                <form action="<?php echo base_url(); ?>index.php/oficina/reportes/Cambientales/generar" method="post">
                                                    <div class="row">
                                                        <div class="form-group col-md-3">
                                                            <label style="font-weight: bold; color: grey" for="nombres">Fecha inicial<br />
                                                                <input type="text" class="form-control datepicker" id="fechainicial" name="fechainicial" data-format="yyyy-mm-dd " autocomplete="off">
                                                                <!--<strong style="color: #E31F24"><?php echo form_error('fechainicial'); ?></strong>-->
                                                            </label>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label style="font-weight: bold; color: grey" for="nombres">Fecha final<br />
                                                                <input type="text" class="form-control datepicker" id="fechafinal" name="fechafinal" data-format="yyyy-mm-dd " autocomplete="off">
                                                                <!--<strong style="color: #E31F24"><?php echo form_error('fechafinal'); ?></strong>-->
                                                            </label>
                                                        </div>

                                                        <?php if ($tipoinforme == 'Corantioquia' || $tipoinforme == 'Corpocesar' || $tipoinforme == 'Corpouraba') : ?>
                                                            <div class="form-group col-md-2" style="margin-top: 22px;">
                                                                <select id="tipo_inspeccion" name="tipo_inspeccion" style="height: 35px">
                                                                    <option value="1">Certificadas</option>
                                                                    <option value="8888">Pruebas libres</option>
                                                                    <option value="4444">Preventivas</option>
                                                                </select>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="form-group col-md-2">
                                                            <label style="font-weight: bold; color: black"></label>
                                                            <input type="hidden" id="tipoinforme" name="tipoinforme" value="<?= $tipoinforme ?>">
                                                            <div type="hidden" id="div-informeNewAntCorantioquia" name="div-informeNewAnt"></div>
                                                            <button type="submit" style="margin-top: 18px;" class="btn btn-info" id="btnGeneral" onclick="showSuccess('Generando el informe, por favor espere.')">Generar</button>

                                                        </div>
                                                    </div>
                                                </form>
                                            <?php } else { ?>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Pista</th>
                                                            <th>Equipo</th>
                                                            <th>Generar informe</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $c = 0;
                                                        foreach ($maquina as $item) :
                                                        ?>

                                                            <?php if (($item->prueba == 'analizador' || $item->prueba == 'opacidad') && $item->activo == 1) { ?>
                                                                <tr>
                                                                    <td><?= $item->idconf_maquina ?></td>
                                                                    <td><?php
                                                                        if ($item->idconf_linea_inspeccion == 1 || $item->idconf_linea_inspeccion == 7 || $item->idconf_linea_inspeccion == 8) {
                                                                            echo 'Liviano';
                                                                        } elseif ($item->idconf_linea_inspeccion == 4 || $item->idconf_linea_inspeccion == 11 || $item->idconf_linea_inspeccion == 12) {
                                                                            echo 'Mixta';
                                                                        } else {
                                                                            echo 'Moto';
                                                                        }
                                                                        ?></td>
                                                                    <td><?= $item->nombre . '-' . $item->marca . '<br>' . $item->serie_maquina . '-' . $item->serie_banco ?></td>

                                                                    <td>
                                                                        <form action="<?php echo base_url(); ?>index.php/oficina/reportes/Cambientales/generar" method="post">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-3">
                                                                                    <label style="font-weight: bold; color: grey" for="nombres">Fecha inicial<br />
                                                                                        <input type="text" class="form-control datepicker" id="fechainicial" name="fechainicial" data-format="yyyy-mm-dd " autocomplete="off">
                                                                                        <!--<strong style="color: #E31F24"><?php echo form_error('fechainicial'); ?></strong>-->
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <label style="font-weight: bold; color: grey" for="nombres">Fecha final<br />
                                                                                        <input type="text" class="form-control datepicker" id="fechafinal" name="fechafinal" data-format="yyyy-mm-dd " autocomplete="off">
                                                                                        <!--<strong style="color: #E31F24"><?php echo form_error('fechafinal'); ?></strong>-->
                                                                                    </label>
                                                                                </div>

                                                                                <!-- <?php if ($tipoinforme == 'Corantioquia' || $tipoinforme == 'Corpouraba') : ?>
                                                                                    <div class="form-group col-md-2" style="margin-top: 22px;">
                                                                                        <select id="tipo_inspeccion" name="tipo_inspeccion" style="height: 35px">
                                                                                            <option value="1">Certificadas</option>
                                                                                            <option value="8888">Pruebas libres</option>
                                                                                            <option value="4444">Preventivas</option>
                                                                                        </select>
                                                                                    </div>
                                                                                <?php endif; ?> -->
                                                                                <div class="form-group col-md-2">
                                                                                    <label style="font-weight: bold; color: black"></label>
                                                                                    <input type="hidden" id="idconf_maquina" name="idconf_maquina" value="<?= $item->idconf_maquina ?>">
                                                                                    <input type="hidden" id="prueba" name="prueba" value="<?= $item->prueba ?>">
                                                                                    <input type="hidden" id="idconf_linea_inspeccion" name="idconf_linea_inspeccion" value="<?= $item->idconf_linea_inspeccion ?>">
                                                                                    <input type="hidden" id="tipoinforme" name="tipoinforme" value="<?= $tipoinforme ?>">
                                                                                    <input type="hidden" id="serieanalizador" name="serieanalizador" value="<?= $item->serie_maquina ?>">
                                                                                    <div type="hidden" id="div-informeNewAnt<?php echo $c ?>" name="div-informeNewAnt"></div>
                                                                                    <button type="submit" class="btn btn-info" onclick="variableNA(this)" id="btnGeneral<?= $c ?>" onclick="showSuccess('Generando el informe, por favor espere.')">Generar</button>

                                                                                </div>
                                                                                <?php if ($tipoinforme == 'Bogota' || $tipoinforme == 'Car') : ?>
                                                                                    <div class="form-group col-md-2">
                                                                                        <div id="div-btn-csv<?= $c ?>"></div>
                                                                                        <input type="hidden" name="csvdowload" id="csvdowload<?= $c ?>" value="0">
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </form>
                                                                        <?php $c++; ?>
                                                                    <?php }; ?>
                                                                <?php endforeach; ?>
                                                                </tr>
                                                    </tbody>
                                                </table>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <?php if ($informeWebBogota == '1'): ?>
                                <section class="box ">
                                    <header class="panel_header">
                                        <h2 class="title float-left">Envio de pruebas pendientes api <?= $tipoinforme ?></h2>
                                    </header>

                                    <div class="content-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table" id="tablePendientesBogota">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Placa</th>
                                                            <th>Fecha</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </section>

        </div>



        <!-- MAIN CONTENT AREA ENDS -->
    </section>
</section>
<!-- END CONTENT -->



<?php $this->load->view('./footer'); ?>
<script type="text/javascript">
    var FugasCal = "<?php
                    echo $FugasCal;
                    ?>";
    var c = "<?php
                echo $c;
                ?>";
    var tipoInformeNew = "<?php
                            echo $tipoinforme;
                            ?>";
    var informeWebBogota = "<?php
                            echo $informeWebBogota;
                            ?>";
    var ipLocal = '<?php
                    echo base_url();
                    ?>';

    var dominio = "";
    $(document).ready(function() {
        if (FugasCal == "NA") {
            var tipoInforme = $('#sel-tipo-informe-fugas-cal option:selected').attr('value');
            $("#div-informeNewAntCorantioquia").html("");
            $("#div-informeNewAntCorantioquia").append('<input type="hidden" id="informeNewAnt" name="informeNewAnt" value="' + tipoInforme + '">');
            for (var i = 0; i < c; i++) {
                $("#div-informeNewAnt" + i + "").append('<input type="hidden" id="informeNewAnt" name="informeNewAnt" value="' + tipoInforme + '">');
            }
        }
        if (tipoInformeNew == 'Bogota' || tipoInformeNew == 'Car') {
            for (var i = 0; i < c; i++) {
                $("#div-btn-csv" + i + "").append('<button type="submit" class="btn btn-success" onclick="Variable(this)" id="btnCsv' + i + '"  style="margin-top: 23px">Generar Csv</button>');
            }
        }

        var text = new XMLHttpRequest();
        text.open("GET", ipLocal + "system/dominio.dat", false);
        text.send(null);
        dominio = text.responseText;
        if (parseInt(informeWebBogota) == 1) {
            getTokenBogota();
            getPendientes();
        }
        //saveSerCornare();

    });

    var getTokenBogota = function() {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/Cindex/getTokenBogota',
                type: 'post',
                mimeType: 'json',
                success: function(data) {
                    // if (localStorage.getItem("tokenBogota") === null || localStorage.getItem("tokenBogota") === undefined) {
                        localStorage.setItem("tokenBogota", data['access_token']);
                    // }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText)
                }
            });
        }

    // var getPendientes = function() {
    //     $.ajax({
    //         type: 'GET',
    //         url: "<?php echo base_url(); ?>index.php/oficina/reportes/Cambientales/getPendientes",
    //         mimeType: 'json',
    //         async: true,
    //         success: function(data, textStatus, jqXHR) {
    //             $("#tablePendientesBogota tbody").html('');
    //             data.forEach(element => {
    //                 $("#tablePendientesBogota").append('<tr><td>' + element.idprueba + '</td><td>' + element.placadata + '</td><td>' + element.fecha + '</td><td><button class="btn btn-danger me-2" onclick="mostrarError(this)"  dataMensaje="' + element.mensaje + '">Ver Error</button><button class="btn btn-primary" onclick="reenviarInforme(\'' + element.idcontrolenvioapi + '\',\'' + element.tipo_vehiculo + '\',\'' + element.idprueba + '\',\'' + element.idmaquina + '\',\'' + element.idtipocombustible + '\')">Reenviar</button></td></tr>');
    //             });

    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             console.log(jqXHR.responseText)

    //         }
    //     });
    // }

    var getPendientes = function() {
    $.ajax({
        type: 'GET',
        url: "<?php echo base_url(); ?>index.php/oficina/reportes/Cambientales/getPendientes",
        mimeType: 'json',
        async: true,
        success: function(data, textStatus, jqXHR) {
            // Limpiar el tbody correctamente
            var tbody = $("#tablePendientesBogota tbody");
            tbody.empty();
            
            // Construir todo el HTML primero
            var html = '';
            data.forEach(element => {
                // Escapar las comillas en el mensaje para evitar problemas
                var mensajeEscapado = element.mensaje.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                
                html += '<tr>' +
                    '<td>' + element.idprueba + '</td>' +
                    '<td>' + element.placadata + '</td>' +
                    '<td>' + element.fecha + '</td>' +
                    '<td>' +
                    '<button class="btn btn-danger me-2" onclick="mostrarError(this)" data-mensaje="' + mensajeEscapado + '">Ver Error</button>' +
                    '<button class="btn btn-primary" onclick="reenviarInforme(\'' + element.idcontrolenvioapi + '\',\'' + element.tipo_vehiculo + '\',\'' + element.idprueba + '\',\'' + element.idmaquina + '\',\'' + element.idtipocombustible + '\')">Reenviar</button>' +
                    '</td>' +
                    '</tr>';
            });
            
            // Agregar todo el HTML de una vez
            tbody.html(html);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', jqXHR.responseText);
        }
    });
}

    var mostrarError = function(data) {
        let mensaje = data.getAttribute('dataMensaje');
        Swal.fire({
            icon: "info",
            title: "<div style='font-size:14px;'>Problemas en el envio del informe</div>",
            html: mensaje,
            // footer: footer,
            width: "800px",
        });
    }

    var reenviarInforme = function(idcontrolenvioapi, tipo_vehiculo, idprueba, idmaquina, idtipocombustible) {
        Swal.fire({
            title: 'Enviando informe',
            text: 'Por favor espere...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>index.php/oficina/reportes/Cambientales/envioinformeBogota",
            mimeType: 'json',
            async: true,
            data: {
                idtipocombustible: idtipocombustible,
                idmaquina: idmaquina,
                idprueba: idprueba,
                tipo_vehiculo: tipo_vehiculo,
                token: localStorage.getItem("tokenBogota")
            },
            success: function(data, textStatus, jqXHR) {
                console.log(data);
                Swal.close();
                if(data == null || data == ''){
                    Swal.fire({
                        icon: "error",
                        title: "<div style='font-size:14px;'>Problemas en el envio</div>",
                        html: "<div style='font-size:14px;'>No se recibió respuesta del servidor, por favor intente nuevamente.</div>",
                        // footer: footer,
                        width: "800px",
                        confirmButtonText: "Aceptar"
                    });
                    return;
                }
                // Swal.close();
                let mensaje = "";
                let estado = 0;
                if (typeof data.data.original.aErrores !== "undefined" && data.data.original.aErrores.length > 0) {
                    // console.log(data.data.original.aErrores);
                    if (Array.isArray(data.data.original.aErrores)) {
                        mensaje = data.data.original.aErrores.map(function(e) {
                            return "<div style='font-size:12px;'>" + e + "</div>";
                        }).join("");
                    } else {
                        mensaje = "<div style='font-size:12px;'>" + data.data.original.aErrores + "</div>";
                    }
                    footer = "<div style='font-size:12px; color:red'>Si el envío no se realizó con éxito, por favor diríjase a la sección de informes ambientales y envíelo nuevamente una vez haya corregido los problemas reportados por el servidor.</div>";
                    estado = 0;
                } else {
                    mensaje = data.data.original.message;
                    footer = "";
                    estado = 1;
                }

                Swal.fire({
                    icon: "info",
                    title: "<div style='font-size:14px;'>" + data.data.original.name + "</div>",
                    html: "<div style='font-size:14px;'>" + data.data.original.message + "</div><br>" + mensaje,
                    footer: footer,
                    width: "800px",
                });
                updateInfoEnvioBogota(idcontrolenvioapi, mensaje, estado);
                setTimeout(() => {
                    getPendientes();
                }, 1000);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Swal.close();
                Swal.close();
                Swal.fire({
                    icon: "error",
                    title: "<div style='font-size:14px;'>Problemas en el envio</div>",
                    html: "<div style='font-size:14px;'>" + jqXHR.responseText + "</div>",
                    // footer: footer,
                    width: "800px",
                    confirmButtonText: "Aceptar"
                });

            }
        });

    }

    function updateInfoEnvioBogota(idcontrolenvioapi, mensaje, estado) {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>index.php/oficina/reportes/Cambientales/updateInfoEnvioBogota",
            mimeType: 'json',
            async: true,
            data: {
                idcontrolenvioapi: idcontrolenvioapi,
                mensaje: mensaje,
                estado: estado
            },
            success: function(data, textStatus, jqXHR) {
                console.log(data);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText)

            }
        });
    }


    if (FugasCal == "NA") {
        $("#sel-tipo-informe-fugas-cal").change(function() {
            var tipoInforme = $('#sel-tipo-informe-fugas-cal option:selected').attr('value');
            $("#div-informeNewAntCorantioquia").html("");
            $("#div-informeNewAntCorantioquia").append('<input type="hidden" id="informeNewAnt" name="informeNewAnt" value="' + tipoInforme + '">');
            for (var i = 0; i < c; i++) {
                $("#div-informeNewAnt" + i + "").html("");
                $("#div-informeNewAnt" + i + "").append('<input type="hidden" id="informeNewAnt" name="informeNewAnt" value="' + tipoInforme + '">');
            }
        });
    }

    var Variable = function(d) {
        const id = d.id;
        $("#csvdowload" + id.slice(-1) + "").val(1);
    }

    var variableNA = function(r) {
        const id = r.id;
        $("#csvdowload" + id.slice(-1) + "").val(0);
    }

    var saveSerCornare = function() {
        var idprueba = 1507621748;
        var tipoVehiculo = 2;
        var idmaquina = 2;
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>index.php/oficina/reportes/Cambientales/getInformeCronareWeb",
            mimeType: 'json',
            async: true,
            data: {
                idmaquina: idmaquina,
                idprueba: idprueba,
                tipoVehiculo: tipoVehiculo
            },
            success: function(data, textStatus, jqXHR) {
                if (data !== "") {
                    envioInformeCornare(data, idprueba, tipoVehiculo);
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(jqXHR.responseText)

            }
        });
    }
    var envioInformeCornare = function(data, idprueba, tipoVehiculo) {
        var datos = {
            informe: data,
            function: "saveDatos"
        }
        var norma = "";
        if (tipoVehiculo == 1) {
            norma = "NTC4983";
        } else if (tipoVehiculo == 2) {
            norma = "NTC4231";
        } else {
            norma = "NTC5365";
        }
        fetch("http://" + dominio + "/api/index.php/" + norma, {
                method: "POST",
                body: JSON.stringify(datos),
                headers: {
                    'Autorization': 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.Ijg5NnNkYndmZTg3dmNzZGFmOTg0bmc4ZmdoMjRvMTI5MHIi.HraZ7y3eG3dGhKngzOWge-je8Y3lxZgldXjbRbcA7cA',
                    'Content-Type': 'application/json'
                },
            }, 200)
            .then(respuesta => respuesta)
            .then((rta) => {
                insertControl(idprueba);

            })
            .catch(error => {
                console.log(error.message);

            });



        //        $.ajax({
        //            type: 'POST',
        //            url: "http://" + dominio + "/cda/index.php/" + norma,
        //            mimeType: 'json',
        //            async: true,
        //            data: {informe: data},
        //            success: function (data, textStatus, jqXHR) {
        //                if (data == 1) {
        //                    insertControl(idprueba);
        //                }
        //
        //            },
        //            error: function (jqXHR, textStatus, errorThrown) {
        //                console.log(jqXHR.responseText)
        //
        //            }
        //        });
    }

    var insertControl = function(idprueba) {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>index.php/oficina/reportes/Cambientales/insertControl",
            mimeType: 'json',
            async: true,
            data: {
                idprueba: idprueba
            },
            success: function(data, textStatus, jqXHR) {

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText)

            }
        });
    }
    //    $("#btnCsv" + c + "").click(function () {
    //        $("#csvdowload" + c + "").val(1);
    //        alert(c);
    //    })
    //    $("#btnGeneral" + c + "").click(function () {
    //        $("#csvdowload" + c + "").val(0);
    //    })
</script>