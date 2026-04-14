<?php $this->load->view('./header'); ?>


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
                <div class="content-body">    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <section class="box ">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <h4>Modulos adicionales</h4>

                                    <div class="panel-group collapsed active" id="accordion-4" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne4">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion-4" href="#collapseOne-4" aria-expanded="true" aria-controls="collapseOne-4">
                                                        <i class='fa fa-list'></i>Metrologia de equipos
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne-4" class="panel-collapse collapse in active" role="tabpanel" aria-labelledby="headingOne4">
                                                <div class="panel-body">
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3 col-lg-3 col-sm-3">
                                                            <div style="text-align: center; font-size: 18px">Tipo</div>
                                                            <select class="form-control input-lg m-bot15" id="tipo">
                                                                <option value="0">Calibración</option>
                                                                <option value="1">Verificación</option>

                                                            </select>

                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-sm-3">
                                                            <div style="text-align: center; font-size: 18px">Numero Certificado</div>
                                                            <input class="form-control input-lg m-bot15" type="text" id="certificado">
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-sm-3">
                                                            <div style="text-align: center; font-size: 18px">Empresa</div>
                                                            <input class="form-control input-lg m-bot15" type="text" id="empresa">
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-sm-3">
                                                            <div style="text-align: center; font-size: 18px">Fecha vencimiento</div>
                                                            <input type="text" class="form-control datepicker" id="fechavencimiento"  data-format="yyyy-mm-dd " autocomplete="off" >
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                                            <div style="text-align: center; font-size: 18px">Maquina</div>
                                                            <select class="form-control input-lg m-bot15" id="idmaquina">
                                                                <option selected="">Seleccione la maquina</option>
                                                                <?php foreach ($maquina as $v) { ?>
                                                                    <?php if ($v->activo == 1 && ($v->conf_idtipo_prueba <> 5 && $v->conf_idtipo_prueba <> 20 && $v->conf_idtipo_prueba <> 8 && $v->conf_idtipo_prueba <> 16 && $v->conf_idtipo_prueba <> 17 && $v->conf_idtipo_prueba <> 19 && $v->conf_idtipo_prueba <> 21 && $v->conf_idtipo_prueba <> 22)) { ?>
                                                                        <option value="<?= $v->nombre . "-" . $v->marca . "-" . $v->serie_maquina . "-" . $v->serie_banco ?>"><?= $v->nombre . "-" . $v->marca . "-" . $v->serie_maquina . "-" . $v->serie_banco ?></option>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-sm-3">
                                                            <div style="text-align:  center">
                                                                <button type="button" class="btn btn-success" style="margin-top: 22px;" onclick="metrologiaC()">Guardar</button>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-sm-3">
                                                            <div style="text-align:  center">
                                                                <button type="button" class="btn btn-warning" style="margin-top: 22px;" onclick="verMetrologia()">Ver registros</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div id="mesajeError" style="color: red; font-size: 18px "></div>
                                                    <br>
                                                    <div id="div-Metrologia" style="display: none">
                                                        <div class="table">
                                                            <table class="table" id="table-metrologia" >
                                                                <thead id="head-metrologia">

                                                                </thead>
                                                                <tbody id="body-metrologia">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </section>

                        </div>
                    </div>
                </div>



                <!-- MAIN CONTENT AREA ENDS -->
            </section>
    </section>
</section>
<div class="modal fade bd-example-modal-sm" id="updateMetrologia"   role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #383085;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: white">Actualizar datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="form-group">
                    <input type="hidden" id="idconf_maquina">
                    <label for="recipient-name" class="col-form-label" ><b>Tipo</b></label>
                    <input type="text" class="form-control" id="tipom" disabled>
                    <label for="recipient-name" class="col-form-label"><b>Certificado</b></label>
                    <input type="text" class="form-control" id="certificadom">
                    <label for="recipient-name" class="col-form-label"><b>Empresa</b></label>
                    <input type="text" class="form-control" id="empresam">
                    <label for="recipient-name" class="col-form-label" ><b>Maquina</b></label>
                    <input type="text" class="form-control" id="maquinam" disabled>
                    <label for="recipient-name" class="col-form-label"><b>Fecha registro</b></label>
                    <!--<input type="text" class="form-control" id="fecharegistrom" >-->
                    <input type="text" class="form-control datepicker" id="fecharegistrom"  data-format="yyyy-mm-dd "  >
                    <input type="hidden" id="idmetrologia">
                    <label for="recipient-name" class="col-form-label"><b>Estado</b></label>
                    <select class="browser-default custom-select" id="estadom">

                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModal">Close</button>
                <button class="btn btn-primary" onclick="updateMetrologia()">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- END CONTENT -->



<?php $this->load->view('./footer'); ?>
<script type="text/javascript">
    var text = new XMLHttpRequest();
    text.open("GET", "<?php echo base_url(); ?>/system/dominio.dat", false);
    text.send(null);
    var dominio = text.responseText;
    console.log()

    function metrologiaC() {
        $("#mesajeError").html("");
        var tipo = $('#tipo option:selected').attr("value");
        var certificado = $("#certificado").val();
        var empresa = $("#empresa").val();
        var fechavencimiento = $("#fechavencimiento").val();
        var maquina = $('#idmaquina option:selected').attr("value");
        var mesaje = "";
        var valid = true;

        if (tipo == "" || tipo == null) {
            mesaje = mesaje + "Seleccione el tipo.<br>";
            valid = false;
        }
        if (certificado == "" || certificado == null) {
            mesaje = mesaje + "Ingrese el certificado.<br>";
            valid = false;
        }
        if (empresa == "" || empresa == null) {
            mesaje = mesaje + "Ingrese el empresa.<br>";
            valid = false;
        }
        if (fechavencimiento == "" || fechavencimiento == null) {
            mesaje = mesaje + "Ingrese la fecha de vencimiento.<br>";
            valid = false;
        }
        if (maquina == "" || maquina == null) {
            mesaje = mesaje + "Seleccione la maquina.<br>";
            valid = false;
        }
        if (!valid) {
            Swal.fire({
                icon: 'error',
                title: 'Campos obligatorios.',
                html: '<div style="font-size: 15 px">' + mesaje + '</div>',
//                footer: '<a href="">Why do I have this issue?</a>'
            })
        } else {

            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/reportes/adicionales/Cadicionales/getMetrologia',
                data: {tipo: tipo,
                    certificado: certificado,
                    empresa: empresa,
                    fechavencimiento: fechavencimiento,
                    maquina: maquina
                },
                type: 'POST',
                mimeType: 'json',
                success: function (rta) {
                    if (rta == 1) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Registro guardado',
                            showConfirmButton: true,
                            timer: 2000
                        })
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#mesajeError").html(jqXHR.responseText);
                    console.log(jqXHR.responseText);
                }
            });
        }
    }

    function verMetrologia() {
        $("#mesajeError").html("");
        $.ajax({
            url: 'http://' + dominio + '/cda/index.php/Cadicionales/selMetrologia',
            type: 'GET',
            mimeType: 'json',
            success: function (data) {
                $("#body-metrologia").html("")
                var html = "<tr><th style='font-size: 13px; text-align: center;'>Tipo</th>\n\
                                <th style='font-size: 13px; text-align: center;'>Maquina</th>\n\
                                <th style='font-size: 13px; text-align: center;'>Certificado</th>\n\
                                <th style='font-size: 13px; text-align: center;'>Empresa</th>\n\
                                <th style='font-size: 13px; text-align: center;'>Fecha vencimiento</th>\n\
                                <th style='font-size: 13px; text-align: center;'>Opciones</th>\n\
                            </tr>";
                $("#head-metrologia").html(html);
                document.getElementById("div-Metrologia").style.display = '';
                $('html, body').animate({
                    scrollTop: $("#div-Metrologia").offset().top
                }, 900);
                $.each(data, function (i, data) {
                    //dato++;
//                    $('#div-info-statspruebas').html('Numero de registros: ' + dato);
                    if (data.tipo == 0) {
                        var tipo = 'Calibración';
                    } else {
                        var tipo = 'Verificación';
                    }
                    var body = "<tr>";
                    body += "<td style='font-size: 12px; text-align: center;'>" + tipo + "</td>";
                    body += "<td style='font-size: 12px; text-align: center;'>" + data.maquina + "</td>";
                    body += "<td style='font-size: 12px; text-align: center;'>" + data.certificado + "</td>";
                    body += "<td style='font-size: 12px; text-align: center;'>" + data.empresa + "</td>";
                    body += "<td style='font-size: 12px; text-align: center;'>" + data.fechacertificado + "</td>";
                    body += '<td style="font-size: 12px; text-align: center;"><div class="btn-group btn-group-justified"><a type="button" class="btn btn-info" style="color: whitesmoke" data-toggle="modal" data-target="#updateMetrologia" onclick="updateData(\'' + data.idmetrologia + '\',\'' + tipo + '\',\'' + data.certificado + '\',\'' + data.empresa + '\',\'' + data.maquina + '\',\'' + data.fechacertificado + '\',\'' + data.estado + '\')">Ver</a><a type="button" class="btn btn-danger" style="color: whitesmoke" onclick="deleteData(' + data.idmetrologia + ')">Eliminar</a></div>';
                    body += "</tr>";
                    $("#table-metrologia tbody").append(body);
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#mesajeError").html(jqXHR.responseText);
            }
        });
    }

    updateData = function (idmetrologia, tipo, certificado, empresa, maquina, fechacertificado, estado) {
        $("#idmetrologia").val(idmetrologia);
        $("#tipom").val(tipo);
        $("#certificadom").val(certificado);
        $("#empresam").val(empresa);
        $("#maquinam").val(maquina);
        $("#fecharegistrom").val(fechacertificado);
        if (estado == 0) {
            $('#estadom').append("<option value='0'>Desactivado</option>");
            $('#estadom').append("<option value='1'>Activado</option>");
        } else {
            $('#estadom').append("<option value='1'>Activado</option>");
            $('#estadom').append("<option value='0'>Desactivado</option>");
        }
    }

    function updateMetrologia() {
        $("#mesajeError").html("");
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/reportes/adicionales/Cadicionales/updateMetrologia',
            type: 'POST',
            mimeType: 'json',
            data: {idmetrologia: $("#idmetrologia").val(),
                tipo: $("#tipom").val(),
                certificado: $("#certificadom").val(),
                empresa: $("#empresam").val(),
                maquina: $("#maquinam").val(),
                fechavencimiento: $("#fecharegistrom").val(),
            },
            success: function (data) {
                if (data == 1) {
                    $("#closeModal").click();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Registro actualizado.',
                        showConfirmButton: true,
                        timer: 2000
                    })
                    verMetrologia();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#mesajeError").html(jqXHR.responseText);
            }
        });
    }

    function deleteData(idmetrologia) {
        $("#mesajeError").html("");
        Swal.fire({
            title: '¿Eliminar registro?',
            text: "El registro sera eliminado del sistema y no se podra recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                delet(idmetrologia)


            }

        })

        var delet = function (idmetrologia) {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/reportes/adicionales/Cadicionales/deleteMetrologia',
                type: 'POST',
                mimeType: 'json',
                data: {idmetrologia: idmetrologia},
                success: function (data) {
                    verMetrologia();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Registro eliminado.',
                        showConfirmButton: true,
                        timer: 2000
                    })
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#mesajeError").html(jqXHR.responseText);
                }
            });

        }

    }
</script>
