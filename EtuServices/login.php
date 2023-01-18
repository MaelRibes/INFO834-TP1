<?php
include("config.php");

$connection = $_POST["connection"];

if (isset($connection)) {
    if (empty($_POST['email'])) {
        echo "Le champ Email est vide.";
    } else {
        if (empty($_POST['mdp'])) {
            echo "Le champ Mot de passe est vide.";
        } else {

            $email = $_POST['email'];
            $mdp = $_POST['mdp'];

            $request = "SELECT * FROM `Utilisateurs`";

            $utilisateurs = $conn->query($request);

            while ($utilisateur = $utilisateurs->fetch()) {
                if ($utilisateur['Email'] == $email && $utilisateur['Mdp'] == $mdp) {
                    echo ('Connecté !');
                    $cmd = "/usr/local/bin/python3 script_redis.py $email";
                    $path = escapeshellcmd($cmd);
                    $output = shell_exec($path);
                    echo ("nombre de connexion : $output");
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST">
        <label>
            Email :
        </label>
        <input type=" text" placeholder="Email" name="email" require>

        <label>
            Mot de passe :
        </label>
        <input type="password" placeholder="Mot de passe" name="mdp" require>

        <button type="submit" name="connection">Se connecter</button>
    </form>
</body>

</html>