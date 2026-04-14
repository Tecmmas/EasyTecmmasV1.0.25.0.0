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
                                    <h4>Optimización base de datos</h4>
                                    <div class="row">

                                        <div class="col-md-9 col-lg-9 col-sm-9">
                                            <div style="text-align: center; font-size: 18px"><b>Tenga en cuenta</b></div>
                                            <br>
                                            1. Debe detener operación, por cuestiones de seguridad de la información.<br>
                                            2. Después de iniciado el proceso no se puede parar.<br>
                                            3. El proceso demora según el peso de la base de datos.<br>
                                            4. Al finalizar se mostrará el resultado.<br>
                                            <br>
                                        </div>

                                        <div class="col-md-3 col-lg-3 col-sm-3">
                                            <button type="button" id="btn-optimizar"  class="btn btn-primary"   style="margin-top: 80px">Optimizar</button>
                                        </div>

                                    </div>



                                </div>
                                
                            </section>

                        </div>
                    </div>
                </div>
                <div id="mesajeOp"></div>
                <div class="content-body">    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div id="div-op" style="display: none">
                                <div class="table">
                                    <table class="table" id="table-op" >
                                        <thead id="head-op">

                                        </thead>
                                        <tbody id="body-op">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- MAIN CONTENT AREA ENDS -->
            </section>
    </section>
</section>


<!-- END CONTENT -->



<?php $this->load->view('./footer'); ?>
<script type="text/javascript">


    $("#btn-optimizar").click(function () {
        $("#mesajeOp").html("<div style='color: green; text-aling: center; margin-left: 22px'>Ejecutado por favor espere.</div>");
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/reportes/db/Cdb/ejcutarOp',
            type: 'POST',
            mimeType: 'json',
            success: function (data) {
                console.log(data)
                $("#body-op").html("")
                var html = "<tr><th style='font-size: 13px; text-align: center;'>Tabla</th>\n\
                                <th style='font-size: 13px; text-align: center;'>Operacion</th>\n\
                                <th style='font-size: 13px; text-align: center;'>Estado</th>\n\
                                <th style='font-size: 13px; text-align: center;'>Respuesta</th>\n\
                            </tr>";
                $("#head-op").html(html);
                document.getElementById("div-op").style.display = '';
                $('html, body').animate({
                    scrollTop: $("#div-op").offset().top
                }, 900);
                var iterator = Object.keys(data);
                var d = 0;
                $.each(data, function (i, data) {
                    var body = "<tr>";
                    for (var e = 0; e < 1; e++) {
                        body += "<td style='font-size: 12px; text-align: center;'>" + iterator[d] + "</td>";
                        d++;
                    }
                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Op + "</td>";
                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Msg_type + "</td>";
                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Msg_text + "</td>";
                    body += "</tr>";
                    $("#table-op tbody").append(body);
                });
                $("#mesajeOp").html("<div style='color: green; text-aling: center; margin-left: 22px'>Operación finaliza con exito.</div>");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#mesajeError").html("<label style='color: red'>Error: " + jqXHR.responseText + "</label>");
            }
        });
    })






</script>
