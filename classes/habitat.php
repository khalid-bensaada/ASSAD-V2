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

    
    
}
