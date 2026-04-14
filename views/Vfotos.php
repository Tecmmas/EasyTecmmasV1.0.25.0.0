<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Imágenes con Canvas</title>
</head>

<body>
    <h1>Vista de Imágenes con Canvas</h1>
    <canvas id="cFoto1" width="800" height="600" style="border:1px solid #000;"></canvas>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var ipLocal = '<?php
                        echo base_url();
                        ?>';
        // Cargar una imagen completa en base64 y asignarla a una variable

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>index.php/Cindex_/consultarImagen",
            mimeType: 'json',
            async: true,
            success: function(data, textStatus, jqXHR) {
                imagen(data.imagen)

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText)

            }
        });


        var imagen = function(base64Image) {
            var canvas = document.getElementById('cFoto1');
            var context = canvas.getContext('2d');
            var numero_placa = "AAA001";
            var f1 = new Image();
            f1.src = base64Image;
            f1.onload = function() {
                context.font = "22px Arial";
                context.drawImage(f1, 0, 0, 650, 490);
                context.fillRect(5, 450, 322, 33);
                context.strokeStyle = "#FFFFFF";
                context.strokeText("2025-01-01, " + numero_placa + " " + "10:00", 10, 472);
                context.strokeStyle = "#000000";
                var foto1 = document.getElementById('foto1');
                console.log(foto1);
                var foto = canvas.toDataURL('image/jpeg', 0.6);
                 foto1.style.backgroundImage = "url('" + foto + "')";
                 foto1.value = '';
                // guardarFoto(fotografia1.idprueba, foto, localStorage.getItem('IdUsuario'));
                //evaluarSiFinaliza();
            };
        }
    </script>
</body>

</html>