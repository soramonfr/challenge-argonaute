<?php

/**
 * Classe Crew qui correspond à la table crew_members en bdd
 */
class Crew
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database->getDb();
    }

    public function createCrewMember($arrayParameters)
    { 
        try {
            $response = $this->db->prepare("INSERT INTO `crew_member` (`lastname`, `firstname`, `description`, `gender`) VALUES (:lastname, :firstname, :description, :gender)");
            $response->bindValue("lastname", $arrayParameters["lastname"], PDO::PARAM_STR);
            $response->bindValue("firstname", $arrayParameters["firstname"], PDO::PARAM_STR);
            $response->bindValue("description", $arrayParameters["description"], PDO::PARAM_STR);
            $response->bindValue("gender", $arrayParameters["gender"], PDO::PARAM_STR);
            return $response->execute();
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function displayCrewMembers() {
        $response = $this->db->prepare("SELECT * FROM `crew_member`");
        $response->execute();
        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countCrew(){ 
        $response = $this->db->prepare("SELECT COUNT(*) FROM `crew_member`");
        $response->execute();
        return $response->fetch();
    }
}