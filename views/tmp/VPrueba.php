<?php $this->load->view('header'); ?>
<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>

        <div class='col-12'>
            <div class="page-title">

                <div class="float-left">
                    <!-- PAGE HEADING TAG - START --><h4 class="title">PANEL DE PRUEBAS</h4><!-- PAGE HEADING TAG - END -->  
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
        <!-- MAIN CONTENT AREA STARTS -->

        <div class="col-xl-12">
            <section class="box ">
                <header class="panel_header">
                    <h4 class="title float-left">LISTADO DE PRUEBAS</h4>

                </header>
                <div class="content-body">    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <?php $this->load->view('VAlineacion'); ?>
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
