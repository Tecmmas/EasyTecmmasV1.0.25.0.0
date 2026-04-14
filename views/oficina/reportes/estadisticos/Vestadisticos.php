<?php $this->load->view('./header'); ?>

<!-- START CONTENT -->
<style>
    .select-css {
        display: block;
        font-size: 16px;
        font-family: 'Arial', sans-serif;
        font-weight: 400;
        color: #444;
        line-height: 1.3;
        padding: .4em 1.4em .3em .8em;
        width: 450px;
        max-width: 100%; 
        box-sizing: border-box;
        margin: 0;
        border: 1px solid #aaa;
        box-shadow: 0 1px 0 1px rgba(0,0,0,.03);
        border-radius: .3em;
        -moz-appearance: none;
        -webkit-appearance: none;
        appearance: none;
        background-color: #fff;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'),
            linear-gradient(to bottom, #ffffff 0%,#f7f7f7 100%);
        background-repeat: no-repeat, repeat;
        background-position: right .7em top 50%, 0 0;
        background-size: .65em auto, 100%;
    }
    .select-css::-ms-expand {
        display: none;
    }
    .select-css:hover {
        border-color: #888;
    }
    .select-css:focus {
        border-color: #aaa;
        box-shadow: 0 0 1px 3px rgba(59, 153, 252, .7);
        box-shadow: 0 0 0 3px -moz-mac-focusring;
        color: #222; 
        outline: none;
    }
    .select-css option {
        font-weight:normal;
    }
</style>
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
                <?php $this->load->view('./nav'); ?>
                <div class="content-body">    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <section class="box ">

                                <header class="panel_header">
                                    <h2 class="title float-left">Informes Estadisticos</h2>
                                </header>
                                <div class="content-body">    
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="<?php echo base_url(); ?>index.php/oficina/reportes/estadisticos/Cestadisticos/getReporte" method="post">
                                                <table class="table" >
                                                    <thead>
                                                        <tr>
                                                            <th colspan="1">
                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Seleccione el reporte</label>
                                                                    <div class="col-sm-7">
                                                                        <select class="select-css" name='idreporte' id="idreporte">
                                                                            <option disabled="disabled" selected="selected">Seleccione el reporte</option>
                                                                            <option value="1">Lista de defectos</option>
                                                                            <option value="2">Facturacion diaria</option>
                                                                            <option value="3">Inspecciones por defecto</option>
                                                                            <option value="4">Resumen diario de servicio</option>
                                                                            <!--<option value="5">Mapa de servicios entre fechas</option>-->
                                                                            <option value="6">Lista de defectos por inspector</option>
                                                                            <option value="7">Inspector/categoria descriminada</option>
                                                                            <option value="8">Lista de provisiones de servicios</option>
                                                                            <option value="9">Aprobados rechazados por año de matricula</option>
                                                                            <option value="10">Clientes adquiridos,perdidos y retornados</option>
                                                                            <option value="11">Informe cambio contraseña</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody >
                                                        <tr>
                                                            <td>
                                                                <div class="row" id="databody" style="display: none">
                                                                    <div class="form-group mx-sm-4" style="margin-top: 10px; display: none" id="fechaperdidos">
                                                                        <label style="font-weight: bold; color: grey" for="nombres">Fecha perdidos<br/>
                                                                            <input type="text" class="form-control datepicker" id="fechaperdidos" name="fechaperdidos" data-format="yyyy-mm-dd " autocomplete="off" >
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group mx-sm-4" style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey" for="nombres">Fecha inicial<br/>
                                                                            <input type="text" class="form-control datepicker" id="fechainicial" name="fechainicial" data-format="yyyy-mm-dd " autocomplete="off" >
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group mx-sm-4" style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey" for="nombres">Fecha final<br/>
                                                                            <input type="text" class="form-control datepicker" id="fechafinal" name="fechafinal" data-format="yyyy-mm-dd " autocomplete="off" >
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group mx-sm-4" >
                                                                        <label style="font-weight: bold; color: black"></label>
                                                                        <input type="submit" formtarget="_blank" name="consultar" id="btn-generar-confpassword" class="btn btn-accent btn-block" onclick="showSuccess('Generando el informe, por favor espere.')" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px"  value="Generar">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mx-sm-10" id="btn-genera-report" style="display: none">
                                                                    <label style="font-weight: bold; color: black"></label>
                                                                    <input type="submit" formtarget="_blank" name="consultar" id="btn-generar" class="btn btn-accent btn-block" onclick="showSuccess('Generando el informe, por favor espere.')" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 100%"  value="Generar">
                                                                </div>
                                                                <div class="form-group row" id="divpassword" style="display: none">
                                                                    <label for="staticEmail" class="col-sm-4 col-form-label" style="font-weight: bold; color: grey">Ingrese la clave</label>
                                                                    <input type="password" class="mx-sm-4" id="password" onkeyup="validarcontra()">
                                                                    <div style="color: #E31F24" id="divconfcontra"></div>
                                                                </div>

                                                                <div>El tiempo de generación de estos informes puede variar, según el intervalo de tiempo y la cantidad de datos (en algunos casos puede demoras hasta 5 minutos).</div>
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
<script type="text/javascript">
    $('#idreporte').change(function () {
        var idreporte = $('#idreporte option:selected').attr('value');
        if (idreporte == 1) {
            habilitarComponentes();
        } else if (idreporte == 2) {
            deshabilitarComponentes();
            campopassword();
        } else if (idreporte == 10) {
            fechaperdidos();
        } else {
            deshabilitarComponentes();
        }

    });
    function habilitarComponentes() {
        document.getElementById("databody").style.display = 'none';
        document.getElementById("btn-genera-report").style.display = '';
        document.getElementById("divpassword").style.display = 'none';
        document.getElementById("fechaperdidos").style.display = 'none';
        $('#divconfcontra').html('');
    }
    function deshabilitarComponentes() {
        document.getElementById("databody").style.display = '';
        document.getElementById("btn-genera-report").style.display = 'none';
        document.getElementById("divpassword").style.display = 'none';
        document.getElementById("fechaperdidos").style.display = 'none';
        document.getElementById("btn-generar-confpassword").disabled = false;
        $('#divconfcontra').html('');

    }
    function campopassword() {
        document.getElementById("divpassword").style.display = '';
        document.getElementById("btn-generar-confpassword").disabled = true;
    }
    function validarcontra() {
        var contralocal = '**tecmmas**123';
        var inputcontra = $('#password').val()
        if (contralocal === inputcontra) {
            $('#divconfcontra').html('La contraseña es correcta');
            document.getElementById("btn-generar-confpassword").disabled = false;
        } else {
            $('#divconfcontra').html('La contraseña es incorrecta');
            document.getElementById("btn-generar-confpassword").disabled = true;
        }
    }
    function fechaperdidos() {
        document.getElementById("fechaperdidos").style.display = '';
        document.getElementById("divpassword").style.display = 'none';
        document.getElementById("btn-generar-confpassword").disabled = false;
    }
</script>


