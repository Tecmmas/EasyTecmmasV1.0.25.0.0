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

    .table-wrapper {
        /*width: 100%;*/
        height: 500px;   
        overflow: auto;
        white-space: nowrap;

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
                <div class="content-body">    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Auditorias de pruebas</h2>
                                </header>

                                <div class="content-body">    
                                    <div class="row">
                                        <div class="col-12">

                                            <header class="panel_header">
                                                <div style="color: red;">
                                                    <input type="submit" name="consultar" onclick="limpiarform()"  style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke;"  value="Limpiar campos" >
                                                </div>
                                            </header>
                                            <div class="row">
                                                <div class="col-12">
                                                    <form id="form">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <label style="font-weight: bold; color: grey; align-content: center;margin-top: 10px" for="nombres">Placa</label>
                                                                        <div  style="margin-top: 5px;">
                                                                            <input type="text" class="input" id="placa" style="height: 31px; width: 190px; text-transform: uppercase">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div  style="margin-top: 10px;">
                                                                            <label style="font-weight: bold; color: grey; align-content: center" for="nombres">Equipo
                                                                                <select class="select-css" id="idmaquina" name="sel-analizador">
                                                                                    <option disabled="disabled" selected="selected">Seleccionar</option>
                                                                                    <?php foreach ($maquina as $item): ?>
                                                                                        <?php if (($item->prueba == 'suspension' && $item->activo == 1) || ($item->prueba == 'frenometro' && $item->activo == 1) || ($item->prueba == 'alineador' && $item->activo == 1) || ($item->prueba == 'taximetro' && $item->activo == 1)): ?>
                                                                                            <option data="<?= $item->conf_idtipo_prueba ?>" value="<?= $item->idconf_maquina ?>"><?= $item->nombre . '-' . $item->marca . '-' . $item->serie_maquina . '-' . $item->serie_banco ?></option>
                                                                                        <?php endif; ?>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </label>
                                                                            <div id="valid-maquina" style="color: red"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div  style="margin-top: 10px">
                                                                            <label style="font-weight: bold; color: grey; align-content: center " for="nombres">Fecha inicial
                                                                                <input type="text" class="form-control datepicker" id="fechainicial" name="fechainicialc" data-format="yyyy-mm-dd " autocomplete="off" style="margin-top: 10px">
                                                                            </label>
                                                                        </div>
                                                                    </td>

                                                                    <td>
                                                                        <div  style="margin-top: 40px">
                                                                            <label style="font-weight: bold; color: black; align-content: center"></label>
                                                                            <input type="submit" name="consultar" id="btn-consultar"  style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke;"  value="Generar" >
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div id="infores" style="color: red"></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        </section>
                                        <section class="box" style="display: none"  id="sec-suspension">
                                            <div class="content-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-wrapper">
                                                            <div class="form-group row">
                                                                <input type="submit" name="consultar" id="btn-descargar"   style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; margin-left: 20px" value="Descargar">
                                                            </div>
                                                            <table class="table" id="table-suspension" >
                                                                <thead id="head-suspension">
                                                                </thead>
                                                                <tbody id="body-suspension">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="box" style="display: none"  id="sec-grafica">
                                            <div class="content-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <br>
                                                        <header class="panel_header">
                                                            <div style="color: black; text-align: center; font-size: 18px">
                                                                <b>GRAFICA PRUEBA</b>
                                                            </div>
                                                        </header>
                                                        <div class="col-xs-12">
                                                            <section class="box ">
                                                                <div id="canva"></div>
                                                            </section>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="box" style="display: none"  id="sec-table-taximetro">
                                            <div class="content-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-wrapper">
                                                            <div class="form-group row">
                                                                <input type="submit" name="consultar" id="btn-descargar"   style="background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke; margin-left: 20px" value="Descargar">
                                                            </div>
                                                            <table class="table" id="table-taximetro" >
                                                                <thead id="head-taximetro">
                                                                </thead>
                                                                <tbody id="body-taximetro">

                                                                </tbody>
                                                            </table>
                                                        </div>
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
                                var distancia = [];
                                var tiempo = [];
                                function limpiarform() {
                                    $("#form")[0].reset();
                                    document.getElementById("sec-table-taximetro").style.display = "none";
                                }
                                $('#btn-consultar').click(function (ev) {
                                    document.getElementById("sec-table-taximetro").style.display = "none";
                                    $('#infores').html('');
                                    ev.preventDefault();
                                    var placa = $("#placa").val();
                                    var idmaquina = $('#idmaquina option:selected').attr('value');
                                    var tipoprueba = $('#idmaquina option:selected').attr('data');
                                    var fecha = $("#fechainicial").val();
                                    var mesaje = "";
                                    var valid = true;
                                    if (tipoprueba == 6) {
                                        if (placa == "" || placa == null) {
                                            mesaje = mesaje + "La placa es obligatoria.<br>";
                                            valid = false;
                                        }
                                    }
                                    if (idmaquina == null || idmaquina == "") {
                                        mesaje = mesaje + "Seleccione la maquina. <br>";
                                        valid = false;
                                    }
                                    if (!valid) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Campos obligatorios.',
                                            html: mesaje,
//                                            footer: '<a href="">Why do I have this issue?</a>'
                                        })
                                    } else {
                                        localStorage.setItem('tipoPruebaGrafica', tipoprueba);
                                        $("#valid-maquina").text('')
                                        $.ajax({
                                            url: '<?php echo base_url(); ?>index.php/oficina/reportes/auditorias/Cauditorias/getDatos',
                                            type: 'post',
                                            mimeType: 'json',
                                            data: {placa: placa,
                                                idmaquina: idmaquina,
                                                fecha: fecha,
                                                tipoprueba: tipoprueba},
                                            success: function (data) {
                                                document.getElementById('sec-suspension').style.display = "";
                                                $('#body-suspension').html('');
                                                $('html, body').animate({
                                                    scrollTop: $("#sec-suspension").offset().top
                                                }, 900);
                                                switch (tipoprueba) {
                                                    case '6':
                                                        var html = '<tr>\n\
                                                    <th style="font-size: 13px; text-align: center;">Placa</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Maquina</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Fecha</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Tiempo</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Distancia</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Opciones</th> \n\
                                                                    </tr>';
                                                        $('#head-suspension').html(html);


                                                        $.each(data, function (i, data) {
                                                            distancia = data.vector_distancia.split("|");
                                                            tiempo = data.vector_tiempo.split("|");
                                                            var body = "<tr>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.placa + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.idmaquina + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.fecha + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.error_tiempo_nuevo + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.error_distancia_nuevo + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'><button onclick=(getTaximetro()) style='background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke'>Vectores</button></td>";



                                                            body += "</tr>";
                                                            $("#table-suspension tbody").append(body);
                                                        });
                                                        break;
                                                    case '7':
                                                        var html = '<tr>\n\
                                                    <th style="font-size: 13px; text-align: center;">Placa</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Maquina</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Fecha</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Eje</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Llanta</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Valor</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Opciones</th> \n\
                                                                    </tr>';
                                                        $('#head-suspension').html(html);
                                                        $.each(data, function (i, data) {
                                                            var body = "<tr>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.placa + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.idmaquina + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.fecha + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.eje + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.llanta + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.valor + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'><button onclick=(getVector(" + data.id + ")) style='background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke'>Generar grafica</button></td>";
                                                            body += "</tr>";
                                                            $("#table-suspension tbody").append(body);
                                                        });
                                                        break;
                                                    case '9':
                                                        var html = '<tr>\n\
                                                    <th style="font-size: 13px; text-align: center;">Placa</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Maquina</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Fecha</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Llanta</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Peso</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Valor minimo</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Adherencia</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Estado</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Opciones</th> \n\
                                                                    </tr>';
                                                        $('#head-suspension').html(html);
                                                        $.each(data, function (i, data) {

                                                            if (data.peso < 0 || data.valor_minimo < 0 || data.adherencia < 0) {
                                                                var style = "style='background-color: #FADBD8'"
                                                                var estado = "Prueba mal realizada"
                                                            } else {
                                                                var style = "style='background-color: whitesmoke'"
                                                                var estado = "Finalizada"
                                                            }
                                                            var body = "<tr " + style + ">";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.placa + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.idmaquina + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.fecha + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.llanta + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.peso + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.valor_minimo + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.adherencia + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + estado + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'><button onclick=(getVector(" + data.id + ")) style='background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke'>Generar grafica</button></td>";
                                                            body += "</tr>";
                                                            $("#table-suspension tbody").append(body);
                                                        });
                                                        break;
                                                    case '10':
                                                        var html = '<tr>\n\
                                                                    <th style="font-size: 13px; text-align: center;">Placa</th> \n\
                                                                    <th style="font-size: 13px; text-align: center;">Maquina</th> \n\
                                                                    <th style="font-size: 13px; text-align: center;">Fecha</th> \n\
                                                                    <th style="font-size: 13px; text-align: center;">Eje</th> \n\
                                                                    <th style="font-size: 13px; text-align: center;">Valor</th> \n\
                                                                    <th style="font-size: 13px; text-align: center;">Opciones</th> \n\
                                                                </tr>';
                                                        $('#head-suspension').html(html);
                                                        $.each(data, function (i, data) {
                                                            var body = "<tr>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.placa + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.idmaquina + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.fecha + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.eje + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'>" + data.valor + "</td>";
                                                            body += "<td style='font-size: 12px; text-align: center;'><button onclick=(getVector(" + data.id + ")) style='background-color: #393185;border-radius: 40px 40px 40px 40px; width: 180px; color: whitesmoke'>Generar grafica</button></td>";
                                                            body += "</tr>";
                                                            $("#table-suspension tbody").append(body);
                                                        });

                                                        break;

                                                    default:

                                                        break;
                                                }

                                            },
                                            error: function (xhr) {
                                                $('#infores').html('Error:' + xhr.responseText);
                                            }

                                        });
                                    }

                                });
                                function getVector(id) {
                                    var tipoprueba = localStorage.getItem('tipoPruebaGrafica');
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/oficina/reportes/auditorias/Cauditorias/getVector',
                                        type: 'post',
                                        mimeType: 'json',
                                        data: {id: id,
                                            tipoprueba: tipoprueba},
                                        success: function (data) {
                                            $('#myChart').remove();
                                            document.getElementById('sec-grafica').style.display = "";
                                            $('html, body').animate({
                                                scrollTop: $("#sec-grafica").offset().top
                                            }, 900);
                                            switch (tipoprueba) {
                                                case '7':
                                                    GraficaFrenos(data[0].vector, data[0].valor)
                                                    break;
                                                case '9':
                                                    GraficaSuspension(data[0].vector, data[0].valor_minimo, data[0].peso)
                                                    break;
                                                case '10':
                                                    GraficaAlineacion(data[0].vector, data[0].valor)
                                                    break;

                                                default:

                                                    break;
                                            }

                                        },
                                        error: function (xhr) {
                                            $('#infores').html('Error:' + xhr.responseText);
                                        }

                                    })
                                }
