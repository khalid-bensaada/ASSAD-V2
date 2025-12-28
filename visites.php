<?php
session_start();
require_once 'Database.php';
require_once 'VisiteGuidee.php';
require_once 'Reservation.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$db = new Database();
$pdo = $db->getPdo();
$userId = $_SESSION['user']['id'];


$visiteObj = new VisiteGuidee();
$visites = $visiteObj->listerToutes($pdo); 

$reservation = new Reservation();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reserver'])) {
    $idvisite = intval($_POST['idvisite']);
    $numbers = intval($_POST['numbers']);

    
    $visiteInfo = $visiteObj->getVisiteParId($idvisite); 
    $capRestante = $visiteInfo['capacite_max'] - $visiteObj->totalReserves($idvisite, $pdo);

    if ($numbers <= 0) {
        $error = "Le nombre de personnes doit être supérieur à 0.";
    } elseif ($numbers > $capRestante) {
        $error = "Il ne reste que $capRestante places disponibles pour cette visite.";
    } else {
        $reservation->setIdVisite($idvisite);
        $reservation->setIdUser($userId);
        $reservation->setNumbers($numbers);
        $reservation->creer();
        $success = "Réservation effectuée avec succès !";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Visites disponibles - Zoo ASSAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen font-sans">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Visites disponibles</h1>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4"><?= $error ?></div>
        <?php elseif (isset($success)): ?>
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4"><?= $success ?></div>
        <?php endif; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($visites as $v):
                $reserves = $visiteObj->totalReserves($v['id_visites'], $pdo);
                $capRestante = $v['capacite_max'] - $reserves;
                ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 flex flex-col">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2"><?= htmlspecialchars($v['title']) ?>
                    </h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><?= htmlspecialchars($v['description_visites']) ?></p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                        Date: <?= $v['date_visite'] ?> | Heure: <?= $v['start_visite'] ?> | Langue: <?= $v['langue'] ?>
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Capacité restante: <?= $capRestante ?>
                    </p>

                    <form method="POST" class="flex gap-2 mt-auto">
                        <input type="hidden" name="idvisite" value="<?= $v['id_visites'] ?>">
                        <input type="number" name="numbers" min="1" max="<?= $capRestante ?>"
                            placeholder="Nombre de personnes"
                            class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                        <button type="submit" name="reserver"
                            class="bg-primary text-white px-4 py-2 rounded hover:bg-green-600 transition">Réserver</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>