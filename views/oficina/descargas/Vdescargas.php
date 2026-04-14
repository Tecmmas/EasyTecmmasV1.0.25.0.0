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
        width: 400px;
        height: 42px;
        max-width: 100%;
        box-sizing: border-box;
        margin: 0;
        border: 1px solid #aaa;
        margin-top: 20px;
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
                                    <h2 class="title float-left">Descargar Actualización</h2>
                                </header>

                                <div class="content-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <!--<form action="<?php echo base_url(); ?>index.php/oficina/descargas/Cdescargas/Getactualizacion" method="post">-->
                                            <div style="color: #E31F24"> <?php
                                                                            echo $this->session->flashdata('error');
                                                                            if (isset($mensaje)) {
                                                                                echo $mensaje;
                                                                            }
                                                                            ?></div>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Version</th>
                                                        <th>Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <select class="select-css" name='idactualizacion' id="idactualizacion">
                                                                <option disabled="disabled" selected="selected" id="sel-version">Seleccionar Version</option>

                                                            </select>
                                                        </td>
                                                        <td style="text-align: center; margin-top: 2px">
                                                            <label style="font-weight: bold; color: black"></label>
                                                            <input type="hidden" id="file">
                                                            <input type="hidden" id="url">
                                                            <input type="hidden" id="version">
                                                            <input type="submit" name="consultar" id="btn-descarga" onclick="Getactualizacion()" class="btn btn-accent btn-block" onclick="showSuccess('Descargando actualizacion, por favor espere.')" style="background-color: #393185;border-radius: 40px 40px 40px 40px" value="Descargar">
                                                        </td>
                                                    </tr>
                                                    <td colspan="2" style="text-align: left; color: black; font-size: 15px">
                                                        <label id="descripcion"></label>
                                                    </td>
                                                    <table>
                                                        <td colspan="2" style="text-align: justify; color: black; border: red 1px solid; background-color: whitesmoke">
                                                            <div style="margin-left: 10px; margin-top: 15px; margin-right: 10px">
                                                                Al finalizar la actualización, la oficina en la cual realizó el proceso se reiniciará de manera automática, por ende, debe cerrar todos los aplicativos de TECMMAS en los dispositivos móviles y en las oficinas, puede verificar el release en el cual se encuentra trabajando en la parte inferior de la ventana de login, como se observa en la imagen. En la misma, se encuentra el botón ayuda para más información. Tenga en cuenta que es muy importante que todos los aplicativos móviles se encuentren en esta misma versión, comuníquese con TECMMAS SAS para ayudarle en este proceso.
                                                            </div>
                                                            <br>
                                                        </td>
                                                    </table>
                                                </tbody>
                                            </table>
                                            <br>
                                            <div style="text-align: center;">
                                                <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/4RDuRXhpZgAATU0AKgAAAAgABAE7AAIAAAAMAAAISodpAAQAAAABAAAIVpydAAEAAAAYAAAQzuocAAcAAAgMAAAAPgAAAAAc6gAAAAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEJyYXlhbiBMZW9uAAAFkAMAAgAAABQAABCkkAQAAgAAABQAABC4kpEAAgAAAAM3OQAAkpIAAgAAAAM3OQAA6hwABwAACAwAAAiYAAAAABzqAAAACAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAyMTowMjowNiAwOToxNToxMAAyMDIxOjAyOjA2IDA5OjE1OjEwAAAAQgByAGEAeQBhAG4AIABMAGUAbwBuAAAA/+ELHmh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8APD94cGFja2V0IGJlZ2luPSfvu78nIGlkPSdXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQnPz4NCjx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iPjxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+PHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9InV1aWQ6ZmFmNWJkZDUtYmEzZC0xMWRhLWFkMzEtZDMzZDc1MTgyZjFiIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iLz48cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0idXVpZDpmYWY1YmRkNS1iYTNkLTExZGEtYWQzMS1kMzNkNzUxODJmMWIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyI+PHhtcDpDcmVhdGVEYXRlPjIwMjEtMDItMDZUMDk6MTU6MTAuNzk0PC94bXA6Q3JlYXRlRGF0ZT48L3JkZjpEZXNjcmlwdGlvbj48cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0idXVpZDpmYWY1YmRkNS1iYTNkLTExZGEtYWQzMS1kMzNkNzUxODJmMWIiIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyI+PGRjOmNyZWF0b3I+PHJkZjpTZXEgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj48cmRmOmxpPkJyYXlhbiBMZW9uPC9yZGY6bGk+PC9yZGY6U2VxPg0KCQkJPC9kYzpjcmVhdG9yPjwvcmRmOkRlc2NyaXB0aW9uPjwvcmRmOlJERj48L3g6eG1wbWV0YT4NCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgPD94cGFja2V0IGVuZD0n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kfbP/sGx/wDo2WivdofwokM7X4B/8iHe/wDYSf8A9FRV6fXmHwD/AORDvf8AsJP/AOioq9PrycR/FkWgooorAAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA+e/j1/wAj7Z/9g2P/ANGy0UfHr/kfbP8A7Bsf/o2WivdofwokM7X4B/8AIh3v/YSf/wBFRV6fXmHwD/5EO9/7CT/+ioq9PrycR/FkWgooorAAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAGTSeVBJJjOxS2M4zXF6H8QbnUrvS01HQmsYNW3C0nS6WXcQM8rgFeldlcoZLSVFGWZCAPXivOvDXgm98My6FqdrpitdmNrfVITIhZAx4lVi2MjuFPIPSs25c2h1UVScHzb9PuOxj8W6HLrB0yPUEN15hi27W2lx1QPjaW9s5rO0jxlG9jrN3rktvaw2GqS2UTIrZdVxt4ySzHPQflXPaN4NvrDUIrLUdMu7y3gvjcQ3i6oVhX5twcw5+8M9AOeeabc+C9Zm06+ZbciaPxDLqMMK3IjaeIjA2up+RjnjOMY5oUpWu/62NfZUbuN/mdrH4p0abR5dUjvQ1pA/lyN5bbo2yBtKY3A5I4xnmmReMNCm0ebU01BfssD+XKzIysjdlKEbsnI4xXLyaHrkHh6d9E068sbu4vY3uopNSEs9xCFw2JSSFPQdei9e1R23hbUE0zXk1HRJbtb64hlit/7R3SgBR83msc7lPqcdhkUuaVyVRpWvc60eLtEbSDqZvdtqJfKy8Tqxf8AuhCNxPsBVzTNZsNYsjd6bcCeFWKtgEMjDqpUjIPsRXBS+F/E954as/txnnuLHUDPBbSXoE5g24CmZcDeMk5z+NdT4Q0ttOs7uSXTriwluZ97pc3v2l5PlA3Fsn6Yyegqk220yKlOnGN07stJ4q0aTTbO/S8DW19OILdhG+XkJI27cZByD1H1qjZeM0v/ABm2hQ6fOkawvILqbKbyjbSFQjJGc/NkdKyNL8JajbeOmM8YGh2dxNe2jb1OZZQuV29QFO8j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" width="50%" height="20%">
                                            </div>
                                            <!--</form>-->

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
    var informacion = "";
    $(document).ready(function() {
        $.ajax({
            url: 'http://updateapp.tecmmas.com/Actualizaciones/index.php/Cdescargas/getActualizacionOficina',
            //            url: 'system/actualizaciones.json',
            type: 'post',
            mimeType: 'json',
            success: function(data, textStatus, jqXHR) {
                if (data !== null || data !== "") {
                    informacion = data;
                    localStorage.setItem('actualizaciones', JSON.stringify(data[0]));
                    $.each(data, function(i, data) {
                        $('#idactualizacion').append("<option value=" + data.actulizacionOficina + ">" + data.version + "</option>");
                    });
                    informacion = data;
                    var html = localStorage.getItem('actualizaciones');
                    $.each(html, function(i, data) {
                        $('#idactualizacion').append("<option value=" + data.actulizacionOficina + ">" + data.version + "</option>");
                    });

                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                var html = JSON.parse(localStorage.getItem('actualizaciones'));
                informacion = html;
                $('#idactualizacion').append("<option value=" + html.actulizacionOficina + ">" + html.version + "</option>");

            }
        }, 1000);
    })


    $('#idactualizacion').change(function() {
        var idactualizacion = $('#idactualizacion option:selected').attr('value');
        if (informacion.length > 0) {
            $.each(informacion, function(i, data) {
                if (idactualizacion == data.actulizacionOficina) {
                    var html = "<div style='color: red; font-size:16px'>Descripcion de la actualizacion:</div><br> \n\
                            " + data.descripcion;
                    $("#descripcion").html(html);
                    $("#file").val(data.file)
                    $("#url").val(data.url)
                    $("#version").val(data.version)
                }
            });
        } else {
            var html = "<div style='color: red; font-size:16px'>Descripcion de la actualizacion:</div><br> \n\
                            " + informacion.descripcion;
            $("#descripcion").html(html);
            $("#file").val(informacion.file)
            $("#url").val(informacion.url)
            $("#version").val(informacion.version)
        }

    });

    var Getactualizacion = function() {
        Swal.fire({
            title: 'Actualizando sistema',
            html: 'Por favor espere mientras se descarga la actualización...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });

        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/descargas/Cdescargas/Getactualizacion',
            type: 'post',
            dataType: 'json',
            data: {
                url: $("#url").val(),
                file: $("#file").val(),
                version: $("#version").val()
            },
            success: function(response) {
                console.log(response);
                if (response == '1') {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Sistema actualizado con éxito',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        window.location.href = "<?php echo base_url(); ?>index.php/Cindex";
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en actualización',
                        html: response.message || 'Ocurrió un error durante la actualización'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo completar la solicitud. Verifique su conexión a internet.'
                });
                console.error("Error en AJAX:", textStatus, errorThrown);
            }
        });
    };
</script>