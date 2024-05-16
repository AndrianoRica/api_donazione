<?php
require('../src/Model/UtentiModel.php');

class UtentiController {
    private $db;
    private $utentiModel;

    public function __construct($db) {
        $this->db = $db;
        $this->utentiModel = new UtentiModel($this->db);
    }

    public function getUser($id) {
        $user = $this->utentiModel->getUserById($id);
        if ($user) {
            http_response_code(200);
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Utente non trovato."));
        }
    }

    //CANCELLA
    public function deleteUser($id) {
        if ($this->utentiModel->deleteUserById($id)) {
            http_response_code(200);
            echo json_encode(array("message" => "Utente eliminato con successo."));
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Utente non trovato."));
        }
    }
    //cra (POST)
    
    
    public function createUser($data) {
        if (!isset($data->nome_completo) || !isset($data->tipo_sangue)) {
            http_response_code(400);
            echo json_encode(array("message" => "Nome completo e tipo di sangue sono campi obbligatori."));
            return;
        }

        // Check if the user already exists by name
        $existingUser = $this->utentiModel->getUserByName($data->nome_completo);
        if ($existingUser) {
            http_response_code(400);
            echo json_encode(array("message" => "Utente già esistente."));
            return;
        }

        $result = $this->utentiModel->insertUser($data);

        if ($result) {
            http_response_code(201);
            echo json_encode(array("message" => "Utente creato con successo."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Impossibile creare l'utente."));
        }
    }
    
    
}
?>
