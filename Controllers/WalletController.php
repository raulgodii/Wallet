<?php
    namespace Controllers;

    use Lib\Pages;
    use Models\Wallet;

    class WalletController{
        private Pages $pages;
        private Wallet $wallet;

        public function __construct(){
            $this->pages = new Pages();
            $this->wallet = new Wallet();
        }

        function showRegisters(){
            $this->pages->render("main/main", ['registers' => $this->wallet->getRegisters()]);
        }

        function addRegister(){
            $input1Value = $_GET['input1'];
            $input2Value = $_GET['input2'];
            $input3Value = $_GET['input3'];
            $this->wallet->addRegister($input1Value, $input2Value, $input3Value);  
            header("Location:index.php");
        }

        function deleteRegister(){
            $index = $_GET['index'];
            if($index == 'concept') $index = 0;
            $this->wallet->deleteRegister($index);
            header("Location:index.php");
        }

        function editRegister(){
            $index = $_GET['index'];
            $this->pages->render("main/main", ['registers' => $this->wallet->getRegisters(), 'indexInput' => [$index]]);
        }

        function editNewRegister(){
            $input1Value = $_POST['input1'];
            $input2Value = $_POST['input2'];
            $input3Value = $_POST['input3'];
            $index = $_GET['index'];
            if($index == 'concept') $index = 0;
            $this->wallet->editRegister($index, $input1Value, $input2Value, $input3Value);
            header("Location:index.php");
        }

        function searchConcept(){
            $concept = $_POST["search"];
            $this->wallet->searchConcept($concept);
            $this->pages->render("main/main", ['registers' => $this->wallet->searchConcept($concept)]);
        }

        function orderByConcept(){
            $this->wallet->orderByConcept();
            header("Location:index.php");
        }

        function orderByAmount(){
            $this->wallet->orderByAmount();
            header("Location:index.php");
        }

        function orderByDate(){
            $this->wallet->orderByDate();
            header("Location:index.php");
        }
    }
?>