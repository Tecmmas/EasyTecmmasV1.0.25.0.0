<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <script>
        var entrada = new Array();
        var ard, lea;
        var marca, serie, ip;
        var configuracion;

        window.onload = function () {
            getConfiguracion();
            //leer();
        };

        function getConfiguracion() {
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
            //  alert(configuracion[3].val);
            lea = true;
            ard = new Worker(leerArd());

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
                            document.getElementById("alineacion").innerHTML = entrada[$('#item3').text()];
                            document.getElementById("sensor").innerHTML = entrada[$('#item8').text()];
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

        function escribirArd() {
            data = {
                response: $("#response").val(),
                valor: $("#valor").val()
            };
            $.ajax({
                url: "<?php echo base_url() ?>index.php/Cmodbus/escribir",
                data: data,
                type: 'post'
            });
        }

        function terminarArd() {
            lea = false;
        }


    </script>
    <body>
<!--        <table border="1" id="table_lectura">
            <tr>
                <td>Rspse</td>
                <td>Valor</td>
            </tr>
        <?php
//            for ($i = 0; $i <= 29; $i++) {
//                echo "<tr><td>r$i</td>";
//                echo "<td><label id='r$i'></label></td></tr>";
//            }
        ?>
        </table>
        <input id="response" type="number" />
        <input id="valor" type="number" />
        <input type="submit" onclick="escribirArd()" value="Enviar" /><br>
        
        <input type="submit" onclick="mostrar()" value="Mostrar" />-->
        <h2>Servicio de alineación</h2>
        <table style="width: 100%">
            <tr>
                <td><h3>Informacion del dispostivo</h3></td>
                <td><h3>Configuración</h3></td>
            </tr>
            <tr>
                <td><table>
                        <tr>
                            <td><strong>Marca: </strong></td>
                            <td><p id="marca"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Serie: </strong></td>
                            <td><p id="serie"></p></td>
                        </tr>
                        <tr>
                            <td><strong>IP: </strong></td>
                            <td><p id="ip"></p></td>
                        </tr>
                    </table></td>
                <td><table>
                        <tr>
                            <td><strong>Entrada analógica: </strong></td>
                            <td><p id="item3"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Entrada digital: </strong></td>
                            <td><p id="item4"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Divisor de entrada: </strong></td>
                            <td><p id="item5"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Punto cero: </strong></td>
                            <td><p id="item6"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Ciclos: </strong></td>
                            <td><p id="item7"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Response: </strong></td>
                            <td><p id="item8"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Velocidad lectura: </strong></td>
                            <td><p id="item9"></p></td>
                        </tr>
                    </table></td>
            </tr>
        </table>

        <h3>Lectura</h3>
        <table style="width: 100%">
            <tr>
                <td><strong>Sensor: </strong></td>
                <td><p id="sensor"></p></td>
            </tr>
            <tr>
                <td><strong>Alineacion: </strong></td>
                <td><p id="alineacion"></p></td>
            </tr>
        </table>
        <input type="submit" onclick="iniciarArd()" value="Iniciar" />
        <input type="submit" onclick="terminarArd()" value="Terminar" /></br>
        <strong>Fecha de consulta: </strong>
        <p id="ahora"></p>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 

    </body>
</html>
