<?php
session_start();
require_once 'Database.php';
require_once 'Animale.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$db = new Database();
$animal = new Animale();
$animal->pdo = $db->getPdo();
$animaux = $animalObj->list();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['nam'] ?? '');
    $food = trim($_POST['food'] ?? '');
    $habitat = intval($_POST['habitats'] ?? 0);

    $errors = [];

    if ($name === '') {
        $errors[] = "Le nom de l'animal est requis.";
    }

    if ($food === '') {
        $errors[] = "Le type d'alimentation est requis.";
    }

    if ($habitat <= 0) {
        $errors[] = "Veuillez choisir un habitat valide.";
    }

    $imageName = null;
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExt = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowed)) {
            $errors[] = "Format d'image non autorisé (jpg, png, gif).";
        } else {
            $imageName = time() . '_' . basename($_FILES['img']['name']);
            $uploadDir = __DIR__ . '/uploads/';
            move_uploaded_file($_FILES['img']['tmp_name'], $uploadDir . $imageName);
        }
    }

    if (empty($errors)) {
        $animal->setname($name);
        $animal->setalimentation($food);
        $animal->setidhabitat($habitat);
        $animal->setimage($imageName);

        if ($animal->creatAnimal()) {

            header("Location: admin_animaux.php?success=1");
            exit;
        } else {
            $errors[] = "Erreur lors de l'ajout de l'animal.";
        }
    }


    if (!empty($errors)) {
        foreach ($errors as $err) {
            echo "<p style='color:red;'>$err</p>";
        }
    }
}


?>


