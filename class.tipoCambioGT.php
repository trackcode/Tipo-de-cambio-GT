<?php

/**
 * Obtención de Tipo de Cambio
 * 
 * Esta aplicación obtiene el tipo de cambio a través de diferentes proveedores.
 * Permite agregar proveedores y obtener el tipo de cambio de manera uniforme.
 * 
 * By:
 * Fernando Leiva
 */

interface TipoCambioProvider {
    public function obtenerTipoCambio();
}

// Banco Industrial - EndPoint público
class BancoIndustrialProvider implements TipoCambioProvider {
    public function obtenerTipoCambio() {
        // Endpoint
        $url = "https://www.corporacionbi.com/gt/bancoindustrial/wp-content/plugins/jevelin_showcase_exchange_rate/service/mod_moneda.php";

        // Construir los datos del cuerpo de la solicitud
        $postData = http_build_query(['action' => 'getMoneda']);

        // Configurar las opciones del contexto de flujo
        $contextOptions = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postData
            ]
        ];

        // Crear el contexto de flujo
        $context = stream_context_create($contextOptions);

        // Obtener los datos JSON
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            throw new Exception('Error al obtener los datos.');
        }

        // Decodificar la respuesta JSON
        $data = json_decode($response, true);

        if ($data === null) {
            throw new Exception('Error al decodificar la respuesta JSON.');
        }

        // Obtener los valores de tipo de cambio
        $tipoCambioOnline = $data['result'][2];
        $tipoCambioAgencia = $data['result'][1];

        return [
            'INDUSTRIAL' => [
                'bi_online' => $tipoCambioOnline,
                'bi_agencia' => $tipoCambioAgencia
            ]
        ];
    }
}

// BanRural - EndPoint público
class BanRuralProvider implements TipoCambioProvider {
    public function obtenerTipoCambio() {
        // Endpoint
        $url = "https://banruralportal05-banruralmsp.cec.ocp.oraclecloud.com/pxysvc/proxy/brobtenerdolarseuros/";

        // Obtener los datos JSON
        $response = file_get_contents($url);

        if ($response === false) {
            throw new Exception('Error al obtener los datos.');
        }

        // Decodificar la respuesta JSON
        $data = json_decode($response, true);

        if ($data === null) {
            throw new Exception('Error al decodificar la respuesta JSON.');
        }

        return [
            'BANRURAL' => [
                'br_online' => $data['venta_dolares_docto_bv'],
                'br_agencia' => $data['venta_dolares_docto']
            ]
        ];
    }
}

class TipoCambioObtainer {
    private $providers;

    public function __construct() {
        $this->providers = [];
    }

    public function agregarProvider(TipoCambioProvider $provider) {
        $this->providers[] = $provider;
    }

    public function obtenerTipoCambio() {
        $tiposCambio = [];

        foreach ($this->providers as $provider) {
            try {
                $result = $provider->obtenerTipoCambio();
                $tiposCambio = array_merge($tiposCambio, $result);
            } catch (Exception $e) {
                // Manejar el error o registrar en un log, según sea necesario
                echo 'Error al obtener el tipo de cambio: ' . $e->getMessage();
            }
        }

        // Convertir el arreglo a formato JSON
        $json = json_encode($tiposCambio);

        // Mostrar el resultado JSON
        echo $json;
    }
}

// Crear una instancia del obtainer
$obtainer = new TipoCambioObtainer();

// Agregar los providers al obtainer
$obtainer->agregarProvider(new BancoIndustrialProvider());
$obtainer->agregarProvider(new BanRuralProvider());

// Obtener el tipo de cambio
$obtainer->obtenerTipoCambio();

?>