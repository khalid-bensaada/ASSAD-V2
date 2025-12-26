<?php
require_once 'Database.php';
class Animale extends Database
{
    private $Aid;
    private $name;
    private $alimentation;
    private $image;
    private $live;
    private $description;
    private $idhabitat;
    private $views_animal;

    public $conn;

    public function __construnct(string $name = "", string $alimentation = "", string $image = "", string $live = "", string $description = "", int $idhabitat = "", int $views_animal = "")
    {

        $this->name = $name;
        $this->alimentation = $alimentation;
        $this->image = $image;
        $this->live = $live;
        $this->description = $description;
        $this->idhabitat = $idhabitat;
        $this->views_animal = $views_animal;

    }

    //GETTERS
    public function getAid()
    {
        return $this->Aid;
    }
    public function getname()
    {
        return $this->name;
    }

    public function getalimentation()
    {
        return $this->alimentation;
    }

    public function getimage()
    {
        return $this->image;
    }

    public function getlive()
    {
        return $this->live;
    }
    public function getdescription()
    {
        return $this->description;
    }
    public function getidhabitat()
    {
        return $this->idhabitat;
    }
    public function getviewsanimal()
    {
        return $this->views_animal;
    }

    //SETTERS
    public function setAid(int $Aid): void
    {
        $this->Aid = $Aid;
    }
    public function setname(string $name): void
    {
        $this->name = $name;
    }
    public function setalimentation(string $alimentation): void
    {
        $this->alimentation = $alimentation;
    }
    public function setimage(string $image): void
    {
        $this->image = $image;
    }
    public function setlive(string $live): void
    {
        $this->live = $live;
    }
    public function setdescription(string $description): void
    {
        $this->description = $description;
    }
    public function setidhabitat(int $idhabitat): void
    {
        $this->idhabitat = $idhabitat;
    }
    public function setviewsanimal(int $views_animal): void
    {
        $this->views_animal = $views_animal;
    }

    public function list()
    {
        $query = "
        SELECT 
            a.id,
            a.name_animal AS name,
            a.description AS description,
            h.hab_name AS idhabitat,
            h.zonezoo AS live
        FROM animaux a
        LEFT JOIN habitats h ON a.id_habitat = h.id_hab
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    


}
?>