<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manage Animals - Zoo ASSAD</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;700;900&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;700&amp;display=swap"
        rel="stylesheet" />
    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Theme Config -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#11d45f",
                        "primary-dark": "#0ea64a",
                        "background-light": "#f8fcfa",
                        "background-dark": "#102217",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1c3024",
                        "text-main": "#0d1b13",
                        "text-secondary": "#4c9a6b",
                        "border-light": "#e7f3ec",
                        "border-dark": "#2a4234",
                    },
                    fontFamily: {
                        "display": ["Work Sans", "Noto Sans", "sans-serif"],
                        "body": ["Noto Sans", "sans-serif"],
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
</head>

<body
    class="bg-background-light dark:bg-background-dark text-text-main dark:text-white font-display transition-colors duration-200">
    <div class="relative flex min-h-screen flex-col overflow-x-hidden">
        <!-- Top Navigation -->
        <header
            class="w-full border-b border-gray-200 dark:border-gray-800 bg-white dark:bg-[#1a2e22] sticky top-0 z-50">
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
        <!-- Main Content Wrapper -->
        <div class="layout-container flex h-full grow flex-col">
            <div class="px-4 sm:px-10 lg:px-40 flex flex-1 justify-center py-5">
                <div class="layout-content-container flex flex-col max-w-[1200px] flex-1">

                    <!-- Page Heading & Actions -->
                    <div class="flex flex-col md:flex-row justify-between gap-6 px-4 py-4 items-start md:items-end">
                        <div class="flex flex-col gap-2">
                            <h1
                                class="text-text-main dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">
                                Animal Inventory</h1>
                            <p class="text-text-secondary text-base font-normal leading-normal max-w-lg">
                                Manage and oversee the zoo's animal collection, including health status, habitat
                                location, and
                                species details.</p>
                        </div>
                        <button id="addAnimalBtn"
                            class="flex shrink-0 min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-6 bg-primary text-text-main text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary-dark transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <span class="material-symbols-outlined text-[20px]">add</span>
                            <span class="truncate">Add New Animal</span>
                        </button>
                    </div>

                    <!-- Animal Cards Grid -->
                    <div id="animalGrid"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-4">
                        <?php foreach ($animaux as $row): ?>
                            <div
                                class="group flex flex-col bg-surface-light dark:bg-surface-dark rounded-xl overflow-hidden border border-border-light dark:border-border-dark shadow-sm hover:shadow-lg transition-all hover:scale-[1.02] duration-300">

                                <!-- Image + Habitat badge -->
                                <div class="relative h-48 overflow-hidden">
                                    <div
                                        class="absolute top-3 right-3 bg-white/90 dark:bg-black/60 backdrop-blur-sm px-2 py-1 rounded text-xs font-bold text-text-main dark:text-white flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px] text-primary">public</span>
                                        <?= htmlspecialchars($row['habitat_nom'] ?? 'N/A') ?>
                                    </div>
                                    <div class="w-full h-full bg-gray-200 bg-center bg-cover"
                                        style="background-image: url('uploads/<?= htmlspecialchars($row['image'] ?? 'default.png') ?>');">
                                    </div>
                                </div>

                                <!-- Contenu texte -->
                                <div class="p-4 flex flex-col flex-1 gap-3">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-xl font-bold text-text-main dark:text-white">
                                                <?= htmlspecialchars($row['name'] ?? 'Unnamed') ?>
                                            </h3>
                                            <span
                                                class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold border border-amber-200">
                                                <?= htmlspecialchars($row['habitat_nom'] ?? 'N/A') ?>
                                            </span>
                                        </div>
                                        <p class="text-text-secondary text-sm italic">
                                            <?= htmlspecialchars($row['alimentation'] ?? 'Unknown') ?>
                                        </p>
                                    </div>


                                    <div
                                        class="mt-auto pt-4 flex gap-2 border-t border-border-light dark:border-border-dark">
                                        <a href="delete_animal.php?id=<?= $row['id'] ?>"
                                            class="flex-1 flex items-center justify-center gap-2 h-9 rounded-lg border border-border-light dark:border-gray-600 bg-transparent text-text-main dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">edit</span> Edit
                                        </a>
                                        <a href="edit_animal.php?id=<?= $row['id'] ?>"
                                            class="flex items-center justify-center w-9 h-9 rounded-lg border border-red-100 bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                            onclick="return confirm('Are you sure you want to delete this animal?')"
                                            title="Delete">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Add Animal Form -->
                    <div id="addAnimalForm"
                        class="hidden relative flex min-h-screen w-full flex-col items-center justify-center bg-background-light dark:bg-background-dark p-4 sm:p-6 lg:p-8"
                        style='font-family: Lexend, "Noto Sans", sans-serif;'>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div
                                class="absolute inset-0 bg-background-light/50 dark:bg-background-dark/70 backdrop-blur-sm z-0">
                            </div>
                            <div
                                class="relative z-10 w-full max-w-2xl bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 font-display">
                                <div class="p-6 sm:p-8">
                                    <div
                                        class="flex items-start justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                                        <h2
                                            class="text-[#131811] dark:text-gray-100 tracking-light text-2xl font-bold leading-tight">
                                            Add New Animal
                                        </h2>
                                        <button type="button" id="closeForm"
                                            class="text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white transition-colors">
                                            <span class="material-symbols-outlined">close</span>
                                        </button>
                                    </div>
                                    <div class="mt-6 space-y-6">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                                            <div class="flex flex-col gap-6">
                                                <label class="flex flex-col w-full">
                                                    <p
                                                        class="text-[#131811] dark:text-gray-200 text-base font-medium leading-normal pb-2">
                                                        Animal's Name</p>
                                                    <input name="nam"
                                                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#131811] dark:text-gray-200 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-[#dfe6db] dark:border-gray-600 bg-white dark:bg-gray-800 focus:border-primary h-12 placeholder:text-[#6f8961] dark:placeholder:text-gray-400 p-3 text-base font-normal leading-normal"
                                                        placeholder="e.g., Leo the Lion" />
                                                </label>
                                                <label class="flex flex-col w-full">
                                                    <p
                                                        class="text-[#131811] dark:text-gray-200 text-base font-medium leading-normal pb-2">
                                                        Favorite Food</p>
                                                    <select name="food"
                                                        class="form-select flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#131811] dark:text-gray-200 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-[#dfe6db] dark:border-gray-600 bg-white dark:bg-gray-800 focus:border-primary h-12 p-3 text-base font-normal leading-normal">
                                                        <option value="">Select a food type</option>
                                                        <option value="Carnivore">Carnivore</option>
                                                        <option value="Herbivore">Herbivore</option>
                                                        <option value="Omnivore">Omnivore</option>
                                                    </select>
                                                </label>
                                                <label class="flex flex-col w-full">
                                                    <p
                                                        class="text-[#131811] dark:text-gray-200 text-base font-medium leading-normal pb-2">
                                                        Habitat</p>
                                                    <select name="habitats"
                                                        class="form-select flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#131811] dark:text-gray-200 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-[#dfe6db] dark:border-gray-600 bg-white dark:bg-gray-800 focus:border-primary h-12 p-3 text-base font-normal leading-normal">
                                                        <option value="1">Jungle</option>
                                                        <option value="2">Savannah</option>
                                                        <option value="3">Arctic</option>
                                                        <option value="4">Ocean</option>
                                                    </select>
                                                </label>
                                                <label class="flex flex-col w-full">
                                                    <p
                                                        class="text-[#131811] dark:text-gray-200 text-base font-medium leading-normal pb-2">
                                                        Image</p>
                                                    <input type="file" name="img"
                                                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#131811] dark:text-gray-200 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-[#dfe6db] dark:border-gray-600 bg-white dark:bg-gray-800 focus:border-primary h-12 placeholder:text-[#6f8961] dark:placeholder:text-gray-400 p-3 text-base font-normal leading-normal" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="flex justify-end items-center gap-4 pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                                        <button type="button" id="cancelAnimal"
                                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-11 px-6 bg-transparent text-gray-700 dark:text-gray-300 text-base font-bold leading-normal tracking-wide hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-11 px-6 bg-primary text-background-dark text-base font-bold leading-normal tracking-wide shadow-sm hover:brightness-110 transition-all">
                                            Save Animal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <script>
            const addAnimalBtn = document.getElementById('addAnimalBtn');
            const addAnimalForm = document.getElementById('addAnimalForm');
            const cancelAnimal = document.getElementById('cancelAnimal');
            const closeForm = document.getElementById('closeForm');

            addAnimalBtn.addEventListener('click', () => {
                addAnimalForm.classList.remove('hidden');
                addAnimalForm.scrollIntoView({ behavior: "smooth" });
            });

            cancelAnimal.addEventListener('click', () => addAnimalForm.classList.add('hidden'));
            closeForm.addEventListener('click', () => addAnimalForm.classList.add('hidden'));
        </script>
</body>

</html>