//
                                function GraficaSuspension(datos, minimo, peso) {
                                    $('#canva').html('<canvas id="myChart" height="200" width="600"></canvas>');
                                    const labels = [];
                                    var da = JSON.parse(datos);
                                    var linePeso = [];
                                    var lineMinimo = [];
                                    $.each(da, function (i, datos) {
                                        labels.push(i);
                                        linePeso.push(peso);
                                        lineMinimo.push(minimo);
                                    });
                                    const data = {
                                        labels: labels,
                                        datasets: [
                                            {
                                                label: 'Datos',
                                                data: [...da],
                                                borderColor: 'rgb(255, 99, 132)',
                                                backgroundColor: 'rgb(255, 99, 132)',
                                            }
                                            ,
                                            {
                                                label: 'Peso',
                                                data: [...linePeso],
                                                borderColor: 'black',
                                                backgroundColor: 'black',
                                            }
                                            ,
                                            {
                                                label: 'Minimo',
                                                data: [...lineMinimo],
                                                borderColor: 'red',
                                                backgroundColor: 'red',
                                            }
                                        ]
                                    };
                                    const config = {
                                        type: 'line',
                                        data: data,
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                title: {
                                                    display: true,
                                                    text: 'Grafica de prueba'
                                                }
                                            },
                                            scales: {
                                                y: {
                                                    // the data minimum used for determining the ticks is Math.min(dataMin, suggestedMin)
                                                    suggestedMin: 0,
                                                    // the data maximum used for determining the ticks is Math.max(dataMax, suggestedMax)
                                                    suggestedMax: Math.max(...datos),
                                                }
                                            }
                                        },
                                    };

                                    const myChart = new Chart(
                                            document.getElementById('myChart'),
                                            config
                                            );


                                }

                                function GraficaFrenos(datos, valor) {
                                    $('#canva').html('<canvas id="myChart" height="200" width="600"></canvas>');
                                    const labels = [];
                                    var da = JSON.parse(datos);
                                    var arrValor = [];
//                                    var lineMinimo = [];
                                    $.each(da, function (i, datos) {
                                        labels.push(i);
                                        arrValor.push(valor);
//                                        lineMinimo.push(minimo);
                                    });
                                    const data = {
                                        labels: labels,
                                        datasets: [
                                            {
                                                label: 'Datos',
                                                data: [...da],
                                                borderColor: 'rgb(255, 99, 132)',
                                                backgroundColor: 'rgb(255, 99, 132)',
                                            }
                                            ,
                                            {
                                                label: 'Valor',
                                                data: [...arrValor],
                                                borderColor: 'black',
                                                backgroundColor: 'black',
                                            }

                                        ]
                                    };
                                    const config = {
                                        type: 'line',
                                        data: data,
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                title: {
                                                    display: true,
                                                    text: 'Grafica de prueba'
                                                }
                                            },
                                            scales: {
                                                y: {
                                                    // the data minimum used for determining the ticks is Math.min(dataMin, suggestedMin)
                                                    suggestedMin: Math.min(...datos),
                                                    // the data maximum used for determining the ticks is Math.max(dataMax, suggestedMax)
                                                    suggestedMax: Math.max(...datos),
                                                }
                                            }
                                        },
                                    };

                                    const myChart = new Chart(
                                            document.getElementById('myChart'),
                                            config
                                            );
                                }

                                function GraficaAlineacion(datos, valor) {
                                    console.log(datos);
                                    $('#canva').html('<canvas id="myChart" height="200" width="600"></canvas>');
                                    const labels = [];
                                    var da = JSON.parse(datos);
                                    var arrValor = [];
//                                    var lineMinimo = [];
                                    $.each(da, function (i, datos) {
                                        labels.push(i);
                                        arrValor.push(valor);
//                                        lineMinimo.push(minimo);
                                    });
                                    const data = {
                                        labels: labels,
                                        datasets: [
                                            {
                                                label: 'Datos',
                                                data: [...da],
                                                borderColor: 'rgb(255, 99, 132)',
                                                backgroundColor: 'rgb(255, 99, 132)',
                                            }
                                            ,
                                            {
                                                label: 'Valor',
                                                data: [...arrValor],
                                                borderColor: 'black',
                                                backgroundColor: 'black',
                                            }

                                        ]
                                    };
                                    const config = {
                                        type: 'line',
                                        data: data,
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                title: {
                                                    display: true,
                                                    text: 'Grafica de prueba'
                                                }
                                            },
                                            scales: {
                                                y: {
                                                    // the data minimum used for determining the ticks is Math.min(dataMin, suggestedMin)
                                                    suggestedMin: Math.min(...datos),
                                                    // the data maximum used for determining the ticks is Math.max(dataMax, suggestedMax)
                                                    suggestedMax: Math.max(...datos),
                                                }
                                            }
                                        },
                                    };

                                    const myChart = new Chart(
                                            document.getElementById('myChart'),
                                            config
                                            );
                                }
                                function getTaximetro() {
                                    document.getElementById("sec-table-taximetro").style.display = "";

                                    console.log(tiempo)
                                    console.log(distancia)
                                    var html = '<tr>\n\
                                                    <th style="font-size: 13px; text-align: center;">Caida</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Distancia</th> \n\
                                                    <th style="font-size: 13px; text-align: center;">Tiempo</th> \n\
                                                </tr>';
                                    $('#head-taximetro').html(html);
                                    if (distancia.length > tiempo.length) {
                                        $.each(distancia, function (i, distancia) {

                                            var body = "<tr>";
                                            body += "<td style='font-size: 12px; text-align: center;'>" + i + "</td>";
                                            body += "<td style='font-size: 12px; text-align: center;'>" + distancia + "</td>";
                                            body += "<td style='font-size: 12px; text-align: center;'>" + tiempo[i] + "</td>";
                                            body += "</tr>";
                                            $("#table-taximetro tbody").append(body);

                                        });
                                    } else {
                                        $.each(tiempo, function (i, tiempo) {
                                            var body = "<tr>";
                                            body += "<td style='font-size: 12px; text-align: center;'>" + i + "</td>";
                                            body += "<td style='font-size: 12px; text-align: center;'>" + distancia[i] + "</td>";
                                            body += "<td style='font-size: 12px; text-align: center;'>" + tiempo + "</td>";
                                            body += "</tr>";
                                            $("#table-taximetro tbody").append(body);

                                        });
                                    }


                                    $('html, body').animate({
                                        scrollTop: $("#sec-table-taximetro").offset().top
                                    }, 900);
                                }


                                $("#btn-descargar").click(function () {
                                    showSuccess('Descargando el informe, por favor espere.');
                                    $('#table-suspension').table2csv({
                                        filename: 'INFORME AUDITORIA.csv',
                                        separator: ';',
                                        newline: '\n',
                                        quoteFields: true,
                                        excludeColumns: '',
                                        excludeRows: '',
                                        trimContent: true
                                    });
                                }
                                );



                            </script>



