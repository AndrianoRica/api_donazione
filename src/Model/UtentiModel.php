<?php
class UtentiModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserById($id) {
        if ($id === null) {
            $query = "SELECT * FROM utenti";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT * FROM utenti WHERE id = :id";
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
    //CANCELLA
    public function deleteUserById($id) {
        $query = "DELETE FROM utenti WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function getUserByName($name) {
        $query = "SELECT * FROM utenti WHERE nome_completo = :nome_completo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nome_completo", $name);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertUser($data) {
        $query = "INSERT INTO utenti (nome_completo, tipo_sangue) VALUES (:nome_completo, :tipo_sangue)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nome_completo", $data->nome_completo);
        $stmt->bindParam(":tipo_sangue", $data->tipo_sangue);

        return $stmt->execute();
    }
}

?>
