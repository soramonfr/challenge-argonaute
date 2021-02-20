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

}