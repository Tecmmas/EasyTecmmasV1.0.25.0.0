<?php $this->load->view('./header'); ?>

<!-- START CONTENT -->

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
                                <style>
                                    .menu-barra:hover{
                                        background-color: #b2e2f2;
                                        font-size: 17px;
                                        color: whitesmoke;
                                        font-family: sans-serif;
                                        border-radius: 10px 10px 10px 10px;
                                    }
                                    #a-color{
                                        color: black;
                                    }
                                </style>
                                <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fdf9c4">
                                    <div class="collapse navbar-collapse" id="navbarText">
                                        <ul class="navbar-nav mr-auto">
                                            <li class="nav-item">
                                                <a class="nav-link menu-barra" id="a-color" href="<?php echo base_url(); ?>index.php/oficina/backup/Cbackup"><i>Backup</i></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link menu-barra" id="a-color" href="<?php echo base_url(); ?>index.php/oficina/backup/Cbackup/viewreportbackup"><i>Reporte</i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                                <header class="panel_header">
                                    <h2 class="title float-left">Reporte backup</h2>
                                </header>
                                <br>
                                <br>
                                <div class="content-body">    
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="<?php echo base_url(); ?>index.php/oficina/backup/Cbackup/reporbackup" method="post">
                                                <table class="table" >
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">Generar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="form-group mx-sm-5" style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey" for="nombres">Fecha inicial<br/>
                                                                            <input type="text" class="form-control datepicker" id="fechainicial" name="fechainicial" data-format="yyyy-mm-dd " autocomplete="off" >
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group mx-sm-5" style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey" for="nombres">Fecha final<br/>
                                                                            <input type="text" class="form-control datepicker" id="fechafinal" name="fechafinal" data-format="yyyy-mm-dd " autocomplete="off" >
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group mx-sm-4" >
                                                                        <label style="font-weight: bold; color: black"></label>
                                                                        <input type="submit" name="consultar" id="btn-generar-carder" class="btn btn-accent btn-block" onclick="showSuccess('Generando el informe, por favor espere.')" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px"  value="Generar">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
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
<?php $this->load->view('./footer'); ?>


