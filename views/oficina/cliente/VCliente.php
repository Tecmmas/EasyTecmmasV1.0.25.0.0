<?php $this->load->view('./header'); ?>
<script type="text/javascript">

</script>
<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>

        <div class='col-12'>
            <div class="page-title">

                <div class="float-left">
                    <!-- PAGE HEADING TAG - START --><h4 class="title">GESTION DE CLIENTES</h4><!-- PAGE HEADING TAG - END -->  
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
        <!-- MAIN CONTENT AREA STARTS -->
        <section class="box ">
            <header class="panel_header">
                <h2 class="title pull-left">CLIENTES REGISTRADOS</h2>
            </header>
            <div class="content-body"> 

                <table style="width: 100%;text-align: left">
                    <tr>
                    <form action="<?php echo base_url(); ?>index.php/oficina/cliente/Ccliente/getCliente" method="post" >
                        <td style="text-align: left;width: 100px">
                            <label  for="placa">BUSQUEDA<br/>
                                <input type="text" name="match" id="placa" class="form-control"  value="<?php
                                if (isset($item)) {
                                    echo $item;
                                }
                                ?>" />
                            </label>
                        </td>
                        <td style="text-align: left;width: 200px">
                            <input type="submit" name="consultar" id="wp-submit" class="btn bot_azul btn-block" style="width: 150px"  value="Consultar" />
                        </td>
                    </form>
                    <td style="text-align: left;width: 200px">
                        <form action="<?php echo base_url(); ?>index.php/oficina/cliente/CAdministrarCliente" method="post" style="width: 100%">
                            <input type="submit" name="agregar" id="wp-submit" class="btn bot_verde btn-block" style="width: 150px" value="Agregar" />
                        </form>
                    </td>
                    </tr>
                </table>
                <br>
                <div class="col-xs-12">
                    <table id="example-1" class="table table-striped dt-responsive display">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (isset($clientes)) {
                                echo $clientes;
                            }
                            ?>
                        </tbody>
                    </table>




                </div>
            </div>
        </section>



        <!-- MAIN CONTENT AREA ENDS -->
    </section>
</section>
<!-- END CONTENT -->



<?php
$this->load->view('./footer');
