<?php
class CreadorStocks
{
    public $stockTotal;

    public $renglonesASumar = array();

    function __construct()
    {
        $this->stockTotal = array();
    }

    ///////////////////////////////////////////////////////////////////////////////////
    public function loadStockSession($conex)
    {
       
        $queryTraerStocks= "SELECT 
                                ((SELECT cantidadPorLote FROM stockmateriales WHERE idArticulos = 1) * (SELECT unidadPorLote FROM articulos  WHERE idArticulos = 1)) totalTela,
                                ((SELECT cantidadPorLote FROM stockmateriales WHERE idArticulos = 2) * (SELECT unidadPorLote FROM articulos  WHERE idArticulos = 2)) totalHilo, 
                                ((SELECT cantidadPorLote FROM stockmateriales WHERE idArticulos = 3) * (SELECT unidadPorLote FROM articulos  WHERE idArticulos = 3)) totalBotones;";
        $resultado = mysqli_query($conex, $queryTraerStocks);
        if (!$resultado) {
            die("Error al obtener datos de la tabla: " . mysqli_error($conex));
        }
        
        while ($filaStock = mysqli_fetch_assoc($resultado)) {
            $cantidadStock = array(
                'metrosTelasStock' =>$filaStock['totalTela'],
                'metrosHiloStock' =>$filaStock['totalHilo'],
                'BotonesStock' =>$filaStock['totalBotones']       
            );
        }
        
        if ( $this->stockTotal == null) {
            $this->stockTotal[] =  $cantidadStock;
        }
       
    }

    ///////////////////////////////////////////////////////////////////////////////////
    public function muestraStock($conex){
        $stockT='';
        $stockH='';
        $stockB='';
       
        foreach ($this->stockTotal as $stockActual) {
            $stockT='<div class="modal-header justify-content-start">
                       <div>
                           <h6 class="modal-title">Cantidad de Tela: ' .round($stockActual['metrosTelasStock']) . '</h6>
                       </div>
                   </div>';     
            
            $stockH='<div class="modal-header justify-content-start">
                       <div>
                           <h6 class="modal-title">Cantidad de Hilo: ' .round($stockActual['metrosHiloStock']) . '</h6>
                       </div>
                   </div>';     
            
            $stockB='<div class="modal-header justify-content-start">
                       <div>
                           <h6 class="modal-title">Cantidad de Botones: ' .round($stockActual['BotonesStock']) . '</h6>
                       </div>
                   </div>';     
        }
        echo $stockT;
        echo $stockH; 
        echo $stockB;  
    }

