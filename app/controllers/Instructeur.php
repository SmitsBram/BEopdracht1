<?php

class Instructeur extends BaseController
{
    private $instructeurModel;

    public function __construct()
    {
        $this->instructeurModel = $this->model('InstructeurModel');
    }

    public function overzichtInstructeur()
    {
        $result = $this->instructeurModel->getInstructeurs();

        //  var_dump($result);
        $rows = "";
        foreach ($result as $instructeur) {
            /**
             * Datum in het juiste formaat gezet
             */
            $date = date_create($instructeur->DatumInDienst);
            $formatted_date = date_format($date, 'd-m-Y');

            $rows .= "<tr>
                        <td>$instructeur->Voornaam</td>
                        <td>$instructeur->Tussenvoegsel</td>
                        <td>$instructeur->Achternaam</td>
                        <td>$instructeur->Mobiel</td>
                        <td>$formatted_date</td>            
                        <td>$instructeur->AantalSterren</td>            
                        <td>
                            <a href='" . URLROOT . "/instructeur/overzichtvoertuigen/$instructeur->Id'>
                                <i class='bi bi-car-front'></i>
                            </a>
                        </td>            
                      </tr>";
        }
        
        $data = [
            'title' => 'Instructeurs in dienst',
            'rows' => $rows
        ];

        $this->view('Instructeur/overzichtinstructeur', $data);
    }

    public function overzichtVoertuigen($Id)
    {

        $instructeurInfo = $this->instructeurModel->getInstructeurById($Id);

        // var_dump($instructeurInfo);
        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        $datumInDienst = $instructeurInfo->DatumInDienst;
        $aantalSterren = $instructeurInfo->AantalSterren;

        /**
         * We laten de model alle gegevens ophalen uit de database
         */
        $result = $this->instructeurModel->getToegewezenVoertuigen($Id);


        $tableRows = "";
        if (empty($result)) {
            /**
             * Als er geen toegewezen voertuigen zijn komt de onderstaande tekst in de tabel
             */
            $tableRows = "<tr>
                            <td colspan='6'>
                                Er zijn op dit moment nog geen voertuigen toegewezen aan deze instructeur
                            </td>
                          </tr>";
        } else {
            /**
             * Bouw de rows op in een foreach-loop en stop deze in de variabele
             * $tabelRows
             */
            foreach ($result as $voertuig) {

                /**
                 * Zet de datum in het juiste format
                 */
                $date_formatted = date_format(date_create($voertuig->Bouwjaar), 'd-m-Y');

                $tableRows .= "<tr>
                                    <td>$voertuig->TypeVoertuig</td>
                                    <td>$voertuig->Type</td>
                                    <td>$voertuig->Kenteken</td>
                                    <td>$date_formatted</td>
                                    <td>$voertuig->Brandstof</td>
                                    <td>$voertuig->RijbewijsCategorie</td>   
                                    <td>
                                        <a href='" . URLROOT . "/instructeur/updatevoertuig/$voertuig->Id'>
                                            <i class='bi bi-pencil-square'></i>
                                        </a>         
                                    </td>
                                    <td>
                                        <a href='" . URLROOT . "/instructeur/deletevoertuig/$voertuig->Id'>
                                            <i class='bi bi-trash'></i>
                                        </a>
                                    </td>
                            </tr>";
            }
        }
        

        $data = [
            'title'     => 'Door instructeur gebruikte voertuigen',
            'tableRows' => $tableRows,
            'naam'      => $naam,
            'datumInDienst' => $datumInDienst,
            'aantalSterren' => $aantalSterren
        ];

        $this->view('Instructeur/overzichtVoertuigen', $data);


    }


    public function updateVoertuig($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Haal de gegevens op van het formulier
            $typeVoertuig = $_POST['typeVoertuig'];
            $type = $_POST['type'];
            $kenteken = $_POST['kenteken'];
            $bouwjaar = $_POST['bouwjaar'];
            $brandstof = $_POST['brandstof'];
            $rijbewijsCategorie = $_POST['rijbewijsCategorie'];
    
            // Voer de update query uit met de gegevens
            $this->instructeurModel->updateVoertuig($id, $typeVoertuig, $type, $kenteken, $bouwjaar, $brandstof, $rijbewijsCategorie);
    
            // Stuur de gebruiker door naar een overzichtspagina of een andere gewenste locatie
            header('Location: ' . URLROOT . '/instructeur/overzichtVoertuigen');
        } else {
            // Haal de voertuiginformatie op om weer te geven in het updateformulier
            $voertuig = $this->instructeurModel->getVoertuigById($id);
            // Toon het updateformulier met de bestaande gegevens
            $data = [
                'voertuig' => $voertuig
            ];
            $this->view('Voertuig/updateVoertuig', $data);
        }
    }
    
    public function deleteVoertuig($id) {
        // Voer de verwijderquery uit met de voertuig-ID
        $this->instructeurModel->deleteVoertuig($id);
        // Stuur de gebruiker door naar een overzichtspagina of een andere gewenste locatie
        header('Location: ' . URLROOT . '/instructeur/overzichtVoertuigen');
    }
    
    
}
