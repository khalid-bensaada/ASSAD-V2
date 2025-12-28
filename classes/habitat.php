<?php

class Habitat
{
    private int $id_hab;
    private string $hab_name;
    private string $description;
    private string $zonezoo;

    private PDO $pdo;

    public function __construct(
        PDO $pdo,
        int $id_hab = "",
        string $hab_name = '',
        string $description = '',
        string $zonezoo = ''
    ) {
        $this->pdo = $pdo;
        $this->id_hab = $id_hab;
        $this->hab_name = $hab_name;
        $this->description = $description;
        $this->zonezoo = $zonezoo;
    }


    public function getIdHab(): ?int
    {
        return $this->id_hab;
    }
    public function getHabName(): string
    {
        return $this->hab_name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getZoneZoo(): string
    {
        return $this->zonezoo;
    }

    public function setIdHab(int $id_hab): void
    {
        $this->id_hab = $id_hab;
    }

    public function setHabName(string $hab_name): void
    {
        $this->hab_name = $hab_name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setZoneZoo(string $zonezoo): void
    {
        $this->zonezoo = $zonezoo;
    }


    public function listerTous(): array
    {
        $stmt = $this->pdo->query(
            "SELECT id_hab, hab_name, description, zonezoo
             FROM habitats
             ORDER BY hab_name"
        );

        $habitats = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $habitats[] = new Habitat(
                $this->pdo,
                $row['id_hab'],
                $row['hab_name'],
                $row['description'],
                $row['zonezoo']
            );
        }

        return $habitats;
    }
    public function creathabitat()
    {
        $sql = "INSERT INTO habitats (hab_name,  description , zonezoo )
                VALUES (:hab_name, :description, :zonezoo)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':hab_name' => $this->hab_name,

            ':description' => $this->description,
            ':zonezoo' => $this->zonezoo
        ]);

    }
    public function deleteHabitat()
    {
        $sql = "DELETE FROM habitats WHERE id_hab = ?";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$this->id_hab]);

        header("Location: admin_habitats.php");
        exit;
    }
    public function updateHabitat()
    {
        $sql = "UPDATE habitats SET hab_name = :name, zonezoo = :zone, description = :desc WHERE id_hab = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $this->hab_name,

            ':zone' => $this->zonezoo,
            ':desc' => $this->description,
            ':id' => $this->id_hab
        ]);
        header("Location: m_habitat.php");
        exit;
    }


}
?>