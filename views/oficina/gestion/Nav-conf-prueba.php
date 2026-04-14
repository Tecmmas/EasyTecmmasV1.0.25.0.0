<style>
    .menu-barra:hover{
        background-color: #b2e2f2;
        font-size: 17px;
        color: whitesmoke;
        font-family: sans-serif;
        border-radius: 10px 10px 10px 10px;

    }
    #a-color{
        color: black;
    }

</style>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fdf9c4" >
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link menu-barra" id="a-color" onclick="onReasignacionIndividual()"><i>Reasignación individual</i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-barra" id="a-color" onclick="onPinEstado()"><i>Cambiar pin y estado</i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-barra" id="a-color" onclick="onreconfPrueba()"><i>Reconfigurar prueba</i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-barra" id="a-color" onclick="oncancelPrueba()"><i>Cancelar prueba</i></a>
            </li>
        </ul>
    </div>
</nav>
<script type="text/javascript">
    function onReasignacionIndividual() {
        $('#val-razon').html('');
        var RI = document.getElementById('RasignacionI');
        RI.style.display = 'block';
        RI.style.position = 'relative';
        var PE = document.getElementById('pinEstado');
        PE.style.display = 'none';
        PE.style.position = 'absolute';
        var RP = document.getElementById('reconfPrueba');
        RP.style.display = 'none';
        RP.style.position = 'absolute';
        var CP = document.getElementById('cancelPrueba');
        CP.style.display = 'none';
        CP.style.position = 'absolute';
    }
    function onPinEstado() {
        $('#div-rest-estado').html('');
        var RI = document.getElementById('RasignacionI');
        RI.style.display = 'none';
        RI.style.position = 'absolute';
        var PE = document.getElementById('pinEstado');
        PE.style.display = 'block';
        PE.style.position = 'relative';
        var RP = document.getElementById('reconfPrueba');
        RP.style.display = 'none';
        RP.style.position = 'absolute';
        var CP = document.getElementById('cancelPrueba');
        CP.style.display = 'none';
        CP.style.position = 'absolute';
    }
    function onreconfPrueba() {
        $('#div-reconf-prueba').html('');
        var RI = document.getElementById('RasignacionI');
        RI.style.display = 'none';
        RI.style.position = 'absolute';
        var PE = document.getElementById('pinEstado');
        PE.style.display = 'none';
        PE.style.position = 'absolute';
        var RP = document.getElementById('reconfPrueba');
        RP.style.display = 'block';
        RP.style.position = 'relative';
        var CP = document.getElementById('cancelPrueba');
        CP.style.display = 'none';
        CP.style.position = 'absolute';
    }
    function oncancelPrueba() {
        $('#div-cancel-prueba').html('');
        var RI = document.getElementById('RasignacionI');
        RI.style.display = 'none';
        RI.style.position = 'absolute';
        var PE = document.getElementById('pinEstado');
        PE.style.display = 'none';
        PE.style.position = 'absolute';
        var RP = document.getElementById('reconfPrueba');
        RP.style.display = 'none';
        RP.style.position = 'absolute';
        var CP = document.getElementById('cancelPrueba');
        CP.style.display = 'block';
        CP.style.position = 'relative';
    }
</script>