    ///////////////////////////////////////////////////////////////////////////////////
    public function descuentaStock($conex,$idGenero,$tS,$tM,$tL,$tXL,$tXXL){
        $queryTraerCurva = "SELECT
                                ((SELECT SUM(medidaCintura + medidaCuello + medidaEspalda + medidaHombro + medidaManga + medidaPecho) FROM curva WHERE idTalle = 1 AND idTipoGenero = $idGenero) / 100) totalMetrosS,
                                ((SELECT SUM(medidaCintura + medidaCuello + medidaEspalda + medidaHombro + medidaManga + medidaPecho) FROM curva WHERE idTalle = 2 AND idTipoGenero = $idGenero) / 100) totalMetrosM,
                                ((SELECT SUM(medidaCintura + medidaCuello + medidaEspalda + medidaHombro + medidaManga + medidaPecho) FROM curva WHERE idTalle = 3 AND idTipoGenero = $idGenero) / 100) totalMetrosL,
                                ((SELECT SUM(medidaCintura + medidaCuello + medidaEspalda + medidaHombro + medidaManga + medidaPecho) FROM curva WHERE idTalle = 4 AND idTipoGenero = $idGenero) / 100) totalMetrosXL,
                                ((SELECT SUM(medidaCintura + medidaCuello + medidaEspalda + medidaHombro + medidaManga + medidaPecho) FROM curva WHERE idTalle = 5 AND idTipoGenero = $idGenero) / 100) totalMetrosXXL,
                                (SELECT cantUnitaria FROM curvamaterial WHERE idTipoGenero = $idGenero AND idArticulos = 2) totalMetrosHilo,
                                (SELECT cantUnitaria FROM curvamaterial WHERE idTipoGenero = $idGenero AND idArticulos = 3) totalUnidadBotones;";

        $resultado = mysqli_query($conex, $queryTraerCurva);
        if (!$resultado) {
            die("Error al obtener datos de la tabla: " . mysqli_error($conex));
        }

        $totalPorRenglon = floatval($tS)+floatval($tM)+floatval($tL)+floatval($tXL)+floatval($tXXL);

        while ($filaCurva = mysqli_fetch_assoc($resultado)) {

            $telasMetrosS= floatval($filaCurva['totalMetrosS']) * floatval($tS);
            $telasMetrosM= floatval($filaCurva['totalMetrosM']) * floatval($tM);
            $telasMetrosL= floatval($filaCurva['totalMetrosL']) * floatval($tL);
            $telasMetrosXL= floatval($filaCurva['totalMetrosXL']) * floatval($tXL);
            $telasMetrosXXL= floatval($filaCurva['totalMetrosXXL']) * floatval($tXXL);
            $hiloMetros =  floatval($filaCurva['totalMetrosHilo']) * floatval($totalPorRenglon);
            $botonesCant =  floatval($filaCurva['totalUnidadBotones']) * floatval($totalPorRenglon);
        }

        $totalTelaRenglon = round($telasMetrosS,2) + round($telasMetrosM,5) + round($telasMetrosL,5) + round($telasMetrosXL,5) + round($telasMetrosXXL,5);

        foreach ($this->stockTotal as $val) {
        
            if ($val['metrosTelasStock'] > $totalTelaRenglon 
                && $val['metrosHiloStock'] > $hiloMetros 
                && $val['BotonesStock'] > $botonesCant) {

                $reorganizado = array();
            
                foreach ($this->stockTotal as $filaStock) {
                    $tela=$filaStock['metrosTelasStock'];
                    $filaStock['metrosTelasStock'] = floatval($tela) - floatval($totalTelaRenglon);

                    $hilo=$filaStock['metrosHiloStock'];
                    $filaStock['metrosHiloStock'] = floatval($hilo) - floatval($hiloMetros);

                    $botones=$filaStock['BotonesStock'];
                    $filaStock['BotonesStock'] = floatval($botones) - floatval($botonesCant);

                    $reorganizado[] = $filaStock;
                }
                $this->stockTotal = $reorganizado;
                return true;
            }else{
                return false;
            }  
        }   
    }
    ///////////////////////////////////////////////////////////////////////////////////

