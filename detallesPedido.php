<?php
require_once 'class/claseCRUDPedido.php';
require_once 'class/claseCRUDRenglonesPedido.php';
include 'FormControllers.php';

if (isset($_GET['idPedido'])) {

  $idPedido = $_GET['idPedido'];

  $claseRenglon = new CabecerasRenglones;

  $queryTraerDatos = "SELECT * FROM pedidos AS P 
        JOIN pedidosdetalles PD ON P.idPedido = Pd.idPedido
        JOIN tipoestados TE ON Pd.idEstado = TE.idEstado WHERE PD.Habilitado = 1 AND P.idPedido =  $idPedido ORDER BY PD.idEstado, P.fechaPedido DESC LIMIT 10";
  $resultado = mysqli_query($conex, $queryTraerDatos);

  if (!$resultado) {
    die("Error al obtener datos de la tabla: " . mysqli_error($conex));
  }

  $filaPedido = mysqli_fetch_assoc($resultado);

}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
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

    /* @media (min-width: 768px) {
            #tableColor{
            height: 50px;
            }
        } */

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



  <div class="d-flex flex-column align-items-center">
    <!--//////////  Esta parte imprime los pedidos ////////////////////////// -->
    <div>
      <div class="container text-center">
        <div class="d-flex mt-5 align-items-center">
          <strong style="font-size:5rem;">Loading...</strong>
          <div class="spinner-border ms-auto"  style="font-size:100px;" role="status" aria-hidden="true"></div>
        </div>

        <div class="d-flex align-items-center justify-content-center">
          <div class="row g-2 justify-content-center">
            <?php
            $ObjetoPedidos->imprimirDetallePedido($conex, $idPedido);
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
  <script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
  </script>
  <script>
    // Mostrar el modal al cargar la página
    document.addEventListener("DOMContentLoaded", function () {
      var modal = new bootstrap.Modal(document.getElementById("<?php echo $idPedido; ?>"));
      modal.show();
    });
  </script>
</body>

</html>