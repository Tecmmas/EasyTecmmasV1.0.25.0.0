<html class=" ">

<head>
    <!-- 
         * @Package: Complete Admin - Responsive Theme
         * @Subpackage: Bootstrap
         * @Version: BS4-1.0
         * This file is part of Complete Admin Theme.
        -->
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>USUARIOS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" type="image/x-icon" /> <!-- Favicon -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-57-precomposed.png"> <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-114-precomposed.png"> <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-72-precomposed.png"> <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-144-precomposed.png"> <!-- For iPad Retina display -->
    <style>
        .status {
            padding: 6px 10px;
            margin: 8px 0;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
        }

        .connected {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .disconnected {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .connecting {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .log {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px;
            overflow-y: scroll;
        }

        .event {
            color: #007bff;
        }

        .error {
            color: #dc3545;
        }

        .success {
            color: #28a745;
        }

        .warning {
            color: #ffc107;
        }

        .fingerprint-img {
            max-width: 100%;
            max-height: 180px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 3px;
            background-color: white;
        }

        .connection-controls {
            background-color: #f8f9fa;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #e9ecef;
        }

        .btn-group .btn {
            font-size: 12px;
            padding: 4px 8px;
        }

        .modal-footer .btn {
            font-size: 13px;
            padding: 6px 12px;
        }
    </style>



    <!-- CORE CSS FRAMEWORK - START -->
    <link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/> -->
    <link href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" media="screen" />

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE CSS TEMPLATE - START -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/tecmmas.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class=" ">
    <!-- START TOPBAR -->
    <div class='page-topbar '>
        <div class='logo-area'>

        </div>
        <div class='quick-area'>
            <div class='float-left'>
                <ul class="info-menu left-links list-inline list-unstyled">
                    <li class="message-toggle-wrapper list-inline-item">
                        <ul class="dropdown-menu messages animated fadeIn">
                            <li class="list dropdown-item">
                            </li>
                        </ul>
                    </li>
            </div>
        </div>

    </div>
    <!-- END TOPBAR -->

    <!-- START CONTENT -->
    <section class="wrapper main-wrapper row" style=''>
        <div class="clearfix"></div>
        <!-- MAIN CONTENT AREA STARTS -->
        <div class="col-xl-12">
            <section class="box ">
                <div class="content-body" style="background: whitesmoke">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">CREAR USUARIOS</h2>
                                </header>
                                <div class="content-body">
                                    <form action="<?php echo base_url(); ?>index.php/oficina/usuarios/Cusuarios" style="width: 100px" method="post">
                                        <input name="button" class="btn btn-block bot_azul" type="submit" value="Atras" />
                                    </form>
                                    <br>
                                    <form action="<?php echo base_url(); ?>index.php/oficina/usuarios/Cusuarios/crearUsuario" id="form-reg-user" method="post">
                                        <input type="hidden" name="idcliente" value="" />
                                        <table class="table dt-responsive display">
                                            <?php if (isset($usuario)) { ?>
                                                <?php foreach ($usuario as $value): ?>
                                                    <tr>
                                                        <td style="text-align: right">
                                                            TIPO DOCUMENTO
                                                        </td>
                                                        <td>
                                                            <select class="form-control" name="tipo_identificacion" style="background: #FFE1E1">
                                                                <?php if (isset($value->tipoidentificacion)): ?>
                                                                    <option value="<?= $value->tipoidentificacion ?>"><?= $value->nombreidentificacion ?></option>
                                                                <?php endif; ?>
                                                                <option value="1">Cédula de ciudadanía</option>
                                                                <option value="2">Numero Identificación Tributaria (NIT)</option>
                                                                <option value="3">Cédula de extrangería</option>
                                                                <option value="4">Tarjeta de identidad</option>
                                                                <option value="5">N. único de Id. Personal</option>
                                                                <option value="6">Pasaporte</option>
                                                            </select>
                                                            <strong style="color: #E31F24;font-size: 12px "></strong>
                                                        </td>
                                                        <td style="text-align: right">
                                                            NUMERO DE DOCUMENTO
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="numero_identificacion" value="<?php
                                                                                                                            if (isset($value->identificacion)) {
                                                                                                                                echo $value->identificacion;
                                                                                                                            }
                                                                                                                            ?>" style="background: #FFE1E1" type="number">
                                                            <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('numero_identificacion'); ?></strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right">
                                                            NOMBRES
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="nombres" value="<?php
                                                                                                                if (isset($value->nombres)) {
                                                                                                                    echo $value->nombres;
                                                                                                                }
                                                                                                                ?>" style="background: #FFE1E1; text-transform: uppercase" type="text" autocomplete="off">
                                                            <strong style="color: #E31F24;font-size: 12px "></strong>
                                                        </td>
                                                        <td style="text-align: right">
                                                            APELLIDOS
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="apellidos" value="<?php
                                                                                                                if (isset($value->apellidos)) {
                                                                                                                    echo $value->apellidos;
                                                                                                                }
                                                                                                                ?>" style="background: #FFE1E1; text-transform: uppercase" type="text" autocomplete="off">
                                                            <strong style="color: #E31F24;font-size: 12px "></strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right">
                                                            PERFIL
                                                        </td>
                                                        <td>
                                                            <select class="form-control" name="tipo_perfil" style="background: #FFE1E1">
                                                                <?php if (isset($value->idperfil)): ?>
                                                                    <option value="<?= $value->idperfil ?>"><?= $value->perfil ?></option>
                                                                <?php endif; ?>
                                                                <option value="1">Administrador</option>
                                                                <option value="2">Operario</option>
                                                                <option value="3">Supervisor</option>
                                                                <option value="4">Administrativo</option>
                                                                <option value="5">Sistemas</option>
                                                                <option value="6">Auditor del sistema</option>
                                                                <option value="7">Representante legal</option>
                                                            </select>
                                                            <strong style="color: #E31F24;font-size: 12px "></strong>
                                                        </td>
                                                        <td style="text-align: right">
                                                            USUARIO
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="usuario" value="<?php
                                                                                                                if (isset($value->usuario)) {
                                                                                                                    echo $value->usuario;
                                                                                                                }
                                                                                                                ?>" type="text" style="background: #FFE1E1">
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td style="text-align: right">
                                                            CONTRASEÑA
                                                        </td>
                                                        <td>
                                                            <input class="form-control contrasenaconeach" name="contrasena" id="contrasena" onkeyup="validarcontrasenauser()" value="<?php
                                                                                                                                                                                        if (isset($value->passwd)) {
                                                                                                                                                                                            echo $value->passwd;
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>" style="background: #FFE1E1" type="password">
                                                            <input class="form-control" name="contrasenaold" value="<?php
                                                                                                                    if (isset($value->passwd)) {
                                                                                                                        echo $value->passwd;
                                                                                                                    }
                                                                                                                    ?>" style="background: #FFE1E1" type="hidden">
                                                            <strong style="color: #E31F24;font-size: 12px "></strong>
                                                            <div id="divcontra"></div>
                                                        </td>
                                                        <td style="text-align: right">
                                                            ESTADO
                                                        </td>
                                                        <td>
                                                            <select class="form-control" name="estado" style="background: #FFE1E1">
                                                                <?php if (isset($value->estado)): ?>
                                                                    <option value="<?= $value->idestado ?>"><?= $value->estado ?></option>
                                                                <?php endif; ?>
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>

                                                            </select>
                                                            <strong style="color: #E31F24;font-size: 12px "></strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right">
                                                            CONFIRMAR CONTRASEÑA
                                                        </td>
                                                        <td>
                                                            <input class="form-control confircontrasenaconeach" name="confirmcontrasena" value="<?php
                                                                                                                                                if (isset($value->passwd)) {
                                                                                                                                                    echo $value->passwd;
                                                                                                                                                }
                                                                                                                                                ?>" style="background: #FFE1E1" type="password">
                                                            <input name='idusuario' id="idusuario" type='hidden' value='<?php
                                                                                                                        if (isset($value->IdUsuario)) {
                                                                                                                            echo $value->IdUsuario;
                                                                                                                        }
                                                                                                                        ?>'>
                                                            <strong style="color: #E31F24;font-size: 12px "></strong>
                                                            <div id="divcontraconf"></div>
                                                        </td>
                                                        <td style="text-align: right">
                                                            EQUIPO ASIGNADO
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="equipo_asignado" value="<?php
                                                                                                                        if (isset($value->equipo_asignado)) {
                                                                                                                            echo $value->equipo_asignado;
                                                                                                                        }
                                                                                                                        ?>" style="background: #FFE1E1; text-transform: uppercase" type="text" autocomplete="off">
                                                            <strong style="color: #E31F24;font-size: 12px "></strong>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right">
                                                            REGISTRAR HUELLA
                                                        </td>
                                                        <td>
                                                            <!-- <form action="<?php echo base_url(); ?>index.php/oficina/usuarios/Cusuarios/registrarhuella" method="post"> -->
                                                            <?php
                                                            if (isset($value->biometrico) && !empty($value->biometrico)) {
                                                                echo '<input name="button" class="btn btn-block bot_verde" type="button" value="Huella registrada" id="btnModalHuella" />';
                                                            } else {
                                                                echo '<input name="button" class="btn btn-block bot_azul" type="button" value="Registrar huella" id="btnModalHuella" />';
                                                            }
                                                            ?>
                                                            <input type="hidden" name="base64Huella" id="base64Huella" value="<?php
                                                                                                                                if (isset($value->biometrico)) {
                                                                                                                                    echo $value->biometrico;
                                                                                                                                }
                                                                                                                                ?>" />
                                                            <!-- </form> -->
                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td style="text-align: right">
                                                        TIPO DOCUMENTO
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="tipo_identificacion" style="background: #FFE1E1">
                                                            <?php
                                                            if (isset($tipoidentificacion)) {
                                                                echo $tipoidentificacion;
                                                            } else {
                                                            ?>
                                                                <option value=""></option>
                                                            <?php }; ?>
                                                            <option value="1">Cédula de ciudadanía</option>
                                                            <option value="2">Numero Identificación Tributaria (NIT)</option>
                                                            <option value="3">Cédula de extrangería</option>
                                                            <option value="4">Tarjeta de identidad</option>
                                                            <option value="5">N. único de Id. Personal</option>
                                                            <option value="6">Pasaporte</option>
                                                        </select>
                                                        <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('tipo_identificacion'); ?></strong>
                                                    </td>
                                                    <td style="text-align: right">
                                                        NUMERO DE DOCUMENTO
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="numero_identificacion" value="<?php
                                                                                                                        if (isset($identificacion)) {
                                                                                                                            echo $identificacion;
                                                                                                                        }
                                                                                                                        ?>" style="background: #FFE1E1" type="number">
                                                        <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('numero_identificacion'); ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right">
                                                        NOMBRES
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="nombres" value="<?php
                                                                                                            if (isset($nombres)) {
                                                                                                                echo $nombres;
                                                                                                            }
                                                                                                            ?>" style="background: #FFE1E1; text-transform: uppercase" type="text" autocomplete="off">
                                                        <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('nombres'); ?></strong>
                                                    </td>
                                                    <td style="text-align: right">
                                                        APELLIDOS
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="apellidos" value="<?php
                                                                                                            if (isset($apellidos)) {
                                                                                                                echo $apellidos;
                                                                                                            }
                                                                                                            ?>" style="background: #FFE1E1; text-transform: uppercase" type="text" autocomplete="off">
                                                        <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('apellidos'); ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right">
                                                        PERFIL
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="tipo_perfil" style="background: #FFE1E1">
                                                            <?php
                                                            if (isset($perfil)) {
                                                                echo $perfil;
                                                            } else {
                                                            ?>
                                                                <option value=""></option>
                                                            <?php }; ?>
                                                            <option value="1">Administrador</option>
                                                            <option value="2">Operario</option>
                                                            <option value="3">Supervisor</option>
                                                            <option value="4">Administrativo</option>
                                                            <option value="5">Sistemas</option>
                                                            <option value="6">Auditor del sistema</option>
                                                            <option value="7">Representante legal</option>
                                                        </select>
                                                        <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('tipo_perfil'); ?></strong>
                                                    </td>
                                                    <td style="text-align: right">
                                                        USUARIO
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="usuario" value="<?php
                                                                                                            if (isset($usuarios)) {
                                                                                                                echo $usuarios;
                                                                                                            }
                                                                                                            ?>" type="text" style="background: #FFE1E1">
                                                        <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('usuario'); ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right">
                                                        CONTRASEÑA
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="contrasena" id="contrasena" value="<?php
                                                                                                                                if (isset($contrasena)) {
                                                                                                                                    echo $contrasena;
                                                                                                                                }
                                                                                                                                ?>" style="background: #FFE1E1" onkeyup="validarcontrasenauser()" type="password">

                                                        <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('contrasena'); ?></strong>
                                                        <div id="divcontra"></div>
                                                    </td>

                                                    <td style="text-align: right">
                                                        ESTADO
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="estado" style="background: #FFE1E1">
                                                            <?php
                                                            if (isset($estado)) {
                                                                echo $estado;
                                                            } else {
                                                            ?>
                                                                <option value=""></option>
                                                            <?php }; ?>
                                                            <option value="1">Activo</option>
                                                            <option value="0">Inactivo</option>
                                                        </select>
                                                        <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('estado'); ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right">
                                                        CONFIRMAR CONTRASEÑA
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="confirmcontrasena" id="confirmcontrasena" value="" style="background-color: #FFE1E1" onkeyup="validarconfcontra()" type="password">
                                                        <strong style="color: #E31F24;font-size: 12px "><?php echo form_error('confirmcontrasena'); ?></strong>
                                                        <div id="divcontraconf"></div>
                                                    </td>
                                                    <td style="text-align: right">
                                                        EQUIPO ASIGNADO
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="equipo_asignado" value="<?php
                                                                                                                    if (isset($equipo_asignado)) {
                                                                                                                        echo $equipo_asignado;
                                                                                                                    }
                                                                                                                    ?>" style="background: #FFE1E1; text-transform: uppercase" type="text" autocomplete="off">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                        <table style="text-align: center;width: 100%">
                                            <tr>
                                                <td>
                                                    <input name="guardar" id="guardar" class="btn btn-block bot_gris" value="Guardar" />
                                                    <input type="hidden" name="guardarref" id="guardarref" class="btn btn-block bot_gris" value="" />
                                                    <div style="color: green; font-size: 8 px"> <?php
                                                                                                echo $this->session->flashdata('error');
                                                                                                if (isset($mensaje)) {
                                                                                                    echo $mensaje;
                                                                                                }
                                                                                                ?></div>
                                                </td>
                                                <td>
                                                    <input name="btnguardarnuevo" id="btnguardarnuevo" class="btn btn-block bot_gris" value="Guardar y nuevo" />
                                                    <input type="hidden" name="btnguardarnuevoref" id="btnguardarnuevoref" class="btn btn-block bot_gris" value="" />
                                                </td>
                                                <td>
                                                    <input name="guardarfinalizar" id="guardarfinalizar" class="btn btn-block bot_gris" value="Guardar y finalizar" />
                                                    <input type="hidden" name="guardarfinalizarref" id="guardarfinalizarref" class="btn btn-block bot_gris" value="" />
                                                </td>
                                                <td>
                                                    <input name="btnnuevo" class="btn btn-block bot_verde" type="submit" value="Nuevo" />
                                                </td>
                                                <input name='idusuarioUpdate' id="idusuarioUpdate" type='hidden' value='<?php echo  $this->session->userdata('IdUsuario') ?>'>
                                            </tr>
                                        </table>
                                    </form>
                                    <br>
                                    <form action="<?php echo base_url(); ?>index.php/oficina/usuarios/Cusuarios" method="post" style="width: 200px">
                                        <input name="button" class="btn btn-block bot_rojo" type="submit" value="Cancelar" />
                                    </form>

                                    <br>
                                    <div style="text-align: center;color: gray">
                                        Copyright © 2025 TECMMAS SAS
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


    <!-- modal huella biometrica -->

    <!-- Modal Registro de Huella Biométrica -->
    <div class="modal fade" id="modalHuellaBiometrica" tabindex="-1" role="dialog" aria-labelledby="modalHuellaBiometricaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHuellaBiometricaLabel">Registro de Huella Biométrica</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Controles de conexión -->
                    <div class="connection-controls mb-3">
                        <div id="status" class="status disconnected mb-2">
                            Desconectado del servidor de huellas
                        </div>
                        <div class="btn-group" role="group">
                            <button id="btnConnect" onclick="connect()" class="btn btn-outline-primary btn-sm">
                                Conectar
                            </button>
                            <button id="btnDisconnect" onclick="disconnect()" disabled class="btn btn-outline-secondary btn-sm">
                                Desconectar
                            </button>
                            <button id="btnInit" onclick="initializeCapturer()" disabled class="btn btn-outline-info btn-sm">
                                Reinicializar
                            </button>
                        </div>
                    </div>

                    <!-- Información de estado -->
                    <div id="Scores">
                        <div id="qualityMessageBox" style="
                        background-color: #f5f5f5;
                        border: 2px solid #007bff;
                        border-radius: 8px;
                        padding: 12px;
                        margin: 10px auto 15px auto;
                        color: #222;
                        font-size: 14px;
                        text-align: center;
                        box-shadow: 0 2px 6px rgba(0,0,0,0.07);
                    ">
                            <span id="qualityInputBox" style="font-weight: 500;">Presione "Capturar Huella" para comenzar</span>
                        </div>
                    </div>

                    <!-- Contenedor principal en línea -->
                    <div class="row">
                        <!-- Columna de imagen de huella -->
                        <div class="col-md-6">
                            <div class="capture-area">
                                <div id="content-capture" style="height: 200px; width: 100%; margin: auto; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 2px dashed #ccc; background-color: #f9f9f9;">
                                    <div id="imagediv" style="margin: auto; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                        <div id="imagePlaceholder" class="text-center">
                                            <i class="fas fa-fingerprint fa-3x text-muted mb-2"></i>
                                            <p class="text-muted mb-0" style="font-size: 12px;">Imagen de la huella</p>
                                        </div>
                                        <img id="fingerprintImg" class="fingerprint-img" style="display: none; max-height: 180px; max-width: 100%; border-radius: 5px;" alt="Imagen de huella digital">
                                    </div>
                                </div>

                                <!-- Información de la imagen -->
                                <div class="image-info mt-2 text-center">
                                    <small class="text-muted">
                                        <span id="imageInfo">Resolución: 0x0 px</span> |
                                        <span id="imageSize">Tamaño: 0 KB</span>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Columna del log -->
                        <div class="col-md-6">
                            <div class="log-section" style="height: 100%;">
                                <h6 style="font-size: 14px; margin-bottom: 8px;">📝 Registro de Eventos</h6>
                                <div id="log" class="log" style="height: 180px; overflow-y: scroll; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px; padding: 8px; font-size: 11px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Template oculto -->
                    <div class="template-section" style="display: none;">
                        <textarea id="fingerprintData" class="form-control" rows="2" readonly placeholder="Los datos del template aparecerán aquí..."></textarea>
                        <div class="template-info mt-1">
                            <small class="text-muted">
                                <span id="templateSize">Tamaño: 0 bytes</span> |
                                <span id="templateInfo">Características: 0</span>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Botones de captura -->
                    <div class="btn-group mr-2" role="group">
                        <button id="btnCapture" onclick="captureFingerprint()" disabled class="btn btn-primary">
                            <i class="fas fa-fingerprint mr-1"></i> Capturar Huella
                        </button>
                    </div>

                    <!-- Botones de acciones -->
                    <button type="button" onclick="limpiarImagen()" class="btn btn-outline-secondary">
                        <i class="fas fa-broom mr-1"></i> Limpiar
                    </button>
                    <button type="button" onclick="guardarTemplate()" id="btnGuardar" disabled class="btn btn-success">
                        Guardar
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- END CONTAINER -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


    <!-- CORE JS FRAMEWORK - START -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/popper.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>
    <script>
        window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');
    </script>
    <!-- CORE JS FRAMEWORK - END -->


    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <script src="<?php echo base_url(); ?>assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE TEMPLATE JS - START -->
    <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS - END -->


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- <script src="<?php echo base_url(); ?>application/libraries/lectorbiometrico/es6-shim.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>application/libraries/lectorbiometrico/websdk.client.bundle.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>application/libraries/lectorbiometrico/fingerprint.sdk.min.js" type="text/javascript"></script> -->
    <script>
        // Recarga app.js cada vez con un parámetro único para evitar caché
        (function loadAppJs() {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = '<?php echo base_url(); ?>application/libraries/lectorbiometrico/app.js?v=' + new Date().getTime();
            document.body.appendChild(script);
        })();
    </script>

    <script type="text/javascript">
        var huellaDigital = '<?php
                                    echo $this->session->userdata('huellaDigital');
                                    ?>';
        $(document).ready(function() {
            
            var contra = $("#contrasena").val();
            if (contra !== "" && contra !== null) {
                habilitarBotones();
            } else {
                deshabilitarBotones();
            }

        });

        $('#btnModalHuella').click(function(ev) {
            ev.preventDefault();
            if (huellaDigital == '0') {
                // Mostrar SweetAlert indicando que el servicio debe ser activado
                Swal.fire({
                    icon: 'warning',
                    title: 'Servicio no activado',
                    html: 'Este servicio debe ser activado.<br>Para más información comuníquese con soporte.',
                    confirmButtonText: 'Aceptar'
                });

            } else {
                $('#modalHuellaBiometrica').modal('show');
            }

        });



        $('#contrasena').click(function() {
            var contrasenna = $('#contrasena').val();
            if (contrasenna.length == 0) {
                $('#divcontra').html("<p style='font-weight: bold;color: black; text-align: left;; font-size: 9px'>" +
                    "Bienvenido(a) tenga en cuenta lo siguiente para la asignacion de contraseña: <br>" +
                    "1.Las contraseñas deben tener 6 o mas caracteres<br>" +
                    "2.Debe combinar letras mayúsculas, minúsculas y números.<br>" +
                    "4.Debe contener almenos un caracter especial. Ejemplo: @*,.<br>" +
                    "5.No se pueden repetir caracteres en la contraseña.<br>" +
                    "</p>");
            }
        });

        function validarcontrasenauser() {
            var contrasenna = $('#contrasena').val();
            if (contrasenna.length >= 6) {
                var mayuscula = false;
                var minuscula = false;
                var numero = false;
                var caracter_raro = false;
                for (var i = 0; i < contrasenna.length; i++) {
                    if (contrasenna.charCodeAt(i) >= 65 && contrasenna.charCodeAt(i) <= 90) {
                        mayuscula = true;
                    } else if (contrasenna.charCodeAt(i) >= 97 && contrasenna.charCodeAt(i) <= 122) {
                        minuscula = true;
                    } else if (contrasenna.charCodeAt(i) >= 48 && contrasenna.charCodeAt(i) <= 57) {
                        numero = true;
                    } else {
                        caracter_raro = true;
                    }
                }

                if (mayuscula == true && minuscula == true && caracter_raro == true && numero == true) {
                    console.log($("#idusuario").val())
                    $.ajax({
                        url: '<?php echo base_url(); ?>index.php/oficina/contrasenas/Ccontrasenas/getpassword',
                        type: 'post',
                        mimeType: 'json',
                        data: {
                            iduser: $("#idusuario").val(),
                            contrasenna: $('#contrasena').val()
                        },
                        success: function(data) {
                            if (data == 1) {
                                $('#divcontra').html(' ');
                                $('#divcontra').html('<div style=" color: red; font-size: 12px">La contraseña fue asignada anteriormente.</div>');
                                deshabilitarBotones();
                            }
                        }
                    });
                    var rta = camposrepetidos(contrasenna);
                    if (rta == true) {
                        deshabilitarBotones()
                        $('#divcontra').html(' ');
                        $('#divcontra').html('<div style=" color: red; font-size: 12px">La contraseña no puede tener caracteres repetidos.</div>');
                    } else {
                        habilitarBotones();
                        $('#divcontra').html('<div style=" color: green; font-size: 12px">La contraseña cumple con los parametros.</div>');
                    }
                } else {
                    deshabilitarBotones()
                    $('#divcontra').html(' ');
                    $('#divcontra').html('<div style=" color: red; font-size: 12px">La contraseña no cumple con los parametros.</div>');
                }
            }
        }

        function camposrepetidos(contrasenna) {
            var arraycontra = contrasenna.split("");
            var campos = arraycontra.sort();
            var repetido = false;
            for (var i = 0; i < campos.length; i++) {
                if (campos[i] == campos[i + 1]) {
                    return repetido = true;
                }
            }
            return repetido;
        }
        $('#guardar').click(function(ev) {
            ev.preventDefault();
            $('#guardarref').val('guardarref');
            var contrasenaconeach = $('.contrasenaconeach').val();
            var confircontrasenaconeach = $('.confircontrasenaconeach').val();
            var contrasena = $('#contrasena').val();
            var confirmcontrasena = $('#confirmcontrasena').val();
            if (contrasena.length < 6) {
                deshabilitarBotones()
                $('#contrasena').val('');
                $('#confirmcontrasena').val('');
                $('#divcontra').html("<p style='font-weight: bold;color: red; text-align: left;; font-size: 9px'>La contraseña no cumple con la longitud</p>");
            } else {
                if (contrasena == confirmcontrasena) {
                    $('#form-reg-user').submit();
                } else if (contrasenaconeach == confircontrasenaconeach) {
                    $('#form-reg-user').submit();
                } else {
                    deshabilitarBotones();
                    $('#contrasena').val('');
                    $('#confirmcontrasena').val('');
                    $('#divcontraconf').html('<div style=" color: red; font-size: 12px">Las contraseña no coinciden.</div>');
                }
            }

            //                                                                    $('#mesaje').html('Usuario Creado');

        });
        $('#btnguardarnuevo').click(function(ev) {
            ev.preventDefault();
            $('#btnguardarnuevoref').val('btnguardarnuevoref');
            var contrasenaconeach = $('.contrasenaconeach').val();
            var confircontrasenaconeach = $('.confircontrasenaconeach').val();
            var contrasena = $('#contrasena').val();
            var confirmcontrasena = $('#confirmcontrasena').val();
            if (contrasena.length < 6) {
                deshabilitarBotones();
                $('#contrasena').val('');
                $('#confirmcontrasena').val('');
                $('#divcontra').html("<p style='font-weight: bold;color: red; text-align: left;; font-size: 9px'>La contraseña no cumple con la longitud</p>");
            } else {
                if (contrasena == confirmcontrasena) {
                    $('#form-reg-user').submit();
                } else if (contrasenaconeach == confircontrasenaconeach) {
                    $('#form-reg-user').submit();
                } else {
                    deshabilitarBotones();
                    $('#contrasena').val('');
                    $('#confirmcontrasena').val('');
                    $('#divcontraconf').html('<div style=" color: red; font-size: 12px">Las contraseña no coinciden.</div>');
                }
            }
        });
        $('#guardarfinalizar').click(function(ev) {
            ev.preventDefault();
            $('#guardarfinalizarref').val('guardarfinalizarref');
            var contrasenaconeach = $('.contrasenaconeach').val();
            var confircontrasenaconeach = $('.confircontrasenaconeach').val();
            var contrasena = $('#contrasena').val();
            var confirmcontrasena = $('#confirmcontrasena').val();
            if (contrasena.length < 6) {
                deshabilitarBotones();
                $('#contrasena').val('');
                $('#confirmcontrasena').val('');
                $('#divcontra').html("<p style='font-weight: bold;color: red; text-align: left;; font-size: 9px'>La contraseña no cumple con la longitud</p>");
            } else {
                if (contrasena == confirmcontrasena) {
                    $('#form-reg-user').submit();
                } else if (contrasenaconeach == confircontrasenaconeach) {
                    $('#form-reg-user').submit();
                } else {
                    deshabilitarBotones();
                    $('#contrasena').val('');
                    $('#confirmcontrasena').val('');
                    $('#divcontraconf').html('<div style=" color: red; font-size: 12px">Las contraseña no coinciden.</div>');
                }
            }
        });

        function habilitarBotones() {
            document.getElementById("guardar").disabled = false;
            document.getElementById("btnguardarnuevo").disabled = false;
            document.getElementById("guardarfinalizar").disabled = false;
        }

        function deshabilitarBotones() {
            document.getElementById("guardar").disabled = true;
            document.getElementById("btnguardarnuevo").disabled = true;
            document.getElementById("guardarfinalizar").disabled = true;
        }
    </script>

    <script>
        // Variables globales para el modal
        let socket = null;
        let reconnectAttempts = 0;
        const maxReconnectAttempts = 5;
        const reconnectDelay = 2000;
        let autoReconnect = true;
        let isCapturing = false;
        let captureTimeout = null;
        const CAPTURE_TIMEOUT_MS = 30000;
        let currentTemplate = '';

        // Elementos del DOM del modal
        const statusElement = document.getElementById('status');
        const fingerprintDataElement = document.getElementById('fingerprintData');
        const fingerprintImgElement = document.getElementById('fingerprintImg');
        const imagePlaceholderElement = document.getElementById('imagePlaceholder');
        const logElement = document.getElementById('log');
        const qualityInputBoxElement = document.getElementById('qualityInputBox');

        // Elementos de información
        const templateSizeElement = document.getElementById('templateSize');
        const templateInfoElement = document.getElementById('templateInfo');
        const imageInfoElement = document.getElementById('imageInfo');
        const imageSizeElement = document.getElementById('imageSize');

        // Botones del modal
        const btnConnect = document.getElementById('btnConnect');
        const btnDisconnect = document.getElementById('btnDisconnect');
        const btnCapture = document.getElementById('btnCapture');
        const btnInit = document.getElementById('btnInit');
        const btnGuardar = document.getElementById('btnGuardar');

        // Función para mostrar mensajes en el log
        function logMessage(message, type = 'info') {
            const timestamp = new Date().toLocaleTimeString();
            const className = type === 'error' ? 'error' :
                type === 'success' ? 'success' :
                type === 'event' ? 'event' :
                type === 'warning' ? 'warning' : '';
            logElement.innerHTML += `<div class="${className}">[${timestamp}] ${message}</div>`;
            logElement.scrollTop = logElement.scrollHeight;
        }

        // Función para actualizar el estado de conexión
        function updateStatus(connected, message = '') {
            if (connected) {
                statusElement.textContent = message || '✅ Conectado al servidor de huellas';
                statusElement.className = 'status connected';
                btnConnect.disabled = true;
                btnDisconnect.disabled = false;
                btnCapture.disabled = isCapturing;
                btnInit.disabled = false;
            } else {
                statusElement.textContent = message || '❌ Desconectado del servidor de huellas';
                statusElement.className = 'status disconnected';
                btnConnect.disabled = false;
                btnDisconnect.disabled = true;
                btnCapture.disabled = true;
                btnInit.disabled = true;
                resetCaptureState();
            }
        }

        // Función para actualizar estado de conexión
        function updateStatusConnecting() {
            statusElement.textContent = '🔄 Conectando al servidor de huellas...';
            statusElement.className = 'status connecting';
            btnConnect.disabled = true;
        }

        // Resetear estado de captura
        function resetCaptureState() {
            isCapturing = false;
            if (captureTimeout) {
                clearTimeout(captureTimeout);
                captureTimeout = null;
            }
            updateCaptureButton();
        }

        // Actualizar botón de captura
        function updateCaptureButton() {
            btnCapture.disabled = isCapturing || !socket || socket.readyState !== WebSocket.OPEN;
            if (isCapturing) {
                btnCapture.innerHTML = '<i class="fas fa-sync-alt mr-1"></i> Capturando...';
                btnCapture.style.backgroundColor = '#ffc107';
            } else {
                btnCapture.innerHTML = '<i class="fas fa-fingerprint mr-1"></i> Capturar Huella';
                btnCapture.style.backgroundColor = '';
            }
        }

        // Timeout de captura
        function startCaptureTimeout() {
            if (captureTimeout) {
                clearTimeout(captureTimeout);
            }
            captureTimeout = setTimeout(() => {
                logMessage('⏰ Tiempo de captura agotado', 'warning');
                resetCaptureState();
            }, CAPTURE_TIMEOUT_MS);
        }

        // Mostrar imagen de huella
        function displayFingerprintImage(imageBase64) {
            try {
                if (imageBase64 && imageBase64.length > 100) {
                    const imageSrc = `data:image/png;base64,${imageBase64}`;

                    const img = new Image();
                    img.onload = function() {
                        fingerprintImgElement.src = imageSrc;
                        fingerprintImgElement.style.display = 'block';
                        imagePlaceholderElement.style.display = 'none';

                        imageInfoElement.textContent = `Resolución: ${this.width}x${this.height} px`;
                        imageSizeElement.textContent = `Tamaño: ${Math.round(imageBase64.length * 0.75 / 1024)} KB`;

                        logMessage(`✅ Imagen capturada (${this.width}x${this.height} px)`, 'success');

                        // Habilitar botón guardar
                        btnGuardar.disabled = false;
                    };
                    img.onerror = function() {
                        logMessage('❌ Error al cargar la imagen', 'error');
                        resetImageDisplay();
                    };
                    img.src = imageSrc;
                } else {
                    logMessage('⚠️ Imagen no válida', 'warning');
                    resetImageDisplay();
                }
            } catch (error) {
                logMessage(`❌ Error: ${error}`, 'error');
                resetImageDisplay();
            }
        }

        // Resetear visualización de imagen
        function resetImageDisplay() {
            fingerprintImgElement.style.display = 'none';
            imagePlaceholderElement.style.display = 'block';
            imageInfoElement.textContent = 'Resolución: 0x0 px';
            imageSizeElement.textContent = 'Tamaño: 0 KB';
            btnGuardar.disabled = true;
        }

        // Conectar al servidor WebSocket
        function connect() {
            if (socket && socket.readyState === WebSocket.OPEN) {
                logMessage('Ya conectado', 'info');
                return;
            }

            updateStatusConnecting();
            logMessage('Conectando...', 'info');

            try {
                socket = new WebSocket('ws://localhost:8081/');

                socket.onopen = function(event) {
                    reconnectAttempts = 0;
                    updateStatus(true, '✅ Conectado - Servidor listo');
                    logMessage('Conexión establecida', 'success');
                    resetCaptureState();
                    resetImageDisplay();
                    qualityInputBoxElement.textContent = 'Presione "Capturar Huella" para comenzar';
                };

                socket.onmessage = function(event) {
                    const message = event.data;
                    logMessage(`${message}`, 'event');
                    processServerMessage(message);
                };

                socket.onclose = function(event) {
                    logMessage(`Conexión cerrada`, 'info');
                    updateStatus(false);
                    resetCaptureState();

                    if (autoReconnect && reconnectAttempts < maxReconnectAttempts) {
                        reconnectAttempts++;
                        logMessage(`Reconectando... (${reconnectAttempts}/${maxReconnectAttempts})`, 'info');
                        setTimeout(connect, reconnectDelay);
                    }
                };

                socket.onerror = function(error) {
                    logMessage(`❌ Error de conexión`, 'error');
                    updateStatus(false, '❌ Error de conexión');
                    resetCaptureState();
                };

            } catch (error) {
                logMessage(`❌ Error: ${error}`, 'error');
                updateStatus(false);
                resetCaptureState();
            }
        }

        // Procesar mensajes del servidor
        function processServerMessage(message) {
            // Mensaje de huella capturada
            if (message.startsWith('FINGERPRINT_CAPTURED:')) {
                const parts = message.split(':');
                if (parts.length >= 3) {
                    const templateBase64 = parts[1];
                    const imageBase64 = parts[2];

                    // Guardar template (oculto)
                    fingerprintDataElement.value = templateBase64;
                    currentTemplate = templateBase64;
                    const templateSize = Math.round(templateBase64.length * 0.75);
                    templateSizeElement.textContent = `Tamaño: ${templateSize} bytes`;
                    templateInfoElement.textContent = `Características: ${Math.round(templateSize / 10)} aprox.`;

                    // Mostrar imagen
                    displayFingerprintImage(imageBase64);

                    logMessage('✅ Huella capturada correctamente', 'success');

                    qualityInputBoxElement.textContent = '✅ Huella capturada correctamente';
                    qualityInputBoxElement.style.color = '#28a745';

                    resetCaptureState();
                }
            } else if (message.startsWith('ERROR:')) {
                const errorMsg = message.split(':')[1];
                logMessage(`❌ ${errorMsg}`, 'error');
                qualityInputBoxElement.textContent = `❌ ${errorMsg}`;
                qualityInputBoxElement.style.color = '#dc3545';
                resetCaptureState();
            } else if (message.startsWith('STATUS:')) {
                const status = message.split(':')[1];
                logMessage(`📊 ${status}`, 'info');
            } else if (message === 'CAPTURE_STARTED') {
                logMessage('🎯 Iniciando captura...', 'success');
                isCapturing = true;
                updateCaptureButton();
                startCaptureTimeout();
                qualityInputBoxElement.textContent = 'Coloque su dedo en el lector...';
                qualityInputBoxElement.style.color = '#007bff';

                // Limpiar datos anteriores
                fingerprintDataElement.value = '';
                resetImageDisplay();
                templateSizeElement.textContent = 'Tamaño: 0 bytes';
                templateInfoElement.textContent = 'Características: 0';

            } else if (message === 'FINGER_TOUCHED') {
                logMessage('👆 Dedo detectado', 'event');
                qualityInputBoxElement.textContent = 'Dedo detectado - Procesando...';
                qualityInputBoxElement.style.color = '#ffc107';
            } else if (message === 'FINGER_REMOVED') {
                logMessage('👋 Dedo retirado', 'event');
            } else if (message === 'READER_CONNECTED') {
                logMessage('🔌 Lector conectado', 'success');
            } else if (message === 'SAMPLE_QUALITY_GOOD') {
                logMessage('✅ Calidad: BUENA', 'success');
                qualityInputBoxElement.textContent = '✅ Calidad: BUENA';
                qualityInputBoxElement.style.color = '#28a745';
            } else if (message === 'SAMPLE_QUALITY_POOR') {
                logMessage('⚠️ Calidad: POBRE', 'warning');
                qualityInputBoxElement.textContent = '⚠️ Calidad: POBRE - Intente nuevamente';
                qualityInputBoxElement.style.color = '#ffc107';
            }
        }

        // Desconectar del servidor
        function disconnect() {
            autoReconnect = false;
            if (socket) {
                socket.close(1000, 'Desconexión manual');
                socket = null;
            }
            reconnectAttempts = maxReconnectAttempts;
            updateStatus(false);
            resetCaptureState();
            logMessage('Desconexión manual', 'info');
        }

        // Capturar huella
        function captureFingerprint() {
            if (isCapturing) {
                logMessage('⚠️ Captura en progreso', 'warning');
                return;
            }

            if (socket && socket.readyState === WebSocket.OPEN) {
                isCapturing = true;
                updateCaptureButton();
                startCaptureTimeout();

                socket.send('capture');
                logMessage('🔄 Enviando comando...', 'info');
                qualityInputBoxElement.textContent = 'Iniciando captura...';
                qualityInputBoxElement.style.color = '#007bff';

            } else {
                logMessage('❌ No hay conexión', 'error');
                resetCaptureState();
            }
        }

        // Inicializar capturador
        function initializeCapturer() {
            if (socket && socket.readyState === WebSocket.OPEN) {
                socket.send('init');
                logMessage('🔄 Reinicializando...', 'info');
                qualityInputBoxElement.textContent = 'Reinicializando...';
            } else {
                logMessage('❌ No hay conexión', 'error');
            }
        }

        // Limpiar imagen
        function limpiarImagen() {
            resetImageDisplay();
            fingerprintDataElement.value = '';
            templateSizeElement.textContent = 'Tamaño: 0 bytes';
            templateInfoElement.textContent = 'Características: 0';
            qualityInputBoxElement.textContent = 'Imagen limpiada - Listo para nueva captura';
            qualityInputBoxElement.style.color = '#6c757d';
            logMessage('🔄 Imagen limpiada', 'info');
        }

        // Guardar imagen
        function guardarTemplate() {
            event.preventDefault();
            if (!fingerprintDataElement.value) {
                alert('No hay datos de huella para guardar');
                return;
            }

            const templateData = fingerprintDataElement.value;
            document.getElementById("base64Huella").value = templateData;

            // console.log('Guardando huella con template:', templateData);

            logMessage('💾 Guardando datos...', 'success');
            qualityInputBoxElement.textContent = '✅ Datos guardados';
            qualityInputBoxElement.style.color = '#28a745';

            // Aquí puedes enviar los datos a tu base de datos
            // templateData contiene el template en base64

            //alert('Huella guardada correctamente');

            // Ejemplo de cómo enviar a tu backend:
            /*
            fetch('/guardar-huella', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    template: templateData,
                    imagen: fingerprintImgElement.src
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Huella guardada en base de datos');
                }
            });
            */
        }

        // Evento cuando se abre el modal
        $('#modalHuellaBiometrica').on('show.bs.modal', function() {
            connect();
        });

        // Evento cuando se cierra el modal
        $('#modalHuellaBiometrica').on('hide.bs.modal', function() {
            // Opcional: Desconectar cuando se cierra el modal
             disconnect();
        });
    </script>

</body>

</html>