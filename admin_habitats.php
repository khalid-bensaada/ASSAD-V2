<?php
session_start();
require_once 'Database.php';
require_once 'Habitat.php';


if (!isset($_SESSION['user']) || $_SESSION['user']['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}


$db = new Database();
$pdo = $db->getPdo();


$habitat = new Habitat($pdo);


if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $habitat->setIdHab($id) = intval($_GET['delete']);
    $habitat->deleteHabitat();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['add'])) {
        $name = trim($_POST['name'] ?? '');
        $climate = trim($_POST['climate'] ?? '');
        $zone = trim($_POST['zone'] ?? '');
        $description = trim($_POST['description'] ?? '');


        $errors = [];
        if ($name === '')
            $errors[] = "";
        if ($climate === '')
            $errors[] = "";
        if ($zone === '')
            $errors[] = "";

        if (empty($errors)) {
            $habitat->setHabName($name) ;
            $habitat->typeclimat = $climate;
            $habitat->setZoneZoo($zone)  ;
            $habitat->setDescription($description) ;
            $habitat->creathabitat();
        }
    }


    if (isset($_POST['edit'])) {
        $id = intval($_POST['edit_id']);
        $name = trim($_POST['name'] ?? '');
        $climate = trim($_POST['climate'] ?? '');
        $zone = trim($_POST['zone'] ?? '');
        $description = trim($_POST['description'] ?? '');

        $errors = [];
        if ($name === '')
            $errors[] = "";
        if ($climate === '')
            $errors[] = "";
        if ($zone === '')
            $errors[] = "";

        if (empty($errors)) {
            $habitat->setIdHab($id);
            $habitat->setHabName($name);
            $habitat->typeclimat = $climate;
            $habitat->setZoneZoo($zone);
            $habitat->setDescription($description);
            $habitat->updateHabitat();
        }
    }
}


$stmt = $pdo->query("SELECT * FROM habitats ORDER BY hab_name");
$habitats = $stmt;
?>



<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Habitats - Zoo ASSAD</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Noto+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
</head>

<body
    class="bg-background-light dark:bg-background-dark text-[#111714] dark:text-white font-display min-h-screen flex flex-col overflow-x-hidden">


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



    <main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-40">
        <div class="w-full max-w-6xl flex flex-col gap-6">
            <!-- Heading & Add Button -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900 dark:text-white">Habitat
                    Administration</h1>
                <button id="openForm"
                    class="bg-primary hover:bg-green-400 text-[#0d331a] transition-colors h-11 px-6 rounded-lg font-bold text-sm flex items-center gap-2 shadow-sm shadow-green-500/20">
                    <span class="material-symbols-outlined">add</span> Add New Habitat
                </button>
            </div>

            <!-- Search -->
            <div class="w-full md:max-w-md">
                <div
                    class="relative flex items-center w-full h-12 rounded-lg bg-white dark:bg-[#1a2e22] border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden focus-within:ring-2 focus-within:ring-primary focus-within:border-primary transition-all">
                    <div class="grid place-items-center h-full w-12 text-gray-400 dark:text-gray-500">
                        <span class="material-symbols-outlined">search</span>
                    </div>
                    <input id="search" placeholder="Search habitats..." type="text"
                        class="peer h-full w-full outline-none text-sm text-gray-700 dark:text-gray-200 pr-2 bg-transparent placeholder-gray-400 dark:placeholder-gray-500 font-normal" />
                </div>
            </div>

            <!-- Table -->
            <div
                class="w-full overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-[#1a2e22] shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="habitatsTable">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700/50 bg-gray-50/50 dark:bg-white/5">
                                <th
                                    class="p-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Name</th>
                                <th
                                    class="p-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Climate</th>
                                <th
                                    class="p-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Zone</th>
                                <th
                                    class="p-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Description</th>
                                <th
                                    class="p-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <div id="habitatGrid"
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-4">
                            <?php while ($row = $habitats->fetch_assoc()): ?>
                                <div
                                    class="group flex flex-col bg-surface-light dark:bg-surface-dark rounded-xl overflow-hidden border border-border-light dark:border-border-dark shadow-sm hover:shadow-lg transition-all hover:scale-[1.02] duration-300">
                                    <div class="p-4 flex flex-col flex-1 gap-3">
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-xl font-bold text-text-main dark:text-white">
                                                <?= htmlspecialchars($row['hab_name']) ?>
                                            </h3>
                                            <span
                                                class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold border border-amber-200">
                                                <?= htmlspecialchars($row['typeclimat']) ?>
                                            </span>
                                        </div>
                                        <p class="text-text-secondary text-sm italic">
                                            <?= htmlspecialchars($row['zonezoo']) ?>
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3">
                                            <?= htmlspecialchars($row['description']) ?>
                                        </p>
                                        <div
                                            class="mt-auto pt-4 flex gap-2 border-t border-border-light dark:border-border-dark">
                                            <button
                                                onclick="openEditModal(<?= $row['id_hab'] ?>, '<?= htmlspecialchars($row['hab_name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['typeclimat'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['zonezoo'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>')"
                                                class="flex-1 flex items-center justify-center gap-2 h-9 rounded-lg border border-border-light dark:border-gray-600 bg-transparent text-text-main dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">edit</span> Edit
                                            </button>
                                            <a href="?delete=<?= $row['id_hab'] ?>"
                                                onclick="return confirm('Delete this habitat?')"
                                                class="flex items-center justify-center w-9 h-9 rounded-lg border border-red-100 bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                                title="Delete">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>

                    </table>
                </div>
            </div>

            <!-- Add Habitat Form Modal -->
            <div id="addFormModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                <form method="POST" class="bg-white dark:bg-gray-900 rounded-xl p-6 w-full max-w-md space-y-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Add New Habitat</h2>
                    <input type="text" name="name" placeholder="Habitat Name" required
                        class="w-full p-2 rounded border border-gray-300 dark:border-gray-700" />
                    <input type="text" name="climate" placeholder="Climate Type" required
                        class="w-full p-2 rounded border border-gray-300 dark:border-gray-700" />
                    <input type="text" name="zone" placeholder="Zone" required
                        class="w-full p-2 rounded border border-gray-300 dark:border-gray-700" />
                    <textarea name="description" placeholder="Description"
                        class="w-full p-2 rounded border border-gray-300 dark:border-gray-700"></textarea>
                    <div class="flex justify-end gap-2">
                        <button type="button" id="closeForm"
                            class="px-4 py-2 rounded bg-gray-300 dark:bg-gray-700">Cancel</button>
                        <button type="submit" name="add"
                            class="px-4 py-2 rounded bg-primary text-black font-bold">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Open/close modal
        const openFormBtn = document.getElementById('openForm');
        const addFormModal = document.getElementById('addFormModal');
        const closeFormBtn = document.getElementById('closeForm');

        openFormBtn.onclick = () => addFormModal.classList.remove('hidden');
        closeFormBtn.onclick = () => addFormModal.classList.add('hidden');

        // Search filter
        document.getElementById('search').addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('#habitatsTable tbody tr').forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                row.style.display = name.includes(filter) ? '' : 'none';
            });
        });
    </script>

</body>

</html>