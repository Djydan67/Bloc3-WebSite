<?php

/**
 * Forum Controller
 * 
 * This class handles interactions with the forum and theme database tables.
 * 
 * @author Salar
 */

function checkPermission($requiredRole)
{
    if (!isset($_SESSION['user']['droit_id'])) {
        throw new Exception('User is not authenticated');
    }

    $userRole = $_SESSION['user']['droit_id'];
    if ($userRole < $requiredRole) {
        throw new Exception('User does not have permission for this action');
    }
}
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
    public function getForumsByTheme()
    {
        include(__DIR__ . "/../Model/forum_model.php");
        $objForumModel = new Forum_model();

        try {
            if (isset($_GET['theme_id'])) {
                // Ensure the theme ID is properly validated and forums are fetched
                $themeId = intval($_GET['theme_id']);
                $arrForums = $objForumModel->getAllForumsByTheme($themeId);

                header('Content-Type: application/json');
                echo json_encode($arrForums);
                return;
            } else {
                throw new Exception('Theme ID is required');
            }
        } catch (Exception $e) {
            error_log('Error fetching forums by theme: ' . $e->getMessage());
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function getForum()
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
                $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

                $arrForums = $objForumModel->getAllForumsByTheme($themeId, $limit,);
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

    public function deleteForum()
    {
        include(__DIR__ . "/../Model/forum_model.php");
        $objForumModel = new Forum_model();

        try {
            // Check if user has moderator or admin rights
            checkPermission(2);

            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['forum_id'])) {
                $forumId = intval($data['forum_id']);
                $result = $objForumModel->deleteForum($forumId);

                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                return;
            } else {
                throw new Exception('Missing parameters');
            }
        } catch (Exception $e) {
            error_log('Error deleting forum: ' . $e->getMessage());
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => $e->getMessage()]);
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
    public function deleteResponse()
    {
        include(__DIR__ . "/../Model/forum_model.php");
        $objForumModel = new Forum_model();

        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['response_id'])) {
                $responseId = intval($data['response_id']);
                $result = $objForumModel->deleteResponse($responseId);

                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                return;
            } else {
                throw new Exception('Missing parameters');
            }
        } catch (Exception $e) {
            error_log('Error deleting response: ' . $e->getMessage());
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function closeForum()
    {
        include(__DIR__ . "/../Model/forum_model.php");
        $objForumModel = new Forum_model();

        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['forum_id'])) {
                $forumId = intval($data['forum_id']);
                $result = $objForumModel->closeForum($forumId);

                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                return;
            } else {
                throw new Exception('Missing parameters');
            }
        } catch (Exception $e) {
            error_log('Error closing forum: ' . $e->getMessage());
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function openForum()
    {
        include(__DIR__ . "/../Model/forum_model.php");
        $objForumModel = new Forum_model();

        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['forum_id'])) {
                $forumId = intval($data['forum_id']);
                $result = $objForumModel->openForum($forumId);

                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                return;
            } else {
                throw new Exception('Missing parameters');
            }
        } catch (Exception $e) {
            error_log('Error opening forum: ' . $e->getMessage());
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function createTheme()
    {
        include(__DIR__ . "/../Model/forum_model.php");
        $objForumModel = new Forum_model();

        try {
            // Check if user has admin rights
            checkPermission(3);

            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['theme_name'], $data['color'], $data['description'])) {
                $themeName = $data['theme_name'];
                $description = $data['description'];
                $color = $data['color'];
                $result = $objForumModel->createTheme($themeName, $description, $color);

                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                return;
            } else {
                throw new Exception('Missing parameters');
            }
        } catch (Exception $e) {
            error_log('Error creating theme: ' . $e->getMessage());
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function deleteTheme()
    {
        include(__DIR__ . "/../Model/forum_model.php");
        $objForumModel = new Forum_model();

        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['theme_id'])) {
                $themeId = intval($data['theme_id']);
                $result = $objForumModel->deleteTheme($themeId);

                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                return;
            } else {
                throw new Exception('Missing parameters');
            }
        } catch (Exception $e) {
            error_log('Error deleting theme: ' . $e->getMessage());
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
