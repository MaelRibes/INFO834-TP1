# Un cache Redis pour EtuServices

## Création de la bdd :

On lance une connexion à phpMyAdmin en local grâce à MAMP.

Dans une base de donnée "EtuServices", lancer les commandes suivantes :

```SQL
--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE `Utilisateurs` (
  `ID` int(11) NOT NULL,
  `Nom` varchar(12) NOT NULL,
  `Prénom` varchar(12) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Mdp` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Utilisateurs`
--

INSERT INTO `Utilisateurs` (`ID`, `Nom`, `Prénom`, `Email`, `Mdp`) VALUES
(1, 'Robert', 'José', 'robert.jose@gmail.com', 'joser'),
(2, 'Axel', 'Pedro', 'axel.pedro@gmail.com', 'pedroa');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
```

Dans le fichier _login.php_, on crée un formulaire html permattant de connecter un utilisateur avec son email et son mot de passe. On vérifie si les champs du formulaires sont remplis. On utilise le fichier _config.php_ pour initialiser la connexion avec la base de donnée avec PDO avant de vérifier dans celle-ci si l'utilisateur existe.

Si c'est le cas, on lance le _script_redis.py_. Le script permet de récupérer la session redis de l'utilisateur qui tente de se connecter si elle existe et de la créer sinon. On vérifie ensuite si le compteur de connexions stocké dans la session est inférieur à 10. Si c'est le cas on permet la connexion et on incrémente le compteur de 1. Sinon, on refuse la connexion en affichant le nombre de minutes à attendre pour tenter une nouvelle connexion.
