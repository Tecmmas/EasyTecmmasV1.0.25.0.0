<?php $this->load->view('././header'); ?>
<script type="text/javascript">

</script>
<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
        <div class='col-12'>
            <div class="page-title">
                <div class="float-left">
                    <!-- PAGE HEADING TAG - START --><h4 class="title">INFORME DE ATESTIGUAMIENTO</h4><!-- PAGE HEADING TAG - END -->  
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
                                    <form action="<?php echo base_url(); ?>index.php/oficina/informes/Catestiguamiento/consultar" method="post">
                                        <div class="row">
                                            <div class="col-2">
                                                <label style="font-weight: bold;color: black" for="placa">PLACA<br/>
                                                    <input type="text" name="placa" id="placa" class="input" style="font-size: 15px;height: 37px"  size="15" 
                                                           value="<?php
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
                                    <form action="<?php echo base_url(); ?>index.php/oficina/atestiguamiento/Catestiguamiento" method="post">
                                        <input type="hidden" name="desdeConsulta" value="true" />
                                        <div class="col-12">
                                            <table  class="table table-bordered" >
                                                <thead>
                                                    <tr>
                                                        <th>Id Control</th>
                                                        <th>Placa</th>
                                                        <th>Tipo</th>
                                                        <th>Fecha inicial</th>
                                                        <th>Fecha final</th>
                                                        <th>Generar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($formatos)) {
                                                        foreach ($formatos->result() as $p) {
                                                            ?>
                                                            <tr>
                                                                <td ><?php echo $p->idcontrol; ?></td>
                                                                <th ><?php echo $p->placa; ?></th>
                                                                <th ><?php echo $p->tipo; ?></th>
                                                                <th><?php echo $p->fechainicial; ?></th>
                                                                <th><?php echo $p->fechafinal; ?></th>
                                                                <th><?php echo $p->btnFur; ?></th>
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
<!-- END CONTENT -->
<?php
$this->load->view('././footer');
