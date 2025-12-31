<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Statistiques.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$db = new Database();
$pdo = $db->getPdo();

$stats = new Statistiques($pdo);
$total_visiteurs = $stats->totalVisiteurs();
$total_animaux = $stats->totalAnimaux();
$visites_top = $stats->visitesPlusReservees();
$visiteurs_par_pays = $stats->visiteursParPays();
$stmt = $pdo->query("SELECT id, username, email, user_role, actif FROM utilisateurs ORDER BY username");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header class="w-full border-b border-gray-200 dark:border-gray-800 bg-white dark:bg-[#1a2e22] sticky top-0 z-50">
        <div class="px-6 md:px-10 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="size-8 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">pets</span>
                </div>
                <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Zoo ASSAD</h2>
            </div>
            <nav class="hidden md:flex items-center gap-8">
                <a class="text-sm font-medium hover:text-primary transition-colors text-gray-600 dark:text-gray-300"
                    href="dashboard_admin.php">Dashboard</a>
                <a class="text-sm font-medium hover:text-primary transition-colors text-gray-600 dark:text-gray-300"
                    href="admin_animaux.php">Animals</a>
                <a class="text-sm font-medium text-primary font-bold" href="admin_habitats.php">Habitats</a>
                <a class="text-sm font-medium hover:text-primary transition-colors text-gray-600 dark:text-gray-300"
                    href="m_users.php">Users</a>
            </nav>
            <div class="flex items-center gap-4">
                <button class="md:hidden text-gray-600 dark:text-gray-300">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 border-2 border-primary/20"
                    data-alt="Profile picture of logged in admin user"
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAP6akvW4AOJjIDJrwGEz0eppoFwEHRgt0vsa84z-tjf9gh6HMWdl7X40T_gMDrlxT-wRx7p6SKAPjzoLMnvr8UrJg-rU6iDhysJQtkVFtqu4chGo9wwcLghrS6IknMpHjztUh3-eg_8POwI2HOtfsVla8fdREK97LVVMov-0uWbboJDPpknZogxH27AzbxqWYL0BGJ4rhdzx7tS8Zd3QIHOiPd6D4eyXKJxvmbIGTMaY5GZGLjB304lN1nfXeCdFXkABUI486IlRs");'>
                </div>
            </div>
        </div>
    </header>
    <div class="container mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6">Gestion des Utilisateurs</h1>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow p-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50">
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Nom</th>
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Email</th>
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Rôle</th>
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Actif</th>
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="p-3 font-medium text-gray-900 dark:text-gray-100">
                                <?= htmlspecialchars($user['username']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($user['user_role']) ?></td>
                            <td class="p-3"><?= $user['actif'] ? 'Oui' : 'Non' ?></td>
                            <td class="p-3 text-right flex justify-end gap-2">
                                <a href="edit_user.php?id=<?= $user['id'] ?>"
                                    class="px-3 py-1 rounded bg-blue-500 text-white hover:bg-blue-600 transition">Edit</a>
                                <?php if ($user['user_role'] !== 'admin'): ?>
                                    <a href="delete_user.php?id=<?= $user['id'] ?>"
                                        onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')"
                                        class="px-3 py-1 rounded bg-red-500 text-white hover:bg-red-600 transition">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container mx-auto py-8 px-4">

        <h1 class="text-3xl font-bold mb-6">Statistiques Admin</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
                <h2 class="font-bold text-lg">Total Visiteurs</h2>
                <p class="text-2xl"><?= $total_visiteurs ?></p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
                <h2 class="font-bold text-lg">Total Animaux</h2>
                <p class="text-2xl"><?= $total_animaux ?></p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded shadow p-4 col-span-2">
                <h2 class="font-bold text-lg mb-2">Visites les plus réservées</h2>
                <ul class="list-disc pl-5">
                    <?php foreach ($visites_top as $v): ?>
                        <li><?= htmlspecialchars($v['title']) ?> (<?= $v['total_reserv'] ?> réservations)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="mt-8 bg-white dark:bg-gray-800 rounded shadow p-4">
            <h2 class="font-bold text-lg mb-2">Visiteurs par pays</h2>
            <ul class="list-disc pl-5">
                <?php foreach ($visiteurs_par_pays as $vp): ?>
                    <li><?= htmlspecialchars($vp['country']) ?> : <?= $vp['total'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>

</body>

</html>