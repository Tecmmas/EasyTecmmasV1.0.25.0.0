<?php $this->load->view('././header'); ?>
<script type="text/javascript">
    var analizador = function () {
        th();
        var proceso = setInterval(function () {
            var trama =
                    "0|" +
                    "Transmitiendo|" +
                    _co + "|" +
                    _co2 + "|" +
                    _o2 + "|" +
                    _hc + "|" +
                    _tmp + "|" +
                    _rpm + "|" +
                    _presion + "|||100|123123";
            //console.log(trama);
            var dat = {
                trama: trama
            };
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/pruebas/utils/CanalizadorSim/setData",
                data: dat,
                type: 'post',
                success: function (rta) {
                }
            });
        }, 800);
    };
    var _co = 1.0;
    var _co2 = 7.0;
    var _o2 = 20.0;
    var _hc = 80;
    var _presion = 800;
    var _rpm = 865;
    var _tmp = 23;
    var _humedad = 45;
    var _tmpAmb = 23;
    var _conectado = 1;
    var co = function (val) {
        var data = val.getElementsByClassName("ui-label");
        _co = parseFloat(data[0].innerHTML) / 10;
    };
    var co2 = function (val) {
        var data = val.getElementsByClassName("ui-label");
        _co2 = parseFloat(data[0].innerHTML) / 10;
    };
    var o2 = function (val) {
        var data = val.getElementsByClassName("ui-label");
        _o2 = parseFloat(data[0].innerHTML) / 10;
    };
    var hc = function (val) {
        var data = val.getElementsByClassName("ui-label");
        _hc = parseFloat(data[0].innerHTML);
    };
    var presion = function (val) {
        var data = val.getElementsByClassName("ui-label");
        _presion = parseFloat(data[0].innerHTML);
    };
    var rpm = function (val) {
        var data = val.getElementsByClassName("ui-label");
        _rpm = parseFloat(data[0].innerHTML);
    };
    var tmp = function (val) {
        var data = val.getElementsByClassName("ui-label");
        _tmp = parseFloat(data[0].innerHTML);
    };
    var humedad = function (val) {
        var data = val.getElementsByClassName("ui-label");
        _humedad = parseFloat(data[0].innerHTML);
    };
    var tmpAmb = function (val) {
        var data = val.getElementsByClassName("ui-label");
        _tmpAmb = parseFloat(data[0].innerHTML);
    };
    
    var conectado = function () {
        if ($('#swconectado').prop('checked')) {
            _conectado = "1";
        } else {
            _conectado = "0";
        }
    };
    
    var fecha = function () {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/pruebas/utils/CthSim/getNow",
            type: 'post',
            async: false,
            success: function (rta) {
                _fecha = rta;
            }
        });
        return _fecha;
    };
    
    var th = function () {
        var proceso = setInterval(function () {
            var trama =
                    _tmpAmb + "|" +
                    _humedad + "|" +
                    fecha() + "|" +
                    _conectado;
            var dat = {
                trama: trama
            };
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/pruebas/utils/CthSim/setData",
                data: dat,
                type: 'post',
                success: function (rta) {
                }
            });
        }, 2000);
    };
