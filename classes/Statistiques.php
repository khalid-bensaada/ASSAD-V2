<?php
require_once 'Database.php';

class Statistiques {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    
    public function totalVisiteurs(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE user_role='visiteur'");
        return (int)$stmt->fetchColumn();
    }

    
    public function visiteursParPays(): array {
        $stmt = $this->pdo->query("SELECT country, COUNT(*) as total FROM utilisateurs WHERE user_role='visiteur' GROUP BY country");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function totalAnimaux(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM animaux");
        return (int)$stmt->fetchColumn();
    }

    
    public function visitesPlusReservees(int $limit = 5): array {
        $stmt = $this->pdo->prepare("
            SELECT v.title, COUNT(r.id_reserv) as total_reserv
            FROM visitesguidees v
            LEFT JOIN reservations r ON v.id_visites = r.idvisite
            GROUP BY v.id_visites
            ORDER BY total_reserv DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
