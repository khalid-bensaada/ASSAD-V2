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

    public function creer(): bool
    {
        
        $stmt = $this->pdo->prepare("SELECT capacite_max, id_visites FROM visitesguidees WHERE id_visites = ?");
        $stmt->execute([$this->idvisite]);
        $visite = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$visite)
            return false;

        $stmt2 = $this->pdo->prepare("SELECT SUM(numbers) as total FROM reservations WHERE idvisite = ?");
        $stmt2->execute([$this->idvisite]);
        $row = $stmt2->fetch(PDO::FETCH_ASSOC);
        $totalReserve = $row['total'] ?? 0;

        if (($totalReserve + $this->numbers) > $visite['capacite_max']) {
            return false; 
        }

        $stmt3 = $this->pdo->prepare("INSERT INTO reservations (idvisite, iduser, numbers) VALUES (:idvisite, :iduser, :numbers)");
        return $stmt3->execute([
            ':idvisite' => $this->idvisite,
            ':iduser' => $this->iduser,
            ':numbers' => $this->numbers
        ]);
    }

    
    public function listerParVisite(int $idvisite): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT r.id_reserv, r.numbers, r.date_reservation, u.username, u.email
             FROM reservations r
             INNER JOIN utilisateurs u ON r.iduser = u.id
             WHERE r.idvisite = ?
             ORDER BY r.date_reservation DESC"
        );
        $stmt->execute([$idvisite]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function listerParVisiteur(int $iduser): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT r.id_reserv, r.numbers, r.date_reservation, v.title
             FROM reservations r
             INNER JOIN visitesguidees v ON r.idvisite = v.id_visites
             WHERE r.iduser = ?
             ORDER BY r.date_reservation DESC"
        );
        $stmt->execute([$iduser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$a = new Reservation(1,2,3);
?>