<?php
class DonazioneModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDonationById($id) {
        if ($id === null) {//se è null ritornera tutti quello che ce nella tabella
            $query = "SELECT * FROM donazione";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {//ritorna se ha ricevuto un id ovvero un numero
            $query = "SELECT * FROM donazione WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        }
    }
    public function deleteDonationById($id) {
        $query = "DELETE FROM donazione WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    // crea (post)
    public function insertDonation($data) {
        $query = "INSERT INTO donazione (utente) SELECT utenti.id FROM utenti WHERE utenti.nome_completo = (:utente);";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":utente", $data->utente);

        return $stmt->execute();
    }
}

?>
