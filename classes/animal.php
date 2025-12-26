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


?>