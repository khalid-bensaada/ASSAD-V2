<?php
session_start();
require_once 'Database.php';
require_once 'VisiteGuidee.php';
require_once 'EtapeVisite.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['user_role'] !== 'guide') {
    header('Location: login.php');
    exit;
}

$pdo = (new Database())->getPdo();
$guideId = $_SESSION['user']['id'];

$visite = new VisiteGuidee();
$visites = $visite->listerParGuide($guideId);

$etape = new EtapeVisite();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_visite'])) {
    $visite->setTitle($_POST['title']);
    $visite->setDescription($_POST['description']);
    $visite->setDate($_POST['date']);
    $visite->setStart($_POST['start']);
    $visite->setDuree(intval($_POST['duree']));
    $visite->setLangue($_POST['langue']);
    $visite->setCapacite(intval($_POST['capacite']));
    $visite->setPrix(floatval($_POST['prix']));
    $visite->setStatut('active');
    $visite->setIdGuide($guideId);

    if ($visite->creer()) {
        $lastId = $pdo->lastInsertId();

        if (!empty($_POST['steps'])) {
            $etape->setIdVisite($lastId);
            $etape->ajoutEtapes($_POST['steps']);
        }

        header("Location: dashboard_guide.php");
        exit;
    }
}

if (isset($_GET['annuler']) && is_numeric($_GET['annuler'])) {
    $visite->setId(intval($_GET['annuler']));
    $visite->annuler();
    header("Location: dashboard_guide.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guide - Zoo ASSAD</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-sans text-gray-900 dark:text-white">

    <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Dashboard Guide</h1>
            <button id="openModal" class="px-4 py-2 bg-primary text-white rounded hover:bg-green-600 transition">
                Ajouter une visite
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4 space-y-6">
        <h2 class="text-xl font-semibold">Mes Visites Guidées</h2>
        <div class="overflow-x-auto">
            <table
                class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Titre</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Date</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Heure</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Durée</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Capacité
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Prix</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Statut</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-600 dark:text-gray-300">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($visites as $v): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-2"><?= htmlspecialchars($v['title']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($v['date_visite']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($v['start_visite']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($v['duree_visite']) ?> min</td>
                            <td class="px-4 py-2"><?= htmlspecialchars($v['capacite_max']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($v['prix']) ?> €</td>
                            <td class="px-4 py-2 capitalize"><?= htmlspecialchars($v['statut']) ?></td>
                            <td class="px-4 py-2 text-right space-x-2">
                                <a href="?annuler=<?= $v['id_visites'] ?>"
                                    onclick="return confirm('Annuler cette visite ?')"
                                    class="px-2 py-1 text-red-600 bg-red-100 rounded hover:bg-red-200 transition">Annuler</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Ajouter Visite -->
    <div id="modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <form method="POST"
            class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-2xl space-y-4 overflow-y-auto max-h-[90vh]">
            <h2 class="text-xl font-bold">Ajouter une nouvelle visite</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="title" placeholder="Titre" required class="p-2 rounded border w-full">
                <input type="date" name="date" required class="p-2 rounded border w-full">
                <input type="time" name="start" required class="p-2 rounded border w-full">
                <input type="number" name="duree" placeholder="Durée (minutes)" required
                    class="p-2 rounded border w-full">
                <input type="text" name="langue" placeholder="Langue" class="p-2 rounded border w-full">
                <input type="number" step="0.01" name="prix" placeholder="Prix" class="p-2 rounded border w-full">
                <input type="number" name="capacite" placeholder="Capacité" required class="p-2 rounded border w-full">
            </div>
            <textarea name="description" placeholder="Description" class="p-2 rounded border w-full"></textarea>

            <h3 class="font-semibold">Étapes</h3>
            <div id="stepsContainer" class="space-y-2">
                <div class="flex gap-2">
                    <input type="text" name="steps[0][title]" placeholder="Titre étape"
                        class="p-2 rounded border flex-1" required>
                    <input type="text" name="steps[0][description]" placeholder="Description étape"
                        class="p-2 rounded border flex-1">
                    <input type="number" name="steps[0][ordre]" placeholder="Ordre" class="p-2 rounded border w-20"
                        required>
                </div>
            </div>
            <button type="button" onclick="addStep()"
                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Ajouter étape</button>

            <div class="flex justify-end gap-2">
                <button type="button" id="closeModal"
                    class="px-4 py-2 rounded bg-gray-300 dark:bg-gray-700">Annuler</button>
                <button type="submit" name="add_visite"
                    class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition">Ajouter</button>
            </div>
        </form>
    </div>

    <script>
        const modal = document.getElementById('modal');
        document.getElementById('openModal').onclick = () => modal.classList.remove('hidden');
        document.getElementById('closeModal').onclick = () => modal.classList.add('hidden');

        let stepIndex = 1;
        function addStep() {
            const container = document.getElementById('stepsContainer');
            const div = document.createElement('div');
            div.className = "flex gap-2";
            div.innerHTML = `
        <input type="text" name="steps[${stepIndex}][title]" placeholder="Titre étape" class="p-2 rounded border flex-1" required>
        <input type="text" name="steps[${stepIndex}][description]" placeholder="Description étape" class="p-2 rounded border flex-1">
        <input type="number" name="steps[${stepIndex}][ordre]" placeholder="Ordre" class="p-2 rounded border w-20" required>
    `;
            container.appendChild(div);
            stepIndex++;
        }
    </script>

</body>

</html>