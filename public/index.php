<?php
require_once('../src/System/DatabaseConnector.php');
require_once('../src/Controller/UtentiController.php');
require_once('../src/Controller/DonazioneController.php');

$dbConnection = (new DatabaseConnector())->getConnection();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($uri[2] == 'utenti') {
            $id = isset($uri[3]) ? (int) $uri[3] : null;
            $controller = new UtentiController($dbConnection);
            $controller->getUser($id);
        } else if ($uri[2] == 'donazione') {
            $id = isset($uri[3]) ? (int) $uri[3] : null;
            $controller = new DonazioneController($dbConnection);
            $controller->getDonation($id);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Endpoint non valido."));
        }
        break;
    case 'POST':
        if ($uri[2] == 'utenti') {
            $data = json_decode(file_get_contents("php://input"));
            $controller = new UtentiController($dbConnection);
            $controller->createUser($data);
        } else if ($uri[2] == 'donazione') {
            $data = json_decode(file_get_contents("php://input"));
            $controller = new DonazioneController($dbConnection);
            $controller->createDonation($data);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Endpoint non valido."));
        }
        break;
    case 'DELETE':
        if ($uri[2] == 'utenti') {
            $id = isset($uri[3]) ? (int) $uri[3] : null;
            $controller = new UtentiController($dbConnection);
            $controller->deleteUser($id);
        } else if ($uri[2] == 'donazione') {
            $id = isset($uri[3]) ? (int) $uri[3] : null;
            $controller = new DonazioneController($dbConnection);
            $controller->deleteDonation($id);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Endpoint non valido."));
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method Not Allowed"));
        break;
}
?>
