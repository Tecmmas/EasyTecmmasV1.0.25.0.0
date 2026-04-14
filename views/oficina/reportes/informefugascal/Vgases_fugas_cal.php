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

        <!-- MAIN CONTENT AREA STARTS -->
        <div class="col-xl-12">
            <section class="box ">
                <?php $this->load->view('./nav'); ?>
                <div class="content-body">  
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <section class="box ">

                                <header class="panel_header">
                                    <h2 class="title pull-left">Analizador de gases</h2>
                                </header>
                                <div class="content-body">    
                                    <div class="row">
                                        <form action="<?php echo base_url(); ?>index.php/oficina/reportes/informefugascal/Cinformes/gases_opa_data" method="post">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="field-1">Seleccione el equipo</label>
                                                    <div class="controls">
                                                        <select class="select-css" name='idmaquina' id="idmaquina">
                                                            <option disabled="disabled" selected="selected">Seleccione el equipo</option>
                                                            <?php foreach ($maquina as $item): ?>
                                                                <?php if ($item->prueba == 'analizador' && $item->activo == 1) { ?>
                                                                    <option value="<?= $item->idconf_maquina ?>"><?= $item->nombre . '-' . $item->marca . '-' . $item->serie_maquina . '-' . $item->serie_banco ?></option>
                                                                <?php }; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="field-2">Tipo de reporte</label>
                                                    <div class="controls">
                                                        <select class="select-css" name='tipo_reporte' id="tipo_reporte" disabled>
                                                            <option disabled="disabled" selected="selected">Seleccione el reporte</option>
                                                            <option value="1">Calibración</option>
                                                            <option value="2">Fugas</option>
                                                            <option value="3">Verificación</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="field-3" >Fecha</label>
                                                    <div class="controls">
                                                        <select class="select-css" name="idcontrol_fug_cal" id="fecha">
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <input type="submit" name="consultar" id="btn-generar-carder" class="btn btn-accent btn-block" onclick="showSuccess('Generando el informe, por favor espere.')" formtarget="_blank" style="background-color: #393185;border-radius: 40px 40px 40px 40px" value="Generar">
                                        </form>
                                    </div>
                            </section>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title pull-left">Opacidad</h2>
                                </header>
                                <div class="content-body">    
                                    <div class="row">
                                        <form action="<?php echo base_url(); ?>index.php/oficina/reportes/informefugascal/Cinformes/gases_opa_data" method="post">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="field-3">Seleccione el equipo</label>
                                                    <div class="controls">
                                                        <select class="select-css" name="idmaquina" id="idmaquinaopa">
                                                            <option disabled="disabled" selected="selected">Seleccione el reporte</option>
                                                            <?php foreach ($maquina as $item): ?>
                                                                <?php if ($item->prueba == 'opacidad' && $item->activo == 1) { ?>
                                                                    <option value="<?= $item->idconf_maquina ?>"><?= $item->nombre . '-' . $item->marca . '-' . $item->serie_maquina . '-' . $item->serie_banco ?></option>
                                                                <?php }; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="field-3">Tipo reporte</label>
                                                    <div class="controls">
                                                        <select class="select-css" name="tipo_reporte" id="tipo_reporte">
                                                            <option disabled="disabled" selected="selected">Seleccione el reporte</option>
                                                            <option value="4">Linealidad</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="field-3">Fecha</label>
                                                    <div class="controls">
                                                        <select class="select-css" name="fecha" id="fechalinealidad">
                                                            <option value="2020-11-22 1:13">2020-11-22 1:13</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <input type="submit" name="consultar" id="btn-generar-carder" class="btn btn-accent btn-block" onclick="showSuccess('Generando el informe, por favor espere.')" formtarget="_blank" style="background-color: #393185;border-radius: 40px 40px 40px 40px" value="Generar">
                                        </form>
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
    $('#idmaquina').change(function (ev) {
        ev.preventDefault();
//        alert('maquina')
        var idmaquina = $('#idmaquina option:selected').attr('value');
        if (typeof (Storage) !== "undefined") {
            // Store
            localStorage.setItem("idmaquina", idmaquina);
        } else {
            console.log('No se encuentra el id')
        }
        $('#tipo_reporte').prop('selectedIndex', 0);
        $('#tipo_reporte').removeAttr('disabled');
    });
    $('#tipo_reporte').change(function (ev) {
        ev.preventDefault();
        var idmaquina = localStorage.getItem('idmaquina');
        var idreporte = $('#tipo_reporte option:selected').attr('value');
        $('#fecha').empty();
//        console.log('reporte:', idreporte, 'maquina:', idmaquina)
        $.ajax({
            type: 'POST',
            url: 'Cinformes/carga_select',
            mimeType: 'json',
            data: {idreporte: idreporte,
                idmaquina: idmaquina},
            success: function (data, textStatus, jqXHR) {
                switch (idreporte) {
                    case '1':
                        $.each(data, function (i, data) {
                            var fechacal = (data.fecha);
                            var idcal = (data.idcontrol_calibracion);
                            $('#fecha').append('<option value="' + idcal + '">' + fechacal + '</option>');
                        });
                        break;
                    case '2':
                        $.each(data, function (i, data) {
                            var fechacal = (data.fecha);
                            var idcal = (data.idcontrol_fugas);
                            $('#fecha').append('<option value="' + idcal + '">' + fechacal + '</option>');
                        });
                        break;
                    case '3':
                        alert(data);
                        break;
                    default:
                        alert('Reporte no seleccionado');
                        break;
                }
//                
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
</script>
