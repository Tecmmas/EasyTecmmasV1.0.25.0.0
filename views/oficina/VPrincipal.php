<?php $this->load->view('./header'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .disk-info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        color: white;
        padding: 25px;
        margin: 20px 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .disk-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .disk-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .stat-item {
        text-align: center;
        padding: 15px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .stat-label {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .stat-value {
        font-size: 18px;
        font-weight: 600;
    }

    .progress-container {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        padding: 15px;
        margin-top: 10px;
    }

    .progress-percent {
        text-align: center;
        font-size: 28px;
        font-weight: 700;
        margin: 15px 0;
    }

    .progress-bar-custom {
        height: 12px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 6px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .progress-low {
        background: linear-gradient(90deg, #00b09b, #96c93d);
    }

    .progress-medium {
        background: linear-gradient(90deg, #ffa726, #ff9800);
    }

    .progress-high {
        background: linear-gradient(90deg, #ff416c, #ff4b2b);
    }

    .progress-critical {
        background: linear-gradient(90deg, #ff0000, #8b0000);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.7;
        }

        100% {
            opacity: 1;
        }
    }

    .status-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 10px;
    }

    .status-optimal {
        background: #00b09b;
    }

    .status-warning {
        background: #ff9800;
    }

    .status-critical {
        background: #ff416c;
    }

    /* Optimizaciones de carga */
    .loading-fast {
        padding: 10px;
        text-align: center;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .skeleton-loader {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border-radius: 4px;
        height: 20px;
        margin: 5px 0;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }
</style>

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row">
        <!-- MAIN CONTENT AREA STARTS -->

        <!-- NUEVA SECCIÓN PARA INFORMACIÓN DEL DISCO -->
        <section class="box" id="sectionDisco" style="display: block">
            <div class="content-body">
                <div class="col-12">
                    <div class="col-md-12">
                        <h4><i class="fa fa-hdd-o"></i> Información del Disco</h4>
                        <br>
                    </div>
                    <div class="row" id="infoDisco">
                        <!-- Cargador optimizado -->
                        <div class="col-md-12 col-md-offset-2">
                            <div class="disk-info-card">
                                <div class="disk-title">
                                    <i class="fa fa-hdd-o"></i> Espacio en Disco
                                </div>
                                <div class="disk-stats">
                                    <div class="stat-item">
                                        <div class="skeleton-loader" style="height: 25px;"></div>
                                        <div class="skeleton-loader" style="height: 20px; width: 80%; margin: 0 auto;"></div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="skeleton-loader" style="height: 25px;"></div>
                                        <div class="skeleton-loader" style="height: 20px; width: 80%; margin: 0 auto;"></div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="skeleton-loader" style="height: 25px;"></div>
                                        <div class="skeleton-loader" style="height: 20px; width: 80%; margin: 0 auto;"></div>
                                    </div>
                                </div>
                                <div class="progress-container">
                                    <div class="skeleton-loader" style="height: 40px; width: 50%; margin: 0 auto;"></div>
                                    <div class="skeleton-loader" style="height: 12px; margin: 15px 0;"></div>
                                    <div class="skeleton-loader" style="height: 25px; width: 30%; margin: 0 auto;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="infoPrincipal"></div>

        <input type="hidden" id="fecha" value="<?= $fecha ?>">
        <section class="box " id="sectionMetrologia" style="display: none">
            <div class="content-body">
                <div class="col-12">
                    <div class="col-md-12">
                        <h4>METROLOGIA MAQUINAS</h4><br>
                    </div>
                    <div id="getMetrologia"></div>
                </div>
            </div>
        </section>
    </section>
</section>
<!-- END CONTENT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<?php $this->load->view('./footer'); ?>

<script type="text/javascript">
    var ipLocal = '<?php echo base_url(); ?>';
    var biometrico = '<?php echo $this->session->userdata('biometrico'); ?>';
    var IdUsuario = '<?php echo $this->session->userdata('IdUsuario'); ?>';

    // Cache para evitar llamadas duplicadas
    var diskInfoCache = {
        data: null,
        timestamp: 0,
        ttl: 30000 // 30 segundos
    };

    $(document).ready(function() {
        // Ejecutar en paralelo para mayor velocidad
        Promise.all([
            getdatos(),
            getDiskInfo()
        ]).then(() => {
            console.log('Todas las cargas completadas');
        });

        localStorage.setItem('biometrico', biometrico);
        localStorage.setItem('IdUsuario', IdUsuario);
    });

    // Función optimizada para obtener información del disco
    function getDiskInfo() {
        // Verificar cache primero
        const now = Date.now();
        if (diskInfoCache.data && (now - diskInfoCache.timestamp) < diskInfoCache.ttl) {
            displayDiskInfo(diskInfoCache.data);
            checkDiskAlert(diskInfoCache.data);
            return;
        }

        // Configuración optimizada para AJAX
        $.ajax({
            url: ipLocal + "index.php/oficina/CPrincipal/getDiskInfo",
            type: 'GET',
            dataType: 'json',
            timeout: 10000, // Timeout reducido a 10 segundos
            cache: false, // Evitar cache del navegador
            headers: {
                'Cache-Control': 'no-cache',
                'Pragma': 'no-cache'
            },
            beforeSend: function() {
                // Ya tenemos el skeleton loader en el HTML
            },
            success: function(response) {
                if (response && response.success) {
                    // Actualizar cache
                    diskInfoCache.data = response.data;
                    diskInfoCache.timestamp = Date.now();

                    displayDiskInfo(response.data);
                    checkDiskAlert(response.data);
                } else {
                    displayFallbackDiskInfo();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener información del disco:', error);
                if (diskInfoCache.data) {
                    // Usar datos cacheados si hay error
                    displayDiskInfo(diskInfoCache.data);
                    console.log('Usando datos cacheados debido a error');
                } else {
                    displayFallbackDiskInfo();
                }
            }
        });
    }

    // Función optimizada para mostrar información del disco
    function displayDiskInfo(diskData) {
        const progressClass = getProgressClass(diskData.used_percent);
        const statusClass = getStatusClass(diskData.used_percent);
        const statusText = getStatusText(diskData.used_percent);

        const html = `
            <div class="col-md-12 col-md-offset-2">
                <div class="disk-info-card">
                    <div class="disk-title">
                        <i class="fa fa-hdd-o"></i> Espacio en Disco
                    </div>
                    
                    <div class="disk-stats">
                        <div class="stat-item">
                            <div class="stat-label">Total</div>
                            <div class="stat-value">${diskData.total}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Usado</div>
                            <div class="stat-value">${diskData.used}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Libre</div>
                            <div class="stat-value">${diskData.free}</div>
                        </div>
                    </div>
                    
                    <div class="progress-container">
                        <div class="progress-percent">${diskData.used_percent}%</div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill ${progressClass}" style="width: ${diskData.used_percent}%"></div>
                        </div>
                        <div class="status-badge ${statusClass}">${statusText}</div>
                    </div>
                    
                    <div style="margin-top: 20px; font-size: 12px; opacity: 0.8; text-align: center;">
                        <i class="fa fa-info-circle"></i> Sistema: ${diskData.file_system} | Montaje: ${diskData.mount_point}
                    </div>
                </div>
            </div>
        `;

        // Usar una transición suave
        $('#infoDisco').fadeOut(100, function() {
            $(this).html(html).fadeIn(200);
        });
    }

    // Función separada para verificar alertas
    function checkDiskAlert(diskData) {
        if (diskData.used_percent > 90) {
            showDiskAlert(diskData);
        }
    }

    // Función optimizada para mostrar alerta
    function showDiskAlert(diskData) {
        // Verificar si ya se mostró una alerta recientemente
        const lastAlert = localStorage.getItem('lastDiskAlert');
        const now = Date.now();

        if (lastAlert && (now - parseInt(lastAlert)) < 300000) { // 5 minutos
            return; // No mostrar alerta si ya se mostró hace menos de 5 minutos
        }

        Swal.fire({
            icon: 'warning',
            title: '¡Alerta de Espacio en Disco!',
            html: `
                <div style="text-align: left;">
                    <p>El espacio en disco está llegando a su límite crítico:</p>
                    <ul>
                        <li><strong>Usado:</strong> ${diskData.used} (${diskData.used_percent}%)</li>
                        <li><strong>Libre:</strong> ${diskData.free}</li>
                        <li><strong>Total:</strong> ${diskData.total}</li>
                    </ul>
                    <p style="color: #ff6b6b; font-weight: bold;">
                        ⚠️ Se recomienda liberar espacio inmediatamente.
                    </p>
                </div>
            `,
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#ff6b6b',
            backdrop: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            willOpen: () => {
                localStorage.setItem('lastDiskAlert', now.toString());
            }
        });
    }

    // Función de fallback optimizada
    function displayFallbackDiskInfo() {
        const html = `
            <div class="col-md-12">
                <div class="alert alert-warning" style="text-align: center;">
                    <i class="fa fa-exclamation-triangle"></i> 
                    No se pudo obtener información en tiempo real del disco.
                    <button type="button" class="btn btn-xs btn-default" onclick="forceRefreshDiskInfo()" style="margin-left: 10px;">
                        <i class="fa fa-refresh"></i> Reintentar
                    </button>
                </div>
            </div>
        `;
        $('#infoDisco').html(html);
    }

    // Función forzar refresh (ignorar cache)
    function forceRefreshDiskInfo() {
        diskInfoCache.timestamp = 0; // Invalidar cache
        getDiskInfo();
    }

    // Funciones auxiliares optimizadas (sin cambios)
    function getProgressClass(percent) {
        if (percent < 70) return 'progress-low';
        if (percent < 85) return 'progress-medium';
        if (percent < 90) return 'progress-high';
        return 'progress-critical';
    }

    function getStatusClass(percent) {
        if (percent < 70) return 'status-optimal';
        if (percent < 90) return 'status-warning';
        return 'status-critical';
    }

    function getStatusText(percent) {
        if (percent < 70) return 'Óptimo';
        if (percent < 90) return 'Advertencia';
        return 'Crítico';
    }

    // Tus funciones existentes
    var getdatos = function() {
        return new Promise((resolve) => {
            $.ajax({
                url: "https://updateapp.tecmmas.com/Actualizaciones/index.php/Cdescargas/infoPrincipal",
                type: 'get',
                async: true, // Cambiado a true para no bloquear
                mimeType: 'json',
                timeout: 10000,
                success: function(data) {
                    $("#infoPrincipal").html(data[0].html);
                    resolve();
                },
                error: function(res) {
                    console.log(res.responseText);
                    resolve(); // Resolver incluso en error
                }
            });
        });
    }

    // --- 1. TU FUNCIÓN EXISTENTE (MODIFICADA LIGERAMENTE PARA DEVOLVER DATOS) ---
   // --- TU FUNCIÓN EXISTENTE ---
let informeActualizacion = function () {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "http://updateapp.tecmmas.com/Actualizaciones/index.php/Cdescargas/getActualizacionOficinaAll",
            type: 'get',
            async: true,
            dataType: 'json',
            timeout: 10000,
            success: function (data) {
                console.log("Datos recibidos:", data);
                resolve(data);
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                reject(new Error("No se pudieron obtener los datos: " + error));
            }
        });
    });
}

// --- GENERAR PDF CON ESTILO SIMPLE ---
async function generarYDescargarInformePDF() {
    // Mostrar carga
    $("#loadingIndicator").remove();
    $('body').append('<div id="loadingIndicator" style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:black; color:white; padding:15px 25px; border-radius:8px; z-index:10000;">Generando PDF, espere...</div>');

    try {
        const actualizaciones = await informeActualizacion();
        
        if (!actualizaciones || actualizaciones.length === 0) {
            throw new Error("No hay datos");
        }

        // Preparar datos
        let htmlContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Informe de Actualizaciones</title>
            <style>
                body {
                    font-family: Arial, Helvetica, sans-serif;
                    margin: 20px;
                    padding: 0;
                    line-height: 1.4;
                }
                .container {
                    max-width: 100%;
                    margin: 0 auto;
                }
                h1 {
                    text-align: center;
                    color: #2c3e50;
                    font-size: 22px;
                    margin-bottom: 5px;
                }
                .fecha {
                    text-align: center;
                    font-size: 12px;
                    color: #666;
                    margin-bottom: 20px;
                    padding-bottom: 10px;
                    border-bottom: 1px solid #ccc;
                }
                .version-item {
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    margin-bottom: 15px;
                    page-break-inside: avoid;
                }
                .version-header {
                    background: #f5f5f5;
                    padding: 8px 12px;
                    border-bottom: 1px solid #ddd;
                    font-weight: bold;
                }
                .version-body {
                    padding: 12px;
                }
                .estado {
                    display: inline-block;
                    padding: 2px 8px;
                    border-radius: 3px;
                    font-size: 11px;
                    font-weight: bold;
                    margin-left: 10px;
                }
                .activa {
                    background: #28a745;
                    color: white;
                }
                .inactiva {
                    background: #dc3545;
                    color: white;
                }
                .fecha-item {
                    font-size: 12px;
                    color: #666;
                    margin-bottom: 10px;
                }
                .descripcion {
                    background: #fef9e6;
                    padding: 10px;
                    border-left: 3px solid #ff9800;
                    font-size: 12px;
                }
                .descripcion p {
                    margin: 5px 0;
                }
                .footer {
                    text-align: center;
                    font-size: 10px;
                    color: #999;
                    margin-top: 20px;
                    padding-top: 10px;
                    border-top: 1px solid #eee;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Informe de Actualizaciones del Sistema</h1>
                <div class="fecha">Generado: ${new Date().toLocaleString('es-CO')}</div>
        `;

        // Agregar cada versión
        for (let item of actualizaciones) {
            let version = item.file || item.version || "Sin versión";
            let estado = item.estado === "1" ? "Activa" : "Inactiva";
            let estadoClass = item.estado === "1" ? "activa" : "inactiva";
            let fecha = item.fecha || "Fecha no disponible";
            let descripcion = item.descripcion || "<p>Sin descripción</p>";
            
            htmlContent += `
                <div class="version-item">
                    <div class="version-header">
                        ${version}
                        <span class="estado ${estadoClass}">${estado}</span>
                    </div>
                    <div class="version-body">
                        <div class="fecha-item">📅 ${fecha}</div>
                        <div class="descripcion">
                            ${descripcion}
                        </div>
                    </div>
                </div>
            `;
        }

        htmlContent += `
                <div class="footer">
                    Informe generado automáticamente
                </div>
            </div>
        </body>
        </html>
        `;

        // Crear elemento temporal y generar PDF
        const element = document.createElement('div');
        element.innerHTML = htmlContent;
        element.style.backgroundColor = 'white';
        document.body.appendChild(element);

        const opt = {
            margin: [0.5, 0.5, 0.5, 0.5],
            filename: `Informe_Actualizaciones_${new Date().toISOString().slice(0,10)}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        await html2pdf().set(opt).from(element).save();
        document.body.removeChild(element);
        
    } catch (error) {
        console.error("Error:", error);
        alert("Error: " + error.message);
    } finally {
        $("#loadingIndicator").remove();
    }
}

// --- BOTÓN PARA GENERAR ---
$(document).ready(function() {
    $("#btnGenerarPDF").remove();
    $('body').append(`
        <button id="btnGenerarPDF" style="position:fixed; bottom:20px; right:20px; background:#dc3545; color:white; border:none; border-radius:5px; padding:10px 20px; cursor:pointer; z-index:9999;">
            📄 Descargar informe de actualizaciones.
        </button>
    `);
    
    $("#btnGenerarPDF").click(generarYDescargarInformePDF);
});
</script>