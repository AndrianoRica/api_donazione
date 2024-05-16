<?php
require('../src/Model/DonazioneModel.php');

class DonazioneController {
    private $db;
    private $donazioneModel;

    public function __construct($db) {
        $this->db = $db;
        $this->donazioneModel = new DonazioneModel($this->db);
    }

    public function getDonation($id) {
        $donation = $this->donazioneModel->getDonationById($id);
        if ($donation) {
            http_response_code(200);
            echo json_encode($donation);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Donazione non trovata."));
        }
    }
    public function deleteDonation($id) {
        if ($this->donazioneModel->deleteDonationById($id)) {
            http_response_code(200);
            echo json_encode(array("message" => "Donazione eliminata con successo."));
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Donazione non trovata."));
        }
    }

    public function createDonation($data) {
        if (!isset($data->utente)) {
            http_response_code(400);
            echo json_encode(array("message" => "Utente manca"));
            return;
        }

        // Crea la donazione
        $result = $this->donazioneModel->insertDonation($data);

        if ($result) {
            http_response_code(201);
            echo json_encode(array("message" => "Donazione creata con successo."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Impossibile creare la donazione."));
        }
    }
}
?>
