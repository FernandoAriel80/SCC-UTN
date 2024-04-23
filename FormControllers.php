<?php

require_once 'class/claseCRUDPedido.php';
require_once 'class/claseCRUDRenglonesPedido.php';
require_once 'class/claseCRUDStock.php';

$host = '127.0.0.1:3310';
$user = 'root';
$password = '';
$database = 'SCC';
$conex = mysqli_connect($host, $user, $password, $database);

if (!$conex) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
session_start();

///////////////////////////-STOCK-////////////////////////////////////
if (!isset($_SESSION['ObjetoStocks'])) {
    $_SESSION['ObjetoStocks'] = new CreadorStocks();
}
$ObjetoStocks = $_SESSION['ObjetoStocks'];

///////////////////////////-PEDIDO-////////////////////////////////////
if (!isset($_SESSION['ObjetoPedidos'])) {
    $_SESSION['ObjetoPedidos'] = new CreadorPedidos();
}
$ObjetoPedidos = $_SESSION['ObjetoPedidos'];

if (!isset($_SESSION['CabecerasRenglones'])) {
    $_SESSION['CabecerasRenglones'] = new CabecerasRenglones();
}
$ObjetoRenglones = $_SESSION['CabecerasRenglones'];

if (isset($_POST['cargarPedido'])) {

    if ($ObjetoRenglones->ListaRenglones != NULL) {
        $pedidoActual = $ObjetoPedidos->traeIdPedido($conex);

        $ObjetoPedidos->cargaPedido($conex);
        
        foreach ($ObjetoRenglones->ListaRenglones as $tablaRenglones) {
            $idRenglon = $tablaRenglones['idRenglon'];
            $color = $tablaRenglones['idColor'];
            $genero = $tablaRenglones['idGenero'];
            $S = $tablaRenglones['talleS'];
            $M = $tablaRenglones['talleM'];
            $L = $tablaRenglones['talleL'];
            $XL = $tablaRenglones['talleXL'];
            $XXL = $tablaRenglones['talleXXL'];
            $ObjetoRenglones->DB_cargarRenglones($conex, $pedidoActual, $idRenglon, $color, $S, $M, $L, $XL, $XXL, $genero);
        }
        $ObjetoPedidos->cargaPedidosDetalles($conex,$pedidoActual);
        $ObjetoStocks->DB_DescontarStockMateriales($conex);
        unset($_SESSION['CabecerasRenglones']);
        unset($_SESSION['ObjetoStocks']);
        header("Location: index.php");
        exit();
    }
}

if (isset($_POST['cambiarEstadoPedido'])) {

    $pedidoActual = $_POST['cambiarEstadoPedido'];
    $estado = $_POST['valorEstado'];
    $ObjetoPedidos->cambiarPedidoEstado($conex, $pedidoActual, $estado);
    header("Location: index.php");
}

if( isset($_POST['btn-ToIndex']) ){

    header("Location:index.php");
    exit;
}

///////////////////////////-RENGLONES-//////////////////////////////////////

if (isset($_POST['cargarRenglon'])) {

    if (
        strlen(($_POST["S"])) > 0 || strlen(($_POST["M"])) > 0 ||
        strlen(($_POST["L"])) > 0 || strlen(($_POST["XL"])) > 0 || strlen(($_POST["XXL"])) > 0
    ) {
        $idColor = $_POST['miSelectorColor'];
        $colorDesc = $ObjetoPedidos->traerColor($conex, $idColor);
        $idGenero = $_POST['miSelectorGenero'];
        $generoDesc = $ObjetoPedidos->traerGenero($conex, $idGenero);

        $pedidoActual = strval($ObjetoPedidos->traeIdPedido($conex));
        $idRengAct = $ObjetoRenglones->devolverRenglon();
        
        $S = $_POST['S'];
        $M = $_POST['M'];
        $L = $_POST['L'];
        $XL = $_POST['XL'];
        $XXL = $_POST['XXL'];

       if ($ObjetoStocks->descuentaStock($conex,$idGenero,$S,$M,$L,$XL,$XXL)) {
        
        $ObjetoStocks->cargarArrayRenglonStock($idRengAct,$idGenero,$S,$M,$L,$XL,$XXL); 
        
        $ObjetoRenglones->loadRenglonesSession($pedidoActual, $idRengAct , $idColor, $S, $M, $L, $XL, $XXL, $idGenero, $colorDesc , $generoDesc);
       
       }
      
    }

    header("Location: index.php");
    exit();
}

if(isset($_POST['eliminarRenglon'])){
    $idReng = $_POST['eliminarRenglon'];
    $ObjetoStocks->sumarRenglonBorrado($conex,$idReng);
    $ObjetoStocks->borrarRenglonStock($conex,$idReng);
    $ObjetoRenglones->borrarRenglonSession($conex,$idReng);
    header("Location: index.php");
    exit();
}

if (isset($_POST['borrarRenglones'])) {
    unset($_SESSION['CabecerasRenglones']);
    unset($_SESSION['ObjetoStocks']);
    header("Location: index.php");
    exit();
}