    public function DB_DescontarStockMateriales($conex){

        $queryTraerStocks= "SELECT 
                                (SELECT unidadPorLote FROM articulos  WHERE idArticulos = 1) totalTela,
                                (SELECT unidadPorLote FROM articulos  WHERE idArticulos = 2) totalHilo, 
                                (SELECT unidadPorLote FROM articulos  WHERE idArticulos = 3) totalBotones;";
        $resultado = mysqli_query($conex, $queryTraerStocks);
        if (!$resultado) {
            die("Error al obtener datos de la tabla: " . mysqli_error($conex));
        }
        
        while ($filaArticulo = mysqli_fetch_assoc($resultado)) {

            foreach ($this->stockTotal as $stockActual) {

                $telasMetros= floatval($stockActual['metrosTelasStock']) / floatval($filaArticulo['totalTela']);
                $hiloMetros= floatval($stockActual['metrosHiloStock']) / floatval($filaArticulo['totalHilo']);
                $canBoton= floatval($stockActual['BotonesStock']) / floatval($filaArticulo['totalBotones']);
            }
        }

        $stockActualizado = [0,floatval($telasMetros),floatval($hiloMetros),floatval($canBoton)];
        for ($i = 1; $i <= 3; $i++) {
            $query = "UPDATE stockmateriales
                      SET cantidadPorLote = ".round(floatval($stockActualizado[$i]),5)."
                      WHERE idArticulos = ".$i;
            $resultado1 = mysqli_query($conex, $query);
            if (!$resultado1) {
                die("Error al insertar valores: " . mysqli_error($conex));
            }
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////
    public function cargarArrayRenglonStock($idRenglon,$idGenero,$tS,$tM,$tL,$tXL,$tXXL){
        
        $RenglonTMP = array( 
                array(
                'idGenero' => $idGenero,
                'S' => $tS,
                'M' => $tM,
                'L' => $tL,
                'XL' => $tXL,
                'XXL' => $tXXL
            )
        );

        $this->renglonesASumar[] = $RenglonTMP;

    }
    ///////////////////////////////////////////////////////////////////////////////////
    public function sumarRenglonBorrado($conex,$idReng){
        foreach($this->renglonesASumar as $key => $array)
        {
            if ($key==($idReng - 1)) {
                foreach($array as $renglon => $valor)
                {
                    $idGenero = $valor['idGenero'];
                    $tS = $valor['S'];
                    $tM = $valor['M'];
                    $tL = $valor['L'];
                    $tXL = $valor['XL'];
                    $tXXL = $valor['XXL'];  
                }  
            }
        }
      
        $queryTraerCurva = "SELECT
                                ((SELECT SUM(medidaCintura + medidaCuello + medidaEspalda + medidaHombro + medidaManga + medidaPecho) FROM curva WHERE idTalle = 1 AND idTipoGenero = $idGenero) / 100) totalMetrosS,
                                ((SELECT SUM(medidaCintura + medidaCuello + medidaEspalda + medidaHombro + medidaManga + medidaPecho) FROM curva WHERE idTalle = 2 AND idTipoGenero = $idGenero) / 100) totalMetrosM,
                                ((SELECT SUM(medidaCintura + medidaCuello + medidaEspalda + medidaHombro + medidaManga + medidaPecho) FROM curva WHERE idTalle = 3 AND idTipoGenero = $idGenero) / 100) totalMetrosL,
                                ((SELECT SUM(medidaCintura + medidaCuello + medidaEspalda + medidaHombro + medidaManga + medidaPecho) FROM curva WHERE idTalle = 4 AND idTipoGenero = $idGenero) / 100) totalMetrosXL,
                                ((SELECT SUM(medidaCintura + medidaCuello + medidaEspalda + medidaHombro + medidaManga + medidaPecho) FROM curva WHERE idTalle = 5 AND idTipoGenero = $idGenero) / 100) totalMetrosXXL,
                                (SELECT cantUnitaria FROM curvamaterial WHERE idTipoGenero = $idGenero AND idArticulos = 2) totalMetrosHilo,
                                (SELECT cantUnitaria FROM curvamaterial WHERE idTipoGenero = $idGenero AND idArticulos = 3) totalUnidadBotones;";

        $resultado = mysqli_query($conex, $queryTraerCurva);
        if (!$resultado) {
            die("Error al obtener datos de la tabla: " . mysqli_error($conex));
        }

        $totalPorRenglon = floatval($tS)+floatval($tM)+floatval($tL)+floatval($tXL)+floatval($tXXL);

        while ($filaCurva = mysqli_fetch_assoc($resultado)) {

            $telasMetrosS= floatval($filaCurva['totalMetrosS']) * floatval($tS);
            $telasMetrosM= floatval($filaCurva['totalMetrosM']) * floatval($tM);
            $telasMetrosL= floatval($filaCurva['totalMetrosL']) * floatval($tL);
            $telasMetrosXL= floatval($filaCurva['totalMetrosXL']) * floatval($tXL);
            $telasMetrosXXL= floatval($filaCurva['totalMetrosXXL']) * floatval($tXXL);
            $hiloMetros =  floatval($filaCurva['totalMetrosHilo']) * floatval($totalPorRenglon);
            $botonesCant =  floatval($filaCurva['totalUnidadBotones']) * floatval($totalPorRenglon);
        }

        $totalTelaRenglon = round($telasMetrosS,2) + round($telasMetrosM,5) + round($telasMetrosL,5) + round($telasMetrosXL,5) + round($telasMetrosXXL,5);

        
        $reorganizado = array();
        foreach ($this->stockTotal as $filaStock) {
            $tela=$filaStock['metrosTelasStock'];
            $filaStock['metrosTelasStock'] = floatval($tela) +  $totalTelaRenglon;
            $hilo=$filaStock['metrosHiloStock'];
            $filaStock['metrosHiloStock'] = floatval($hilo) + $hiloMetros;
            $botones=$filaStock['BotonesStock'];
            $filaStock['BotonesStock'] = floatval($botones) + $botonesCant;
            $reorganizado[] = $filaStock;
        }
        $this->stockTotal = $reorganizado;
            
    }

    ////////////////////////////////1000.00000//////////////////////////////////////////////
    public function borrarRenglonStock($conex,$idRenglon)
    {
        unset($this->renglonesASumar[$idRenglon - 1]);
        $this->renglonesASumar = array_values($this->renglonesASumar);

    }
    

}