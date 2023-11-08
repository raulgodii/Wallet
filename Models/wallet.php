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
                    $register[0]->concept = $concept;
                    $register[0]->date = $date;
                    $register[0]->amount = $amount;
                    break; // Salir del bucle después de editar el elemento
                }
                // Incrementar el contador del índice actual
                $currentIndex++;
            }

            // Guardar los cambios en el archivo XML
            $xml->asXML(self::xmlFilePath);
        }

        public function searchConcept($concept){
            // Cargar el contenido XML en un objeto SimpleXMLElement
            $xml = simplexml_load_file(self::xmlFilePath);

            $result = array();

            // Iterar sobre los elementos del XML
            foreach ($xml->register as $register) {
                if($register[0]->concept == $concept){
                    
                    $registroArray = array(
                        'concept' => (string)$register->concept,
                        'date' => (string)$register->date,
                        'amount' => (string)$register->amount
                    );
                    // Devolver el resultado y salir del bucle
                    $result['register'][] = $registroArray;
                }
            }

            if (empty($result['register'])) {
                $result = array(
                    'register' => array(
                        'concept' => "Concept",
                        'date' => "Not",
                        'amount' => "Found"
                    )
                );
            }
            
            // Devolver el resultado y salir del bucle
            return $result;
        }

                    // Iterar sobre los elementos del XML

        public function orderByConcept(){
            // Cargar el contenido XML en un objeto SimpleXMLElement
            $xml = simplexml_load_file(self::xmlFilePath);

               // Convertir SimpleXMLElement a un array para facilitar la manipulación
                $data = json_decode(json_encode($xml), true);

                // Función de comparación para ordenar por el elemento <concept>
                $compareConcepts = function($a, $b) {
                    return strcmp($a['concept'], $b['concept']);
                };

                // Ordenar el array de registros por el elemento <concept>
                usort($data['register'], $compareConcepts);

                // Crear un nuevo objeto SimpleXMLElement con los registros ordenados
                $sortedXml = new SimpleXMLElement('<wallet></wallet>');
                foreach ($data['register'] as $register) {
                    $node = $sortedXml->addChild('register');
                    $node->addChild('concept', $register['concept']);
                    $node->addChild('date', $register['date']);
                    $node->addChild('amount', $register['amount']);
                }

                // Guardar el XML ordenado en un archivo o hacer lo que desees con él
                $sortedXml->asXML(self::xmlFilePath);
        }

        public function orderByAmount(){
                // Cargar el contenido XML en un objeto SimpleXMLElement
                $xml = simplexml_load_file(self::xmlFilePath);

                // Convertir SimpleXMLElement a un array para facilitar la manipulación
                $data = json_decode(json_encode($xml), true);

                // Función de comparación para ordenar por el elemento <amount>
                $compareAmounts = function($a, $b) {
                    return floatval($a['amount']) - floatval($b['amount']);
                };

                // Ordenar el array de registros por el elemento <amount>
                usort($data['register'], $compareAmounts);

                // Crear un nuevo objeto SimpleXMLElement con los registros ordenados
                $sortedXml = new SimpleXMLElement('<wallet></wallet>');
                foreach ($data['register'] as $register) {
                    $node = $sortedXml->addChild('register');
                    $node->addChild('concept', $register['concept']);
                    $node->addChild('date', $register['date']);
                    $node->addChild('amount', $register['amount']);
                }

                // Guardar el XML ordenado por cantidad en un archivo o hacer lo que desees con él
                $sortedXml->asXML(self::xmlFilePath);
        }

        public function orderByDate(){
            // Cargar el contenido XML en un objeto SimpleXMLElement
            $xml = simplexml_load_file(self::xmlFilePath);
        
            // Convertir SimpleXMLElement a un array para facilitar la manipulación
            $data = json_decode(json_encode($xml), true);
        
            // Función de comparación para ordenar por el elemento <date>
            $compareDates = function($a, $b) {
                $dateA = strtotime(str_replace('/', '-', $a['date']));
                $dateB = strtotime(str_replace('/', '-', $b['date']));
                return $dateA - $dateB;
            };
        
            // Ordenar el array de registros por el elemento <date>
            usort($data['register'], $compareDates);
        
            // Crear un nuevo objeto SimpleXMLElement con los registros ordenados por fecha
            $sortedXml = new SimpleXMLElement('<wallet></wallet>');
            foreach ($data['register'] as $register) {
                $node = $sortedXml->addChild('register');
                $node->addChild('concept', $register['concept']);
                $node->addChild('date', $register['date']);
                $node->addChild('amount', $register['amount']);
            }
        
            // Guardar el XML ordenado por fecha en un archivo o hacer lo que desees con él
            $sortedXml->asXML(self::xmlFilePath);
        }
    }
?>