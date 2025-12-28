<?php
require_once 'Database.php';

class EtapeVisite extends Database
{
    private int $id;
    private string $title_step;
    private ?string $description_step;
    private int $ordre_step;
    private int $id_visite;

    public function __construct()
    {
        parent::__construct();
    }

    
    public function getId(): int
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title_step;
    }
    public function getDescription(): ?string
    {
        return $this->description_step;
    }
    public function getOrdre(): int
    {
        return $this->ordre_step;
    }
    public function getIdVisite(): int
    {
        return $this->id_visite;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setTitle(string $title): void
    {
        $this->title_step = $title;
    }
    public function setDescription(?string $desc): void
    {
        $this->description_step = $desc;
    }
    public function setOrdre(int $ordre): void
    {
        $this->ordre_step = $ordre;
    }
    public function setIdVisite(int $id): void
    {
        $this->id_visite = $id;
    }

    

    public function ajoutEtapes(array $etapes): bool
    {
        $sql = "INSERT INTO apesvisite (title_step, description_step, ordre_step, id_visite) 
                VALUES (:title, :desc, :ordre, :id_visite)";
        $stmt = $this->pdo->prepare($sql);

        foreach ($etapes as $etape) {
            $stmt->execute([
                ':title' => $etape['title'],
                ':desc' => $etape['description'] ?? '',
                ':ordre' => $etape['ordre'],
                ':id_visite' => $this->id_visite
            ]);
        }
        return true;
    }
}
?>