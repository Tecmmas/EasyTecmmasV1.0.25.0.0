<script type="text/javascript">
    var entrada = new Array();
    var ard, lea;
    var marca, serie, ip;
    var configuracion;
    var alineacion;
    var sensorAli, ciclosAli;
    var inductivoAliCad;
    var incrementarEjeAli;
    var ejeAli;
    var capturarAli;
    var alineacionEje1, alineacionEje2;
    function inicalizarAli() {
        ejeAli = 0;
        incrementarEjeAli = true;
        ciclosAli = 0;
        aliAnt = 0;
        valMaxAli = 0;
        alineacionEje1 = '---';
        alineacionEje2 = '---';
    }
    function getConfiguracion() {
        inicalizarAli();
        data = {
            idconfiguracion: '1'
        };
        $.ajax({
            url: "https://10.8.0.54:8091/atalaya/index.php/cget",
            data: data,
            type: 'post',
            success: function (r) {
                if (r) {
                    try {

                        var d = JSON.parse(r);
                        var dispositivo = d.dispositivo[0];
                        // alert();
                        $('#marca').text(dispositivo.marca);
                        $('#serie').text(dispositivo.serie);
                        $('#ip').text(dispositivo.ip);
                        $('#ahora').text(d.ahora[0].ahora);
                        configuracion = d.configuracion;
                        var i;
                        for (i = 0; i <= d.configuracion.length; i++) {
                            $('#item' + d.configuracion[i].iditem).text(d.configuracion[i].val);
                        }
                        i = d = null;
                    } catch (e) {
                    }
                }
            }
        });
    }
    function iniciarArd() {
        getConfiguracion();
        lea = true;
        ard = new Worker(leerArd());
        ocultarComponente('btnIniciar');
    }

    function leerArd() {
        data = {
            ip: $("#ip").text()
        };
        $.ajax({
            url: "<?php echo base_url() ?>index.php/Cmodbus/leer",
            data: data,
            type: 'post',
            success: function (r) {
                if (r) {
                    try {
                        var d = JSON.parse(r);
                        var i;
                        for (i = 0; i <= d.address; i++) {
                            entrada[i] = d.result[i].dato;
                        }
                        alineacion = (entrada[$('#item3').text()] - $('#item6').text()) / $('#item5').text();
                        inductivoAliCad = entrada[$('#item8').text()].toString(2);
                        if (inductivoAliCad.length < 2) {
                            inductivoAliCad = '0000' + inductivoAliCad;
                        } else if (inductivoAliCad.length < 3) {
                            inductivoAliCad = '000' + inductivoAliCad;
                        } else if (inductivoAliCad.length < 4) {
                            inductivoAliCad = '00' + inductivoAliCad;
                        } else if (inductivoAliCad.length < 5) {
                            inductivoAliCad = '0' + inductivoAliCad;
                        }
                        if (inductivoAliCad.toString().substring($('#item4').text()) === '1') {
                            sensorAli = true;
                            incrementarEje();
                        } else {
                            sensorAli = false;
                            incrementarEjeAli = true;
                        }

                        document.getElementById("AlineacionEje1").innerHTML = alineacionEje1;
                        document.getElementById("AlineacionEje2").innerHTML = alineacionEje2;

                        if (ciclosAli < $('#item7').text() && ejeAli !== 0) {
                            capturarAlineacion();
                            ciclosAli++;
                        }

                        i = d = null;
                    } catch (e) {
                    }
                }
            }
        });
        if (lea) {
            setTimeout("leerArd()", $('#item9').text());
        } else {
            ard.terminate();
        }
    }

    function incrementarEje() {
        if (incrementarEjeAli) {
            incrementarEjeAli = false;
            ejeAli++;
            ciclosAli = 0;
//            if (ejeAli === 2) {
//                alineacionEje1 = valMaxAli;
//            }
//            if (ejeAli === 3) {
//                alineacionEje2 = valMaxAli;
//            }
        }
    }
    var valMaxAli;
    var aliAnt;
    function capturarAlineacion() {
        if (alineacion > 0) {
            if (alineacion > aliAnt) {
                valMaxAli = alineacion;
            }
        } else {
            if (alineacion < aliAnt) {
                valMaxAli = alineacion;
            }
        }
        aliAnt = alineacion;
        if (ejeAli === 1) {
            alineacionEje1 = Math.round(valMaxAli);
        } else if (ejeAli === 2) {
            alineacionEje2 = Math.round(valMaxAli);
            mostrarComponente('btnTerminar');
            lea = false;

        }
    }

    function TerminarAli() {
        data = {
            alineacion1: alineacionEje1,
            alineacion2: alineacionEje2,
            idprueba: <?php echo $idalineacion; ?>
        };
        $.ajax({
            url: "<?php echo base_url() ?>index.php/CPrueba/guardarAlineacion",
            data: data,
            type: 'post',
            success: function (r) {
                window.location.href = "<?php echo base_url() ?>index.php/CPrueba/CPistaPrincipal";
            }
        });
    }


