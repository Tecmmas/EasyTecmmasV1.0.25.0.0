<?php $this->load->view('./header'); ?>
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>

        <div class='col-12'>
            <div class="page-title">

                <div class="float-left">
                    <!-- PAGE HEADING TAG - START --><h4 class="title">GESTION DE USUARIOS</h4><!-- PAGE HEADING TAG - END -->  
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
        <!-- MAIN CONTENT AREA STARTS -->
        <section class="box ">
            <header class="panel_header">
                <h2 class="title pull-left">USUARIOS REGISTRADOS</h2>
            </header>
            <div class="content-body"> 

                <table style="width: 100%;text-align: left">
                    <tr>
                        <td style="text-align: left;width: 200px">
                            <form action="<?php echo base_url(); ?>index.php/oficina/usuarios/Cusuarios/getUsuarios" method="post" style="width: 100%">
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
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Perfil</th>
                                <th>Identificacion</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Perfil</th>
                                <th>Identificacion</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($usuarios as $value): ?>
                                <tr>
                                    <td><?= $value->nombres ?></td>
                                    <td><?= $value->apellidos ?></td>
                                    <td><?= $value->perfil ?></td>
                                    <td><?= $value->identificacion ?></td>
                                    <td><?= $value->estado ?></td>
                                    <td><form action='<?php echo base_url(); ?>index.php/oficina/usuarios/Cusuarios/getUsuarios' method='post'>
                                            <input name='idusuario' type='hidden' value='<?= $value->IdUsuario ?>'>
                                            <input name='button' class='btn btn-block'  style='width: content-box;
                                                   border-radius: 10px 10px 10px 10px;
                                                   background: whitesmoke;
                                                   border: solid gold;
                                                   color: black' type='submit' value='Ver/Editar' />   
                                        </form>
                                    </td> 
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- MAIN CONTENT AREA ENDS -->
    </section>
</section>
<?php $this->load->view('./footer'); ?>