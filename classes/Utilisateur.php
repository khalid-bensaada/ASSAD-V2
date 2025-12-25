<?php

require_once 'classes/Database.php';

class Utilisateur
{
    private int $id;
    private string $username;
    private string $email;
    private string $user_role;
    private string $password_hash;
    private bool $actif;
    private bool $guide_approuve;

    private string $reapet;
    private $pdo;

    // make objects for the attributs i make 
    public function __construct(string $username = "", string $email = "", string $user_role = "", string $password_hash = "", string $reapet = "", bool $actif = false, bool $guide_approuve = false)
    {

        $this->username = $username;
        $this->email = $email;
        $this->user_role = $user_role;
        $this->password_hash = $password_hash;
        $this->actif = $actif;
        $this->guide_approuve = $guide_approuve;
        $this->reapet = $reapet;
    }

    //Get for read the value

    public function getid(): int
    {
        return $this->id;
    }

    // get object of username in function 
    public function getusername(): string
    {
        return $this->username;
    }

    // get object of email in function 
    public function getemail(): string
    {
        return $this->email;
    }
    // get object of user_role in function 
    public function getrole(): string
    {
        return $this->user_role;
    }

    // get object of password_hash in function 
    public function getpassword(): string
    {
        return $this->password_hash;
    }

    public function getreapet(): string
    {
        return $this->reapet;
    }
    // get object of actif in function 
    public function getactif(): bool
    {
        return $this->actif;
    }

    // get object of guide_approuve in function 
    public function getapprouve(): bool
    {
        return $this->guide_approuve;
    }

    // for madify values or type of variable

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setusername(string $username): void
    {
        $this->username = $username;
    }
    public function setemail(string $email): void
    {
        $this->email = $email;
    }
    public function setrol(string $user_role): void
    {
        $this->user_role = $user_role;
    }
    public function setpassword(string $password_hash): void
    {
        $this->password_hash = $password_hash;
    }

    public function setreapet(string $reapet)
    {
        $this->reapet = $reapet;
    }
    public function setactif(bool $actif): void
    {
        $this->actif = $actif;
    }
    public function setapprouve(bool $guide_approuve): void
    {
        $this->guide_approuve = $guide_approuve;
    }

    public function regexE()
    {
        $errors = [];
        $this->errors = $errors;
        $pattern_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";
        if (!preg_match($pattern_email, $this->email)) {
            $errors['email_error'] = "L'adresse email n'est pas valide (format attendu: nom@exemple.com).";
        }

    }

    public function lengthP()
    {
        $errors = [];
        $this->errors = $errors;
        if (strlen($this->password_hash) < 6) {
            $errors['password_error'] = "Le mot de passe doit faire au moins 6 caractères.";
        }
    }

    public function regexP()
    {
        $errors = [];
        $this->errors = $errors;
        $passRegex = '/^(?=.*[a-zA-Z])(?=.*[\d])(?=.*[-_@&!#\.*]){8,}$/';
        if (!preg_match($passRegex, $this->password_hash)) {
            $errors['password_error'] = "L'adresse email n'est pas valide.";
        }
    }

    public function hash()
    {
        $password_raw = password_hash($this->password_hash, PASSWORD_DEFAULT);
        $this->password_raw = $password_raw;
    }
    public function create()
    {
        $sql = "INSERT INTO utilisateurs (username, email, user_role , password_hash )
                VALUES (username,email , user_role , password_hash)";

        $stmt = $this->pdo->prepare($sql);

        $hash = password_hash($this->password_hash, PASSWORD_DEFAULT);

        return $stmt->execute([
            ':username' => $this->username,
            ':email' => $this->email,
            ':user_role' => $this->user_role,
            ':password_hash' => $this->$hash
        ]);

    }



    public function foundEmail($email)
    {
        $sql = "SELECT * FROM utilisateur WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function verifyP($password)
    {
        return password_verify($password, $this->password_hash);
    }

}
?>