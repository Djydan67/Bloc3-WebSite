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

            // include("views/_partial/header.php");
            include("View/".$strArgument.".php");
            // include("views/_partial/footer.php");
        }
    }