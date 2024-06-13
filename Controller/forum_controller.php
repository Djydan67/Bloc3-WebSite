<?php

/**
 * Forum Controller
 * 
 * This class handles interactions with the forum and theme database tables.
 * 
 * @autor Salar
 */

class Forum_Ctrl extends Ctrl
{
    public function themes()
    {
        include(__DIR__ . "/../Model/forum_model.php");
        $objForumModel = new Forum_model();

        try {
            if (isset($_GET['theme_id'])) {
                $themeId = intval($_GET['theme_id']);
                $arrForums = $objForumModel->getAllForumsByTheme($themeId);
                header('Content-Type: application/json');

                // Checking JSON if is valid
                $jsonData = json_encode($arrForums);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    error_log('JSON encode error: ' . json_last_error_msg());
                    echo json_encode(['error' => 'Failed to encode JSON']);
                    return;
                }
                echo $jsonData;
                return;
            }

            $arrThemes = $objForumModel->getAllThemes();
            $this->_arrData['arrThemes'] = $arrThemes;

            $this->_arrData['strPage'] = "forum";
            $this->_arrData['strTitleH1'] = "Forums";
            $this->_arrData['strFirstP'] = "Page affichant les forums";
            $this->prepare('forum_view');
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public function forums()
    {
        include(__DIR__ . "/../Model/forum_model.php");
        $objForumModel = new Forum_model();

        try {
            if (isset($_GET['forum_id'])) {
                $forumId = intval($_GET['forum_id']);
                $arrForums = $objForumModel->getForumResponses($forumId);
                header('Content-Type: application/json');

                // Checking JSON if is valid
                $jsonData = json_encode($arrForums);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    error_log('JSON encode error: ' . json_last_error_msg());
                    echo json_encode(['error' => 'Failed to encode JSON']);
                    return;
                }

                echo $jsonData;
                return;
                echo $jsonData;
                return;
            }
        } catch (\Throwable $th) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