</script>
<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>

        <div class='col-12'>
            <div class="page-title">

                <div class="float-left">
                    <!-- PAGE HEADING TAG - START --><h4 class="title">Simulador de datos</h4><!-- PAGE HEADING TAG - END -->  
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
        <!-- MAIN CONTENT AREA STARTS -->

        <div class="col-xl-12">
            <section class="box ">
                <header class="panel_header">
                    <h4 class="title float-left">Analizador de gases</h4>
                </header>
                <div class="content-body">    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Panel de control</h2>
                                </header>
                                <div class="content-body">    
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="row">
                                            <!--                                            <div class="col-6">
                                                                                            <label style="font-weight: bold;color: black" for="ip">IP<br/>
                                                                                                <input type="text" name="ip" id="ip" class="input" style="font-size: 15px;height: 37px"  size="30"  />
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="col-3">
                                                                                            <label style="font-weight: bold;color: black" for="puerto">PUERTO<br/>
                                                                                                <input type="text" name="puerto" id="puerto" class="input" style="font-size: 15px;height: 37px"  size="5"  />
                                                                                            </label>
                                                                                        </div>-->
                                            <div class="col-3">
                                                <input type="submit" onclick="analizador()" class="input" style="font-size: 15px;height: 37px" value="Iniciar"  size="5"  />
                                            </div>
                                        </div>

                                        <table>
                                            <tr>
                                                <td>
                                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                                        <div class="text-center">CoMonóxido%</div><div class="clearfix spacer20"></div>
                                                        <div id="co" onmouseup="co(this)" style='height:200px;margin:0 auto;' class="slider slider-success" data-vertical="1" data-prefix="" data-min="0" data-max="50" data-value="10"></div>
                                                    </div>            
                                                </td>
                                                <td>
                                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                                        <div class="text-center">Co2Dióxido%</div><div class="clearfix spacer20"></div>
                                                        <div id="co2" onmouseup="co2(this)" style='height:200px;margin:0 auto;' class="slider slider-warning" data-vertical="1" data-prefix="" data-min="0" data-max="500" data-value="70"></div>
                                                    </div>            
                                                </td>
                                                <td>
                                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                                        <div class="text-center">O2Oxígeno%</div><div class="clearfix spacer20"></div>
                                                        <div id="o2" onmouseup="o2(this)" style='height:200px;margin:0 auto;' class="slider slider-info" data-vertical="1" data-prefix="" data-min="0" data-max="500" data-value="200"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                                        <div class="text-center">HCHidrocarburo</div><div class="clearfix spacer20"></div>
                                                        <div id="hc" onmouseup="hc(this)" style='height:200px;margin:0 auto;' class="slider slider-danger" data-vertical="1" data-prefix="" data-min="0" data-max="1000" data-value="80"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                                        <div class="text-center">PresionPpm</div><div class="clearfix spacer20"></div>
                                                        <div id="presion" onmouseup="presion(this)" style='height:200px;margin:0 auto;' class="slider slider-accent" data-vertical="1" data-prefix="" data-min="0" data-max="1000" data-value="800"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                                        <div class="text-center">RPMInducción</div><div class="clearfix spacer20"></div>
                                                        <div id="rpm" onmouseup="rpm(this)" style='height:200px;margin:0 auto;' class="slider slider-purple" data-vertical="1" data-prefix="" data-min="0" data-max="5000" data-value="865"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                                        <div class="text-center">TempAnalizador°</div><div class="clearfix spacer20"></div>
                                                        <div id="tmp" onmouseup="tmp(this)" style='height:200px;margin:0 auto;' class="slider slider-accent" data-vertical="1" data-prefix="" data-min="0" data-max="100" data-value="23"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                                        <div class="text-center">H.Relativa%</div><div class="clearfix spacer20"></div>
                                                        <div id="humedad" onmouseup="humedad(this)" style='height:200px;margin:0 auto;' class="slider slider-info" data-vertical="1" data-prefix="" data-min="0" data-max="100" data-value="45"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                                        <div class="text-center">T.Ambiente°</div><div class="clearfix spacer20"></div>
                                                        <div id="tmpAmb" onmouseup="tmpAmb(this)" style='height:200px;margin:0 auto;' class="slider slider-warning" data-vertical="1" data-prefix="" data-min="0" data-max="100" data-value="23"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <input  id="swconectado" onchange="conectado()" tabindex="5" type="checkbox" id="minimal-checkbox-1" class="icheck-minimal-red" checked>
                                                            <label  class="icheck-label form-label" for="minimal-checkbox-1">TH Conectado</label>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </table>







<!--                                            <form action="<?php echo base_url(); ?>index.php/oficina/informes/CPrerevision" method="post">
    <p class="submit">
        <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-accent btn-block" style="background-color: #393185;width: 200px;height: 70px;border-radius: 40px 40px 40px 40px" value="Prerevisión" />
        <strong style="color: #E31F24">
                                        <?php
                                        echo $this->session->flashdata('error');
                                        ?>    
        </strong>
    </p>
</form>-->
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
$this->load->view('././footer');
