<!DOCTYPE html>
<html>

<head>
    <title>Cliente WebSocket - Captura y Verificación de Huellas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .connected {
            background-color: #d4edda;
            color: #155724;
        }

        .disconnected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .connecting {
            background-color: #fff3cd;
            color: #856404;
        }

        .controls {
            margin: 20px 0;
        }

        button {
            padding: 10px 15px;
            margin: 5px;
            cursor: pointer;
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        textarea {
            width: 100%;
            height: 150px;
            margin: 10px 0;
        }

        .log {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            height: 200px;
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

        .focus-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .data-container {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }

        .data-section {
            flex: 1;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #f8f9fa;
        }

        .fingerprint-image {
            text-align: center;
            margin: 10px 0;
        }

        .fingerprint-img {
            max-width: 100%;
            max-height: 300px;
            border: 2px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            background-color: white;
        }

        .image-placeholder {
            width: 100%;
            height: 200px;
            border: 2px dashed #dee2e6;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            background-color: #f8f9fa;
        }

        .template-info {
            font-size: 12px;
            color: #6c757d;
            margin-top: 10px;
        }

        .auto-capture-notice {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .verification-section {
            background-color: #f0f8ff;
            border: 2px solid #007bff;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }

        .verification-result {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }

        .verification-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .verification-failed {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Cliente WebSocket - Captura y Verificación de Huellas Digitales</h1>

        <div class="focus-notice">
            💡 <strong>Nota:</strong> La aplicación se activará automáticamente cuando inicies una captura
        </div>

        <div class="auto-capture-notice">
            🔄 <strong>Captura Automática:</strong> Se iniciará automáticamente cuando se conecte al servidor
        </div>

        <div id="status" class="status disconnected">
            Desconectado
        </div>

        <div class="controls">
            <button id="btnConnect" onclick="connect()" style="display: none;">Conectar</button>
            <button id="btnDisconnect" onclick="disconnect()" disabled>Desconectar</button>
            <button id="btnCapture" onclick="captureFingerprint()" disabled>Capturar Huella</button>
            <button id="btnStatus" onclick="getStatus()" disabled>Obtener Estado</button>
            <button id="btnInit" onclick="initializeCapturer()" disabled>Reinicializar</button>
            <!-- NUEVO: Botón de verificación -->
            <button id="btnVerify" onclick="startVerificationMode()" disabled>Verificar Huella</button>
        </div>

        <!-- NUEVA SECCIÓN: Verificación -->
        <div class="verification-section">
            <h3>🔍 Verificación de Huella</h3>
            <p>Usa el template capturado para verificar una huella:</p>
            <button id="btnStartVerify" onclick="startVerification()" disabled>Iniciar Verificación</button>
            <div id="verificationResult" class="verification-result" style="display: none;">
                <!-- Resultado de verificación aparecerá aquí -->
            </div>
        </div>

        <div class="data-container">
            <div class="data-section">
                <h3>📊 Template de Huella:</h3>
                <textarea id="fingerprintData" readonly placeholder="Los datos del template aparecerán aquí..."></textarea>
                <div class="template-info">
                    <div id="templateSize">Tamaño: 0 bytes</div>
                    <div id="templateInfo">Características: 0</div>
                </div>
            </div>

            <div class="data-section">
                <h3>🖼️ Imagen de Huella:</h3>
                <div class="fingerprint-image">
                    <div id="imagePlaceholder" class="image-placeholder">
                        👆 La imagen de la huella aparecerá aquí
                    </div>
                    <img id="fingerprintImg" class="fingerprint-img" style="display: none;" alt="Imagen de huella digital">
                </div>
                <div class="template-info">
                    <div id="imageInfo">Resolución: 0x0 px</div>
                    <div id="imageSize">Tamaño: 0 KB</div>
                </div>
            </div>
        </div>

        <h3>📝 Registro de Eventos:</h3>
        <div id="log" class="log"></div>
    </div>

    <script>
        let socket = null;
        let reconnectAttempts = 0;
        const maxReconnectAttempts = 5;
        const reconnectDelay = 2000;
        let autoReconnect = true;

        // VARIABLES PARA CONTROLAR CAPTURA
        let isCapturing = false;
        let captureTimeout = null;
        const CAPTURE_TIMEOUT_MS = 30000;
        let autoCaptureOnConnect = true;

        // NUEVO: Variables para verificación
        let isVerificationMode = false;
        let currentTemplate = '';

        const statusElement = document.getElementById('status');
        const fingerprintDataElement = document.getElementById('fingerprintData');
        const fingerprintImgElement = document.getElementById('fingerprintImg');
        const imagePlaceholderElement = document.getElementById('imagePlaceholder');
        const logElement = document.getElementById('log');
        const verificationResultElement = document.getElementById('verificationResult');

        // Elementos de información
        const templateSizeElement = document.getElementById('templateSize');
        const templateInfoElement = document.getElementById('templateInfo');
        const imageInfoElement = document.getElementById('imageInfo');
        const imageSizeElement = document.getElementById('imageSize');

        // Botones
        const btnConnect = document.getElementById('btnConnect');
        const btnDisconnect = document.getElementById('btnDisconnect');
        const btnCapture = document.getElementById('btnCapture');
        const btnStatus = document.getElementById('btnStatus');
        const btnInit = document.getElementById('btnInit');
        const btnVerify = document.getElementById('btnVerify');
        const btnStartVerify = document.getElementById('btnStartVerify');

        function logMessage(message, type = 'info') {
            const timestamp = new Date().toLocaleTimeString();
            const className = type === 'error' ? 'error' :
                type === 'success' ? 'success' :
                type === 'event' ? 'event' :
                type === 'warning' ? 'warning' : '';
            logElement.innerHTML += `<div class="${className}">[${timestamp}] ${message}</div>`;
            logElement.scrollTop = logElement.scrollHeight;
            console.log(`[${timestamp}] ${message}`);
        }

        function updateStatus(connected, message = '') {
            if (connected) {
                statusElement.textContent = message || '✅ Conectado al servidor';
                statusElement.className = 'status connected';
                btnConnect.disabled = true;
                btnDisconnect.disabled = false;
                btnCapture.disabled = isCapturing;
                btnStatus.disabled = false;
                btnInit.disabled = false;
                btnVerify.disabled = false;
                btnStartVerify.disabled = !currentTemplate;

                // Iniciar captura automática si está habilitada
                if (autoCaptureOnConnect) {
                    setTimeout(() => {
                        logMessage('🔄 Iniciando captura automática...', 'info');
                        captureFingerprint();
                    }, 1000);
                }
            } else {
                statusElement.textContent = message || '❌ Desconectado';
                statusElement.className = 'status disconnected';
                btnConnect.disabled = false;
                btnDisconnect.disabled = true;
                btnCapture.disabled = true;
                btnStatus.disabled = true;
                btnInit.disabled = true;
                btnVerify.disabled = true;
                btnStartVerify.disabled = true;
                resetCaptureState();
            }
        }

        function updateStatusConnecting() {
            statusElement.textContent = '🔄 Conectando...';
            statusElement.className = 'status connecting';
            btnConnect.disabled = true;
        }

        function resetCaptureState() {
            isCapturing = false;
            isVerificationMode = false;
            if (captureTimeout) {
                clearTimeout(captureTimeout);
                captureTimeout = null;
            }
            updateCaptureButton();
        }

        function updateCaptureButton() {
            btnCapture.disabled = isCapturing || !socket || socket.readyState !== WebSocket.OPEN;
            if (isCapturing) {
                btnCapture.textContent = '🔄 Capturando...';
                btnCapture.style.backgroundColor = '#ffc107';
            } else {
                btnCapture.textContent = 'Capturar Huella';
                btnCapture.style.backgroundColor = '';
            }
        }

        function startCaptureTimeout() {
            if (captureTimeout) {
                clearTimeout(captureTimeout);
            }
            captureTimeout = setTimeout(() => {
                logMessage('⏰ Timeout de captura alcanzado - Reiniciando estado', 'warning');
                resetCaptureState();
            }, CAPTURE_TIMEOUT_MS);
        }

        // NUEVO: Función para verificar huella
        function verifyFingerprint(templateBase64) {
            if (socket && socket.readyState === WebSocket.OPEN) {
                const message = `verify:${templateBase64}`;
                socket.send(message);
                logMessage('🔍 Enviando template para verificación...', 'info');
                logMessage('💡 Escanee la huella a verificar', 'info');
                isVerificationMode = true;
            } else {
                logMessage('❌ Error: No hay conexión con el servidor', 'error');
            }
        }

        // NUEVO: Iniciar modo verificación
        function startVerification() {
            const templateBase64 = fingerprintDataElement.value.trim();
            if (!templateBase64) {
                logMessage('❌ Error: No hay template para verificar', 'error');
                showVerificationResult('Por favor, capture primero una huella para obtener el template', false);
                return;
            }

            currentTemplate = templateBase64;
            verifyFingerprint(templateBase64);
            showVerificationResult('Modo verificación activado - Escanee huella para verificar', null);
        }

        // NUEVO: Mostrar resultado de verificación
        function showVerificationResult(message, isSuccess) {
            verificationResultElement.style.display = 'block';
            verificationResultElement.textContent = message;

            if (isSuccess === true) {
                verificationResultElement.className = 'verification-result verification-success';
            } else if (isSuccess === false) {
                verificationResultElement.className = 'verification-result verification-failed';
            } else {
                verificationResultElement.className = 'verification-result';
                verificationResultElement.style.backgroundColor = '#fff3cd';
                verificationResultElement.style.color = '#856404';
            }
        }

        // NUEVO: Función para modo verificación (comando simple)
        function startVerificationMode() {
            if (socket && socket.readyState === WebSocket.OPEN) {
                socket.send('verify');
                logMessage('🔍 Solicitando modo verificación...', 'info');
            } else {
                logMessage('❌ Error: No hay conexión con el servidor', 'error');
            }
        }

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

                        logMessage(`🖼️ Imagen de huella mostrada (${this.width}x${this.height} px)`, 'success');
                    };
                    img.onerror = function() {
                        logMessage('❌ Error al cargar la imagen de huella', 'error');
                        resetImageDisplay();
                    };
                    img.src = imageSrc;
                } else {
                    logMessage('⚠️ Datos de imagen insuficientes o inválidos', 'warning');
                    resetImageDisplay();
                }
            } catch (error) {
                logMessage(`❌ Error al mostrar imagen: ${error}`, 'error');
                resetImageDisplay();
            }
        }

        function resetImageDisplay() {
            fingerprintImgElement.style.display = 'none';
            imagePlaceholderElement.style.display = 'flex';
            imageInfoElement.textContent = 'Resolución: 0x0 px';
            imageSizeElement.textContent = 'Tamaño: 0 KB';
        }

        function connect() {
            if (socket && socket.readyState === WebSocket.OPEN) {
                logMessage('Ya está conectado', 'info');
                return;
            }

            updateStatusConnecting();
            logMessage('Intentando conectar con el servidor...', 'info');

            try {
                socket = new WebSocket('ws://localhost:8081/');

                socket.onopen = function(event) {
                    reconnectAttempts = 0;
                    updateStatus(true, '✅ Conectado - Servidor listo');
                    logMessage('Conexión WebSocket establecida correctamente', 'success');
                    logMessage('Puedes enviar comandos de captura', 'info');
                    resetCaptureState();
                    resetImageDisplay();
                };

                socket.onmessage = function(event) {
                    const message = event.data;
                    logMessage(`📨 Servidor: ${message}`, 'event');
                    processServerMessage(message);
                };

                socket.onclose = function(event) {
                    logMessage(`Conexión cerrada: ${event.code} - ${event.reason || 'Sin razón'}`, 'info');
                    updateStatus(false);
                    resetCaptureState();

                    if (autoReconnect && reconnectAttempts < maxReconnectAttempts) {
                        reconnectAttempts++;
                        logMessage(`Intentando reconectar... (${reconnectAttempts}/${maxReconnectAttempts})`, 'info');
                        setTimeout(connect, reconnectDelay);
                    }
                };

                socket.onerror = function(error) {
                    logMessage(`❌ Error de WebSocket: No se pudo conectar al servidor`, 'error');
                    logMessage(`Asegúrate de que la aplicación C# esté ejecutándose`, 'error');
                    updateStatus(false, '❌ Error de conexión');
                    resetCaptureState();
                };

            } catch (error) {
                logMessage(`❌ Error al crear WebSocket: ${error}`, 'error');
                updateStatus(false);
                resetCaptureState();
            }
        }

        function processServerMessage(message) {
            // NUEVO: Procesar mensajes de verificación
            if (message.startsWith('VERIFICATION_READY:')) {
                const status = message.split(':')[1];
                logMessage(`✅ ${status}`, 'success');
                logMessage('👆 Coloque su dedo en el lector para verificar', 'info');
                isVerificationMode = true;
                showVerificationResult('Listo para verificar - Escanee su huella', null);
            } else if (message.startsWith('VERIFICATION_SUCCESS:')) {
                const result = message.split(':')[1];
                logMessage(`🎉 ${result}`, 'success');
                showVerificationResult('✅ HUELLA VERIFICADA CORRECTAMENTE', true);
                resetCaptureState();
                isVerificationMode = false;
            } else if (message.startsWith('VERIFICATION_FAILED:')) {
                const result = message.split(':')[1];
                logMessage(`❌ ${result}`, 'error');
                showVerificationResult('❌ HUELLA NO COINCIDE - Verificación fallida', false);
                resetCaptureState();
                isVerificationMode = false;
            } else if (message.startsWith('VERIFICATION_ERROR:')) {
                const error = message.split(':')[1];
                logMessage(`❌ Error de verificación: ${error}`, 'error');
                showVerificationResult(`❌ Error: ${error}`, false);
                resetCaptureState();
                isVerificationMode = false;
            }
            // Procesar mensaje con template e imagen
            else if (message.startsWith('FINGERPRINT_CAPTURED:')) {
                const parts = message.split(':');
                if (parts.length >= 3) {
                    const templateBase64 = parts[1];
                    const imageBase64 = parts[2];

                    // Mostrar template
                    fingerprintDataElement.value = templateBase64;
                    currentTemplate = templateBase64;
                    const templateSize = Math.round(templateBase64.length * 0.75);
                    templateSizeElement.textContent = `Tamaño: ${templateSize} bytes`;
                    templateInfoElement.textContent = `Características: ${Math.round(templateSize / 10)} aprox.`;

                    // Mostrar imagen
                    displayFingerprintImage(imageBase64);

                    logMessage('✅ Huella digital capturada - Template e imagen recibidos', 'success');
                    logMessage(`📊 Tamaño del template: ${templateSize} bytes`, 'info');

                    // Habilitar botón de verificación
                    btnStartVerify.disabled = false;

                    resetCaptureState();
                }

            } else if (message.startsWith('ERROR:')) {
                const errorMsg = message.split(':')[1];
                logMessage(`❌ Error del servidor: ${errorMsg}`, 'error');
                resetCaptureState();

            } else if (message.startsWith('STATUS:')) {
                const status = message.split(':')[1];
                logMessage(`📊 Estado del servidor: ${status}`, 'info');

            } else if (message === 'CAPTURE_STARTED') {
                logMessage('🎯 Captura iniciada - Coloque su dedo en el lector', 'success');
                logMessage('💡 La ventana de la aplicación se activará automáticamente', 'info');
                isCapturing = true;
                updateCaptureButton();
                startCaptureTimeout();

                // Limpiar datos anteriores
                fingerprintDataElement.value = '';
                resetImageDisplay();
                templateSizeElement.textContent = 'Tamaño: 0 bytes';
                templateInfoElement.textContent = 'Características: 0';
                verificationResultElement.style.display = 'none';

            } else if (message === 'FINGER_TOUCHED') {
                logMessage('👆 Dedo detectado en el lector', 'event');

            } else if (message === 'FINGER_REMOVED') {
                logMessage('👋 Dedo retirado del lector', 'event');

            } else if (message === 'READER_CONNECTED') {
                logMessage('🔌 Lector de huellas conectado', 'success');

            } else if (message === 'SAMPLE_QUALITY_GOOD') {
                logMessage('✅ Calidad de la muestra: BUENA', 'success');

            } else if (message === 'SAMPLE_QUALITY_POOR') {
                logMessage('⚠️ Calidad de la muestra: POBRE - Intente nuevamente', 'warning');
            }
        }

        function disconnect() {
            autoReconnect = false;
            if (socket) {
                socket.close(1000, 'Desconexión manual del usuario');
                socket = null;
            }
            reconnectAttempts = maxReconnectAttempts;
            updateStatus(false);
            resetCaptureState();
            logMessage('Desconexión manual', 'info');
        }

        function captureFingerprint() {
            if (isCapturing) {
                logMessage('⚠️ Ya hay una captura en progreso - Espere a que termine', 'warning');
                return;
            }

            if (socket && socket.readyState === WebSocket.OPEN) {
                isCapturing = true;
                updateCaptureButton();
                startCaptureTimeout();

                socket.send('capture');
                logMessage('🔄 Enviando comando CAPTURE...', 'info');
                logMessage('💡 Activando ventana de la aplicación...', 'info');

            } else {
                logMessage('❌ Error: No hay conexión con el servidor', 'error');
                resetCaptureState();
            }
        }

        function initializeCapturer() {
            if (socket && socket.readyState === WebSocket.OPEN) {
                socket.send('init');
                logMessage('🔄 Enviando comando INIT...', 'info');
            } else {
                logMessage('❌ Error: No hay conexión con el servidor', 'error');
            }
        }

        function getStatus() {
            if (socket && socket.readyState === WebSocket.OPEN) {
                socket.send('status');
                logMessage('📊 Solicitando estado del servidor...', 'info');
            } else {
                logMessage('❌ Error: No hay conexión con el servidor', 'error');
            }
        }

        // Conectar automáticamente al cargar la página
        window.addEventListener('load', function() {
            logMessage('Página cargada - Conectando automáticamente...', 'info');
            connect();
        });

        // Verificar el estado de la conexión periódicamente
        setInterval(() => {
            if (socket && socket.readyState === WebSocket.OPEN) {
                // Conexión saludable
            } else if (socket && socket.readyState === WebSocket.CLOSED && autoReconnect) {
                if (reconnectAttempts < maxReconnectAttempts) {
                    logMessage('🔄 Intentando reconexión automática...', 'info');
                    connect();
                }
            }
        }, 5000);
    </script>
</body>

</html>




