<?php
require_once 'Database.php';

class Reservation extends Database
{
    private int $id_reserv;
    private int $idvisite;
    private int $iduser;
    private int $numbers;
    private $date_reservation;

    public function __construct($idvisite = 0, $iduser = 0, $numbers = 0)
    {
        parent::__construct();
        $this->idvisite = $idvisite;
        $this->iduser = $iduser;
        $this->numbers = $numbers;
    }

    public function getId(): int
    {
        return $this->id_reserv;
    }
    public function getIdVisite(): int
    {
        return $this->idvisite;
    }
    public function getIdUser(): int
    {
        return $this->iduser;
    }
    public function getNumbers(): int
    {
        return $this->numbers;
    }
    public function getDate(): string
    {
        return $this->date_reservation;
    }

    public function setIdVisite(int $id)
    {
        $this->idvisite = $id;
    }
    public function setIdUser(int $id)
    {
        $this->iduser = $id;
    }
    public function setNumbers(int $n)
    {
        $this->numbers = $n;
    }

    public function creer()
    {
        $sql = "INSERT INTO reservations (idvisite, iduser, numbers) VALUES (:idvisite, :iduser, :numbers)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idvisite' => $this->idvisite,
            ':iduser' => $this->iduser,
            ':numbers' => $this->numbers
        ]);
    }

    public function listerParVisite($idvisite)
    {
        $sql = "SELECT r.*, u.username FROM reservations r 
                JOIN utilisateurs u ON r.iduser = u.id
                WHERE r.idvisite = :idvisite";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idvisite' => $idvisite]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listerParVisiteur($iduser)
    {
        $sql = "SELECT r.*, v.title FROM reservations r 
                JOIN visitesguidees v ON r.idvisite = v.id_visites
                WHERE r.iduser = :iduser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':iduser' => $iduser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>