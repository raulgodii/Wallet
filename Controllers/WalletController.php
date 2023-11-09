<?php
    namespace Controllers;

    use Lib\Pages;
    use Models\Wallet;

    class WalletController{
        private Pages $pages;
        private Wallet $wallet;

        /**
         * Constructor de la clase WalletController.
         * Crea instancias de Pages y Wallet.
         */
        public function __construct(){
            $this->pages = new Pages();
            $this->wallet = new Wallet();
        }

        /**
         * Muestra los registros de la billetera en la página principal.
         */
        function showRegisters(){
            $this->pages->render("main/main", ['registers' => $this->wallet->getRegisters()]);
        }

        /**
         * Agrega un nuevo registro a la billetera.
         * Recupera los valores de los parámetros GET y los pasa al método addRegister de Wallet.
         * Redirige a la página index.php después de agregar el registro.
         */
        function addRegister(){
            $input1Value = $_GET['input1'];
            $input2Value = $_GET['input2'];
            $input3Value = $_GET['input3'];
            $this->wallet->addRegister($input1Value, $input2Value, $input3Value);  
            header("Location:index.php");
        }

        /**
         * Elimina un registro de la billetera.
         * Recupera el índice del registro de los parámetros GET y lo pasa al método deleteRegister de Wallet.
         * Redirige a la página index.php después de eliminar el registro.
         */
        function deleteRegister(){
            $index = $_GET['index'];
            if($index == 'concept') $index = 0;
            $this->wallet->deleteRegister($index);
            header("Location:index.php");
        }

        /**
         * Permite editar un registro existente.
         * Recupera el índice del registro de los parámetros GET y lo pasa a la página principal para llenar el formulario de edición.
         */
        function editRegister(){
            $index = $_GET['index'];
            $this->pages->render("main/main", ['registers' => $this->wallet->getRegisters(), 'indexInput' => [$index]]);
        }

        /**
         * Guarda los cambios realizados en un registro existente.
         * Recupera los valores de los parámetros GET y el índice del registro, y los pasa al método editRegister de Wallet.
         * Redirige a la página index.php después de guardar los cambios.
         */
        function editNewRegister(){
            $input1Value = $_GET['input1'];
            $input2Value = $_GET['input2'];
            $input3Value = $_GET['input3'];
            $index = $_GET['index'];
            if($index == 'concept') $index = 0;
            $this->wallet->editRegister($index, $input1Value, $input2Value, $input3Value);
            header("Location:index.php");
        }

        /**
         * Realiza una búsqueda de registros por concepto.
         * Recupera el concepto de búsqueda por POST y lo pasa al método searchConcept de Wallet.
         * Renderiza la página principal con los resultados de la búsqueda.
         */
        function searchConcept(){
            $concept = $_POST["search"];
            $results = $this->wallet->searchConcept($concept);
            $this->pages->render("main/main", ['registers' => $results]);
        }

        /**
         * Ordena los registros por concepto.
         * Utiliza el método orderByConcept de la clase Wallet para realizar el ordenamiento.
         * Redirige a la página index.php después de ordenar los registros.
         */
        function orderByConcept(){
            $this->wallet->orderByConcept();
            header("Location:index.php");
        }

        /**
         * Ordena los registros por cantidad.
         * Utiliza el método orderByAmount de la clase Wallet para realizar el ordenamiento.
         * Redirige a la página index.php después de ordenar los registros.
         */
        function orderByAmount(){
            $this->wallet->orderByAmount();
            header("Location:index.php");
        }

        /**
         * Ordena los registros por fecha.
         * Utiliza el método orderByDate de la clase Wallet para realizar el ordenamiento.
         * Redirige a la página index.php después de ordenar los registros.
         */
        function orderByDate(){
            $this->wallet->orderByDate();
            header("Location:index.php");
        }
    }
?>