<?php $this->load->view('././header'); ?>
<script type="text/javascript">

</script>
<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
        <div class='col-12'>
            <div class="page-title">
                <div class="float-left">
                    <!-- PAGE HEADING TAG - START --><h4 class="title">INFORME DE PREREVISION</h4><!-- PAGE HEADING TAG - END -->  
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- MAIN CONTENT AREA STARTS -->
        <div class="col-xl-12">
            <section class="box ">
                <header class="panel_header">
                    <h4 class="title float-left">módulo para la generación de informes de prerevisión</h4>
                </header>
                <div class="content-body">    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">buscador</h2>
                                </header>

                                <div class="content-body">    
                                    <form action="<?php echo base_url(); ?>index.php/oficina/informes/CPrerevision/consultar" method="post">
                                        <div class="row">
                                            <div class="col-2">
                                                <label style="font-weight: bold;color: black" for="placa">PLACA<br/>
                                                    <input type="text" name="placa" id="placa" class="input" style="font-size: 15px;height: 37px"  size="15" value="<?php echo $placa; ?>" />
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <label style="font-weight: bold;color: black" for="daterange-2">FECHA<br/>
                                                    <input type="text" name="rango" id="daterange-2" class="form-control daterange" data-format="YYYY-DD-MM" data-separator="," value="<?php echo $rango; ?>">
                                                </label>
                                            </div>
                                            <div class="col-3">
                                                <p class="submit">
                                                    <input type="submit" name="consultar" id="wp-submit" class="btn btn-accent btn-block" onclick="showSuccess('Generando el informe, por favor espere.')" style="background-color: #393185;border-radius: 40px 40px 40px 40px" value="Consultar" />
                                                </p>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="col-12">
                                        <table  class="table table-bordered" >
                                            <thead>
                                                <tr>
                                                    <th>Placa</th>
                                                    <th>Fecha y hora</th>
                                                    <th>Ocasión</th>
                                                    <th>Generar informe</th>
                                                    <th>Estado del vehículo</th>
                                                    <th>Enviar formato al cliente</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($prerevision !== '') {
                                                    foreach ($prerevision->result() as $p) {
                                                        ?>
                                                        <tr>
                                                            <td ><?php echo $p->placa; ?></td>
                                                            <th ><?php echo $p->fecha_prerevision; ?></th>
                                                            <th><?php echo $p->ocacion; ?></th>
                                                            <td>
                                                                <form action="<?php echo base_url(); ?>index.php/oficina/informes/CPrerevision/generar" method="post">
                                                                    <input type="hidden" value="0" name="savePdf" >
                                                                    <input type="hidden" value="" name="email" >
                                                                    <input type="hidden" value="<?php echo $p->tipo_inspeccion; ?>" name="tipo_inspeccion" >
                                                                    <button class="btn btn-primary btn-block" name="idpre_prerevision" value ="<?php echo $p->idpre_prerevision; ?>" type="submit" formtarget="_blank" style="border-radius: 40px 40px 40px 40px">Generar</button>
                                                                </form>    
                                                            </td>
                                                            <td>
                                                                <form action="<?php echo base_url(); ?>index.php/oficina/informes/CPrerevision/verEstado" method="post">
                                                                    <button class="btn btn-primary btn-block" name="idpre_prerevision" value ="<?php echo $p->idpre_prerevision; ?>" type="submit" formtarget="_blank" style="border-radius: 40px 40px 40px 40px">Ver</button>
                                                                </form>
                                                            </td>
                                                            <td>
                                                                <!--<form action="<?php echo base_url(); ?>index.php/oficina/informes/CPrerevision/generar" method="post">-->
                                                                <input type="hidden" value="1" name="savePdf" >
                                                                <button class="btn btn-primary btn-block" name="idpre_prerevision" onclick="enviarEmail(<?php echo $p->idpre_prerevision; ?>, ' <?php echo $p->email; ?>')" value ="<?php echo $p->idpre_prerevision; ?>" type="submit" data-toggle='modal' data-target='#envioEmail'  style="border-radius: 40px 40px 40px 40px">Enviar email</button>
                                                                <!--</form>-->
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </section>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!--<button ></button>-->
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
                <label id="mensaje"
                       style="background: white;
                       width: 100%;
                       text-align: center;
                       font-weight: bold;
                       font-size: 15px;
                       padding: 5px;border: solid gray 2px;
                       border-radius:  15px 15px 15px 15px;color: gray">Bienvenido</label>
                <br>
                <table class="table">
                    <tr id="pin">
                        <td style="text-align: right">
                            Email
                        </td>
                        <td colspan="3" style="text-align: left;padding-left: 10px">
                            <input id="datEmail" type="email" class="form-control"/>
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
<!-- END CONTENT -->
<?php
$this->load->view('././footer');
?>
<script type="text/javascript">

    var envioCorreo = '<?php
if (isset($envioCorreo)) {
    echo $envioCorreo;
} else {
    echo'0';
}
?>';
    var idpred = 0;
    function enviarEmail(idpre, email) {
        document.getElementById('btnEnviar').disabled = false;
        $('#datEmail').val(email);
        idpred = idpre;
    }

    function enviarEmailData() {
        var emaild = $('#datEmail').val();
        if (envioCorreo === "1") {
            document.getElementById('btnEnviar').disabled = true;
            $('#mensaje').html('Enviado Información, por favor espere.');
//        console.log(emaild, idpred);
            if ((idpred === null || idpred === "") || (emaild === null || emaild === "")) {
                $('#cancelar').click();
                Swal.fire({
                    icon: 'error',
                    text: 'Campo email vacio.'
                });
            } else {
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/informes/CPrerevision/generar',
                    type: 'post',
                    mimeType: 'json',
                    data: {savePdf: 1,
                        idpre_prerevision: idpred,
                        email: emaild
                    },
                    success: function (data, textStatus, jqXHR) {
//                        console.log(data)
                        $('#cancelar').click();
                        Swal.fire({
                            icon: 'success',
                            text: 'Email enviado con exito.',
                        })

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#cancelar').click();
                        Swal.fire({
                            icon: 'error',
                            html: 'No se pudo enviar el email.<br>'.jqXHR.text,
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

</script>
