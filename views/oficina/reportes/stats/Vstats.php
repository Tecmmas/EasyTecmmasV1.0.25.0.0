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
        box-shadow: 0 1px 0 1px rgba(0, 0, 0, .03);
        border-radius: .3em;
        -moz-appearance: none;
        -webkit-appearance: none;
        appearance: none;
        background-color: #fff;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'),
            linear-gradient(to bottom, #ffffff 0%, #f7f7f7 100%);
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
        font-weight: normal;
    }

    .table-wrapper {
        /*width: 100%;*/
        height: 500px;
        overflow: auto;
        white-space: nowrap;

    }

    .toast-custom {
        z-index: 99999 !important;
    }

    .swal2-container {
        z-index: 999999 !important;
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
                        <div class="col-lg-12 col-md-12 col-12">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Informes de stats</h2>
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
                                                                    <select class="select-css" name='idreportstats' id="idreportstats">
                                                                        <option disabled="disabled" selected="selected">Seleccione</option>
                                                                        <option value="1">Vehiculos</option>
                                                                        <option value="2">Certificados</option>
                                                                        <option value="3">Calibraciones</option>
                                                                        <option value="4">Crm</option>
                                                                        <option value="5">Bitacoras</option>
                                                                        <option value="6">Informe pesv</option>
                                                                        <option value="7">Pruebas</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!--informe pruebas-->
                                <div style="display: none" id="div-report-pruebas">
                                    <div class="content-body">
                                        <header class="panel_header">
                                            <div style="float: left; font-size: 1.57em">Informe Vehiculos</div>
                                            <div style="color: red; text-align: center;">
                                                <input type="submit" name="consultar" onclick="limpiarform()" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke;" value="Limpiar campos">
                                            </div>
                                        </header>
                                        <div class="row">
                                            <div class="col-12">
                                                <form id="form-statspruebas">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Servicio
                                                                            <select class="select-css" id="sel-serviciop" name="sel-serviciop">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($servicio as $value): ?>
                                                                                    <option value="<?= $value->idservicio ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Clase
                                                                            <select class="select-css" id="sel-clasep" name="sel-clasep">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($clase as $value): ?>
                                                                                    <option value="<?= $value->idclase ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Marca
                                                                            <select class="select-css" name="sel-marcap" id="sel-marcap">
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                <?php foreach ($marca as $value): ?>
                                                                                    <option value="<?= $value->idmarcaR ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Linea
                                                                            <select class="select-css" name="sel-lineap" id="sel-lineap" disabled>
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <!--                                                                <td>
                                                                    <div  style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tipo prueba
                                                                            <select class="select-css" id="sel-tipopruebap" name="sel-tipopruebap" >
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                <option value="1">Luxometro</option>
                                                                                <option value="2">Opacimetro</option>
                                                                                <option value="3">Analizador de gases</option>
                                                                                <option value="4">Sonometro</option>
                                                                                <option value="5">Camara</option>
                                                                                <option value="6">Taximetro</option>
                                                                                <option value="7">Frenometro</option>
                                                                                <option value="8">Visual</option>
                                                                                <option value="9">Suspension</option>
                                                                                <option value="10">Alineador</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>-->
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Usuarios
                                                                            <select class="select-css" id="sel-operariop" name="sel-operariop">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($usuarios as $value): ?>
                                                                                    <?php if ($value->idperfil !== '2') { ?>
                                                                                        <option value="<?= $value->IdUsuario ?>"><?= $value->nombres ?></option>
                                                                                    <?php } ?>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <!--                                                                <td>
                                                                    <div  style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Estado de prueba
                                                                            <select class="select-css" id="sel-estado-pruebas-p" name="sel-estado-pruebas-p" >
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                <option value="0">Asignado</option>
                                                                                <option value="1">Rechazado</option>
                                                                                <option value="2">Aprobado</option>
                                                                                <option value="3">Reasignado</option>
                                                                                <option value="5">Abortado</option>
                                                                                <option value="9">Reasignado Individual</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>-->

                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tipo inpección
                                                                            <select class="select-css" id="sel-reinpeccionp" name="sel-reinpeccionp">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <option value="0">Tec-1ra</option>
                                                                                <option value="1">Tec-Reins</option>
                                                                                <option value="4444">Prev-1ra</option>
                                                                                <option value="44441">Prev-Reins</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Estado final
                                                                            <select class="select-css" id="sel-estadop" name="sel-estadop">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <option value="2">Aprobado</option>
                                                                                <option value="4">Certificado</option>
                                                                                <option value="3">Rechazado</option>
                                                                                <option value="5">Abortado</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tipo Vehicúlo
                                                                            <select class="select-css" id="sel-tipo-vehiculop" name="sel-tipo-vehiculop">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($tipov as $value): ?>
                                                                                    <option value="<?= $value->idtipo_vehiculo ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Combustible
                                                                            <select class="select-css" id="sel-combustiblep" name="sel-combustiblep">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($combustible as $value): ?>
                                                                                    <option value="<?= $value->idtipocombustible ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tiempos
                                                                            <select class="select-css" id="sel-tiemposp" name="sel-tiemposp">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <option value="2">2 tiempos</option>
                                                                                <option value="4">4 tiempos</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr>



                                                                <td>
                                                                    <div style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey; align-content: center " for="nombres">Fecha inicial
                                                                            <input type="text" class="form-control datepicker" id="fechainicialp" name="fechainicialp" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Fecha final
                                                                            <input type="text" class="form-control datepicker" id="fechafinalp" name="fechafinalp" data-format="yyyy-mm-dd" autocomplete="off" style="margin-top: 10px">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 40px">
                                                                        <label style="font-weight: bold; color: black; align-content: center"></label>
                                                                        <input type="submit" name="consultar" id="btn-generar-statspruebas" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke;" value="Generar">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div id="valid-dato-p" style="color: red"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: none" id="div-pruebas">
                                    <div class="content-body">
                                        <br>
                                        <header class="panel_header">
                                            <div style="float: left; font-size: 1.57em">Informe Pruebas</div>
                                            <div style="color: red; text-align: center;">
                                                <input type="submit" name="consultar" onclick="limpiarform()" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke;" value="Limpiar campos">
                                            </div>
                                        </header>
                                        <div class="row">
                                            <div class="col-12">
                                                <form id="form-statspruebas-data">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Servicio
                                                                            <select class="select-css" id="sel-serviciopruebas" name="sel-serviciop">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($servicio as $value): ?>
                                                                                    <option value="<?= $value->idservicio ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Clase
                                                                            <select class="select-css" id="sel-clasepruebas" name="sel-clasep">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($clase as $value): ?>
                                                                                    <option value="<?= $value->idclase ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Marca
                                                                            <select class="select-css" name="sel-marcap" id="sel-marcapruebas">
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                <?php foreach ($marca as $value): ?>
                                                                                    <option value="<?= $value->idmarcaR ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Linea
                                                                            <select class="select-css" name="sel-lineap" id="sel-lineapruebas" disabled>
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tipo prueba
                                                                            <select class="select-css" id="sel-tipopruebapruebas" name="sel-tipopruebap">
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                <option value="1">Luxometro</option>
                                                                                <option value="2">Opacimetro</option>
                                                                                <option value="3">Analizador de gases</option>
                                                                                <option value="4">Sonometro</option>
                                                                                <option value="5">Camara</option>
                                                                                <option value="6">Taximetro</option>
                                                                                <option value="7">Frenometro</option>
                                                                                <option value="8">Visual</option>
                                                                                <option value="9">Suspension</option>
                                                                                <option value="10">Alineador</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Usuarios
                                                                            <select class="select-css" id="sel-operariopruebas" name="sel-operariop">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($usuarios as $value): ?>
                                                                                    <option value="<?= $value->IdUsuario ?>"><?= $value->nombres ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Estado de prueba
                                                                            <select class="select-css" id="sel-estado-pruebas" name="sel-estado-pruebas-p">
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                <option value="0">Asignado</option>
                                                                                <option value="1">Rechazado</option>
                                                                                <option value="2">Aprobado</option>
                                                                                <option value="3">Reasignado</option>
                                                                                <option value="5">Abortado</option>
                                                                                <option value="9">Reasignado Individual</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tipo inpección
                                                                            <select class="select-css" id="sel-reinpeccionpruebas" name="sel-reinpeccionp">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <option value="0">Tec-1ra</option>
                                                                                <option value="1">Tec-Reins</option>
                                                                                <option value="4444">Prev-1ra</option>
                                                                                <option value="44441">Prev-Reins</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Estado final
                                                                            <select class="select-css" id="sel-estadopruebas" name="sel-estadop">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <option value="2">Aprobado</option>
                                                                                <option value="4">Certificado</option>
                                                                                <option value="3">Rechazado</option>
                                                                                <option value="5">Abortado</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tipo Vehicúlo
                                                                            <select class="select-css" id="sel-tipo-vehiculopruebas" name="sel-tipo-vehiculop">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($tipov as $value): ?>
                                                                                    <option value="<?= $value->idtipo_vehiculo ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>



                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tiempos
                                                                            <select class="select-css" id="sel-tiempospruebas" name="sel-tiemposp">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <option value="2">2 tiempos</option>
                                                                                <option value="4">4 tiempos</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Combustible
                                                                            <select class="select-css" id="sel-combustiblepruebas" name="sel-combustiblep">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($combustible as $value): ?>
                                                                                    <option value="<?= $value->idtipocombustible ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey; align-content: center " for="nombres">Fecha inicial
                                                                            <input type="text" class="form-control datepicker" id="fechainicialpruebas" name="fechainicialp" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Fecha final
                                                                            <input type="text" class="form-control datepicker" id="fechafinalpruebas" name="fechafinalp" data-format="yyyy-mm-dd" autocomplete="off" style="margin-top: 10px">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 40px">
                                                                        <label style="font-weight: bold; color: black; align-content: center"></label>
                                                                        <input type="submit" name="consultar" id="btn-generar-stats-pruebasruebas" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke;" value="Generar">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div id="valid-dato-pruebas" style="color: red"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <section class="box" style="display: none" id="sec-info-statspruebas">
                                    <div class="content-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <br>
                                                <div class="form-group row">
                                                    <input type="submit" name="consultar" id="btn-descargar-statspruebas" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke" value="Descargar">
                                                    <div id="div-info-statspruebas" class="mx-sm-4" style="text-align: right"></div>
                                                </div>
                                                <br>
                                                <div class="table-wrapper">
                                                    <table class="table-bordered" id="table-statspruebas">
                                                        <thead id="head-stats-pruebas">

                                                        </thead>
                                                        <tbody id="body-reg-statspruebas">

                                                        </tbody>
                                                    </table>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!--fin informe pruebas-->
                                <!--inicio informe certificados-->
                                <div style="display: none" id="div-report-certificados">
                                    <div class="content-body">
                                        <header class="panel_header">
                                            <div style="float: left; font-size: 1.57em">Informe Certificados</div>
                                            <div style="color: red; text-align: center;">
                                                <input type="submit" name="consultar" onclick="limpiarform()" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke;" value="Limpiar campos">
                                            </div>
                                        </header>
                                        <div class="row">
                                            <div class="col-12">
                                                <form id="form-statscertificados">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <label style="font-weight: bold; color: grey; align-content: center;margin-top: 10px" for="nombres">Placa</label>
                                                                    <div style="margin-top: 5px;">
                                                                        <input type="text" class="input" id="input-placa-c" style="height: 31px; width: 190px; text-transform: uppercase">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Clase
                                                                            <select class="select-css" id="sel-clasec" name="sel-clasec">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($clase as $value): ?>
                                                                                    <option value="<?= $value->idclase ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Marca
                                                                            <select class="select-css" name="sel-marcac" id="sel-marcac">
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                <?php foreach ($marca as $value): ?>
                                                                                    <option value="<?= $value->idmarcaR ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Linea
                                                                            <select class="select-css" name="sel-lineac" id="sel-lineac" disabled>
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Servicio
                                                                            <select class="select-css" id="sel-servicioc" name="sel-servicioc">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($servicio as $value): ?>
                                                                                    <option value="<?= $value->idservicio ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tipo inpección
                                                                            <select class="select-css" id="sel-reinpeccionc" name="sel-reinpeccionc">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <option value="0">Tec-1ra</option>
                                                                                <option value="1">Tec-Reins</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Estado final
                                                                            <select class="select-css" id="sel-estadoc" name="sel-estadoc">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <option value="4">Certificado</option>
                                                                                <option value="3">Rechazado</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tipo Vehicúlo
                                                                            <select class="select-css" id="sel-tipo-vehiculoc" name="sel-tipo-vehiculoc">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($tipov as $value): ?>
                                                                                    <option value="<?= $value->idtipo_vehiculo ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Combustible
                                                                            <select class="select-css" id="sel-combustiblec" name="sel-combustiblec">
                                                                                <option selected="selected">Seleccionar</option>
                                                                                <?php foreach ($combustible as $value): ?>
                                                                                    <option value="<?= $value->idtipocombustible ?>"><?= $value->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <div style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey; align-content: center " for="nombres">Fecha inicial
                                                                            <input type="text" class="form-control datepicker" id="fechainicialc" name="fechainicialc" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Fecha final
                                                                            <input type="text" class="form-control datepicker" id="fechafinalc" name="fechafinalc" data-format="yyyy-mm-dd" autocomplete="off" style="margin-top: 10px">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 40px">
                                                                        <label style="font-weight: bold; color: black; align-content: center"></label>
                                                                        <input type="submit" name="consultar" id="btn-generar-statscertificados" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke;" value="Generar">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div id="valid-dato-c" style="color: red"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <section class="box" style="display: none" id="sec-info-statscertificados">
                                    <div class="content-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <br>
                                                <div class="form-group row">
                                                    <input type="submit" name="consultar" id="btn-descargar-statscertificados" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke" value="Descargar">
                                                    <div id="div-info-statscertificados" class="mx-sm-4" style="text-align: right"></div>
                                                </div>
                                                <br>
                                                <div class="table-wrapper">
                                                    <table class="table-bordered" id="table-statscertificados">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-size: 13px; text-align: center;">Fecha</th>
                                                                <th style="font-size: 13px; text-align: center;">Placa</th>
                                                                <th style="font-size: 13px; text-align: center;">Numero fur</th>
                                                                <th style="font-size: 13px; text-align: center;">Numero certificado</th>
                                                                <th style="font-size: 13px; text-align: center;">Consecutivo runt</th>
                                                                <th style="font-size: 13px; text-align: center;">Consecutivo rechazo</th>
                                                                <th style="font-size: 13px; text-align: center;">Factura</th>
                                                                <th style="font-size: 13px; text-align: center;">Fecha impresion</th>
                                                                <th style="font-size: 13px; text-align: center;">Fecha vigencia</th>
                                                                <th style="font-size: 13px; text-align: center;">Ingeniero Pista</th>
                                                                <th style="font-size: 13px; text-align: center;">Nombre operario</th>
                                                                <th style="font-size: 13px; text-align: center;">Nombres cliente</th>
                                                                <th style="font-size: 13px; text-align: center;">Nombres propietario</th>
                                                                <th style="font-size: 13px; text-align: center;">Documento</th>
                                                                <th style="font-size: 13px; text-align: center;">Direccion</th>
                                                                <th style="font-size: 13px; text-align: center;">Correo</th>
                                                                <th style="font-size: 13px; text-align: center;">Telefono</th>
                                                                <th style="font-size: 13px; text-align: center;">Marca</th>
                                                                <th style="font-size: 13px; text-align: center;">Linea</th>
                                                                <th style="font-size: 13px; text-align: center;">Color</th>
                                                                <th style="font-size: 13px; text-align: center;">Estado final</th>
                                                                <th style="font-size: 13px; text-align: center;">Ocacion</th>
                                                                <th style="font-size: 13px; text-align: center;">Clase</th>
                                                                <th style="font-size: 13px; text-align: center;">Servicio</th>
                                                                <th style="font-size: 13px; text-align: center;">Combustible</th>
                                                                <th style="font-size: 13px; text-align: center;">Modelo</th>
                                                                <th style="font-size: 13px; text-align: center;">Cilindraje</th>
                                                                <th style="font-size: 13px; text-align: center;">Tipo Vehiculo</th>
                                                                <th style="font-size: 13px; text-align: center;">Numero motor</th>
                                                                <th style="font-size: 13px; text-align: center;">Numero vin</th>
                                                                <th style="font-size: 13px; text-align: center;">Numero serie</th>
                                                                <th style="font-size: 13px; text-align: center;">Scooter</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="body-reg-statscertificados">

                                                        </tbody>
                                                    </table>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!--fin informe certificados-->
                                <!--inicio calibraciones-->
                                <div style="display: none" id="div-report-calibraciones">
                                    <div class="content-body">
                                        <header class="panel_header">
                                            <div class="title float-left" style="font-size: 1.57em">Informe Calibraciones</div>
                                            <div class="title float-center" style="color: red; text-align: center;">
                                                <input type="submit" name="consultar" onclick="limpiarform()" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; margin-left:  180px" value="Limpiar campos">
                                            </div>
                                            <div class="title float-right" style="margin-right: 30px">
                                                <?php if ($tipoinforme == "NA") { ?>
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                Tipo informe
                                                            </tr>
                                                            <tr>
                                                                <select id="sel-tipo-informe-fugas-cal">
                                                                    <option value="0">Gases Anterior</option>
                                                                    <option value="1">Gases Nuevo</option>
                                                                </select>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                <?php } ?>
                                            </div>
                                        </header>
                                        <div class="row">
                                            <div class="col-12">
                                                <form id="form-statscalibraciones">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Analizadores
                                                                            <select class="select-css" id="sel-analizador" name="sel-analizador">
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                <?php foreach ($maquina as $item): ?>
                                                                                    <?php if ($item->prueba == 'analizador' && $item->activo == 1): ?>
                                                                                        <option value="<?= $item->idconf_maquina ?>"><?= $item->nombre . '-' . $item->marca . $item->serie_maquina . '-' . $item->serie_banco ?></option>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tipo reporte gases
                                                                            <select class="select-css" id="sel-tipo-reporte" name="sel-tipo-reporte">
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                <option value="1">Calibracion</option>
                                                                                <option value="2">Fugas</option>
                                                                                <option value="4">Log prueba gases</option>

                                                                                <option value="3" id="option-verificacion">Verificacion</option>


                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Opacimetros
                                                                            <select class="select-css" id="sel-opacidad" name="sel-opacidad">
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                <?php foreach ($maquina as $item): ?>
                                                                                    <?php if ($item->prueba == 'opacidad' && $item->activo == 1): ?>
                                                                                        <option value="<?= $item->idconf_maquina ?>"><?= $item->nombre . '-' . $item->marca . $item->serie_maquina . '-' . $item->serie_banco ?></option>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>

                                                                <td id="tr-reporte-opacidad">
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tipo reporte opacidad
                                                                            <select class="select-css" id="sel-tipo-reporte-opacidad" name="sel-tipo-reporte-opacidad">
                                                                                <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                <option value="1">Linealidad</option>
                                                                                <option value="2">Control Cero</option>
                                                                                <option value="3">Tiempo pruebas</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey; align-content: center " for="nombres">Fecha inicial
                                                                            <input type="text" class="form-control datepicker" id="fechainicialca" name="fechainicialca" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Fecha final
                                                                            <input type="text" class="form-control datepicker" id="fechafinalca" name="fechafinalca" data-format="yyyy-mm-dd" autocomplete="off" style="margin-top: 10px">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 40px">
                                                                        <label style="font-weight: bold; color: black; align-content: center"></label>
                                                                        <input type="submit" name="consultar" data="opaciemtro" id="btn-generar-statscalibraciones" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke;" value="Generar">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div id="valid-dato-ca" style="color: red"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <section class="box" style="display: none" id="sec-info-statscalibraciones">
                                    <div class="content-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-wrapper" id="table-calibraciones" style="display: none">
                                                    <div class="form-group row">
                                                        <div style="float: left; font-size: 1.57em; margin-left: 15px">Resultados</div>
                                                        <input type="submit" name="consultar" id="btn-descargar-statscalibraciones" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; margin-left: 50px" value="Descargar">
                                                    </div>
                                                    <br>
                                                    <table class="table-bordered" id="table-statscalibraciones">
                                                        <thead id="head-reg-statscalibraciones">

                                                        </thead>
                                                        <tbody id="body-reg-statscalibraciones">

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style="white-space: normal; height: 400px; overflow: auto; display: none" id="table-verificacion">
                                                    <div class="form-group row">
                                                        <div style="float: left; font-size: 1.57em; margin-left: 15px">Resultados</div>
                                                        <input type="submit" name="consultar" id="btn-descargar-table-verificacion" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; margin-left: 50px" value="Descargar">
                                                    </div>
                                                    <br>
                                                    <table class="table" id="table-statsverificacion">
                                                        <thead id="head-reg-statsverificacion">

                                                        </thead>
                                                        <tbody id="body-reg-statsverificacion">

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br>
                                                <div style="display: none" id="sec-info-resultadosverificacion">
                                                    <div class="form-group row">
                                                        <div style="float: left; font-size: 1.57em;">Resultados</div>
                                                        <input type="submit" name="consultar" id="btn-descargar-verificaciones" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; margin-left: 50px" value="Descargar">
                                                    </div>
                                                    <br>
                                                    <div style="white-space: normal; height: 500px; overflow: auto;">
                                                        <table class="table" id="table-stats-verificacion">
                                                            <thead id="head-reg-stats-verifricacion">
                                                                <tr>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="body-stats-verifricacion">

                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                                <div style="display: none" id="sec-info-resultados-opa">
                                                    <div class="form-group row">
                                                        <div style="float: left; font-size: 1.57em;">Resultados</div>
                                                        <input type="submit" name="consultar" id="btn-descargar-stats-resultados-opa" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; margin-left: 50px" value="Descargar">
                                                    </div>
                                                    <br>
                                                    <div style="white-space: normal; height: 500px; overflow: auto;">
                                                        <table class="table" id="table-stats-verificacion-opa">
                                                            <thead>

                                                                <tr>
                                                                    <th>Placa</th>
                                                                    <th>Marca software</th>
                                                                    <th>Version software</th>
                                                                    <th>Cda</th>
                                                                    <th>Nit</th>
                                                                    <th>Marca</th>
                                                                    <th>Modelo</th>
                                                                    <th>Serial</th>
                                                                    <th>Fecha y hora</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td id="thPlaca"></td>
                                                                    <td id="thMarcaSoftware"></td>
                                                                    <td id="thVersionSoftware"></td>
                                                                    <td id="thCda"></td>
                                                                    <td id="thNit"></td>
                                                                    <td id="thMarca"></td>
                                                                    <td id="thModelo"></td>
                                                                    <td id="thSerial"></td>
                                                                    <td id="thFechaHora"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="8">
                                                                        <!-- Tabla anidada -->
                                                                        <table class="table">
                                                                            <thead>

                                                                                <tr id="tr-resultados-opa">

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="body-stats-verifricacion-opa">

                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>



                                                    </div>
                                                </div>
                                                <div style="display: none; " id="sec-info-resultadoslog">
                                                    <div class="form-group row">
                                                        <div style="float: left; font-size: 1.57em;">Resultados</div>
                                                        <input type="submit" name="consultar" id="btn-descargar-logs" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; margin-left: 50px" value="Descargar">
                                                    </div>
                                                    <br>
                                                    <div style="white-space: normal; height: 500px; overflow: auto;">
                                                        <table class="table" id="table-stats-logs">
                                                            <thead id="headLogPruebas">

                                                            </thead>
                                                            <tbody id="body-stats-logs">

                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!--fin calibraciones-->
                                <!-- Inicio informe crm-->
                                <div style="display: none" id="div-report-cmr">
                                    <header class="panel_header">
                                        <h2 class="title float-left">Informe Crm</h2>
                                    </header>
                                    <div class="content-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div style="margin-top: 10px;">
                                                                    <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Seleccione tipo de inspeccion
                                                                        <select class="select-css" id="tipoinspeccion" name='tipoi'>
                                                                            <option value="1">Certificadas</option>
                                                                            <option value="2">Preventivas</option>
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div style="margin-top: 10px;">
                                                                    <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Seleccione tipo de servicio
                                                                        <select class="select-css" id="tiposervicio" name='tipov'>
                                                                            <option value="1">Todos</option>
                                                                            <option value="2">Público</option>
                                                                            <option value="3">Particular</option>
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td id="numero-meses" style="display: none">
                                                                <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Seleccione meses de vencimiento
                                                                    <select class="select-css" id="selectmeses">
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                        <option value="11">11</option>
                                                                        <option value="12">12</option>
                                                                    </select>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                            <td>
                                                                <div style="margin-top: 10px">
                                                                    <label style="font-weight: bold; color: grey; " for="nombres">Fecha inicial<br />
                                                                        <input type="text" class="form-control datepicker" id="fechainicial" name="fechainicial" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px">
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div style="margin-top: 10px">
                                                                    <label style="font-weight: bold; color: grey" for="nombres">Fecha final<br />
                                                                        <input type="text" class="form-control datepicker" id="fechafinal" name="fechafinal" data-format="yyyy-mm-dd" autocomplete="off" style="margin-top: 10px">
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div style="text-align: center">
                                                    <label style="font-weight: bold; color: black"></label>
                                                    <input type="hidden" id="get-fecha" value="<?= $fecha ?>">
                                                    <input type="submit" name="consultar" id="btn-generar-crm" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke" value="Generar">
                                                </div>
                                                <br>
                                                <div id="valid-dato" style="color: red"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="box" style="display: none" id="sec-info-report">
                                <div class="content-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <br>
                                            <div class="form-group row">
                                                <input type="submit" name="consultar" id="btn-descargar-crm" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke" value="Descargar">
                                                <div id="div-info" class="mx-sm-4" style="text-align: right"></div>
                                            </div>

                                            <br>
                                            <div class="table-wrapper">
                                                <table class="table-bordered" id="table-crm">
                                                    <thead>
                                                        <tr>
                                                            <th style="font-size: 13px; text-align: center;">Placa</th>
                                                            <th style="font-size: 13px; text-align: center;">Tipo</th>
                                                            <th style="font-size: 13px; text-align: center;">Cilindraje</th>
                                                            <th style="font-size: 13px; text-align: center;">Certificado</th>
                                                            <th style="font-size: 13px; text-align: center;">Fecha&nbsp;impresion</th>
                                                            <th style="font-size: 13px; text-align: center;">Fecha&nbsp;vigencia</th>
                                                            <th style="font-size: 13px; text-align: center;">Soat</th>
                                                            <th style="font-size: 13px; text-align: center;">Indentificación</th>
                                                            <th style="font-size: 13px; text-align: center;">Nombre&nbsp;clientes</th>
                                                            <th style="font-size: 13px; text-align: center;">Telefono&nbsp;1</th>
                                                            <th style="font-size: 13px; text-align: center;">Telefono&nbsp;2</th>
                                                            <th style="font-size: 13px; text-align: center;">Correo</th>
                                                            <th style="font-size: 13px; text-align: center;">Cumpleaños</th>
                                                            <th style="font-size: 13px; text-align: center;">Ciudad</th>
                                                            <th style="font-size: 13px; text-align: center;">Dirección</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="body-reg-crm">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Fin informe crm-->
                            <!--inicio bitacoras-->
                            <section class="box" style="display: none" id="div-report-bitacoras">
                                <div>

                                    <div class="content-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <header class="panel_header">
                                                    <div style="float: left; font-size: 1.57em">Informe Bitacoras</div>
                                                    <div style="color: red; text-align: center;">
                                                        <input type="submit" name="consultar" onclick="limpiarform()" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke;" value="Limpiar campos">
                                                    </div>
                                                </header>
                                                <form id="form-bitacora">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Tipo bitacora
                                                                            <select class="select-css" id="tipobi" name='tipobi'>
                                                                                <option value="Calibracion">Calibracion</option>
                                                                                <option value="Mantenimeinto">Mantenimeinto</option>
                                                                                <option value="Fallas">Fallas</option>
                                                                                <option value="Verificación">Verificación</option>
                                                                            </select>
                                                                            <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('tipobi'); ?></strong>
                                                                        </label>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <div style="margin-top: 10px;">
                                                                        <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Gravedad
                                                                            <select class="select-css" id="gravedadbi" name='gravedadbi'>
                                                                                <option value="Alta">Alta</option>
                                                                                <option value="Media">Media</option>
                                                                                <option value="Baja">Baja</option>
                                                                            </select>
                                                                            <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('gravedadbi'); ?></strong>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td id="numero-meses">
                                                                    <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Estado
                                                                        <select class="select-css" id="estadobi" name="estadobi">
                                                                            <option value="1">Abierto</option>
                                                                            <option value="2">Cerrado</option>
                                                                        </select>
                                                                        <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('estadobi'); ?></strong>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td id="numero-meses">
                                                                    <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Maquinas
                                                                        <select class="select-css" id="maquinabi" name="maquinabi">
                                                                            <?php foreach ($maquina as $item): ?>
                                                                                <option value="<?= $item->idconf_maquina ?>"><?= $item->nombre . ' ' . $item->marca . $item->serie_maquina . ' ' . $item->serie_banco ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('maquinabi'); ?></strong>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey; " for="nombres">Fecha inicial<br />
                                                                            <input type="text" class="form-control datepicker" id="fechainicialbi" name="fechainicialbi" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px">
                                                                            <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('fechainicialbi'); ?></strong>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div style="margin-top: 10px">
                                                                        <label style="font-weight: bold; color: grey" for="nombres">Fecha final<br />
                                                                            <input type="text" class="form-control datepicker" id="fechafinalbi" name="fechafinalbi" data-format="yyyy-mm-dd" autocomplete="off" style="margin-top: 10px">
                                                                            <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('fechafinalbi'); ?></strong>
                                                                        </label>

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div style="margin-top: 10px; align-content:  center">
                                                                        <label style="font-weight: bold; color: grey; align-content: center;">Descripción<br />
                                                                            <textarea class="form-control" id="textbi" name="textbi" style="height: 100px; width: 950px"></textarea>
                                                                            <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('textbi'); ?></strong>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="text-align: center">
                                                        <label style="font-weight: bold; color: black"></label>
                                                        <input type="hidden" id="get-fecha" value="<?= $fecha ?>">
                                                        <input name="consultar" id="btn-guadar-bitacoras" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; text-align: center" value="Guardar">
                                                        <input name="consultar" id="btn-ver-bitacoras" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; text-align: center" value="Ver historial">
                                                    </div>
                                                    <br>
                                                    <div id="valid-dato-bi" style="color: red"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="box" style="display: none" id="sec-info-bitacoras">
                                <div class="content-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <br>
                                            <div class="form-group row">
                                                <input type="submit" name="consultar" id="btn-descargar-bitacoras" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke" value="Descargar">
                                                <div id="div-info-bitacoras" class="mx-sm-4" style="text-align: right"></div>
                                            </div>

                                            <br>
                                            <div class="table-wrapper">
                                                <table class="table-bordered" id="table-bitacoras">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Fecha apertura</th>
                                                            <th>Fecha cierre</th>
                                                            <th>Usuario</th>
                                                            <th>Comentario</th>
                                                            <th>Tipo</th>
                                                            <th>Gravedad</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="body-reg-bitacoras">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="box" style="display: none" id="sec-info-bitacoras-cierre">
                                <!--<section class="box"  id="sec-info-bitacoras-cierre">-->
                                <div class="content-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <br>
                                            <div style="text-align: center">
                                                <strong style="color: black; font-size: 18px">BITACORAS ABIERTAS <label id="coutnBitacoras"></label></strong>
                                            </div>

                                            <br>
                                            <div id="accordion" role="tablist" class="accordion-group">
                                                <div id="data-bitacoras"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!--fin bitacoras-->
                            <!--inicio bitacoras-->
                            <section class="box" style="display: none" id="div-report-pesv">
                                <div>
                                    <div class="content-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <header class="panel_header">
                                                    <div style="float: left; font-size: 1.57em">Informe pesv</div>
                                                </header>
                                                <form id="form-bitacora">
                                                    <table class="table">
                                                        <tbody>

                                                            <tr>
                                                                <div class="row">
                                                                    <div class="col-md-4 col-lg-4 col-sm-3" style="text-align: center"><!-- comment -->
                                                                        <label style="font-weight: bold; color: grey; " for="nombres">Fecha inicial<br />
                                                                            <input type="text" class="form-control datepicker" id="fechainicial-pesv" name="fechainicial-pesv" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px">
                                                                            <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('fechainicialbi'); ?></strong>
                                                                        </label>
                                                                    </div>


                                                                    <div class="col-md-4 col-lg-4 col-sm-3" style="text-align: center"><!-- comment -->
                                                                        <label style="font-weight: bold; color: grey" for="nombres">Fecha final<br />
                                                                            <input type="text" class="form-control datepicker" id="fechafinal-pesv" name="fechafinal-pesv" data-format="yyyy-mm-dd" autocomplete="off" style="margin-top: 10px">
                                                                            <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('fechafinalbi'); ?></strong>
                                                                        </label>
                                                                    </div>


                                                                    <div class="col-md-4 col-lg-4 col-sm-3" style="text-align: center"><!-- comment -->
                                                                        <label style="font-weight: bold; color: grey" for="nombres"></label><br>
                                                                        <input type="submit" name="consultar" id="btn-descargar-pesv" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; margin-top: 12px" value="Generar">
                                                                    </div>
                                                                </div>


                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <br>
                                                    <div id="valid-dato-bi" style="color: red"></div>
                                                </form>
                                                <div style="display: none" id="sec-informe-pesv">
                                                    <div class="form-group row">
                                                        <div style="float: left; font-size: 1.57em;">Resultados</div>
                                                        <input type="submit" name="consultar" id="btn-descargar-informe-pesv" style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; margin-left: 50px" value="Descargar">
                                                        <br>
                                                        <div id="div-info-pesv" class="mx-sm-4" style="text-align: right"></div>
                                                    </div>
                                                    <br>
                                                    <div style="white-space: normal; height: 500px; overflow: auto;">
                                                        <table class="table" id="table-informe-pesv">
                                                            <thead id="head-informe-pesv">

                                                            </thead>
                                                            <tbody id="body-informe-pesv">

                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>

            </section>





            <!-- MAIN CONTENT AREA ENDS -->
    </section>

    <div class="modal" id="modal-resultados" role="dialog" aria-hidden="true" style="display: none" data-backdrop="false">
        <div class="modal-dialog animated bounceInDown">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titulo_">Resultados prueba</h4>
                </div>
                <div class="modal-body" id="modal-body-result">
                    <div id="result" style="display: none">

                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" id="btn-close" type="button">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="Modal-token" s tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog animated bounceInDown">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titulo_">Validar Token</h4>
                </div>
                <div class="modal-body">
                    <label style="color: black; justify-content: center">Para poder ejecutar este comando, por favor comuniquese con el area de desarrollo para que le entregue un token y pueda continuar con el proceso</label>
                    <br>
                    <br>
                    <div style="text-align: center">
                        <input type="password" placeholder="Token" class="input" id="token" autocomplete="off">
                    </div>
                    <div id="valid-token" style="color: red"></div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">CANCELAR</button>
                    <button id="btnAsignar" class="btn btn-success" type="button" onclick="Validar()">Validar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- END CONTENT -->
    <?php $this->load->view('./footer'); ?>
    <script type="text/javascript">
        var fechaPrueba = "";
        var tipoinformeEntra = "<?php
                                echo $tipoinforme;
                                ?>";
        var ipLocal = '<?php
                        echo base_url();
                        ?>';
        var dominio = "";
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
            customClass: {
                popup: 'toast-custom'
            }
        });

        $(document).ready(function() {
            if (tipoinformeEntra == "NA") {
                console.log('entre por na');
                var tipoinforme = $('#sel-tipo-informe-fugas-cal option:selected').attr('value');
                localStorage.setItem("tipoInforme", tipoinforme);
                if (tipoinforme == 1) {
                    document.getElementById("option-verificacion").style.display = '';
                    document.getElementById("tr-reporte-opacidad").style.display = '';
                } else {
                    document.getElementById("option-verificacion").style.display = 'none';
                    document.getElementById("tr-reporte-opacidad").style.display = 'none';
                }
            } else {
                if (tipoinformeEntra == 1) {
                    document.getElementById("option-verificacion").style.display = '';
                    document.getElementById("tr-reporte-opacidad").style.display = '';
                } else {
                    document.getElementById("option-verificacion").style.display = 'none';
                    document.getElementById("tr-reporte-opacidad").style.display = 'none';
                }
                localStorage.setItem("tipoInforme", tipoinformeEntra);
            }

            var text = new XMLHttpRequest();
            text.open("GET", ipLocal + "system/dominio.dat", false);
            text.send(null);
            dominio = text.responseText;


        });


        $("#sel-tipo-informe-fugas-cal").change(function() {
            var tipoinforme = $('#sel-tipo-informe-fugas-cal option:selected').attr('value');
            localStorage.setItem("tipoInforme", tipoinforme);
            if (tipoinforme == 1) {
                document.getElementById("option-verificacion").style.display = '';
                document.getElementById("tr-reporte-opacidad").style.display = '';
            } else {
                document.getElementById("option-verificacion").style.display = 'none';
                document.getElementById("tr-reporte-opacidad").style.display = 'none';
            }
        });


        $('#idreportstats').change(function() {
            var idreportstats = $('#idreportstats option:selected').attr('value');
            switch (idreportstats) {
                case '1':
                    document.getElementById("div-report-pruebas").style.display = '';
                    document.getElementById("div-report-calibraciones").style.display = 'none';
                    document.getElementById("div-report-certificados").style.display = 'none';
                    document.getElementById("div-report-cmr").style.display = 'none';
                    document.getElementById("sec-info-statspruebas").style.display = 'none';
                    document.getElementById("sec-info-report").style.display = 'none';
                    document.getElementById("sec-info-statscertificados").style.display = 'none';
                    document.getElementById("sec-info-statscalibraciones").style.display = 'none';
                    document.getElementById("div-report-bitacoras").style.display = 'none';
                    document.getElementById("sec-info-bitacoras").style.display = 'none';
                    document.getElementById("div-pruebas").style.display = 'none';
                    document.getElementById("div-report-pesv").style.display = 'none';
                    document.getElementById("sec-informe-pesv").style.display = 'none';
                    document.getElementById('sec-info-bitacoras-cierre').style.display = 'none';
                    //                                        document.getElementById("sec-info-pruebas").style.display = 'none';
                    break;
                case '2':
                    document.getElementById("div-report-pruebas").style.display = 'none';
                    document.getElementById("div-report-calibraciones").style.display = 'none';
                    document.getElementById("div-report-certificados").style.display = '';
                    document.getElementById("div-report-cmr").style.display = 'none';
                    document.getElementById("sec-info-statspruebas").style.display = 'none';
                    document.getElementById("sec-info-report").style.display = 'none';
                    document.getElementById("sec-info-statscertificados").style.display = 'none';
                    document.getElementById("sec-info-statscalibraciones").style.display = 'none';
                    document.getElementById("div-report-bitacoras").style.display = 'none';
                    document.getElementById("sec-info-bitacoras").style.display = 'none';
                    document.getElementById("div-pruebas").style.display = 'none';
                    document.getElementById("div-report-pesv").style.display = 'none';
                    document.getElementById("sec-informe-pesv").style.display = 'none';
                    document.getElementById('sec-info-bitacoras-cierre').style.display = 'none';
                    //                                        document.getElementById("sec-info-pruebas").style.display = 'none';
                    break;
                case '3':
                    document.getElementById("div-report-calibraciones").style.display = '';
                    document.getElementById("div-report-pruebas").style.display = 'none';
                    document.getElementById("div-report-certificados").style.display = 'none';
                    document.getElementById("div-report-cmr").style.display = 'none';
                    document.getElementById("sec-info-statspruebas").style.display = 'none';
                    document.getElementById("sec-info-report").style.display = 'none';
                    document.getElementById("sec-info-statscertificados").style.display = 'none';
                    document.getElementById("sec-info-statscalibraciones").style.display = 'none';
                    document.getElementById("div-report-bitacoras").style.display = 'none';
                    document.getElementById("sec-info-bitacoras").style.display = 'none';
                    document.getElementById("div-pruebas").style.display = 'none';
                    document.getElementById("div-report-pesv").style.display = 'none';
                    document.getElementById("sec-informe-pesv").style.display = 'none';
                    document.getElementById('sec-info-bitacoras-cierre').style.display = 'none';
                    //                                        document.getElementById("sec-info-pruebas").style.display = 'none';
                    break;
                case '4':
                    document.getElementById("div-report-cmr").style.display = '';
                    document.getElementById("div-report-calibraciones").style.display = 'none';
                    document.getElementById("div-report-certificados").style.display = 'none';
                    document.getElementById("div-report-pruebas").style.display = 'none';
                    document.getElementById("sec-info-report").style.display = 'none';
                    document.getElementById("sec-info-statscertificados").style.display = 'none';
                    document.getElementById("sec-info-statspruebas").style.display = 'none';
                    document.getElementById("sec-info-statscalibraciones").style.display = 'none';
                    document.getElementById("div-report-bitacoras").style.display = 'none';
                    document.getElementById("sec-info-bitacoras").style.display = 'none';
                    document.getElementById("div-pruebas").style.display = 'none';
                    document.getElementById("div-report-pesv").style.display = 'none';
                    document.getElementById("sec-informe-pesv").style.display = 'none';
                    document.getElementById('sec-info-bitacoras-cierre').style.display = 'none';
                    //                                        document.getElementById("sec-info-pruebas").style.display = 'none';
                    break;
                case '5':
                    document.getElementById("div-report-calibraciones").style.display = 'none';
                    document.getElementById("div-report-bitacoras").style.display = '';
                    document.getElementById("div-report-pruebas").style.display = 'none';
                    document.getElementById("div-report-certificados").style.display = 'none';
                    document.getElementById("div-report-cmr").style.display = 'none';
                    document.getElementById("sec-info-statspruebas").style.display = 'none';
                    document.getElementById("sec-info-report").style.display = 'none';
                    document.getElementById("sec-info-statscertificados").style.display = 'none';
                    document.getElementById("sec-info-statscalibraciones").style.display = 'none';
                    document.getElementById("sec-info-bitacoras").style.display = 'none';
                    document.getElementById("div-pruebas").style.display = 'none';
                    document.getElementById("div-report-pesv").style.display = 'none';
                    document.getElementById("sec-informe-pesv").style.display = 'none';
                    document.getElementById('sec-info-bitacoras-cierre').style.display = 'none';
                    //                                        document.getElementById("sec-info-pruebas").style.display = 'none';
                    bitacoraOpen();
                    break;
                case '6':
                    document.getElementById("div-report-pesv").style.display = '';
                    document.getElementById("div-report-calibraciones").style.display = 'none';
                    document.getElementById("div-report-bitacoras").style.display = 'none';
                    document.getElementById("div-report-pruebas").style.display = 'none';
                    document.getElementById("div-report-certificados").style.display = 'none';
                    document.getElementById("div-report-cmr").style.display = 'none';
                    document.getElementById("sec-info-statspruebas").style.display = 'none';
                    document.getElementById("sec-info-report").style.display = 'none';
                    document.getElementById("sec-info-statscertificados").style.display = 'none';
                    document.getElementById("sec-info-statscalibraciones").style.display = 'none';
                    document.getElementById("sec-info-bitacoras").style.display = 'none';
                    document.getElementById("div-pruebas").style.display = 'none';
                    document.getElementById("sec-informe-pesv").style.display = 'none';
                    document.getElementById('sec-info-bitacoras-cierre').style.display = 'none';


                    break;
                default:
                    document.getElementById("div-report-calibraciones").style.display = 'none';
                    document.getElementById("div-report-bitacoras").style.display = 'none';
                    document.getElementById("div-report-pruebas").style.display = 'none';
                    document.getElementById("div-report-certificados").style.display = 'none';
                    document.getElementById("div-report-cmr").style.display = 'none';
                    document.getElementById("sec-info-statspruebas").style.display = 'none';
                    document.getElementById("sec-info-report").style.display = 'none';
                    document.getElementById("sec-info-statscertificados").style.display = 'none';
                    document.getElementById("sec-info-statscalibraciones").style.display = 'none';
                    document.getElementById("sec-info-bitacoras").style.display = 'none';
                    document.getElementById("div-report-pesv").style.display = 'none';
                    document.getElementById("sec-informe-pesv").style.display = 'none';
                    document.getElementById('sec-info-bitacoras-cierre').style.display = 'none';
                    document.getElementById("div-pruebas").style.display = '';
                    //                                        document.getElementById("sec-info-pruebas").style.display = '';
                    break;
            }
        });
        //carga de linea
        $('#sel-marcap').change(function() {
            var idmarca = $('#sel-marcap option:selected').attr('value');
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/infolinea',
                type: 'post',
                mimeType: 'json',
                data: {
                    idmarca: idmarca
                },
                success: function(data, textStatus, jqXHR) {
                    console.log(data)
                    $('#sel-lineap').html('');
                    $('#sel-lineap').html('<option disabled="disabled" selected="selected">Seleccionar</option>');
                    $.each(data, function(i, data) {
                        $('#sel-lineap').append("<option value=" + data.lineaR + ">" + data.nombre + "</option>");
                    });
                    document.getElementById("sel-lineap").disabled = false;
                }
            });
        });
        $('#sel-marcac').change(function() {
            var idmarca = $('#sel-marcac option:selected').attr('value');
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/infolinea',
                type: 'post',
                mimeType: 'json',
                data: {
                    idmarca: idmarca
                },
                success: function(data, textStatus, jqXHR) {
                    $('#sel-lineac').html('');
                    $('#sel-lineac').html('<option disabled="disabled" selected="selected">Seleccionar</option>');
                    $.each(data, function(i, data) {
                        $('#sel-lineac').append("<option value=" + data.lineaR + ">" + data.nombre + "</option>");
                    });
                    document.getElementById("sel-lineac").disabled = false;
                }
            });
        });
        // sel stats pruebas 
        $('#sel-marcapruebas').change(function() {
            var idmarca = $('#sel-marcapruebas option:selected').attr('value');
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/infolinea',
                type: 'post',
                mimeType: 'json',
                data: {
                    idmarca: idmarca
                },
                success: function(data, textStatus, jqXHR) {
                    console.log(data)
                    $('#sel-lineapruebas').html('');
                    $('#sel-lineapruebas').html('<option disabled="disabled" selected="selected">Seleccionar</option>');
                    $.each(data, function(i, data) {
                        $('#sel-lineapruebas').append("<option value=" + data.lineaR + ">" + data.nombre + "</option>");
                    });
                    document.getElementById("sel-lineapruebas").disabled = false;
                }
            });
        });
        //inicio statsvehiculos
        function limpiarform() {
            $("#form-statscertificados")[0].reset();
            $("#form-statspruebas")[0].reset();
            $("#form-statscalibraciones")[0].reset();
            $("#form-bitacora")[0].reset();
            $("#form-statspruebas-data")[0].reset();
            document.getElementById("sel-opacidad").disabled = false;
            document.getElementById("sel-analizador").disabled = false;
            document.getElementById("sel-tipo-reporte").disabled = false;
        }

        //inicio stats pruebas
        $('#btn-generar-statspruebas').click(function(ev) {
            ev.preventDefault();
            document.getElementById("sec-info-statspruebas").style.display = 'none';
            if ($('#fechainicialp').val().length == 0) {
                $('#valid-dato-p').html('El campo fecha inicial es obligatorio.');
            } else if ($('#fechafinalp').val().length == 0) {
                $('#valid-dato-p').html('El campo fecha final es obligatorio.');
            } else {
                $('#valid-dato-p').html(' ');
                showSuccess('Cargando resultados, por favor espere.');
                var fechainicialp = $('#fechainicialp').val();
                var fechafinalp = $('#fechafinalp').val();
                var selserviciop = $('#sel-serviciop option:selected').attr('value');
                var selclasep = $('#sel-clasep option:selected').attr('value');
                var selmarcap = $('#sel-marcap option:selected').attr('value');
                var sellineap = $('#sel-lineap option:selected').attr('value');
                var seltipopruebap = $('#sel-tipopruebap option:selected').attr('value');
                var selestadopruebasp = $('#sel-estado-pruebas-p option:selected').attr('value');
                var seloperariop = $('#sel-operariop option:selected').attr('value');
                var selestadop = $('#sel-estadop option:selected').attr('value');
                var selreinpeccionp = $('#sel-reinpeccionp option:selected').attr('value');
                var seltipovehiculop = $('#sel-tipo-vehiculop option:selected').attr('value');
                var selcombustiblep = $('#sel-combustiblep option:selected').attr('value');
                var seltiemposp = $('#sel-tiemposp option:selected').attr('value');
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/statspruebas',
                    type: 'post',
                    mimeType: 'json',
                    data: {
                        fechainicialp: fechainicialp,
                        fechafinalp: fechafinalp,
                        selserviciop: selserviciop,
                        selclasep: selclasep,
                        selmarcap: selmarcap,
                        sellineap: sellineap,
                        seltipopruebap: seltipopruebap,
                        selestadopruebasp: selestadopruebasp,
                        seloperariop: seloperariop,
                        selestadop: selestadop,
                        selreinpeccionp: selreinpeccionp,
                        seltipovehiculop: seltipovehiculop,
                        selcombustiblep: selcombustiblep,
                        seltiemposp: seltiemposp,
                        tipo: 1
                    },
                    success: function(data, textStatus, jqXHR) {
                        //                    console.log(data);
                        var html = "<tr><th style='font-size: 13px; text-align: center;'>Fecha inicial</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Placa</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Nombres cliente</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Nombres propietario</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Marca</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Linea</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Documento operario</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Nombres operario</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Estado final</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Ocacion</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Clase</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Servicio</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Combustible</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Modelo</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Tipo Vehiculo</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Numero pasajeros</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Cilindraje</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Cilindros</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Kilometraje</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Taximetro</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Tiempos</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Ensenanza</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Aborto</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Usuario aborto prueba</th>\n\
                                                        </tr>";
                        $("#head-stats-pruebas").html(html);
                        document.getElementById("sec-info-statspruebas").style.display = '';
                        $("#body-reg-statspruebas").html('');
                        $('#div-info-statspruebas').html('');
                        $('html, body').animate({
                            scrollTop: $("#sec-info-statspruebas").offset().top
                        }, 900);
                        var dato = 0;
                        $.each(data, function(i, data) {
                            dato++;
                            $('#div-info-statspruebas').html('Numero de registros: ' + dato);
                            var razonAborto = "";
                            switch (data.Razon_aborto) {
                                case '1':
                                    razonAborto = 'Fallas del equipo de medición';
                                    break;
                                case '2':
                                    razonAborto = 'Falla súbita del fluido eléctrico';
                                    break;
                                case '3':
                                    razonAborto = 'Bloqueo forzado del equipo';
                                    break;
                                case '4':
                                    razonAborto = 'Ejecución incorrecta de la prueba';
                                    break;

                                default:
                                    razonAborto = data.Razon_aborto;
                                    break;
                            }
                            var body = "<tr>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha_inicial + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Placa + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Cliente + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Propietario + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Marca + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Linea + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Documento + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Operario + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Estado_final + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Ocacion + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Clase + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Servicio + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Combustible + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Modelo + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Tipo_vehiculo + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Numero_pasajeros + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Cilindraje + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Cilindros + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.kilometraje + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Taximetro + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Tiempos + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Ensenanza + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + razonAborto + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Usuario_aborto_prueba + "</td>";
                            //body += "<td style='font-size: 12px; text-align: center;'>" + data.prueba_cancelada + "</td>";
                            body += "</tr>";
                            $("#table-statspruebas tbody").append(body);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#valid-dato-p").html(textStatus);
                    }
                });
            }
        });
        //stats prueb                            as 
        $('#btn-generar-stats-pruebasruebas').click(function(ev) {
            ev.preventDefault();
            //                                console.log('data');
            document.getElementById("sec-info-statspruebas").style.display = 'none';
            if ($('#fechainicialpruebas').val().length == 0) {
                $('#valid-dato-pruebas').html('El campo fecha inicial es obligatorio.');
            } else if ($('#fechafinalpruebas').val().length == 0) {
                $('#valid-dato-pruebas').html('El campo fecha final es obligatorio.');
            } else {
                $('#valid-dato-pruebas').html(' ');
                showSuccess('Cargando resultados, por favor espere.');
                var fechainicialp = $('#fechainicialpruebas').val();
                var fechafinalp = $('#fechafinalpruebas').val();
                var selserviciop = $('#sel-serviciopruebas option:selected').attr('value');
                var selclasep = $('#sel-clasepruebas option:selected').attr('value');
                var selmarcap = $('#sel-marcapruebas option:selected').attr('value');
                var sellineap = $('#sel-lineapruebas option:selected').attr('value');
                var seltipopruebap = $('#sel-tipopruebapruebas option:selected').attr('value');
                var selestadopruebasp = $('#sel-estado-pruebas option:selected').attr('value');
                var seloperariop = $('#sel-operariopruebas option:selected').attr('value');
                var selestadop = $('#sel-estadopruebas option:selected').attr('value');
                var selreinpeccionp = $('#sel-reinpeccionpruebas option:selected').attr('value');
                var seltipovehiculop = $('#sel-tipo-vehiculopruebas option:selected').attr('value');
                var selcombustiblep = $('#sel-combustiblepruebas option:selected').attr('value');
                var seltiemposp = $('#sel-tiempospruebas option:selected').attr('value');
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/statspruebas',
                    type: 'post',
                    mimeType: 'json',
                    data: {
                        fechainicialp: fechainicialp,
                        fechafinalp: fechafinalp,
                        selserviciop: selserviciop,
                        selclasep: selclasep,
                        selmarcap: selmarcap,
                        sellineap: sellineap,
                        seltipopruebap: seltipopruebap,
                        selestadopruebasp: selestadopruebasp,
                        seloperariop: seloperariop,
                        selestadop: selestadop,
                        selreinpeccionp: selreinpeccionp,
                        seltipovehiculop: seltipovehiculop,
                        selcombustiblep: selcombustiblep,
                        seltiemposp: seltiemposp,
                        tipo: 2
                    },
                    success: function(data, textStatus, jqXHR) {

                        var html = "<tr><th style='font-size: 13px; text-align: center;'>Fecha inicial</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Placa</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Tipo Prueba</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Nombres cliente</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Nombres propietario</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Marca</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Linea</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Documento operario</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Nombres operario</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Estado prueba</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Clase</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Servicio</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Combustible</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Modelo</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Tipo Vehiculo</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Numero pasajeros</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Cilindraje</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Cilindros</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Kilometraje</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Taximetro</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Tiempos</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Ensenanza</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Aborto</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Usuario aborto prueba</th>\n\
                                                            <th style='font-size: 13px; text-align: center;'>Opciones</th>\n\
                                                        </tr>";
                        $("#head-stats-pruebas").html(html);
                        document.getElementById("sec-info-statspruebas").style.display = '';
                        $("#body-reg-statspruebas").html('');
                        $('#div-info-statspruebas').html('');
                        $('html, body').animate({
                            scrollTop: $("#sec-info-statspruebas").offset().top
                        }, 900);
                        var dato = 0;
                        $.each(data, function(i, data) {
                            dato++;
                            var razonAborto = "";
                            switch (data.Razon_aborto) {
                                case '1':
                                    razonAborto = 'Fallas del equipo de medición';
                                    break;
                                case '2':
                                    razonAborto = 'Falla súbita del fluido eléctrico';
                                    break;
                                case '3':
                                    razonAborto = 'Bloqueo forzado del equipo';
                                    break;
                                case '4':
                                    razonAborto = 'Ejecución incorrecta de la prueba';
                                    break;

                                default:
                                    razonAborto = data.Razon_aborto;
                                    break;
                            }
                            $('#div-info-statspruebas').html('Numero de registros: ' + dato);
                            var body = "<tr>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha_inicial + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Placa + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Tipo_prueba + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Cliente + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Propietario + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Marca + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Linea + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Documento + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Operario + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Estado + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Clase + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Servicio + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Combustible + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Modelo + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Tipo_vehiculo + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.pasajeros + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Cilindraje + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Cilindros + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.kilometraje + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Taximetro + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Tiempos + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Ensenanza + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + razonAborto + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Usuario_aborto_prueba + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'><button data-toggle='modal' data-target='#modal-resultados' style='background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke' onclick='getresultados(" + data.idprueba + "," + data.idtipo_prueba + " )'>Ver resultados</button></td>";
                            body += "</tr>";
                            $("#table-statspruebas tbody").append(body);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#valid-dato-p").html(textStatus);
                    }
                });
            }
        });

        function getresultados(idprueba, idtipo_prueba) {

            //                                console.log(idprueba)
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/getresultados',
                type: 'post',
                mimeType: 'json',
                data: {
                    idprueba: idprueba,
                    idtipo_prueba: idtipo_prueba
                },
                success: function(data, textStatus, jqXHR) {
                    console.log(data);
                    $('#body-table-result').html('');
                    $("#div-data-image").remove();
                    if (idtipo_prueba !== 5) {
                        //                                            document.getElementById("table-modal-resultados").style.display = "";
                        var html = "<table class='table' id='table-modal-resultados'>\n\
                                                            <thead>\n\
                                                                <tr>\n\
                                                                    <th>Descripcion</th>\n\
                                                                    <th>Valor</th>\n\
                                                                </tr>\n\
                                                            </thead>\n\
                                                            <tbody id='body-table-result'>\n\
                                                            </tbody>\n\
                                                        </table>";
                        $("#modal-body-result").html(html);
                        $.each(data, function(i, data) {
                            var body = "<tr>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Descripcion + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Valor + "</td>";
                            body += "</tr>";
                            $("#table-modal-resultados tbody").append(body);
                        });
                    } else {
                        //                                            document.getElementById("table-modal-resultados").style.display = "none"
                        $("#modal-body-result").html("<div id='div-data-image'><img style='width: 90%; height: 90%' src=" + data[0].imagen + " /></div>")
                    }

                    //                                        

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#valid-dato-p").html(textStatus);
                }
            });
        }
        $("#btn-descargar-statspruebas").click(function() {
            var fecha = $('#get-fecha').val();
            showSuccess('Descargando el informe, por favor espere.');
            $('#table-statspruebas').table2csv({
                filename: 'INFORME STATS VEHICULOS-PRUEBAS ' + fecha + '.csv',
                separator: ';',
                newline: '\n',
                quoteFields: true,
                excludeColumns: '1',
                excludeRows: '',
                trimContent: true
            });
        });
        //fin stats pruebas
        //inicio stats certificados
        $('#btn-generar-statscertificados').click(function(ev) {
            ev.preventDefault();
            document.getElementById("sec-info-statscertificados").style.display = 'none';
            if ($('#fechainicialc').val().length == 0) {
                $('#valid-dato-c').html('El campo fecha inicial es obligatorio.');
            } else if ($('#fechafinalc').val().length == 0) {
                $('#valid-dato-c').html('El campo fecha final es obligatorio.');
            } else {
                $('#valid-dato-c').html(' ');
                showSuccess('Cargando resultados, por favor espere.');
                var fechainicialc = $('#fechainicialc').val();
                var fechafinalc = $('#fechafinalc').val();
                var inputplacac = $('#input-placa-c').val();
                var selservicioc = $('#sel-servicioc option:selected').attr('value');
                var selclasec = $('#sel-clasec option:selected').attr('value');
                var selmarcac = $('#sel-marcac option:selected').attr('value');
                var sellineac = $('#sel-lineac option:selected').attr('value');
                var selestadoc = $('#sel-estadoc option:selected').attr('value');
                var selreinpeccionc = $('#sel-reinpeccionc option:selected').attr('value');
                var seltipovehiculoc = $('#sel-tipo-vehiculoc option:selected').attr('value');
                var selcombustiblec = $('#sel-combustiblec option:selected').attr('value');
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/statscertificados',
                    type: 'post',
                    mimeType: 'json',
                    data: {
                        fechainicialc: fechainicialc,
                        fechafinalc: fechafinalc,
                        inputplacac: inputplacac,
                        selservicioc: selservicioc,
                        selclasec: selclasec,
                        selmarcac: selmarcac,
                        sellineac: sellineac,
                        selestadoc: selestadoc,
                        selreinpeccionc: selreinpeccionc,
                        seltipovehiculoc: seltipovehiculoc,
                        selcombustiblec: selcombustiblec,
                    },
                    success: function(data, textStatus, jqXHR) {
                        console.log(data);
                        document.getElementById("sec-info-statscertificados").style.display = '';
                        $("#body-reg-statscertificados").html('');
                        $('#div-info-statscertificados').html('');
                        $('html, body').animate({
                            scrollTop: $("#sec-info-statscertificados").offset().top
                        }, 900);
                        var dato = 0;
                        $.each(data, function(i, data) {
                            dato++;
                            $('#div-info-statscertificados').html('Numero de registros: ' + dato);
                            var body = "<tr>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Placa + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Numero_fur + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Numero_certificado + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Consecutivo_runt + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Consecutivo_runt_rechazado + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Factura + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha_impresion + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha_vigencia + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Ingeniero_pista + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Usuario_certificacion + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Cliente + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Propietario + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Documento + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Direccion + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Correo + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Telefono + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Marca + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Linea + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Color + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Estado_final + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Ocacion + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Clase + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Servicio + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Combustible + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Modelo + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.cilindraje + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Tipo_vehiculo + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.numero_motor + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.numero_vin + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.numero_serie + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.scooter + "</td>";
                            body += "</tr>";
                            $("#table-statscertificados tbody").append(body);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    }
                });
            }
        });
        $("#btn-descargar-statscertificados").click(function() {
            var fecha = $('#get-fecha').val();
            showSuccess('Descargando el informe, por favor espere.');
            $('#table-statscertificados').table2csv({
                filename: 'INFORME STATS CERTIFICADOS ' + fecha + '.csv',
                separator: ';',
                newline: '\n',
                quoteFields: true,
                excludeColumns: '1',
                excludeRows: '',
                trimContent: true
            });
        });
        //fin stats certificados
        //inicio stats calibraciones
        $('#sel-analizador').change(function() {
            document.getElementById("sel-opacidad").disabled = true;
        });
        $('#sel-opacidad').change(function() {
            document.getElementById("sel-analizador").disabled = true;
            document.getElementById("sel-tipo-reporte").disabled = true;
        });
        $('#sel-tipo-reporte').change(function() {
            document.getElementById("sel-opacidad").disabled = true;
        });
        $('#sel-tipo-reporte').change(function() {
            var seltiporeporte = $('#sel-tipo-reporte option:selected').attr('value');
            if (seltiporeporte == 4) {
                document.getElementById("table-calibraciones").style.display = 'none';
                $('#table-statsverificacion tbody').html('');
                //            document.getElementById("body-reg-statsverificacion").html('');
                document.getElementById("sel-opacidad").disabled = true;
                document.getElementById("sel-analizador").disabled = true;
                document.getElementById("fechainicialca").disabled = true;
                document.getElementById("fechafinalca").disabled = true;
                document.getElementById("btn-generar-statscalibraciones").disabled = true;
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/logs',
                    type: 'post',
                    mimeType: 'json',
                    //                data: {},
                    success: function(data, textStatus, jqXHR) {
                        showSuccess('Cargando resultados, por favor espere.');
                        document.getElementById("sec-info-statscalibraciones").style.display = '';
                        $("#body-reg-statsverificacion").html('');
                        $("#body-stats-verifricacion-opa").html('');
                        $('#div-info-statscalibraciones').html('');
                        $('html, body').animate({
                            scrollTop: $("#sec-info-statscalibraciones").offset().top
                        }, 900);
                        document.getElementById("table-verificacion").style.display = '';
                        document.getElementById("sec-info-resultadosverificacion").style.display = 'none';
                        document.getElementById("sec-info-resultados-opa").style.display = 'none';
                        var html = '<tr>\n\
<th style="font-size: 13px; text-align: center;">Placa</th> \n\
<th style="font-size: 13px; text-align: center;">Fecha</th> \n\
<th style="font-size: 13px; text-align: center;">Idprueba</th> \n\
<th style="font-size: 13px; text-align: center;">Opciones</th> \n\
</tr>';
                        $('#head-reg-statsverificacion').html(html);
                        var dato = 0;
                        $.each(data, function(i, data) {
                            var resul = '';
                            dato++;
                            $('#div-info-statscalibraciones').html('Numero de registros: ' + dato);
                            var body = "<tr>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Placa + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha_prueba + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.idprueba + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'><button style='background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke' onclick='getresultadoslog(" + data.idcontrol_prueba_gases + ")'>Ver Resultados</button></td>";
                            body += "</tr>";
                            $("#table-statsverificacion tbody").append(body);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    }
                });
            } else {
                document.getElementById("fechainicialca").disabled = false;
                document.getElementById("fechafinalca").disabled = false;
                document.getElementById("btn-generar-statscalibraciones").disabled = false;
                document.getElementById("sel-analizador").disabled = false;
            }
        });


        function getresultadoslog(idcontrol_prueba_gases) {
            document.getElementById("table-calibraciones").style.height = '130px';
            document.getElementById("sec-info-resultadoslog").style.display = 'none';
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/getresultadoslog',
                type: 'post',
                mimeType: 'json',
                data: {
                    idcontrol_prueba_gases: idcontrol_prueba_gases
                },
                success: function(data, textStatus, jqXHR) {
                    console.log(data);
                    showSuccess('Cargando resultados, por favor espere.');
                    document.getElementById("sec-info-resultadoslog").style.display = '';
                    $('#body-stats-logs').html('');
                    $('html, body').animate({
                        scrollTop: $("#sec-info-resultadoslog").offset().top
                    }, 900);
                    fechaPrueba = data[0].Fecha;
                    var tiempocru = 0;
                    var cru = null;
                    var crucero = "";
                    var relen = JSON.parse(data[0].datos_ciclo_ralenti);

                    if (data[0].datos_ciclo_crucero !== null && data[0].datos_ciclo_crucero !== "") {

                        var cru = JSON.parse(data[0].datos_ciclo_crucero);
                    }
                    var arr = [];

                    $('#headLogPruebas').html(`
                                    <tr>
                                        <th>MARCA SOFTWARE</th>
                                        <th>VERSION SOTWARE</th>
                                        <th>CDA</th>
                                        <th>NIT</th>
                                        <th>MARCA</th>
                                        <th>MODELO</th>
                                        <th>SERIAL</th>
                                        <th>FECHA Y HORA</th>
                                        <th>---</th>
                                        <th>---</th>
                                        <th>---</th>
                                        <th>---</th>
                                        <th>---</th>
                                        <th>---</th>
                                        <th>---</th>
                                        <th>---</th>
                                        
                                    </tr>
                                    <tr>
                                        <td>${data.marcasoft.trim()}</td>
                                        <td>${data.versionsoft.trim()}</td>
                                        <td>${data[0].nombreCda}</td>
                                        <td>${data[0].nit.trim()}</td>
                                        <td>${data.marca.trim()}</td>
                                        <td>${data.serie_banco.trim()}</td>
                                        <td>${data.serie_maquina.trim()}</td>
                                        <td>${fechaPrueba}</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                    </tr>
                                    
                                    <tr>
                                        <th>Ralenti</th>
                                        <th>Placa</th>
                                        <th>Tiempo (S)</th>
                                        <th>Hc (Ppm)</th>
                                        <th>Co (%)</th>
                                        <th>Co2 (%)</th>
                                        <th>O2 (%)</th>
                                        <th>Rpm</th>
                                        <th>-----</th>
                                        <th>Crucero</th>
                                        <th>Tiempo (S)</th>
                                        <th>Hc (Ppm)</th>
                                        <th>Co (%)</th>
                                        <th>Co2 (%)</th>
                                        <th>O2 (%)</th>
                                        <th>Rpm</th>
                                    </tr>
                                `);
                    if (cru !== null) {
                        $.each(cru, function(i, cru) {
                            //                        console.log(cru)
                            var time = parseFloat(cru.tiempo) + 0.5;
                            crucero = "<td style='font-size: 12px; text-align: center;'>Prueba Crucero</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>" + time + "</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>" + cru.hc + "</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>" + cru.co + "</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>" + cru.co2 + "</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>" + cru.o2 + "</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>" + cru.rpm + "</td>";
                            arr.push(crucero);
                        });
                    } else {
                        $.each(relen, function(i, relen) {
                            crucero = "<td style='font-size: 12px; text-align: center;'>---</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>---</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>---</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>---</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>---</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>---</td>";
                            crucero += "<td style='font-size: 12px; text-align: center;'>---</td>";
                            arr.push(crucero);
                        });
                    }
                    $.each(relen, function(i, relen) {



                        var time = parseFloat(relen.tiempo) + 0.5;
                        var body = "<tr>";

                        body += "<td style='font-size: 12px; text-align: center;'>Prueba Ralenti</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + data[0].Placa + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + time + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + relen.hc + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + relen.co + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + relen.co2 + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + relen.o2 + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + relen.rpm + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>----</td>";
                        body += arr[i];
                        body += "</tr>";
                        $("#table-stats-logs tbody").append(body);
                    });
                }
            });
        }

        $('#btn-generar-statscalibraciones').click(function(ev) {
            ev.preventDefault();
            document.getElementById("sec-info-statscalibraciones").style.display = 'none';
            if ($('#fechainicialca').val().length == 0) {
                $('#valid-dato-ca').html('El campo fecha inicial es obligatorio.');
            } else if ($('#fechafinalca').val().length == 0) {
                $('#valid-dato-ca').html('El campo fecha final es obligatorio.');
            } else {
                $('#valid-dato-ca').html(' ');
                showSuccess('Cargando resultados, por favor espere.');
                var fechainicialca = $('#fechainicialca').val();
                var fechafinalca = $('#fechafinalca').val();
                var selanalizador = $('#sel-analizador option:selected').attr('value');
                var selopcaidad = $('#sel-opacidad option:selected').attr('value');
                var seltiporeporte = $('#sel-tipo-reporte option:selected').attr('value');
                var seltiporeporteopacidad = $('#sel-tipo-reporte-opacidad option:selected').attr('value');
                var tipoInforme = localStorage.getItem("tipoInforme");
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/statscalibraciones',
                    type: 'post',
                    mimeType: 'json',
                    data: {
                        fechainicialca: fechainicialca,
                        fechafinalca: fechafinalca,
                        selanalizador: selanalizador,
                        selopcaidad: selopcaidad,
                        seltiporeporte: seltiporeporte,
                        seltiporeporteopacidad: seltiporeporteopacidad,
                        tipoinforme: tipoInforme
                    },
                    success: function(data, textStatus, jqXHR) {
                        //                    console.log(data);
                        document.getElementById("sec-info-statscalibraciones").style.display = '';
                        $("#body-reg-statscalibraciones").html('');
                        $('#div-info-statscalibraciones').html('');
                        $('html, body').animate({
                            scrollTop: $("#sec-info-statscalibraciones").offset().top
                        }, 900);
                        switch (seltiporeporte) {
                            case '1':
                                document.getElementById("table-calibraciones").style.height = '';
                                document.getElementById("sec-info-resultadosverificacion").style.display = 'none';
                                document.getElementById("sec-info-resultados-opa").style.display = 'none';
                                document.getElementById("sec-info-resultadoslog").style.display = 'none';
                                document.getElementById("table-verificacion").style.display = 'none';
                                document.getElementById("table-calibraciones").style.display = '';
                                var html = '<tr>\n\
<th style="font-size: 13px; text-align: center;">Fecha</th> \n\
<th style="font-size: 13px; text-align: center;">Serie</th> \n\
<th style="font-size: 13px; text-align: center;">Pef</th> \n\
<th style="font-size: 13px; text-align: center;">Usuario</th> \n\
<th style="font-size: 13px; text-align: center;">Span alto hc</th> \n\
<th style="font-size: 13px; text-align: center;">Span alto co</th> \n\
<th style="font-size: 13px; text-align: center;">Span alto co2</th> \n\
<th style="font-size: 13px; text-align: center;">Span alto n</th> \n\
<th style="font-size: 13px; text-align: center;">Cal alto hc</th> \n\
<th style="font-size: 13px; text-align: center;">Cal alto co</th> \n\
<th style="font-size: 13px; text-align: center;">Cal alto co2</th> \n\
<th style="font-size: 13px; text-align: center;">Cal alto o2</th> \n\
<th style="font-size: 13px; text-align: center;">Span bajo hc</th> \n\
<th style="font-size: 13px; text-align: center;">Span bajo co</th> \n\
<th style="font-size: 13px; text-align: center;">Span bajo co2</th> \n\
<th style="font-size: 13px; text-align: center;">Span bajo n</th> \n\
<th style="font-size: 13px; text-align: center;">Cal bajo hc</th> \n\
<th style="font-size: 13px; text-align: center;">Cal bajo co</th> \n\
<th style="font-size: 13px; text-align: center;">Cal bajo co2</th> \n\
<th style="font-size: 13px; text-align: center;">Cal bajo o2</th> \n\
<th style="font-size: 13px; text-align: center;">Resultado</th> \n\
<th style="font-size: 13px; text-align: center;">Opciones</th> \n\
</tr>';
                                $('#head-reg-statscalibraciones').html(html);
                                var dato = 0;
                                $.each(data, function(i, data) {
                                    //                                console.log(data);
                                    var resul = '';
                                    if (data.resultado == 'APROBADO') {
                                        resul = "<td style= 'color: green '><strong>" + data.resultado + "</strong></td>";
                                    } else {
                                        resul = "<td style= 'color: #FA8072 '><strong>" + data.resultado + "</strong></td>";
                                    }
                                    var html = '<td>\n\
<form action="<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/reportpdfcalibraciones" method="post" target="_blank"> \n\
\                                               <input type="hidden" name="fecha" value="' + data.Fecha + '"> \n\
<input type="hidden" name="id"  value="' + data.Id + '">\n\
<input type="hidden" name="tipoInforme"  value="' + localStorage.getItem("tipoInforme") + '">\n\
<button style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke"   >Generar pdf</button>\n\
</form>\n\
</td>';
                                    dato++;
                                    $('#div-info-statscalibraciones').html('Numero de registros: ' + dato);
                                    var body = "<tr>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Serie + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Pef + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Responsable + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Span_alto_hc + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Span_alto_co + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Span_alto_co2 + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Span_alto_n + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Cal_alto_hc + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Cal_alto_co + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Cal_alto_co2 + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Cal_alto_o2 + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Span_bajo_hc + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Span_bajo_co + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Span_bajo_co2 + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Span_bajo_n + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Cal_bajo_hc + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Cal_bajo_co + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Cal_bajo_co2 + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Cal_bajo_o2 + "</td>";
                                    body += resul;
                                    body += html;
                                    body += "</tr>";
                                    $("#table-statscalibraciones tbody").append(body);
                                });
                                break;
                            case '2':
                                document.getElementById("table-calibraciones").style.height = '';
                                document.getElementById("sec-info-resultadosverificacion").style.display = 'none';
                                document.getElementById("sec-info-resultados-opa").style.display = 'none';
                                document.getElementById("sec-info-resultadoslog").style.display = 'none';
                                document.getElementById("table-verificacion").style.display = 'none';
                                document.getElementById("table-calibraciones").style.display = '';
                                var html = '<tr>\n\
<th style="font-size: 13px; text-align: center;">Fecha</th> \n\
<th style="font-size: 13px; text-align: center;">Serie</th> \n\
<th style="font-size: 13px; text-align: center;">Pef</th> \n\
<th style="font-size: 13px; text-align: center;">Usuario</th> \n\
<th style="font-size: 13px; text-align: center;">Presion base</th> \n\
<th style="font-size: 13px; text-align: center;">Presion bomba</th> \n\
<th style="font-size: 13px; text-align: center;">Presion filtros</th> \n\
<th style="font-size: 13px; text-align: center;">Total fugas #</th> \n\
<th style="font-size: 13px; text-align: center;">Total fugas %</th> \n\
<th style="font-size: 13px; text-align: center;">Vacio bomba apagada</th> \n\
<th style="font-size: 13px; text-align: center;">Vacio bomba encendida</th> \n\
<th style="font-size: 13px; text-align: center;">Resultado</th> \n\
<th style="font-size: 13px; text-align: center;">Opciones</th> \n\
</tr>';
                                $('#head-reg-statscalibraciones').html(html);
                                var dato = 0;
                                $.each(data, function(i, data) {
                                    var resul = '';
                                    if (data.resultado == 'Aprobado') {
                                        resul = "<td style= 'color: green '><strong>" + data.resultado + "</strong></td>";
                                    } else {
                                        resul = "<td style= 'color: #FA8072 '><strong>" + data.resultado + "</strong></td>";
                                    }
                                    var html = '<td>\n\
<form action="<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/reportpdffugas" method="post" target="_blank"> \n\
\                                               <input type="hidden" name="fecha" value="' + data.Fecha + '"> \n\
<input type="hidden" name="id"  value="' + data.Id + '">\n\
<input type="hidden" name="tipoInforme"  value="' + localStorage.getItem("tipoInforme") + '">\n\
<button style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke">Generar pdf</button>\n\
</form>\n\
</td>';
                                    dato++;
                                    $('#div-info-statscalibraciones').html('Numero de registros: ' + dato);
                                    var body = "<tr>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Serie + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Pef + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.Responsable + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.presion_base + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.presion_bomba + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.presion_filtros + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.total_fugas_num + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.total_fugas_porc + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.vacio_bomba_apag + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.vacio_bomba_pren + "</td>";
                                    body += resul;
                                    body += html;
                                    body += "</tr>";
                                    $("#table-statscalibraciones tbody").append(body);
                                });
                                break;
                            case '3':
                                //                            document.getElementById("table-calibraciones").style.height = '10px';
                                document.getElementById("sec-info-resultadosverificacion").style.display = 'none';
                                document.getElementById("sec-info-resultados-opa").style.display = 'none';
                                document.getElementById("sec-info-resultadoslog").style.display = 'none';
                                document.getElementById("table-calibraciones").style.display = 'none';
                                $('#table-statsverificacion tbody').html('');
                                document.getElementById("table-verificacion").style.display = '';
                                var html = '<tr>\n\
<th style="font-size: 13px; text-align: center;">Fecha</th> \n\
<th style="font-size: 13px; text-align: center;">Serie</th> \n\
<th style="font-size: 13px; text-align: center;">Serie bench</th> \n\
<th style="font-size: 13px; text-align: center;">Auditor 1</th> \n\
<th style="font-size: 13px; text-align: center;">Auditor 2</th> \n\
<th style="font-size: 13px; text-align: center;">Ip</th> \n\
<th style="font-size: 13px; text-align: center;">Ciclo</th> \n\
<th style="font-size: 13px; text-align: center;">Span</th> \n\
<th style="font-size: 13px; text-align: center;">Opciones</th> \n\
</tr>';
                                $('#head-reg-statsverificacion').html(html);
                                var dato = 0;
                                $.each(data, function(i, data) {
                                    var html = '<td>\n\
<form action="<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/reportverificacion" method="post" target="_blank"> \n\
\                                               <input type="hidden" name="id" value="' + data.idcontrol_verificacion + '"> \n\
<button style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke">Ver resultados</button>\n\
</form>\n\
</td>';
                                    dato++;
                                    $('#div-info-statscalibraciones').html('Numero de registros: ' + dato);
                                    var body = "<tr>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.fecha + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.serie + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.noSerieBench + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.auditor1 + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.auditor2 + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.ip + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.ciclo + "</td>";
                                    body += "<td style='font-size: 12px; text-align: center;'>" + data.span + "</td>";
                                    body += '<td style="font-size: 12px; text-align: center;"><button style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke" onclick="getresultadosverificacion(\'' + data.idcontrol_verificacion + '\',\'' + data.idmaquina + '\',\'' + data.fecha + '\')">Ver resultados</button></td>';
                                    body += "</tr>";
                                    $("#table-statsverificacion tbody").append(body);
                                });
                                break;
                            default:
                                if (typeof(seltiporeporteopacidad) === "undefined") {
                                    document.getElementById("table-calibraciones").style.height = '';
                                    document.getElementById("sec-info-resultadosverificacion").style.display = 'none';
                                    document.getElementById("sec-info-resultados-opa").style.display = 'none';
                                    document.getElementById("sec-info-resultadoslog").style.display = 'none';
                                    document.getElementById("table-verificacion").style.display = 'none';
                                    document.getElementById("table-calibraciones").style.display = '';
                                    var html = '<tr>\n\
<th style="font-size: 13px; text-align: center;">Fecha</th> \n\
<th style="font-size: 13px; text-align: center;">Serie</th> \n\
<th style="font-size: 13px; text-align: center;">Usuario</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 1 lectura</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 2 lectura</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 3 lectura</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 4 lectura</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 1 valor</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 2 valor</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 3 valor</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 4 valor</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 1 desviacion</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 2 desviacion</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 3 desviacion</th> \n\
<th style="font-size: 13px; text-align: center;">Lente 4 desviacion</th> \n\
<th style="font-size: 13px; text-align: center;">Error total lectura</th> \n\
<th style="font-size: 13px; text-align: center;">Resultado</th> \n\
<th style="font-size: 13px; text-align: center;">Opciones</th> \n\
</tr>';
                                    $('#head-reg-statscalibraciones').html(html);
                                    var dato = 0;
                                    $.each(data, function(i, data) {
                                        var resul = '';
                                        if (data.resultado == 'Aprobada') {
                                            resul = "<td style= 'color: green '><strong>" + data.resultado + "</strong></td>";
                                        } else {
                                            resul = "<td style= 'color: #FA8072 '><strong>" + data.resultado + "</strong></td>";
                                        }
                                        var html = '<td>\n\
<form action="<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/reportpdflinealidad" method="post" target="_blank"> \n\
<input type="hidden" name="fecha" value="' + data.Fecha + '"> \n\
<input type="hidden" name="id"  value="' + data.Id + '">\n\
<input type="hidden" name="tipoInforme"  value="' + localStorage.getItem("tipoInforme") + '">\n\
<button style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke">Generar pdf</button>\n\
</form>\n\
</td>';
                                        dato++;
                                        $('#div-info-statscalibraciones').html('Numero de registros: ' + dato);
                                        var body = "<tr>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Serie + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Responsable + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente1_lectura + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente2_lectura + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente3_lectura + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente4_lectura + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente1_valor + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente2_valor + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente3_valor + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente4_valor + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente1_desviacion + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente2_desviacion + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente3_desviacion + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Lente4_desviacion + "</td>";
                                        body += "<td style='font-size: 12px; text-align: center;'>" + data.Error_total_lectura + "</td>";
                                        body += resul;
                                        body += html;
                                        body += "</tr>";
                                        $("#table-statscalibraciones tbody").append(body);
                                    });
                                } else {
                                    switch (seltiporeporteopacidad) {
                                        case '1':
                                            document.getElementById("table-calibraciones").style.height = '';
                                            document.getElementById("sec-info-resultadosverificacion").style.display = 'none';
                                            document.getElementById("sec-info-resultados-opa").style.display = 'none';
                                            document.getElementById("sec-info-resultadoslog").style.display = 'none';
                                            document.getElementById("table-verificacion").style.display = 'none';
                                            document.getElementById("table-calibraciones").style.display = '';
                                            var html = '<tr>\n\
<th style="font-size: 13px; text-align: center;">Fecha</th> \n\
<th style="font-size: 13px; text-align: center;">Usuario</th> \n\
<th style="font-size: 13px; text-align: center;">Valor 1</th> \n\
<th style="font-size: 13px; text-align: center;">Valor 2</th> \n\
<th style="font-size: 13px; text-align: center;">Valor 3</th> \n\
<th style="font-size: 13px; text-align: center;">Valor 4</th> \n\
<th style="font-size: 13px; text-align: center;">Lectura 1</th> \n\
<th style="font-size: 13px; text-align: center;">Lectura 2</th> \n\
<th style="font-size: 13px; text-align: center;">Lectura 3</th> \n\
<th style="font-size: 13px; text-align: center;">Lectura 4</th> \n\
<th style="font-size: 13px; text-align: center;">Desviacion 1</th> \n\
<th style="font-size: 13px; text-align: center;">Desviacion 2</th> \n\
<th style="font-size: 13px; text-align: center;">Desviacion 3</th> \n\
<th style="font-size: 13px; text-align: center;">Desviacion 4</th> \n\
<th style="font-size: 13px; text-align: center;">Resultado</th> \n\
<th style="font-size: 13px; text-align: center;">Opciones</th> \n\
</tr>';
                                            $('#head-reg-statscalibraciones').html(html);
                                            var dato = 0;
                                            $.each(data, function(i, data) {
                                                var resul = '';
                                                if (data.Resultado == 'Aprobado') {
                                                    resul = "<td style= 'color: green '><strong>" + data.Resultado + "</strong></td>";
                                                } else {
                                                    resul = "<td style= 'color: #FA8072 '><strong>" + data.Resultado + "</strong></td>";
                                                }

                                                var html = '<td>\n\
<form action="<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/reportpdflinealidad" method="post" target="_blank"> \n\
\                                               <input type="hidden" name="fecha" value="' + data.Fecha + '"> \n\
<input type="hidden" name="id"  value="' + data.Id + '">\n\
<input type="hidden" name="tipoInforme"  value="' + localStorage.getItem("tipoInforme") + '">\n\
<button style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke">Generar pdf</button>\n\
</form>\n\
</td>';
                                                dato++;
                                                $('#div-info-statscalibraciones').html('Numero de registros: ' + dato);
                                                var body = "<tr>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Usuario + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Valor1 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Valor2 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Valor3 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Valor4 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Lectura1 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Lectura2 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Lectura3 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Lectura4 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Desviacion1 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Desviacion2 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Desviacion3 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Desviacion4 + "</td>";
                                                body += resul;
                                                body += html;
                                                body += "</tr>";
                                                $("#table-statscalibraciones tbody").append(body);
                                            });
                                            break;
                                        case '2':
                                            document.getElementById("table-calibraciones").style.display = 'none';
                                            document.getElementById("sec-info-statscalibraciones").style.display = '';
                                            document.getElementById("table-verificacion").style.display = '';
                                            document.getElementById("sec-info-resultadosverificacion").style.display = 'none';
                                            document.getElementById("sec-info-resultados-opa").style.display = 'none';
                                            var html = '<tr>\n\
<th style="font-size: 13px; text-align: center;">Fecha</th> \n\
<th style="font-size: 13px; text-align: center;">Usuario</th> \n\
<th style="font-size: 13px; text-align: center;">Valor Antes</th> \n\
<th style="font-size: 13px; text-align: center;">Valor Despues</th> \n\
<th style="font-size: 13px; text-align: center;">Resultado</th> \n\
<th style="font-size: 13px; text-align: center;">Opciones</th> \n\
</tr>';
                                            $('#head-reg-statsverificacion').html(html);
                                            var dato = 0;
                                            $("#body-reg-statsverificacion").html('');
                                            $("#body-stats-verifricacion-opa").html('');
                                            $('#div-info-statscalibraciones').html('');
                                            $.each(data, function(i, data) {
                                                var resul = '';
                                                if (data.Resultado == 'Aprobada') {
                                                    resul = "<td style= 'color: green '><strong>" + data.Resultado + "</strong></td>";
                                                } else {
                                                    resul = "<td style= 'color: #FA8072 '><strong>" + data.Resultado + "</strong></td>";
                                                }
                                                var html = '<td>\n\
                                                                            <form action="<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/reportpdfcero" method="post" target="_blank"> \n\
                                                                            \                                               <input type="hidden" name="fecha" value="' + data.Fecha + '"> \n\
                                                                            <input type="hidden" name="id"  value="' + data.Id + '">\n\
                                                                            <input type="hidden" name="tipoInforme"  value="' + localStorage.getItem("tipoInforme") + '">\n\
                                                                            <button style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke"   >Generar pdf</button>\n\
                                                                            </form>\n\
                                                                            </td>'
                                                dato++;
                                                $('#div-info-statscalibraciones').html('Numero de registros: ' + dato);
                                                var body = "<tr>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Usuario + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Valorantes + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.Valordespues + "</td>";
                                                body += resul;
                                                body += html;
                                                body += "</tr>";
                                                $("#table-statsverificacion tbody").append(body);
                                            });
                                            break;
                                        default:
                                            document.getElementById("sec-info-statscalibraciones").style.display = '';
                                            $("#body-reg-statsverificacion").html('');
                                            $("#body-stats-verifricacion-opa").html('');
                                            $('#div-info-statscalibraciones').html('');
                                            $('html, body').animate({
                                                scrollTop: $("#sec-info-statscalibraciones").offset().top
                                            }, 900);
                                            document.getElementById("table-verificacion").style.display = '';
                                            document.getElementById("sec-info-resultadosverificacion").style.display = 'none';
                                            document.getElementById("sec-info-resultados-opa").style.display = 'none';
                                            var html = '<tr>\n\
                                                                                <th style="font-size: 13px; text-align: center;">Placa</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Fecha</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Auditor 1</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Auditor 2</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Serie</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Opciones</th> \n\
                                                                            </tr>';
                                            $('#head-reg-statsverificacion').html(html);
                                            var dato = 0;
                                            $.each(data, function(i, data) {
                                                var btn = "";

                                                if (data.datos.length > 2) {
                                                    btn = "<button style='background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke' onclick='getresultadosTiempo(" + data.idcontrol_respuesta + ")'>Ver Resultados</button>"
                                                } else {
                                                    btn = "Sin datos de log"
                                                }
                                                var resul = '';
                                                dato++;
                                                $('#div-info-statscalibraciones').html('Numero de registros: ' + dato);
                                                var body = "<tr>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.placa + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.fecha + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.auditor1 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.auditor2 + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + data.serie + "</td>";
                                                body += "<td style='font-size: 12px; text-align: center;'>" + btn + "</td>";
                                                body += "</tr>";
                                                $("#table-statsverificacion tbody").append(body);
                                            });
                                            break;
                                    }
                                }
                                break;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    }
                });
            }
        });

        function getresultadosverificacion(idcontrol_verificacion, idmaquina, fecha) {
            //                                console.log(idmaquina);
            document.getElementById("sec-info-resultadosverificacion").style.display = '';
            document.getElementById("sec-info-resultados-opa").style.display = 'none';
            fechaPrueba = fecha;
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/reportverificacion',
                type: 'post',
                mimeType: 'json',
                data: {
                    idcontrol_verificacion: idcontrol_verificacion,
                    idmaquina: idmaquina
                },
                success: function(data, textStatus, jqXHR) {
                    //console.log(data);
                    $('#body-stats-verifricacion').html('');
                    $('html, body').animate({
                        scrollTop: $("#sec-info-resultadosverificacion").offset().top
                    }, 900);
                    var html = '<tr>\n\
                                                        <th style="font-size: 13px; text-align: center;">Toma de muestra realizada con el aplicativo: </th> \n\
                                                        <th style="font-size: 13px; text-align: center;">' + data.marcasoft + '</th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                    </tr>\n\\n\
                                                    <tr>\n\
                                                        <th style="font-size: 13px; text-align: center;">Fecha y hora de la toma de datos: </th> \n\
                                                        <th style="font-size: 13px; text-align: center;">' + fecha + '</th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                    </tr>\n\
<tr>\n\
                                                        <th style="font-size: 13px; text-align: center;">Numero de serie del analizador de gases: </th> \n\
                                                        <th style="font-size: 13px; text-align: center;">' + data.seriemaquina + '</th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                    </tr>\n\
\n\<tr>\n\
                                                        <th style="font-size: 13px; text-align: center;">Factor de equivalencia propano (PEF): </th> \n\
                                                        <th style="font-size: 13px; text-align: center;">' + data.pef + '</th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                    </tr>\n\
\n\
                                                        <th style="font-size: 13px; text-align: center;">Analizador de gases propiedad de: </th> \n\
                                                        <th style="font-size: 13px; text-align: center;">' + data.nombrecda + '</th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                        <th style="font-size: 13px; text-align: center;"></th> \n\
                                                    </tr>\n\
                                                     <tr>\n\
                                                        <th style="font-size: 13px; text-align: center;">Prueba</th> \n\
                                                        <th style="font-size: 13px; text-align: center;">Tiempo (S)</th> \n\
                                                        <th style="font-size: 13px; text-align: center;">Hc (Ppm)</th> \n\
                                                        <th style="font-size: 13px; text-align: center;">Co (%)</th> \n\
                                                        <th style="font-size: 13px; text-align: center;">Co2 (%)</th> \n\
                                                        <th style="font-size: 13px; text-align: center;">O2 (%)</th> \n\
                                                    </tr>';
                    $('#head-reg-stats-verifricacion').html(html);
                    $.each(data.verificacion, function(i, data) {
                        var info = JSON.parse(data.datos);
                        //console.log(info);
                        $.each(info, function(i, info) {
                            var body = "<tr>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + info.prueba + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + info.tiempo + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + info.hc + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + info.co + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + info.co2 + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + info.o2 + "</td>";
                            body += "</tr>";
                            $("#table-stats-verificacion tbody").append(body);
                        });
                    });
                }
            });
        }

        function getresultadosTiempo(id) {
            document.getElementById("sec-info-resultados-opa").style.display = 'none';
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/resTiempoRespuesta',
                type: 'post',
                dataType: 'json', // Cambiado de mimeType a dataType
                data: {
                    id: id
                },
                success: function(data, textStatus, jqXHR) {
                    console.log(data);
                    document.getElementById("sec-info-resultados-opa").style.display = '';

                    // Limpiar contenido previo
                    $('#body-stats-verifricacion-opa').html('');
                    $('#tr-resultados-opa').nextAll().remove(); // Limpiar filas de datos

                    // Obtener datos parseados
                    var datos = JSON.parse(data[0].datos);

                    // Llenar los datos adicionales en la tabla


                    $("#thMarcaSoftware").text(data.marcasoft)
                    $("#thVersionSoftware").text(data.versionsoft)
                    $("#thCda").text(data[0].cda)
                    $("#thNit").text(data[0].nit)
                    $("#thPlaca").text(data[0].placa)
                    $("#thMarca").text(data.marca)
                    $("#thModelo").text(data.serie_banco)
                    $("#thSerial").text(data.serie_maquina)
                    $("#thFechaHora").text(data[0].fecha)


                    // Crear encabezados dinámicos
                    if (datos.length > 0) {
                        var firstItem = datos[0];
                        $.each(firstItem, function(key, value) {
                            var html = "<th style='font-size: 13px; text-align: center;'>" +
                                key.charAt(0).toUpperCase() + key.slice(1) + "</th>";
                            $('#tr-resultados-opa').append(html);
                        });

                        // Llenar filas de datos
                        $.each(datos, function(index, item) {
                            var row = "<tr>";
                            $.each(item, function(key, value) {
                                row += "<td style='font-size: 12px; text-align: center;'>" + value + "</td>";
                            });
                            row += "</tr>";
                            $('#body-stats-verifricacion-opa').append(row);
                        });
                    }

                    $('html, body').animate({
                        scrollTop: $("#sec-info-resultados-opa").offset().top
                    }, 900);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                }
            });
        }


        $("#btn-descargar-statscalibraciones").click(function() {
            var fecha = $('#get-fecha').val();
            showSuccess('Descargando el informe, por favor espere.');
            $('#table-statscalibraciones').table2csv({
                filename: 'INFORME STATS ' + fecha + '.csv',
                separator: ';',
                newline: '\n',
                quoteFields: true,
                excludeColumns: '',
                excludeRows: '',
                trimContent: true
            });
        });

        $("#btn-descargar-table-verificacion").click(function() {
            var fecha = $('#get-fecha').val();
            showSuccess('Descargando el informe, por favor espere.');
            $('#table-statsverificacion').table2csv({
                filename: 'INFORME STATS ' + fecha + '.csv',
                separator: ';',
                newline: '\n',
                quoteFields: true,
                excludeColumns: '',
                excludeRows: '',
                trimContent: true
            });
        });

        $("#btn-descargar-stats-resultados-opa").click(function() {
            // var fecha = $('#get-fecha').val();
            // showSuccess('Descargando el informe, por favor espere.');
            // $('#table-stats-verificacion-opa').table2csv({
            //     filename: 'INFORME STATS RESULTADOS OPA ' + fechaPrueba + '.csv',
            //     separator: ';',
            //     newline: '\n',
            //     quoteFields: true,
            //     excludeColumns: '1',
            //     excludeRows: '',
            //     trimContent: true
            // });

            var csv = [];
            var rows = $('#table-stats-verificacion-opa tr:not(:has(table))');

            rows.each(function() {
                var row = [];
                $(this).find('td, th').each(function() {
                    row.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
                });
                csv.push(row.join(';'));
            });

            // Añadir datos de la tabla anidada
            csv.push("\nDetalles adicionales:");
            $('#table-stats-verificacion-opa table tr').each(function() {
                var row = [];
                $(this).find('td, th').each(function() {
                    row.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
                });
                csv.push(row.join(';'));
            });

            var csvContent = csv.join('\n');
            var blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'INFORME COMPLETO ' + $('#get-fecha').val() + '.csv';
            link.click();
        });
        $("#btn-descargar-verificaciones").click(function() {
            var fecha = $('#get-fecha').val();
            showSuccess('Descargando el informe, por favor espere.');
            $('#table-stats-verificacion').table2csv({
                filename: 'INFORME STATS RESULTADOS OPA' + fechaPrueba + '.csv',
                separator: ';',
                newline: '\n',
                quoteFields: true,
                excludeColumns: '',
                excludeRows: '',
                trimContent: true
            });
        });
        $("#btn-descargar-logs").click(function() {
            var fecha = $('#get-fecha').val();
            showSuccess('Descargando el informe, por favor espere.');
            $('#table-stats-logs').table2csv({
                filename: 'INFORME LOG PRUEBA GASES ' + fechaPrueba + '.csv',
                separator: ';',
                newline: '\n',
                quoteFields: true,
                excludeColumns: '',
                excludeRows: '',
                trimContent: true
            });
        });
        $("#btn-descargar-informe-pesv").click(function() {
            var fecha = $('#get-fecha').val();
            showSuccess('Descargando el informe, por favor espere.');
            $('#table-informe-pesv').table2csv({
                filename: 'INFORME PESV ' + fechaPrueba + '.csv',
                separator: ';',
                newline: '\n',
                quoteFields: true,
                excludeColumns: '',
                excludeRows: '',
                trimContent: true
            });
        });
        //fin stats calibraciones
        //inicio informe crm
        $('#tipoinspeccion').change(function() {
            var tipoinspeccion = $('#tipoinspeccion option:selected').attr('value');
            if (tipoinspeccion == 1) {
                document.getElementById("numero-meses").style.display = 'none';
            } else {
                document.getElementById("numero-meses").style.display = '';
            }
        });

        var tokenval = "";
        $('#btn-generar-crm').click(function() {
            console.log('dominio:', dominio)
             if (dominio == 'cdalaestacion.tecmmas.com' || dominio == 'cdalamesa.tecmmas.com')
                $('#Modal-token').show();
             else
                getCrm();

        });

        function Validar() {
            var token = $("#token").val();
            $("#valid-token").html('');
            $.ajax({
                url: 'https://atalayasoft.tecmmas.com/atalaya/index.php/Ctriguer/validToken',
                type: 'post',
                mimeType: 'json',
                data: {
                    token: token
                },
                success: function(data, textStatus, jqXHR) {
                    if (data == 1) {
                        tokenval = token;
                        $('#Modal-token').hide();
                        $("#Modal-token-data").show();
                        getCrm();
                    } else {
                        Toast.fire({
                            icon: "info",
                            title: "El token no es correcto",
                            position: 'top-end'
                        });
                        // $("#valid-token").html('El token no es correcto');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + jqXHR);
                }
            });
        }

        function getCrm() {
            document.getElementById("sec-info-report").style.display = 'none';
            if ($('#fechainicial').val().length == 0) {
                $('#valid-dato').html('El campo fecha inicial es obligatorio.');
            } else if ($('#fechafinal').val().length == 0) {
                $('#valid-dato').html('El campo fecha final es obligatorio.');
            } else {
                $('#valid-dato').html('');
                showSuccess('Generando el informe, por favor espere.');
                var fechainicial = $('#fechainicial').val();
                var fechafinal = $('#fechafinal').val();
                var tiposervicio = $('#tiposervicio option:selected').attr('value');
                var tipoinspeccion = $('#tipoinspeccion option:selected').attr('value');
                var selectmeses = $('#selectmeses option:selected').attr('value');
                var dato = 0;
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/get_informe_crm',
                    type: 'post',
                    mimeType: 'json',
                    data: {
                        fechainicial: fechainicial,
                        fechafinal: fechafinal,
                        tiposervicio: tiposervicio,
                        tipoinspeccion: tipoinspeccion,
                        selectmeses: selectmeses
                    },
                    success: function(data, textStatus, jqXHR) {
                        $("#body-reg-crm").html('');
                        $('#div-info').html('');
                        console.log(data);
                        document.getElementById("sec-info-report").style.display = '';
                        $('html, body').animate({
                            scrollTop: $("#sec-info-report").offset().top
                        }, 900);
                        $.each(data, function(i, data) {
                            if (data.Certificado == null) {
                                data.Certificado = 'N/A';
                            }
                            dato++;
                            $('#div-info').html('Numero de registros: ' + dato);
                            var body = "<tr>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Placa + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Tipo_vehiculo + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Cilindraje + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Certificado + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha_impresion + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha_vigencia + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Fecha_vencimiento_soat + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Numero_identidficacion + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Cliente + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Telefono_1 + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Telefono_2 + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Correo + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Cumpleanos + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Ciudad + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Direccion + "</td>";
                            body += "</tr>";
                            $("#table-crm tbody").append(body);
                        });
                    }
                });
            }
        }
        // descargar informe
        $("#btn-descargar-crm").click(function() {
            var fecha = $('#get-fecha').val();
            showSuccess('Descargando el informe, por favor espere.');
            $('#table-crm').table2csv({
                filename: 'INFORME CRM ' + fecha + '.csv',
                separator: ';',
                newline: '\n',
                quoteFields: true,
                excludeColumns: '',
                excludeRows: '',
                trimContent: true
            });
        });
        //Fin informe crm

        //inicio bitacora
        $('#btn-guadar-bitacoras').click(function(ev) {
            document.getElementById("sec-info-bitacoras").style.display = 'none';
            $('#valid-dato-bi').html('');
            ev.preventDefault();
            var html = $('#textbi').val();
            var fechainicialbi = $('#fechainicialbi').val();
            var fechafinalbi = $('#fechafinalbi').val();
            var tipobi = $('#tipobi option:selected').attr('value');
            var gravedadbi = $('#gravedadbi option:selected').attr('value');
            var estadobi = $('#estadobi option:selected').attr('value');
            var maquinabi = $('#maquinabi option:selected').attr('value');
            if (html.length <= 0 || fechainicialbi.length <= 0 || fechafinalbi.length <= 0) {
                $('#valid-dato-bi').html('Todos los campos son obligatorios.');
            } else {
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/bitacoras',
                    type: 'post',
                    mimeType: 'json',
                    data: {
                        fechainicialbi: fechainicialbi,
                        fechafinalbi: fechafinalbi,
                        tipobi: tipobi,
                        gravedadbi: gravedadbi,
                        estadobi: estadobi,
                        maquinabi: maquinabi,
                        html: html
                    },
                    success: function(data, textStatus, jqXHR) {
                        console.log(data);
                        if (data == 1) {
                            $('#valid-dato-bi').html('<div style="color: green">Datos guardados</div>');
                        } else {
                            $('#valid-dato-bi').html('<div style="color: red">Problemas al guardar los datos.</div>');
                        }
                    }
                });
            }
        });
        $('#btn-ver-bitacoras').click(function() {
            document.getElementById("sec-info-bitacoras").style.display = 'none';
            var dato = 0;
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/getBitacoras',
                type: 'post',
                mimeType: 'json',
                success: function(data, textStatus, jqXHR) {
                    $("#body-reg-bitacoras").html('');
                    $('#div-info-bitacoras').html('');
                    document.getElementById("sec-info-bitacoras").style.display = '';
                    $('html, body').animate({
                        scrollTop: $("#sec-info-bitacoras").offset().top
                    }, 900);
                    $.each(data, function(i, data) {
                        dato++;
                        $('#div-info-bitacoras').html('Numero de registros: ' + dato);
                        var body = "<tr>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + data.nombre + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + data.fecha_apertura + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + data.fecha_cierre + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + data.usuario + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + data.comentario + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + data.tipo + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + data.gravedad + "</td>";
                        body += "<td style='font-size: 12px; text-align: center;'>" + data.estado + "</td>";
                        body += "</tr>";
                        $("#body-reg-bitacoras").append(body);
                    });
                }
            });
        });
        $("#btn-descargar-bitacoras").click(function() {
            var fecha = $('#get-fecha').val();
            showSuccess('Descargando el informe, por favor espere.');
            $('#table-bitacoras').table2csv({
                filename: 'INFORME BITACORAS ' + fecha + '.csv',
                separator: ';',
                newline: '\n',
                quoteFields: true,
                excludeColumns: '',
                excludeRows: '',
                trimContent: true
            });
        });
        var maquina = "";

        function bitacoraOpen() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/bitacorasOpen",
                //        url:  localStorage.getItem('urlserver') + "/et/index.php/oficina/reportes/stats/Cstats/bitacorasOpen",
                type: 'post',
                mimeType: 'json',
                //            data: {idusuario: 2},
                success: function(data, textStatus, jqXHR) {
                    console.log(data)
                    document.getElementById('sec-info-bitacoras-cierre').style.display = '';
                    $('#data-bitacoras').html('');
                    var c = 0;
                    $.each(data, function(i, data) {
                        //                    busacarMaquina(data.idmaquina);
                        c++;
                        $('#data-bitacoras').append("\
                                                <div class='card'>\n\
                                                    <div class='card-header' role='tab' id='heading1_0_10'>\n\
                                                    <h5 class='mb-0'>\n\
                                                    <a data-toggle='collapse' href='#collapse1_0_10' role='button' aria-expanded='true' aria-controls='collapse1_0_10'>\n\
                                                    <strong>" + data.fecha_apertura + "-" + data.user + "</strong>\n\
                                                    </a>\n\
                                                    </h5>\n\
                                                    <div>\n\
                                                    <div id='collapse1_0_10' class='collapse show' role='tabpanel' aria-labelledby='heading1_0_10' data-parent='#accordion'>\n\
                                                    <div class='card-body'>\n\
                                                    <div>\n\
                                                    <label style='color: black'><b>Gravedad</b> - " + data.gravedad + " </label><br />\n\
                                                    <label style='color: black'><b>Tipo</b> - " + data.tipo + "</label><br />\n\
                                                    <label style='color: black'><b>Descripcion inicial</b> <br> " + data.comentario + " </label><br />\n\
                                                    </div>\n\
                                                    <h6 style='text-align: center'><b>Fecha cierre</b></h6>\n\
                                                    <p>\n\
                                                    <input type='date' class='form-control datepicker' id='fecha_cierre_final' name='fechafinalbi' data-format='yyyy-mm-dd' autocomplete='off' >\n\
                                                    </p>\n\
                                                    <h6 style='text-align: center'><b>Descripción</b></h6>\n\
                                                    <p>\n\
                                                    <textarea id='descripcion_final' class='textarea textarea--transparent' rows='5' style='width: 100%;  border: solid 1px black'></textarea>\n\
                                                    </p>\n\
                                                    <div style='display: flex; justify-content: center'>\n\
                                                    <input type='submit' onclick='updateBitacora(" + data.id + ")'  name='consultar' id='btn-descargar-bitacoras'   style='background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke' value='Guardar'>\n\
                                                    </div>\n\
                                                    </div>\n\
                                                    </div>\n\
                                                </div>");
                    });
                    $('#coutnBitacoras').html(c);
                    if (c == 0) {
                        document.getElementById('sec-info-bitacoras-cierre').style.display = 'none';
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    ons.notification.alert(textStatus, {
                        title: 'Error' + jqXHR
                    });
                }
            });
        }

        function updateBitacora(idbitacora) {
            var fechacierre = $("#fecha_cierre_final").val();
            var descripcion = $("#descripcion_final").val();
            var valid = true;
            var mesaje = "";
            if (fechacierre == "" || fechacierre == null) {
                valid = false;
                mesaje = mesaje + "Fecha cierre obligatoria. <br>"
            }
            if (descripcion == "" || descripcion == null) {
                valid = false;
                mesaje = mesaje + "Decripción obligatoria. <br>"
            }
            if (!valid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validación de campos',
                    html: mesaje,
                })
            } else {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/updateBitacoras",
                    //            url: localStorage.getItem('urlserver') + "/et/index.php/oficina/reportes/stats/Cstats/updateBitacoras",
                    type: 'post',
                    mimeType: 'json',
                    data: {
                        fechacierre: fechacierre,
                        descripcion: descripcion,
                        idbitacora: idbitacora
                    },
                    success: function(data, textStatus, jqXHR) {
                        bitacoraOpen()
                        Swal.fire({
                            icon: 'success',
                            title: 'Exitoso',
                            text: 'Bitacora guardada.',
                        })
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: jqXHR,
                        })
                    }
                });
            }
        }

        $("#btn-descargar-pesv").click(function(ev) {
            ev.preventDefault();
            var fechainicial = $("#fechainicial-pesv").val()
            var fechafinal = $("#fechafinal-pesv").val()
            var valid = true;
            var msj = "";
            if (fechainicial == null || fechafinal == "") {
                valid = false;
                msj += "Ingrese la fechainicial <br>";
            }

            if (fechafinal == null || fechafinal == "") {
                valid = false;
                msj += "Ingrese la fechafinal <br>";
            }

            if (!valid) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Campo obligatorio.',
                    html: msj,
                    showConfirmButton: true,
                    //                                                    timer: 1500
                });
            } else {
                document.getElementById("sec-informe-pesv").style.display = 'none';
                showSuccess('Cargando resultados, por favor espere.');
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/informePesv",
                    type: 'post',
                    mimeType: 'json',
                    data: {
                        fechainicial: fechainicial,
                        fechafinal: fechafinal
                    },
                    success: function(data, textStatus, jqXHR) {
                        console.log(data)
                        $("#body-informe-pesv").html('');
                        $('#div-info-pesv').html('');
                        document.getElementById("sec-informe-pesv").style.display = '';
                        $('html, body').animate({
                            scrollTop: $("#sec-informe-pesv").offset().top
                        }, 900);
                        var html = '<tr>\n\
                                                                                <th style="font-size: 13px; text-align: center;">Fecha</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Placa</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Clase</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Inspector</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Identificacion</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Aux-prerevision</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Identificacion-prerevision</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Aprobado/Reprobado</th> \n\
                                                                                <th style="font-size: 13px; text-align: center;">Consecutivo runt</th> \n\
                                                                            </tr>';
                        $('#head-informe-pesv').html(html);
                        var dato = 0;
                        $.each(data, function(i, data) {
                            dato++;
                            $('#div-info-pesv').html('Numero de registros: ' + dato);
                            var body = "<tr>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.fechainicial + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.numeroPlaca + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Clase + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Inspector + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.Identificacion + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.AuxPrerevision + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.IdentificacionP + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.AprobadoReprobado + "</td>";
                            body += "<td style='font-size: 12px; text-align: center;'>" + data.ConsecutivoRunt + "</td>";
                            body += "</tr>";
                            $("#table-informe-pesv tbody").append(body);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: jqXHR,
                        })
                    }
                });
            }
        })
        //fin bitacota
    </script>