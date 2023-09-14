<!-- wijzigenGegevens.php -->
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $data['title']; ?></title>
</head>
<body>
    <h1>Wijzig Voertuiggegevens</h1>
    <p>Instructeur: <?php echo $data['instructeurInfo']->Voornaam . ' ' . $data['instructeurInfo']->Tussenvoegsel . ' ' . $data['instructeurInfo']->Achternaam; ?></p>
    <form method="post" action="<?php echo URLROOT; ?>/instructeur/wijzienGegevens/<?php echo $data['instructeurInfo']->Id; ?>">
        <!-- Voeg hier de invoervelden toe voor het wijzigen van gegevens -->
    

        <label for="nieuwType">Nieuw Type:</label>
        <input type="text" name="nieuwType" required><br>

        <label for="nieuweBrandstof">Nieuwe Brandstof:</label>
        <input type="text" name="nieuweBrandstof" required><br>

        <label for="nieuwKenteken">Nieuw Kenteken:</label>
        <input type="text" name="nieuwKenteken" required><br>

        <input type="submit" value="Opslaan">
    </form>
</body>
</html>
