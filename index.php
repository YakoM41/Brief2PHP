<?php

//importation du fichier de config
require 'config.php';



// Edition et la suppression
//creation d'un fichier edit.php et delete.php
//exemple du edit.php :


//vérification du formulaire et recupération de la saisie
if($_SERVER['REQUEST_METHOD'] === "POST") {
    $erreurs = [];
    $nom = isset($_POST['Nom']) ? $_POST['Nom'] : "";
    $prix = isset($_POST['Prix']) ? $_POST['Prix'] : "";
    $stock = isset($_POST['Stock']) ? $_POST['Stock'] : "";

    if (empty($nom)){
        $erreurs[]="Le nom est manquant";
    }
    if (empty($prix)){
        $erreurs[]="Le prix est manquant";
    }
    if (empty($stock)){
        $erreurs[]="Le stock est manquant";
    }
    if (empty($erreurs)){
        // Insertion données avec requête préparée
        $stmt = $pdo-> prepare("INSERT INTO produits(Nom, Prix, Stock) VALUES (? , ? , ? )");
        $stmt -> execute([$nom, $prix, $stock]);
        $data = "Nom : $nom \n Prix : $prix \n Stock : $stock";
        $_SESSION["message"]= "Votre produit a été enregistré avec succès !";
        $nom = $prix = $stock = "";
    }

}


//préparation de la requête
$query = "SELECT * from produits";

//Execution de la requête
$stmt= $pdo -> query($query);

//Récupération des données
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

//print_r($produits);




?>



<!doctype html>
<html lang=fr>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des produits</title>
    <style>

        body {
            font-family: sans-serif;
            margin: 40px;
            line-height: 1.6;
        }

        form {
            max-width: 400px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            display: flex;
            flex-direction: column;
            font-weight: bold;
        }

        input {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
<h1>Liste des produits</h1>
<?php if(!empty($produits)): ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Stock</th>
        </tr>
        </thead>

        <tbody>
        <!-- PHP -->
        <?php foreach($produits as $p): ?>
            <tr>
                <td> <?= htmlspecialchars($p['ID']) ?></td>
                <td> <?= htmlspecialchars($p['Nom']) ?></td>
                <td> <?= htmlspecialchars($p['Prix']) ?></td>
                <td> <?= htmlspecialchars($p['Stock']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $p['ID']; ?>">Modifier</a>

                </td>
                <td>
                    <a href="delete.php?id=<?= $p['ID']; ?>"
                    onclick="return confirm('Voulez vous vraiment supprimer ce produit ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <p>Aucun produits</p>
<?php endif; ?>

<!-- Formulaire d'ajout-->

<form action="index.php" method="post">
    <label for="Nom"> Nom :
        <input type="text" id="Nom" name="Nom">
    </label>
    <label for="Prix"> Prix :
        <input type="number" id="Prix" name="Prix">
    </label>
    <label for="Stock"> Stock :
        <input type="number" id="Stock" name="Stock" >
    </label>
    <button type="submit">Ajouter</button>
</form>


</body>
</html>
