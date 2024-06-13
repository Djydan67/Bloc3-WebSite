<?php
    // Salar
    // Controller parent
    
    class Ctrl{
        // array for user's data
        protected array $_arrData = array();

        protected function prepare(string $strArgument){
            // Converting the array of the client's data to Key/Value
            foreach ($this->_arrData as $key=>$value){
                $$key = $value;
            }

            include("View/_partial/header.php");
            include("View/" . $strArgument . ".php");
            include("View/_partial/footer.php");

            // $viewPath = __DIR__ . "/../View/" . $strArgument . ".php";

            // if (file_exists($viewPath)) {
            //     include($viewPath);
            // } else {
            //     echo "Le fichier de vue " . $strArgument . " est introuvable.";
            // }
        }
    }