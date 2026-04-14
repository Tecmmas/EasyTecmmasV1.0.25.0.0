<?php $this->load->view('./header'); ?>

<!-- START CONTENT -->
<style>
    .select-css {
        display: block;
        font-size: 16px;
        font-family: 'Arial', sans-serif;
        /*font-weight: 400;*/
        color: #444;
        line-height: 1.3;
        padding: .4em 1.4em .3em .8em;
        width: 190px;
        height: 35px;
        max-width: 100%; 
        box-sizing: border-box;
        margin: 0;
        border: 1px solid #aaa;
        margin-top: 10px;

        /*margin-left: 188px;*/
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
    /*
        .table-wrapper {
            width: 100%;
            height: 500px;   
            overflow: auto;
            white-space: nowrap;
        }*/
</style>
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row">
        <section class="box ">
            <?php $this->load->view('./nav'); ?>
            <div class="content-body">    
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">Informes de pruebas</h2>
                            </header>
                            <div class="content-body">  
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="1">
                                                        <div class="form-group row">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Seleccione el reporte</label>
                                                            <div class="col-sm-7">
                                                                <select class="select-css" name='tipoinforme' id="tipoinforme">
                                                                    <option disabled="disabled" selected="selected">Seleccione</option>
                                                                    <option value="1">Sonometro</option>
                                                                    <!--<option value="2">Gases</option>-->
                                                                    <option value="3">Luces</option>
                                                                    <option value="4">Frenos</option>
                                                                    <option value="5">Suspension</option>
                                                                    <option value="6">Alineador</option>
                                                                    <option value="7">Taximetro</option>
                                                                    <option value="8">Visual</option>
                                                                    <option value="9">Termohigrometro</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div id="div-informe-sonmometro" style="display: none">
                                    <div class="row">
                                        <div class="col-12">
                                            <header class="panel_header">
                                                <h2 class="title float-left" id="nombre-informe"></h2>
                                            </header>
                                            <form action="<?php echo base_url(); ?>index.php/oficina/reportes/pruebas/Cpruebas/pruebasTipo" method="post">
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
                                                                    <div class="col-md-3 col-lg-3 col-sm-3" style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey;" for="nombres">Fecha inicial<br/>
                                                                            <input type="text" class="form-control datepicker" id="fechainicial" name="fechainicial" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px">
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-3 col-lg-3 col-sm-3" style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey;" for="nombres">Fecha final<br/>
                                                                            <input type="text" class="form-control datepicker" id="fechafinal" name="fechafinal" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px" >
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-3 col-lg-3 col-sm-3" style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey" for="nombres">Tipo inspeccion<br/>
                                                                            <select class="select-css" name='tipoinspeccion' id="tipoinspeccion">
                                                                                <option value="1">Certificadas</option>
                                                                                <option value="4444">Preventivas</option>
                                                                                <option value="8888">Prueba libre</option>
                                                                            </select>
                                                                    </div>
                                                                    <div id="divPresion" class="col-md-3 col-lg-3 col-sm-3" style="margin-top: 10px; display: none">
                                                                        <label style="font-weight: bold; color: grey" for="nombres">Presion de llanatas<br/>
                                                                            <select class="select-css" name='presionLlantas' id="presionLlantas">
                                                                                <option value="0">NO</option>
                                                                                <option value="1">SI</option>
                                                                            </select>
                                                                    </div>
                                                                    <div class="col-md-3 col-lg-3 col-sm-3" >
                                                                        <label style="font-weight: bold; color: black"></label>
                                                                        <input type="hidden" id="tipoinformeval" name="tipoinformeval">
                                                                        <input type="submit" name="generar"  class="btn btn-accent btn-block" onclick="showSuccess('Generando el informe, por favor espere.')" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px"  value="Generar">
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
    $('#presionLlantas').change(function () {
        var presionLlantas = $('#presionLlantas option:selected').attr('value');
        if (presionLlantas == 1) {
            Swal.fire({
                icon: 'info',
                title: 'Información',
                html: '<div style="font-size: 15px">Usted selecciono la consulta con las presiones de inflado, se le recomienda no realizar la consulta cuando el cda este operando.</div>',
                //footer: '<a href="">Why do I have this issue?</a>'
            })
        }
    })
    $('#tipoinforme').change(function () {
        var tipoinforme = $('#tipoinforme option:selected').attr('value');
        $('#tipoinformeval').val(tipoinforme);
        document.getElementById("div-informe-sonmometro").style.display = '';
        switch (tipoinforme) {
            case '1':
                $('#nombre-informe').html('Informe sonometro');
                document.getElementById("divPresion").style.display = "none";
                break;
            case '2':
                $('#nombre-informe').html('Informe gases');
                document.getElementById("divPresion").style.display = "none";
                break;
            case '3':
                $('#nombre-informe').html('Informe luces');
                document.getElementById("divPresion").style.display = "none";
                break;
            case '4':
                $('#nombre-informe').html('Informe frenos');
                document.getElementById("divPresion").style.display = "none";
                break;
            case '5':
                $('#nombre-informe').html('Informe suspension');
                document.getElementById("divPresion").style.display = "none";
                break;
            case '6':
                $('#nombre-informe').html('Informe alineador');
                document.getElementById("divPresion").style.display = "none";
                break;
            case '7':
                $('#nombre-informe').html('Informe taximetro');
                document.getElementById("divPresion").style.display = "none";
                break;
            case '8':
                $('#nombre-informe').html('Informe visual');
                document.getElementById("divPresion").style.display = "";
                break;
            case '9':
                $('#nombre-informe').html('Informe termohigrometro');
                document.getElementById("divPresion").style.display = "none";
                break;
            default:

                break;
        }
    });
</script>