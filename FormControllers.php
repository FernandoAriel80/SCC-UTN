<?php

require_once 'class/claseCRUDPedido.php';
require_once 'class/claseCRUDRenglonesPedido.php';

$host = '127.0.0.1';
$user = 'root';
$password = '';
$database = 'SCC';
$conex = mysqli_connect($host, $user, $password, $database);

if (!$conex) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
session_start();


///////////////////////////-PEDIDO-////////////////////////////////////
///////////////////////////-aaaaaaaaaaaaaaaaaaaaaaaaaa-////////////////////////////////////
if (!isset($_SESSION['ObjetoPedidos'])) {
    $_SESSION['ObjetoPedidos'] = new CreadorPedidos();
}
$ObjetoPedidos = $_SESSION['ObjetoPedidos'];

if (!isset($_SESSION['CabecerasRenglones'])) {
    $_SESSION['CabecerasRenglones'] = new CabecerasRenglones();
}
$ObjetoRenglones = $_SESSION['CabecerasRenglones'];

if (isset($_POST['cargarPedido'])) {

    $pedidoActual = $ObjetoPedidos->traeIdPedido($conex);

    foreach ($ObjetoRenglones->ListaRenglones as $tablaRenglones) {
        $idRenglon = $tablaRenglones['idRenglon'];
        $color = $tablaRenglones['color'];
        $genero = $tablaRenglones['gen'];
        $S = $tablaRenglones['talleS'];
        $M = $tablaRenglones['talleM'];
        $L = $tablaRenglones['talleL'];
        $XL = $tablaRenglones['talleXL'];
        $XXL = $tablaRenglones['talleXXL'];
        $ObjetoRenglones->DB_cargarRenglones($conex, $pedidoActual , $idRenglon, $color, $S, $M, $L, $XL, $XXL, $genero);
    }
    $ObjetoPedidos->cargaPedido($conex);
    unset($_SESSION['CabecerasRenglones']);
    header("Location: index.php");
    exit();
}

if (isset($_POST['cancelarPedido'])) {
    $pedidoActual = $_POST['cancelarPedido'];
    $ObjetoPedidos->cancelarPedido($conex, $pedidoActual);
}

if (isset($_POST['iniciarPedido'])) {
    $pedidoActual = $_POST['iniciarPedido'];
    $ObjetoPedidos->iniciarPedido($conex, $pedidoActual);
}

if (isset($_POST['finalizarPedido'])) {
    $pedidoActual = $_POST['finalizarPedido'];
    $ObjetoPedidos->finalizarPedido($conex, $pedidoActual);
}
///////////////////////////-RENGLONES-//////////////////////////////////////

if (isset($_POST['cargarRenglon'])) {

    if (
        strlen(($_POST["S"])) > 0 || strlen(($_POST["M"])) > 0 ||
        strlen(($_POST["L"])) > 0 || strlen(($_POST["XL"])) > 0 || strlen(($_POST["XXL"])) > 0
    ) {
        $color = $_POST['miSelectorColor'];
        $genero = $_POST['miSelectorGenero'];

        $pedidoActual = strval($ObjetoPedidos->traeIdPedido($conex));

        $S = $_POST['S'];
        $M = $_POST['M'];
        $L = $_POST['L'];
        $XL = $_POST['XL'];
        $XXL = $_POST['XXL'];

        $ObjetoRenglones->loadRenglonesSession($pedidoActual, $color, $S, $M, $L, $XL, $XXL, $genero);
    }

    header("Location: index.php");
    exit();
}

if (isset($_POST['borrarRenglones'])) {
    unset($_SESSION['CabecerasRenglones']);
    header("Location: index.php");
    exit();
}
