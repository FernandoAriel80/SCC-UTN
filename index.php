<?php

include 'FormControllers.php';
require_once 'class/claseCRUDPedido.php';
require_once 'class/claseCRUDRenglonesPedido.php';
require_once 'class/claseCRUDStock.php';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/977a02dee3.js" crossorigin="anonymous"></script>
    <title>Sistema de Control de Camisas</title>
    <style>
        /* Barra Lateral */
        *::-webkit-scrollbar {
            width: 4px;
            /* width of the entire scrollbar */
        }

        *::-webkit-scrollbar-track {
            background: #212529;
            background-repeat: no-repeat;
            /* color of the tracking area */
        }

        *::-webkit-scrollbar-thumb {
            background-color: grey;
            /* color of the scroll thumb */
            border-radius: 50px;
            /* roundness of the scroll thumb */
            /* border: .5px solid var(--colorBlanco) */
            ;
            /* creates padding around scroll thumb */
        }

        *::-webkit-scrollbar-thumb:hover {
            background-color: grey;
            /* color of the scroll thumb */
        }

        #tlb {
            position: relative;
        }

        #tlb thead {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        #tlb thead th {
            border-bottom: none;
        }

        #tlb thead::after {
            content: '';
            position: absolute;
            bottom: 0;
            /* Altura del borde inferior */
            left: 0;
            width: 100%;
            border-bottom: solid 1px;
            border-bottom-color: white;
        }

        @media only screen and (max-width: 600px) {
            
        }

        .accordion-button:focus {
            box-shadow: none;
        }

        .accordion-button:not(.collapsed) {
            color: var(--bs-accordion-active-color);
            background-color: transparent;
            box-shadow: inset 0 calc(-1 * var(--bs-accordion-border-width)) 0 var(--bs-accordion-border-color);
        }
    </style>
</head>

<body data-bs-theme="dark" class="container">

    <!-- ********** MENU ********** -->

    <!--//////////  Esta parte solo es stock ////////////////////////// -->
    <div class="d-flex flex-column align-items-center">
        <div class="m-3 p-3 rounded border border-white">
            <div class="container mt-2 text-center  ">
                <h4>Stock de Materiales</h4>
                    <?php
                       $ObjetoStocks->loadStockSession($conex);
                       $ObjetoStocks->muestraStock($conex);
                    ?>
            </div>
        </div>
          
            
    </div>


    <div class="d-flex flex-column align-items-center">

        <!--//////////  Esta parte solo es para realizar pedidos ////////////////////////// -->
        <div class="m-3 p-3 rounded border border-white">

            <div class="">
                <div class="col">
                    <label for="staticEmail" class="">Fecha del pedido:</label>
                    <?php
                    $ObjetoPedidos->fechaActualPedido();
                    ?>
                </div>
                <div class="col-12">
                    <label for="staticEmail" class="col">Pedido N°:
                        <?php echo $ObjetoPedidos->traeIdPedido($conex); ?>
                    </label>

                </div>
            </div>

            <div class="container mt-2 text-center  ">
                <h4>Elija cantidad</h4>
                <hr class="mb-0">
                <form class="d-flex align-items-center justify-content-center" method="post">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col">S</th>
                                <th scope="col">M</th>
                                <th scope="col">L</th>
                                <th scope="col">XL</th>
                                <th scope="col">XXL</th>
                                <th scope="col">COL</th>
                                <th scope="col">GEN</th>
                                <th scope="col">ENVIAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width:70px;"><input type="text" class="form-control form-control-sm" name="S">
                                </td>
                                <td style="width:70px;"><input type="text" class="form-control form-control-sm" name="M">
                                </td>
                                <td style="width:70px;"><input type="text" class="form-control form-control-sm" name="L">
                                </td>
                                <td style="width:70px;"><input type="text" class="form-control form-control-sm" name="XL">
                                </td>
                                <td style="width:70px;"><input type="text" class="form-control form-control-sm" name="XXL">
                                </td>
                                <td style="width:120px;">
                                    <select class="form-select form-select-sm" aria-label="Default select example" name="miSelectorColor">
                                        <?php
                                        $ObjetoRenglones->imprimircolor($conex);
                                        ?>
                                    </select>
                                </td>
                                <td style="width:160px;">
                                    <select class="form-select form-select-sm" name="miSelectorGenero">
                                        <?php
                                        $ObjetoRenglones->imprimirGenero($conex);
                                        ?>
                                    </select>
                                </td>
                                <td style="width:50px;cursor: pointer;">
                                    <input type="hidden" name="cargarRenglon" value="true">
                                    <button type="submit" style="border: none; background: none;">
                                        <i style="font-size:2rem;" class="fa-solid fa-circle-check"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="container mt-2">
                <div>
                    <div class="container text-center d-flex flex-column">
                        <h5>Curva de Pedido</h5>
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <table class="table ">
                                <thead>
                                    <tr>
                                         <!--<th scope="col" class="col-lg-1">idRenglon</th> -->
                                        <th scope="col" class="col-lg-1">S</th>
                                        <th scope="col" class="col-lg-1">M</th>
                                        <th scope="col" class="col-lg-1">L</th>
                                        <th scope="col" class="col-lg-1">XL</th>
                                        <th scope="col" class="col-lg-1">XXL</th>
                                        <th scope="col" class="col-lg-1">COL</th>
                                        <th scope="col" class="col-lg-1">GEN</th>
                                        <!-- <th scope="col" class="col-lg-1">precio</th> -->
                                        <th scope="col" class="col-lg-1"></th>
                                        <!-- <th scope="col">CANTIDAD TELA</th>
                                        <th scope="col">AVIOS</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ObjetoRenglones->printRenglonesSession();
                                    $ObjetoRenglones->imprimirTotalRenglones();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class='d-flex justify-content-between'>
                        <form class="" method="post">
                            <input type="hidden" name="cargarPedido" value="true">
                            <button type="submit" class="btn btn-secondary">Guardar pedido</button>
                        </form>
                        <form class="" method="post">
                            <input type="hidden" name="borrarRenglones" value="true">
                            <button type="submit" class="btn btn-secondary">Borrar pedido</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!--//////////  Esta parte imprime los pedidos ////////////////////////// -->
        <div>
            <div class="container text-center">
                <h4>PEDIDOS</h4>
                <div class="row justify-content-sm-center">
                    <?php
                    $ObjetoPedidos->imprimirPedidos($conex);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>

</html>