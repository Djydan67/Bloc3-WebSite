<?php

/**
 * Forum Controller
 * 
 * This class handles interactions with the forum and theme database tables.
 * 
 * @author Salar
 */

class Forum_Ctrl extends Ctrl
{
    public function allForums()
    {
        $this->_arrData['strPage'] = "forum";
        $this->_arrData['strTitleH1'] = "Forums";
        $this->_arrData['strFirstP'] = "";

        try {
            $this->display('forum');
        } catch (Exception $e) {
            error_log('Error displaying all forums: ' . $e->getMessage());
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => 'Failed to display forums']);
        }
    }

    public function Forums()
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
            }
        } catch (\Throwable $th) {
            error_log('Error fetching forum responses: ' . $th->getMessage());
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

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
            $this->display('forum');
        } catch (Exception $e) {
            error_log('Error fetching themes: ' . $e->getMessage());
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function createForum()
    {
        include(__DIR__ . "/../Model/forum_model.php");
        $objForumModel = new Forum_model();

        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['titre'], $data['message'], $data['user_id'], $data['theme_id'])) {

                $titre = $data['titre'];
                $message = $data['message'];
                $userId = intval($data['user_id']);
                $themeId = intval($data['theme_id']);

                $result = $objForumModel->createForum($titre, $message, $userId, $themeId);

                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                return;
            } else {
                throw new Exception('Missing parameters');
            }
        } catch (\Throwable $th) {
            error_log('Error creating forum: ' . $th->getMessage());
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    public function createResponse()
    {
        include(__DIR__ . "/../Model/forum_model.php");
        $objForumModel = new Forum_model();

        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['message'], $data['user_id'], $data['forum_id'])) {
                $message = $data['message'];
                $userId = intval($data['user_id']);
                $forumId = intval($data['forum_id']);

                $result = $objForumModel->createResponse($message, $userId, $forumId);

                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                return;
            } else {
                throw new Exception('Missing parameters');
            }
        } catch (Exception $e) {
            error_log('Error creating response: ' . $e->getMessage());
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
