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
    }
?>