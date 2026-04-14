<?php $this->load->view('././header'); ?>
<script type="text/javascript">

</script>
<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
        <div class='col-12'>
            <div class="page-title">
                <div class="float-left">
                    <!-- PAGE HEADING TAG - START -->
                    <h4 class="title">FORMATO UNIFORME RTMEC, PREVENTIVAS Y PRUEBAS LIBRES</h4><!-- PAGE HEADING TAG - END -->
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- MAIN CONTENT AREA STARTS -->
        <div class="col-xl-12">
            <section class="box ">
                <header class="panel_header">
                    <h4 class="title float-left">Generación de formatos</h4>
                </header>
                <div class="content-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">buscador</h2>
                                </header>

                                <div class="content-body">
                                    <form action="<?php echo base_url(); ?>index.php/oficina/informes/CFur/consultar" method="post">
                                        <div class="row">
                                            <div class="col-2">
                                                <label style="font-weight: bold;color: black" for="placa">PLACA<br />
                                                    <input type="text" name="placa" id="placa" class="input" style="font-size: 15px;height: 37px" size="15" value="<?php
                                                                                                                                                                    if (isset($placa)) {
                                                                                                                                                                        echo $placa;
                                                                                                                                                                    }
                                                                                                                                                                    ?>" />
                                                </label>
                                            </div>
                                            <div class="col-3">
                                                <p class="submit">
                                                    <input type="submit" name="consultar" id="wp-submit" class="btn btn-accent btn-block" onclick="showSuccess('Generando el informe, por favor espere.')" style="background-color: #393185;border-radius: 40px 40px 40px 40px" value="Consultar" />
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="<?php echo base_url(); ?>index.php/oficina/fur/CFUR" method="post">
                                        <input type="hidden" name="desdeConsulta" value="true" />
                                        <div class="col-12">
                                            <table>
                                                <tr>
                                                    <td>
                                                        Tamaño hoja
                                                    </td>
                                                    <td>
                                                        <select name="tamano" class="form-control input-lg m-bot15">
                                                            <option value="oficio" selected>Oficio</option>
                                                            <option value="carta">Carta</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        Medio
                                                    </td>
                                                    <td>
                                                        <select name="medio" id="medioSelect" class="form-control input-lg m-bot15" onchange="guardarMedio()">
                                                            <option value="0" selected>Impreso</option>
                                                            <option value="1">Digital</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Id Control</th>
                                                        <th>Placa</th>
                                                        <th>Tipo</th>
                                                        <th>Fecha inicial</th>
                                                        <th>Fecha final</th>
                                                        <th>Generar</th>
                                                        <th>Email</th>
                                                        <th>Primer envio sicov</th>
                                                        <th>Envio runt</th>
                                                        <th>Firma digital</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($formatos)) {
                                                        foreach ($formatos->result() as $p) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $p->idcontrol; ?></td>
                                                                <th><?php echo $p->placa; ?></th>
                                                                <th><?php echo $p->tipo; ?></th>
                                                                <th><?php echo $p->fechainicial; ?></th>
                                                                <th><?php echo $p->fechafinal; ?></th>
                                                                <th><?php echo $p->btnFur; ?></th>
                                                                <th><?php echo $p->btnEmail; ?></th>
                                                                <th><?php echo $p->btnPrimerEnvio; ?></th>
                                                                <th><?php echo $p->btnConsecutivo; ?></th>
                                                                <th><?php echo $p->btnFirmaDigital; ?></th>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>

                                    </form>
                                </div>

                            </section>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- MAIN CONTENT AREA ENDS -->
    </section>
</section>
<div class="modal" id="envioEmail" s tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated bounceInDown">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titulo_">ENVIO DE FORMATO</h4>
            </div>
            <div class="modal-body" style="background: whitesmoke">
                <label id="mensaje" style="background: white;
                       width: 100%;
                       text-align: center;
                       font-weight: bold;
                       font-size: 15px;
                       padding: 5px;border: solid gray 2px;
                       border-radius:  15px 15px 15px 15px;color: gray">Bienvenido</label>
                <br>
                <table class="table">
                    <tr>
                        <td style="text-align: right">Email</td>
                        <td colspan="3" style="text-align: left;padding-left: 10px">
                            <input id="datEmail" type="email" class="form-control" />
                        </td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" id="cancelar" class="btn btn-default" type="button">Cancelar</button>
                <button class="btn btn-success" id="btnEnviar" type="submit" onclick="enviarEmailData()">Enviar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="guardarConsecutivo" s tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated bounceInDown">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titulo_">ENVIO DE CONSECUTIVO RUNT</h4>
            </div>
            <div class="modal-body" style="background: whitesmoke">
                <label id="mensaje" style="background: white;
                       width: 100%;
                       text-align: center;
                       font-weight: bold;
                       font-size: 15px;
                       padding: 5px;border: solid gray 2px;
                       border-radius:  15px 15px 15px 15px;color: gray">Bienvenido</label>
                <br>
                <table class="table">
                    <tr>
                        <td style="text-align: right">Consecutivo runt</td>
                        <td colspan="3" style="text-align: left;padding-left: 10px">
                            <input id="consecutivoRunt" type="number" class="form-control" onchange="guardarConsecutivo(this)">
                        </td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" id="cancelarEnvioRunt" class="btn btn-default" type="button">Cancelar</button>
                <button class="btn btn-success" id="btnEnviarConsecutivoRunt" type="submit" onclick="opcionEnvio(event,this.value,2)">Enviar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modalFirmaFur" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated bounceInDown">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Firmar el fur</h4>
            </div>
            <div class="modal-body" style="background: whitesmoke">
                <div style="border: solid 2px; background-color:  white; width: 450px;">
                    <div id="root"></div>
                    <br>
                    <label id="mesajeFirma"></label>
                    <img id="image1" class="image full-width" />
                </div>
            </div>
            <div class="modal-footer">
                <button style="background-color: #a3e4d7;" class="btn btn-default" type="button" id="resetCanvas">Limpiar firma</button>
                <button class="btn btn-success" type="button" id="getFirma">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->


<?php $this->load->view('././footer'); ?>


<script type="text/javascript">
    var envioCorreo = '<?php
                        if (isset($envioCorreo)) {
                            echo $envioCorreo;
                        } else {
                            echo '0';
                        }
                        ?>';
    var firmaDigital = "<?php
                        echo $this->session->userdata('firmaDigital');
                        ?>";
    var idhojaprueba = 0;
    var reins = 0;
    var datos = "";

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



    function emailFur(event, value, title) {
        event.preventDefault();
        $('#datEmail').val(title);
        var dato = value.split('-');

        idhojaprueba = dato[0];
        reins = dato[1];

        datos = idhojaprueba + "-" + reins + "-0-1";
    }

    var crearModalFirma = function(event, value) {
        event.preventDefault();
        var dato = value.split('-');

        idhojaprueba = dato[0];
        reins = dato[1];


        if (firmaDigital == 1) {
            const image1 = document.getElementById("image1")
            image1.src = "";
            getFirmaFur();
            $("#resetCanvas").click();
            $("#root").html("");
            const root = document.getElementById("root")
            const resetCanvas = document.getElementById("resetCanvas")
            const getImage = document.getElementById("getFirma")

            // Call signature with the root element and the options object, saving its reference in a variable
            const component = Signature(root, {
                value: [],
                width: 450,
                height: 200,
                instructions: "Por favor ingrese la firma"
            });
            //$("#modalFirmaFur").modal("show");

            resetCanvas.addEventListener("click", () => {
                component.value = [];
            });

            getImage.addEventListener("click", () => {
                //getImage.nextElementSibling.src = component.getImage();
                firma = component.getImage();
                guardarFirma(firma);
                // image1.src = img.trim();

            });
        } else {
            Swal.fire({
                title: '<div style="font-size:15px;">Activación</div>',
                html: "<div style='font-size:15px;'>Este servicio requiere activación para mas información, comuniquese con el area de soporte.</div>",
                icon: 'info',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
                allowOutsideClick: false
            })
        }
    }

    var guardarFirma = function(firma) {
        const image1 = document.getElementById("image1")
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/guardarFirmaDigital',
            type: 'post',
            data: {
                firma: firma,
                idhojapruebas: idhojaprueba + '-' + reins,
                reinspeccion: reins
            },
            success: function(rta) {
                //$("#modalFirmaFur").modal("hide");
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Firma guardada",
                    showConfirmButton: false,
                    timer: 1500
                });
                image1.src = firma;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: '<div style="font-size:15px;">No se pudo guardar la firma</div>',
                    html: "<div style='font-size:15px;'>Comuniquese con el area de soporte.</div>",
                    icon: 'info',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false
                })

            }
        });
    }

    var getFirmaFur = function() {
        const image1 = document.getElementById("image1")
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/getFirmaFur',
            type: 'post',
            data: {
                idhojapruebas: idhojaprueba + '-' + reins
            },
            success: function(rta) {
                if (rta == "NA") {
                    // Swal.fire({
                    //     title: '<div style="font-size:15px;">Fur sin firma</div>',
                    //     html: "<div style='font-size:15px;'>Este fur no tiene asociada ninguna firma digital.</div>",
                    //     icon: 'info',
                    //     confirmButtonColor: '#3085d6',
                    //     confirmButtonText: 'Aceptar',
                    //     allowOutsideClick: false
                    // })
                } else {
                    $("#mesajeFirma").text("Firma ya registrada")
                    image1.src = rta;
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: '<div style="font-size:15px;">No se pudo guardar la firma</div>',
                    html: "<div style='font-size:15px;'>Comuniquese con el area de soporte.</div>",
                    icon: 'info',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false
                })

            }
        });
    }


    $('#btnEnviarRunt').click(function(e) {
        e.preventDefault();
        var idht = $('#btnEnviarRunt').val().split('-');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/consultarConsecutivo',
            type: 'post',
            data: {
                idhojapruebas: idht[0]
            },
            async: false,
            mimeType: 'json',
            success: function(rta) {
                if (rta !== "") {
                    if (idht[0] == 0) {
                        if (rta.consecutivo_runt !== "") {
                            $("#consecutivoRunt").val(rta.consecutivo_runt);
                            document.getElementById("consecutivoRunt").disabled = true
                        } else if (rta.consecutivo_runt_rechazado !== "") {
                            $("#consecutivoRunt").val(rta.consecutivo_runt_rechazado);
                            document.getElementById("consecutivoRunt").disabled = true
                        }
                    } else {
                        if (rta.consecutivo_runt !== "") {
                            $("#consecutivoRunt").val(rta.consecutivo_runt);
                            document.getElementById("consecutivoRunt").disabled = true
                        }
                    }

                }

            }
        });
        document.getElementById("btnEnviarConsecutivoRunt").value = $('#btnEnviarRunt').val();
    })

    var guardarConsecutivo = function(e) {

        var idht = $('#btnEnviarRunt').val().split('-');
        var data = {
            idhojapruebas: idht[0],
            consecutivorunt: e.value,
            reinspeccion: idht[1]
        };
        if (idht[2] == 2 || idht[2] == 4) {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/guardarConsecutivoAprobado',
                type: 'post',
                data: data,
                async: false,
                success: function(rta) {
                    //                                                                    console.log(rta);
                }
            });
        } else {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/guardarConsecutivoRechazado',
                type: 'post',
                data: data,
                async: false
            });
        }

    };


    function enviarEmailData() {
        var emaild = $('#datEmail').val();
        if (envioCorreo === "1") {
            document.getElementById('btnEnviar').disabled = true;
            $('#mensaje').html('Enviado Información, por favor espere.');
            //        console.log(emaild, idpred);
            if ((idhojaprueba === null || idhojaprueba === "") || (emaild === null || emaild === "")) {
                $('#cancelar').click();
                Swal.fire({
                    icon: 'error',
                    text: 'Campo email vacio.'
                });
            } else {
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/fur/CFUR',
                    type: 'post',
                    data: {
                        dato: datos,
                        email: emaild
                    },
                    success: function(data, textStatus, jqXHR) {
                        var v = 0;
                        //                        if (document.getElementById('email_prerevision').checked) {
                        //                            v = enviarPrerevision(emaild);
                        //                        }
                        $('#cancelar').click();
                        if (v == 1 || data == 1) {
                            Swal.fire({
                                icon: 'success',
                                text: 'Email enviado con exito.'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#cancelar').click();
                        Swal.fire({
                            icon: 'error',
                            html: 'No se pudo enviar el email.<br>' + jqXHR,
                        })
                    }
                })
            }
        } else {
            $('#cancelar').click();
            Swal.fire({
                icon: 'error',
                html: 'Apreciado usuario, usted no tiene habilitado este módulo de envío. por favor comuníquese con TECMMAS SAS<br>',
            });
        }

    }

    function opcionEnvio(ev, value, tipoEnvio) {
        ev.preventDefault();
        $("#cancelarEnvioRunt").click();
        var dato = value.split('-');
        idhojaprueba = dato[0];
        reins = dato[1];
        Swal.fire({
            title: '¿Esta seguro de enviar la información?',
            html: "Usted está a punto de realizar un envío a sicov, tenga en cuenta que deberá tener la autorización brindada por sicov, de lo contrario puede generar errores.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                enviarASICOV(idhojaprueba, tipoEnvio, reins);
                //                Swal.fire(
                //                        'Deleted!',
                //                        'Your file has been deleted.',
                //                        'success'
                //                        )
            }
        })
    }

    var enviarASICOV = function(idhojaprueba, tipoEnvio, reins) {
        var segundos = 2;
        var proceso = setInterval(function() {
            if (segundos === 0) {
                clearInterval(proceso);

                var data = {
                    envioSicov: 'true',
                    dato: idhojaprueba + '-' + reins,
                    envio: tipoEnvio,
                    IdUsuario: '1',
                    ocacion: reins,
                    sicovModoAlternativo: localStorage.getItem("sicovModoAlternativo")

                };
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/fur/CFUR',
                    type: 'post',
                    data: data,
                    async: false,
                    success: function(rta) {

                        var dat = rta.split('|');
                        console.log(dat[0])
                        if (dat[1] === '0000' || dat[1] === '1' || dat[1] === '5') {
                            var segundos = 3;
                            // var proceso = setInterval(function() {
                            //                                $('#mensajeSicov').text("Mensaje de SICOV: " + dat[0] + ". Detalles en el visor.");
                            //                                document.getElementById('mensajeSicov').style.color = 'green';
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Respuesta',
                                text: "Mensaje de SICOV: " + dat[0] + ". Detalles en el visor.",
                                showConfirmButton: false,
                                //                                    timer: 2500
                            });
                            //                                if (segundos === 0) {
                            //                                    clearInterval(proceso);
                            //                                    window.location.replace("<?php echo base_url(); ?>index.php/oficina/CGestion");
                            //                                }
                            segundos--;
                            //}, 1000);
                        } else {
                            var segundos = 3;
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Error',
                                text: "Mensaje de SICOV: " + dat[0] + ". Detalles en el visor.",
                                showConfirmButton: false,
                                //                                timer: 2500
                            });
                            //                            $('#mensajeSicov').text("Mensaje de SICOV: " + dat[0] + ". Detalles en el visor.");
                            //                            document.getElementById('mensajeSicov').style.color = 'salmon';
                            //                            var proceso = setInterval(function () {
                            //                                if (segundos === 0) {
                            //                                    clearInterval(proceso);
                            //                                    window.location.replace("<?php echo base_url(); ?>index.php/oficina/CGestion");
                            //                                }
                            //                                segundos--;
                            //                            }, 1000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR)
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de envio',
                            html: 'No se pudo enviar la información.<br>' + jqXHR.responseText,
                        })
                    }
                });
            }
            segundos--;
        }, 500);

    }
</script>