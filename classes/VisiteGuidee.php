<?php
require_once 'Database.php';

class VisiteGuidee extends Database
{
    private int $id_visites;
    private string $title;
    private ?string $description;
    private string $date_visite;
    private string $start_visite;
    private int $duree_visite;
    private ?string $langue;
    private int $capacite_max;
    private ?float $prix;
    private string $statut;
    private int $id_guide;
    private int $views_visite;

    public function __construct()
    {
        parent::__construct();
    }


    public function getId(): int
    {
        return $this->id_visites;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getDate(): string
    {
        return $this->date_visite;
    }
    public function getStart(): string
    {
        return $this->start_visite;
    }
    public function getDuree(): int
    {
        return $this->duree_visite;
    }
    public function getLangue(): ?string
    {
        return $this->langue;
    }
    public function getCapacite(): int
    {
        return $this->capacite_max;
    }
    public function getPrix(): ?float
    {
        return $this->prix;
    }
    public function getStatut(): string
    {
        return $this->statut;
    }
    public function getIdGuide(): int
    {
        return $this->id_guide;
    }
    public function getViews(): int
    {
        return $this->views_visite;
    }


    public function setId(int $id): void
    {
        $this->id_visites = $id;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function setDescription(?string $desc): void
    {
        $this->description = $desc;
    }
    public function setDate(string $date): void
    {
        $this->date_visite = $date;
    }
    public function setStart(string $start): void
    {
        $this->start_visite = $start;
    }
    public function setDuree(int $duree): void
    {
        $this->duree_visite = $duree;
    }
    public function setLangue(?string $langue): void
    {
        $this->langue = $langue;
    }
    public function setCapacite(int $cap): void
    {
        $this->capacite_max = $cap;
    }
    public function setPrix(?float $prix): void
    {
        $this->prix = $prix;
    }
    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }
    public function setIdGuide(int $id): void
    {
        $this->id_guide = $id;
    }
    public function setViews(int $views): void
    {
        $this->views_visite = $views;
    }



    public function creer(): bool
    {
        $sql = "INSERT INTO visitesguidees 
            (title, description_visites, date_visite, start_visite, duree_visite, langue, capacite_max, prix, statut, id_guide)
            VALUES (:title, :description, :date_visite, :start_visite, :duree, :langue, :capacite, :prix, :statut, :id_guide)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':title' => $this->title,
            ':description' => $this->description,
            ':date_visite' => $this->date_visite,
            ':start_visite' => $this->start_visite,
            ':duree' => $this->duree_visite,
            ':langue' => $this->langue,
            ':capacite' => $this->capacite_max,
            ':prix' => $this->prix,
            ':statut' => $this->statut,
            ':id_guide' => $this->id_guide
        ]);
    }

    public function listerParGuide(int $idGuide): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM visitesguidees WHERE id_guide = :id_guide ORDER BY date_visite DESC");
        $stmt->execute([':id_guide' => $idGuide]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function mettreAJour(): bool
    {
        $sql = "UPDATE visitesguidees SET 
                    title=:title,
                    description_visites=:desc,
                    date_visite=:date_visite,
                    start_visite=:start_visite,
                    duree_visite=:duree,
                    langue=:langue,
                    capacite_max=:capacite,
                    prix=:prix,
                    statut=:statut
                WHERE id_visites=:id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':title' => $this->title,
            ':desc' => $this->description,
            ':date_visite' => $this->date_visite,
            ':start_visite' => $this->start_visite,
            ':duree' => $this->duree_visite,
            ':langue' => $this->langue,
            ':capacite' => $this->capacite_max,
            ':prix' => $this->prix,
            ':statut' => $this->statut,
            ':id' => $this->id_visites
        ]);
    }
    public function listerToutes(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM visitesguidees WHERE statut='active' ORDER BY date_visite");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getVisiteParId(int $id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM visitesguidees WHERE id_visites = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function totalReserves(int $idvisite): int
    {
        $stmt = $this->pdo->prepare("SELECT SUM(numbers) as total FROM reservations WHERE idvisite = ?");
        $stmt->execute([$idvisite]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }


    public function annuler(): bool
    {
        $stmt = $this->pdo->prepare("UPDATE visitesguidees SET statut='annulee' WHERE id_visites = ?");
        return $stmt->execute([$this->id_visites]);
    }

}
?>