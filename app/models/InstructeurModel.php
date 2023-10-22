<?php

class InstructeurModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getInstructeurs()
    {
        $sql = "SELECT Id
                      ,Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,Mobiel
                      ,DatumInDienst
                      ,AantalSterren
                FROM  Instructeur
                ORDER BY AantalSterren DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getToegewezenVoertuigen($Id)
    {
        $sql = "SELECT       VOER.Type
                            ,VOER.Kenteken
                            ,VOER.Bouwjaar
                            ,VOER.Brandstof
                            ,TYVO.TypeVoertuig
                            ,TYVO.RijbewijsCategorie

                FROM        Voertuig    AS  VOER
                
                INNER JOIN  TypeVoertuig AS TYVO

                ON          TYVO.Id = VOER.TypeVoertuigId
                
                INNER JOIN  VoertuigInstructeur AS VOIN
                
                ON          VOIN.VoertuigId = VOER.Id
                
                WHERE       VOIN.InstructeurId = $Id
                
                ORDER BY    TYVO.RijbewijsCategorie DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }



    public function getInstructeurById($Id)
    {
        $sql = "SELECT Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,DatumInDienst
                      ,AantalSterren
                FROM  Instructeur
                WHERE Id = $Id";

        $this->db->query($sql);

        return $this->db->single();
    }


    public function updateToegewezenVoertuigen($voertuigId, $nieuweGegevens)
    {
        // $voertuigId is het ID van het voertuig dat je wilt bijwerken
        // $nieuweGegevens is een associatieve array met de nieuwe gegevens voor het voertuig
    
        // Bouw de UPDATE-query op basis van de meegegeven gegevens
        $sql = "UPDATE Voertuig SET ";
        foreach ($nieuweGegevens as $kolom => $waarde) {
            $sql .= "$kolom = :$kolom, ";
        }
        $sql = rtrim($sql, ', '); // Verwijder de laatste komma en spatie
        $sql .= " WHERE Id = :voertuigId";
    
        // Voer de query uit met behulp van prepared statements
        $this->db->query($sql);
    
        // Voeg de voertuigId toe aan de parameters voor de prepared statement
        $nieuweGegevens['voertuigId'] = $voertuigId;
    
        // Bind de waarden aan de parameters
        foreach ($nieuweGegevens as $kolom => $waarde) {
            // De bind-methode verwacht drie argumenten: de parameter, de waarde en het datatype
            $this->db->bind(":$kolom", $waarde, PDO::PARAM_STR);
        }
    
        // Voer de query uit
        return $this->db->execute();
    }

    public function deletevoertuig($voertuigId)
    {
        // $voertuigId is het ID van het voertuig dat je wilt verwijderen
    
        // Bouw de DELETE-query
        $sql = "DELETE FROM Voertuig WHERE Id = :voertuigId";
    
        // Voer de query uit met behulp van prepared statements
        $this->db->query($sql);
    
        // Roep de bind-methode op met drie argumenten: parameter, waarde en datatype
        $this->db->bind(':voertuigId', $voertuigId, PDO::PARAM_INT); // Hier gebruiken we PDO::PARAM_INT voor een integer waarde, pas aan als dat niet het geval is
    
        // Voer de query uit
        return $this->db->execute();
    }
    
}