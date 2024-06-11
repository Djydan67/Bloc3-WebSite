<?php 
    /**
     * Forum Controller
     * @author Salar
     */

    class Forum_Ctrl extends Ctrl{
        public function forum(){
            include("Model/forum_model.php");

            $objForumModel      = new Forum_model();
            $arrForums          = $objForumModel->getAllByTheme("1");
            $this->_arrData['arrForums']    = $arrForums;

            $this->_arrData['strPage']	    = "forum";
            $this->_arrData['strTitleH1']	= "Forums";
            $this->_arrData['strFirstP']	= "Page affichant les forums";
            $this->prepare('forum_view');
            
        }
    }
