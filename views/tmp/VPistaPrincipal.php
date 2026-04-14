<?php $this->load->view('header'); ?>
<script type="text/javascript">
   
</script>
<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>

        <div class='col-12'>
            <div class="page-title">

                <div class="float-left">
                    <!-- PAGE HEADING TAG - START --><h4 class="title">LINEA LIVIANOS PRINCIPAL</h4><!-- PAGE HEADING TAG - END -->  
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
        <!-- MAIN CONTENT AREA STARTS -->

        <div class="col-xl-12">
            <section class="box ">
                <header class="panel_header">
                    <h4 class="title float-left">VEHICULOS DISPONIBLES</h4>

                </header>
                <div class="content-body">    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Bordered Table</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">    <div class="row">
                                        <div class="col-12">
                                            <form action="<?php echo base_url(); ?>index.php/CPrueba" method="post">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Placa</th>
                                                            <th>Iniciar</th>
                                                        </tr>
                                                        <?php ?>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($pruebas->result() as $p) { ?>
                                                            <tr>

                                                                <td><?php echo $p->fecha; ?></td>
                                                                <th scope="row"><?php echo $p->placa; ?></th>
                                                                <td><button class="btn btn-primary btn-block" name="idprueba" value ="<?php echo $p->idprueba; ?>" type="submit">Iniciar</button></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </form>

                                        </div>
                                    </div>
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
<!-- END CONTENT -->



<?php
$this->load->view('footer');