</script>

<section class="box ">
    <header class="panel_header">
        <h2 class="title float-left">Alineación</h2>
    </header>
    <div class="content-body">    <div class="row">
            <h6>Servicio de alineación</h6>
            <table style="width: 100%">
                <tr>
                    <td><h5 style="text-align: left">Informacion del dispostivo</h5></td>
                    <td><h5 style="text-align: left">Configuración</h5></td>
                </tr>
                <tr>
                    <td><table>
                            <tr>
                                <td style="text-align: left"><strong>Marca: </strong></td>
                                <td  style="text-align: left"><p id="marca"></p></td>
                            </tr>
                            <tr>
                                <td  style="text-align: left"><strong>Serie: </strong></td>
                                <td  style="text-align: left"><p id="serie"></p></td>
                            </tr>
                            <tr>
                                <td  style="text-align: left"><strong>IP: </strong></td>
                                <td  style="text-align: left"><p id="ip"></p></td>
                            </tr>
                        </table></td>
                    <td><table>
                            <tr>
                                <td  style="text-align: left"><strong>Entrada analógica: </strong></td>
                                <td  style="text-align: left"><p id="item3"></p></td>
                            </tr>
                            <tr>
                                <td  style="text-align: left"><strong>Entrada digital: </strong></td>
                                <td  style="text-align: left"><p id="item4"></p></td>
                            </tr>
                            <tr>
                                <td  style="text-align: left"><strong>Divisor de entrada: </strong></td>
                                <td  style="text-align: left"><p id="item5"></p></td>
                            </tr>
                            <tr>
                                <td  style="text-align: left"><strong>Punto cero: </strong></td>
                                <td  style="text-align: left"><p id="item6"></p></td>
                            </tr>
                            <tr>
                                <td  style="text-align: left"><strong>Ciclos: </strong></td>
                                <td  style="text-align: left"><p id="item7"></p></td>
                            </tr>
                            <tr>
                                <td  style="text-align: left"><strong>Response: </strong></td>
                                <td  style="text-align: left"><p id="item8"></p></td>
                            </tr>
                            <tr>
                                <td  style="text-align: left"><strong>Velocidad lectura: </strong></td>
                                <td  style="text-align: left;vertical-align: middle"><p id="item9"></p></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div class="col-12"><button id="btnIniciar" onclick="iniciarArd()" class="btn btn-success">Iniciar prueba</button>
                <br/>
                <br/>
                <label><strong>ID Prueba</strong><?php echo $idalineacion; ?></label>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Eje</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1</th>
                            <td><p id="AlineacionEje1"></p></td>
                        </tr>
                        <tr>
                            <th>2</th>
                            <td><p id="AlineacionEje2"></p></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12"><button id="btnTerminar" onclick="TerminarAli()" class="btn btn-danger">Terminar prueba</button>
            </div>
        </div>
</section>
