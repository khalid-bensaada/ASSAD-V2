<?php
session_start();
require_once 'Database.php';
require_once 'Reservation.php';


if (!isset($_SESSION['user']) || $_SESSION['user']['user_role'] !== 'visiteur') {
    header("Location: login.php");
    exit;
}

$db = new Database();
$pdo = $db->getPdo();

$stmt = $pdo->query("SELECT * FROM visitesguidees WHERE statut = 'active' ORDER BY date_visite ASC");
$visites = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reserver'])) {
    $reservation = new Reservation();
    $reservation->setIdVisite(intval($_POST['idvisite']));
    $reservation->setIdUser($_SESSION['user']['id']);
    $reservation->setNumbers(intval(value: $_POST['numbers']));

    $success = $reservation->creer();
    $message = $success ? "Reservation réussie !" : "Impossible de réserver, capacité dépassée.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visites - Zoo ASSAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Visites Disponibles</h1>

        <?php if (isset($message)): ?>
            <div class="mb-4 p-4 rounded bg-green-200 text-green-800"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($visites as $visite): ?>
                <?php

                $stmt2 = $pdo->prepare("SELECT SUM(numbers) as total FROM reservations WHERE idvisite = ?");
                $stmt2->execute([$visite['id_visites']]);
                $row = $stmt2->fetch(PDO::FETCH_ASSOC);
                $totalReserve = $row['total'] ?? 0;
                $capaciteRestante = $visite['capacite_max'] - $totalReserve;
                ?>
                <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                    <h2 class="text-xl font-bold"><?= htmlspecialchars($visite['title']) ?></h2>
                    <p class="text-gray-500 text-sm mb-2"><?= htmlspecialchars($visite['description_visites']) ?></p>
                    <p class="mb-2"><strong>Date:</strong> <?= htmlspecialchars($visite['date_visite']) ?></p>
                    <p class="mb-2"><strong>Heure:</strong> <?= htmlspecialchars($visite['start_visite']) ?></p>
                    <p class="mb-2"><strong>Langue:</strong> <?= htmlspecialchars($visite['langue']) ?></p>
                    <p class="mb-2"><strong>Prix:</strong> <?= htmlspecialchars($visite['prix']) ?> MAD</p>
                    <p class="mb-2"><strong>Capacité restante:</strong> <?= $capaciteRestante ?></p>

                    <?php if ($capaciteRestante > 0): ?>
                        <form method="POST" class="mt-auto flex gap-2">
                            <input type="hidden" name="idvisite" value="<?= $visite['id_visites'] ?>">
                            <input type="number" name="numbers" value="1" min="1" max="<?= $capaciteRestante ?>"
                                class="w-16 border rounded px-2 py-1">
                            <button type="submit" name="reserver"
                                class="bg-primary text-white px-4 py-2 rounded hover:bg-green-600 transition">Réserver</button>
                        </form>
                    <?php else: ?>
                        <p class="text-red-500 font-bold mt-2">Complet</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>