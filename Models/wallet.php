<?php
    namespace Models;

    use SimpleXMLElement;
    use DOMDocument;

    class Wallet{
        private array $register;
        
        // Ruta del archivo XML
        const xmlFilePath = './Files/wallet.xml';

        public function __construct(){
            // Verificar si el archivo XML existe
            if (file_exists(self::xmlFilePath)) {
                // Cargar el archivo XML existente
                $xml = simplexml_load_file(self::xmlFilePath);
                // Convertir el objeto SimpleXMLElement a array
                $this->register = $this->xmlToArray($xml);
            } else {
                // Si el archivo no existe, crear un nuevo archivo XML
                $xml = new SimpleXMLElement('<wallet></wallet>');
                // Convertir el objeto SimpleXMLElement a array
                $this->register = $this->xmlToArray($xml);
            }

            // Guardar el XML formateado con sangrías
            $dom = new DOMDocument("1.0");
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            $dom->save(self::xmlFilePath);
        }

        // Función para convertir SimpleXMLElement a array recursivamente
        private function xmlToArray($xml) {
            $json = json_encode($xml);
            return json_decode($json, true);
        }
        

        // Obtener el registro como un array
        public function getRegisters(): array {
            return $this->register;
        }
    }
?>