<?php $this->load->view('./header'); ?>

<!-- START CONTENT -->
<style>
    .swal2-html-container {
        color: black;
        text-align: justify;
    }
    .swal2-title{
        color: red;
    }
    .swal2-icon swal2-error swal2-icon-show{
        imageUrl: '/img/loading-gif.png';
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
                                <style>
                                    .menu-barra:hover{
                                        background-color: #b2e2f2;
                                        font-size: 17px;
                                        color: whitesmoke;
                                        font-family: sans-serif;
                                        border-radius: 10px 10px 10px 10px;
                                    };

                                </style>
                                <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fdf9c4">
                                    <div class="collapse navbar-collapse" id="navbarText">
                                        <ul class="navbar-nav mr-auto">
                                            <li class="nav-item">
                                                <a class="nav-link menu-barra" style="color: black" href="<?php echo base_url(); ?>index.php/oficina/backup/Cbackup"><i>Backup</i></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link menu-barra" style="color: black" href="<?php echo base_url(); ?>index.php/oficina/backup/Cbackup/viewreportbackup"><i>Reporte</i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                                <header class="panel_header">
                                    <h2 class="title float-left">Generador backup</h2>
                                </header>

                                <div class="content-body">    
                                    <div class="row">
                                        <div class="col-12">
                                            <!--<form action="<?php echo base_url(); ?>index.php/oficina/backup/Cbackup/createcronbak" method="post">-->
                                            <table class="table" >
                                                <thead>
                                                    <tr>
                                                        <th>Información</th>
                                                        <th>Generar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align: left; width: 70%">
                                                            El backup se debe realizar diariamente, es de carácter obligatorio, para poder tener un respaldo de la información almacenada.
                                                        </td> 
                                                        <td style="text-align: center; margin-top: 2px">       
                                                            <label style="font-weight: bold; color: black"></label>
                                                            <input type="hidden" name="rtamaria" id="rtamaria" value="<?= $rtamaria ?>">
                                                            <input type="hidden" name="date" id="date" value="<?= $date ?>">
                                                            <input type="hidden" name="date" id="dateactu" value="<?= $dateactu ?>">
                                                            <input type="submit" name="consultar" id="btn-generarbackup" class="btn btn-accent btn-block"  style="background-color: #393185;border-radius: 40px 40px 40px 40px" value="Generar">
                                                        </td>
                                                    </tr>

                                                </tbody>
                                                <div style="color: #E31F24" id="divcontra"> <?php
                                                    echo $this->session->flashdata('error');
                                                    if (isset($mensaje)) {
                                                        echo $mensaje;
                                                    }
                                                    ?></div>
                                            </table>
                                            <!--</form>-->
                                        </div>
                                    </div>

                                </div>
                                <div class="content-body">    
                                    <div class="row">
                                        <div class="col-12">
                                            <label style="font-weight: bold; color: grey;text-align: left">Para poder generar restauraciones, es necesario que ingrese la clave que se le ha otorgado, en caso de no conocerla por favor solicítela al área de soporte.</label><br>
                                            <br>
                                            <div style="color: #E31F24" id="infores"></div>
                                            <br>
                                            <div class="form-group row" id="divpassword" >
                                                <label for="staticEmail" class="col-sm-4 col-form-label" style="font-weight: bold; color: black;text-align: center">Ingrese la clave:</label>
                                                <input type="password" class="mx-sm-4" id="passworddata" onkeyup="validarpass();">
                                                <div style="color: #E31F24" id="divconfcontra"></div>
                                            </div>
                                            <table class="table" id="tablebackup" style="display: none">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Nombre backup</th>
                                                        <th>Usuario</th>
                                                        <th>Fecha de creación</th>
                                                        <th>Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="body-reg-tablebackup">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-body" id="infoplacas" style="display: none">    
                                    <div class="row">
                                        <div class="col-12">
                                            <label style="font-weight: bold; color: grey;text-align: left">Placas</label><br>
                                            <table class="table" id="tableplacas">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Placa</th>
                                                        <th>Fecha</th>
                                                        <th>Resultado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
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
    $(document).ready(function () {
        infoBackup();
    });
    $('#btn-generarbackup').click(function (ev) {
        ev.preventDefault();
        $('#infores').html('');
        var rtamaria = $('#rtamaria').val();
        var date = $('#date').val();
        $('#divcontra').html('Por favor espere el backup se esta generando...');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/backup/Cbackup/createcronbak',
            type: 'post',
            mimeType: 'json',
            data: {rtamaria: rtamaria,
                date: date},
            success: function (data) {
                if (data !== null && data !== "") {
                   // $('#divcontra').html('<div style="color: #1D8348">El backup fue generado, por favor diríjase a la siguiente ruta ' + data + ', valide que el peso del backup sea el correcto, en caso de tener algún problema o duda por favor comuníquese con el área de soporte.</div>');
                   $('#divcontra').html(`
    <div style="
        color: #1D8348;
        background-color: #E8F8E8;
        border-left: 4px solid #1D8348;
        padding: 15px;
        border-radius: 5px;
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 10px 0;
    ">
        <strong style="font-size: 16px;">✅ Backup generado exitosamente</strong>
        <p style="margin: 10px 0 5px 0;">
            El backup fue generado, por favor diríjase a la siguiente ruta: 
            <strong style="background-color: #D5F5E3; padding: 3px 8px; border-radius: 3px;">${data}</strong>
        </p>
        <p style="margin: 5px 0;">
            ⚠️ <strong>IMPORTANTE:</strong> Valide que el peso del backup sea el correcto.
        </p>
        <p style="margin: 5px 0; color: #2874A6;">
            📁 <strong>No olvide realizar también la copia de seguridad de la carpeta TCM</strong> en la cual se almacenan los datos de las prerevisiones, firmas de usuarios y clientes.
        </p>
        
        <div style="background-color: #F0F8FF; border-left: 4px solid #2874A6; padding: 10px; margin: 10px 0; border-radius: 4px;">
            <p style="margin: 0; color: #000;">
                <strong>📂 Rutas de la carpeta TCM:</strong>
            </p>
            <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                <li style="margin-bottom: 5px;">
                    <strong>🐧 Linux:</strong> 
                    <code style="background-color: #D5F5E3; padding: 2px 6px; border-radius: 3px;">/var/www/html/et/</code>
                </li>
                <li style="margin-bottom: 5px;">
                    <strong>🪟 Windows:</strong> 
                    <code style="background-color: #D5F5E3; padding: 2px 6px; border-radius: 3px;">C:/tcm</code>
                </li>
            </ul>
            <p style="margin: 8px 0 0 0; font-style: italic; color: #555;">
                ⚡ Asegúrese de respaldar toda la carpeta TCM según su sistema operativo.
            </p>
        </div>
        
        <p style="margin: 10px 0 0 0; font-size: 13px; color: #666;">
            En caso de tener algún problema o duda, por favor comuníquese con el área de soporte.
        </p>
    </div>
`);
                    infoBackup();
                } else {
                    $('#divcontra').html('Problemas al generar el backup, por favor comuniques con el area de soporte.');
                }
            }, error: function (xhr) {
                $('#infores').html('Error:' + xhr.responseText);
            }

        });
    });
    function infoBackup() {
        $("#body-reg-tablebackup").html('');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/backup/Cbackup/infoBackup',
            type: 'post',
            mimeType: 'json',
            success: function (data) {
                $.each(data, function (i, data) {
                    var body = "<tr>";
                    body += "<td style='color: black;'>" + data.idbackup + "</td>";
                    body += "<td style='color: black;'>" + data.nombre + "</td>";
                    body += "<td style='color: black;'>" + data.usuario + "</td>";
                    body += "<td style='color: black;'>" + data.fechageneracion + "</td>";
                    body += '<td><button class="btn btn-accent btn-block"  style="background-color: #393185;border-radius: 40px 40px 40px 40px"  id="btn-restaurar" onClick="resBackup(\'' + data.idbackup + '\',\'' + data.nombre + '\',\'' + data.fechageneracion + '\');" >Restaurar</button> </td>';
                    body += "</tr>";
                    $("#tablebackup tbody").append(body);
                });
            }, error: function (xhr) {
                $('#infores').html('Error:' + xhr.responseText);
            }
        });
    }

    function resBackup(idbackup, nombre, fechageneracion) {
        $('#divcontra').html('');
        document.getElementById("btn-restaurar").disabled = true;
        var rtamaria = $('#rtamaria').val();
        var date = $('#date').val();
        var dateactu = $('#dateactu').val();
        var newcad = nombre.slice(-10);
//        console.log(newcad, dateactu);
        if (dateactu > newcad) {
            Swal.fire({
                title: '¡Atención!',
                text: "Se esta tratando de restaurar una copia de seguridad que no es del presente dia, esto puede generar problemas en el análisis del sistema, se recomienda restaurar una copia de seguridad de la fecha actual.",
                imageUrl: '<?php echo base_url(); ?>application/libraries/advertencia.png',
                imageWidth: 150,
                imageHeight: 150,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#infores').html('Por favor espere el backup se esta restaurando...');
                    $.ajax({
                        url: '<?php echo base_url(); ?>index.php/oficina/backup/Cbackup/regresbackup',
                        type: 'post',
                        mimeType: 'json',
                        data: {idbackup: idbackup,
                            namebackup: nombre,
                            rtamaria: rtamaria,
                            date: date},
                        success: function (data) {
                            console.log(data.data, data.respuesta);
                            document.getElementById("btn-restaurar").disabled = false;
                            switch (data.respuesta) {
                                case 1:
                                    $('#infores').html('<div class="form-group row"><label class="col-sm-5 col-form-label" style="font-weight: bold; color: #1D8348; font-size: 17px; text-align: center">El backup fue restuarado con exito</label><button type="button"  onClick="verInfo(\'' + data.data + '\');"  class="btn btn-primary btn-lg col-sm-5" style="background-color: #393185;border-radius: 40px 40px 40px 40px">Ver información</button></div>');
                                    break;
                                case 2:
                                    $('#infores').html('Problemas al guardar la información.');
                                    break;
                                case 3:
                                    $('#infores').html('Problemas al guardar la información.');
                                    break;
                                default:
                                    $('#infores').html('La información de restauración no concuerda con la del servidor principal, esto puede deberse a las siguientes razones.<br>1. Esta restaurando un backup de una fecha anterior a la actual .<br>2. El backup que realizo, lo hizo mientras el cda estaba operando.<br>3. La ip del servidor de respaldo no es la correcta. En este caso por favor comuníquese con soporte.<br>Nota: se recomienda realizar un nuevo backup, sin que el cda este operando y restaurarlo. En caso de persistir el error por favor comuníquese con soporte.');
                                    break;
                            }
                        }, error: function (xhr) {
                            $('#infores').html('Error:' + xhr.responseText);
                            document.getElementById("btn-restaurar").disabled = false;
                        }
                    });
                } else {
                    setTimeout(recargar, 10);
                }
            });
        } else {
            $('#infores').html('Por favor espere el backup se esta restaurando...');
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/backup/Cbackup/regresbackup',
                type: 'post',
                mimeType: 'json',
                data: {idbackup: idbackup,
                    namebackup: nombre,
                    rtamaria: rtamaria,
                    date: date},
                success: function (data) {
                    console.log(data.data, data.respuesta);
                    document.getElementById("btn-restaurar").disabled = false;
                    switch (data.respuesta) {
                        case 1:
                            $('#infores').html('<div class="form-group row"><label class="col-sm-5 col-form-label" style="font-weight: bold; color: #1D8348; font-size: 17px; text-align: center">El backup fue restaurado con exito</label><button type="button"  onClick="verInfo(\'' + data.data + '\');"  class="btn btn-primary btn-lg col-sm-5" style="background-color: #393185;border-radius: 40px 40px 40px 40px">Ver información</button></div>');
                            break;
                        case 2:
                            $('#infores').html('Problemas al guardar la información.');
                            break;
                        case 3:
                            $('#infores').html('Problemas al guardar la información.');
                            break;
                        default:
                            $('#infores').html('La información de restauración no concuerda con la del servidor principal, esto puede deberse a las siguientes razones.<br>1. Esta restaurando un backup de una fecha anterior a la actual .<br>2. El backup que realizo, lo hizo mientras el cda estaba operando.<br>3. La ip del servidor de respaldo no es la correcta. En este caso por favor comuníquese con soporte.<br>Nota: se recomienda realizar un nuevo backup, sin que el cda este operando y restaurarlo. En caso de persistir el error por favor comuníquese con soporte.');
                            break;
                    }
                }, error: function (xhr) {
                    $('#infores').html('Error:' + xhr.responseText);
                    document.getElementById("btn-restaurar").disabled = false;
                }
            });
        }
    }

    function verInfo(data) {
//        var data = $(this).attr('data');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/backup/Cbackup/infoplacas',
            type: 'post',
            mimeType: 'json',
            data: {data: data},
            success: function (data) {
                var c = 0;
                $.each(data, function (i, data) {
                    c++;
                    var body = "<tr>";
                    body += "<td style='color: black;'>" + c + "</td>";
                    body += "<td style='color: black;'>" + data.numero_placa + "</td>";
                    body += "<td style='color: black;'>" + data.fecha + "</td>";
                    body += "<td style='color: black;'>" + data.resultado + "</td>";
                    body += "</tr>";
                    $("#tableplacas tbody").append(body);
                });
            }, error: function (xhr) {
                $('#infores').html('Error:' + xhr.responseText);
            }
        });
        document.getElementById("infoplacas").style.display = '';
        var altura = $(document).height();
        $("html, body").animate({scrollTop: altura + "px"});
    }

    function validarpass() {
        var clave = '**cda**seguridad$,';
        //var clavein = $('#passworddata').val();
        var clavein = $('#passworddata').val();
        var idbtn = $(this).attr('data');
        if (clave == clavein) {
            document.getElementById("tablebackup").style.display = '';
            document.getElementById("infoplacas").style.display = 'none';
            $('#divconfcontra').css('color', '#1D8348');
            $('#divconfcontra').html('Contraseña correcta.');
        } else {
            document.getElementById("tablebackup").style.display = 'none';
            $('#divconfcontra').css('color', '#E31F24');
            $('#divconfcontra').html('La contraseña es incorrecta.');
        }
    }
    function recargar() {
        location.reload();
    }
</script>



