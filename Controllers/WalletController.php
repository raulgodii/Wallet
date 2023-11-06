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
            $input1Value = $_POST['input1'];
            $input2Value = $_POST['input2'];
            $input3Value = $_POST['input3'];
            $this->wallet->addRegister($input1Value, $input2Value, $input3Value);
            header("Location: index.php");
        }

        function deleteRegister(){
            $index = $_GET['index'];
            $this->wallet->deleteRegister($index);
            header("Location: index.php");
        }
    }
?>