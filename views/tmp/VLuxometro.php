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
    <script type="text/javascript">
        var ard, lea;
        var entrada = new Array();
        var trama = new Array();
        var inicio = false;
        var indTrama;
        var rdTrama;
        window.onload = function () {
            lea = true;
            ard = new Worker(leerArd());

            indTrama = 0;
            escribirArd(23, 18);
            escribirArd(24, 2);
            escribirArd(25, 1);
            escribirArd(21, 0);
            escribirArd(22, 0);
        };
        function leerArd() {
            data = {
                ip: '0'
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
//                                document.getElementById("id" + i).innerHTML = entrada[i];
                            }

                            if (entrada[21] === 1 && !inicio) {
                                inicio = true;
                                rdTrama = new Worker(leerTrama());
                            }
                            i = d = null;
                        } catch (e) {
                        }
                    }
                }
            });
            if (lea) {
                setTimeout("leerArd()", 80);
            } else {
                ard.terminate();
            }
        }

        function leerTrama() {

            indTrama++;
            escribirArd(25, indTrama);
            if (indTrama === entrada[21]) {
                document.getElementById("id" + indTrama).innerHTML = entrada[21] + "-" + entrada[22];// + "-" + charCodeAt(entrada[22]);
            } else {
                indTrama--;
            }



            if (entrada[21] === 18) {
                indTrama = 0;
                rdTrama.terminate();
            } else {
                setTimeout("leerTrama()",100);
            }

        }

        function sleep(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds) {
                    break;
                }
            }
        }


        function escribirArd(response, valor) {
            data = {
                response: response,
                valor: valor
            };
            $.ajax({
                url: "<?php echo base_url() ?>index.php/Cmodbus/escribir",
                data: data,
                type: 'post'
            });
        }
    </script>
    <body>


        <?php
        for ($i = 1; $i <= 19; $i++) {
            echo "<p id='id$i'></p>";
        }
        ?>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 
    </body>

</html>
