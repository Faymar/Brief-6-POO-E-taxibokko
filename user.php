<?php
class User
{
    private $nom;
    private $prenom;
    private $telephone;
    private $email;
    private $password;
    private $date_inscrit;
    public function __construct($nom, $prenom, $telephone, $email, $password, $date_inscrit)
    {
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setTelephone($telephone);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setDateInscrit($date_inscrit);
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $regex_nom = "/^[a-zA-Z ']{2,}$/";
        if (empty($nom)) {
            throw new Exception("Le prénom est obligatoire.");
        } else if (!preg_match($regex_nom, $nom)) {
            throw new Exception("Le nom est obligatoire.");
        } else {
            $this->nom = $nom;
        }
    }

    public function getPrenom()
    {
        return $this->prenom;
    }
    public function setPrenom($prenom)
    {
        $regex_prenom = "/^[a-zA-Z ']{3,}$/";
        if (empty($prenom)) {
            throw new Exception("Le prénom est obligatoire.");
        } else if (!preg_match($regex_prenom, $prenom)) {
            throw new Exception("Le nom est invalide.");
        } else {
            $this->prenom = $prenom;
        }
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $regex_tel = "/^7+[0-9]{1,9}$/";
        if (empty($telephone)) {
            throw new Exception("Le numéro de téléphone est obligatoire");
        } else if (!preg_match($regex_tel, $telephone)) {
            throw new Exception("Le numéro de téléphone doit contenir 9 chiffres.");
        } else {
            $this->telephone = $telephone;
        }
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $regex_email = "/^[a-zA-Z][a-zA-Z0-9]+@+[a-zA-Z]+.+[a-zA-Z]+$/";
        if (empty($email)) {
            throw new Exception("L'email obligatoire");
        } else if (!preg_match($regex_email, $email)) {
            throw new Exception("Le email est invalide.");
        } else {
            $this->email = $email;
        }
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if (strlen($password) < 8) {
            throw new Exception("Le mot de passe doit avoir au moins 8 caractères.");
        } else if (
            !preg_match("/[A-Z]/", $password) ||
            !preg_match("/[a-z]/", $password) ||
            !preg_match("/[0-9]/", $password)
        ) {
            throw new Exception("Le mot de passe doit contenir au moins une lettre majuscule, une lettre minusculeet au moins un chiffre.");
        } else {
            $this->password = $password;
        }
    }

    public function getDateInscrit()
    {
        return $this->date_inscrit;
    }

    public function setDateInscrit($date_inscrit)
    {
        $testedate = strtotime($date_inscrit);

        if ($testedate === false) {
            throw new Exception("La date est invalide");
        } else {
            $this->date_inscrit = $date_inscrit;
        }
    }

    public function inscription($pdo)
    {
        $conn = $pdo->connexion();
        $sql = 'INSERT INTO `users` (nom,	prenom,	telephone, email, `password`, date_inscrit) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);

        $this->password = md5($this->password);

        $stmt->bindParam(1, $this->nom);
        $stmt->bindParam(2, $this->prenom);
        $stmt->bindParam(3, $this->telephone);
        $stmt->bindParam(4, $this->email);
        $stmt->bindParam(5, $this->password);
        $stmt->bindParam(6, $this->date_inscrit);
        try {

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $id = $conn->lastInsertId();

                $_SESSION['id'] = $id;
                header("Location:dashboard.php");
            }
        } catch (Exception $e) {
            echo '<h1>Email ou numero de telephone deja iscrit</h1> <br>';
            echo '<h1><a href="inscription.php">retourner a la page d\'inscription</a> </h1><br>';
        }
    }

    public static function seConnecter($pdo, $email, $password)
    {
        $conn = $pdo->connexion();

        $sql = 'SELECT * FROM users WHERE email = ?';
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(1, $email);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $passwordExist = $stmt->fetchColumn(5);

            if (md5($password) === $passwordExist) {

                $_SESSION['id'] = $stmt->fetchColumn(0);

                header('Location: dashboard.php');
            } else {
                echo 'email ou mot de passe est incorrect.';
            }
        } else {
            echo 'L\'utilisateur n\'existe pas.';
        }
    }

    public static function listeUser($pdo)
    {
        $conn = $pdo->connexion();
        $sql = 'SELECT * FROM users ';
        $users = $conn->query($sql);
        return $users;
    }
}
