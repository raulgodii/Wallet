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

        public function addRegister($concept, $date, $amount) {
            // Cargar el archivo XML
            $xml = simplexml_load_file(self::xmlFilePath);
    
            // Crear un nuevo registro
            $register = $xml->addChild('register');
            $register->addChild('concept', $concept);
            $register->addChild('date', $date);
            $register->addChild('amount', $amount);
    
            // Guardar el XML actualizado de vuelta al archivo
            $xml->asXML(self::xmlFilePath);
        }

        public function deleteRegister($index) {
            // Cargar el contenido XML en un objeto SimpleXMLElement
            $xml = simplexml_load_file(self::xmlFilePath);
            // Inicializar un contador para llevar el seguimiento del índice actual
            $currentIndex = 0;

            // Iterar sobre los elementos del XML
            foreach ($xml->register as $register) {
                // Verificar si el índice actual coincide con el índice que deseas eliminar
                if ($currentIndex == $index) {
                    // Utilizar unset() para eliminar el nodo actual del XML
                    unset($register[0]);
                    break; // Salir del bucle después de eliminar el elemento
                }
                
                // Incrementar el contador del índice actual
                $currentIndex++;
            }

            // Guardar los cambios en el archivo XML
            $xml->asXML(self::xmlFilePath);
            
        }

        public function editRegister($index, $concept, $date, $amount) {
            // Cargar el contenido XML en un objeto SimpleXMLElement
            $xml = simplexml_load_file(self::xmlFilePath);
            // Inicializar un contador para llevar el seguimiento del índice actual
            $currentIndex = 0;

            // Iterar sobre los elementos del XML
            foreach ($xml->register as $register) {
                // Verificar si el índice actual coincide con el índice que deseas eliminar
                if ($currentIndex == $index) {
                    // Utilizar unset() para eliminar el nodo actual del XML
                    $register[0]->concept = $concept;
                    $register[0]->date = $date;
                    $register[0]->amount = $amount;
                    break; // Salir del bucle después de eliminar el elemento
                }
                // Incrementar el contador del índice actual
                $currentIndex++;
            }

            // Guardar los cambios en el archivo XML
            $xml->asXML(self::xmlFilePath);
        }
    }
?>