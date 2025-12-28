<?php
session_start();
require_once 'Database.php';
require_once 'Animale.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: admin_animaux.php');
    exit;
}

$id = intval($_GET['id']);
$db = new Database();
$animal = new Animale();
$animal->pdo = $db->getPdo();


$stmt = $animal->pdo->prepare("SELECT * FROM animaux WHERE id = ?");
$stmt->execute([$id]);
$current = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$current) {
    header('Location: admin_animaux.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['nam'] ?? '');
    $food = trim($_POST['food'] ?? '');
    $habitat = intval($_POST['habitats'] ?? 0);

    if ($name === '')
        $errors[] = "Le nom est requis.";
    if ($food === '')
        $errors[] = "L'alimentation est requise.";
    if ($habitat <= 0)
        $errors[] = "Veuillez choisir un habitat.";

    
    $imageName = $current['image'];
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $imageName = time() . '_' . basename($_FILES['img']['name']);
            move_uploaded_file($_FILES['img']['tmp_name'], __DIR__ . '/uploads/' . $imageName);
        } else {
            $errors[] = "Format image non autorisé.";
        }
    }

    if (empty($errors)) {
        $animal->setAid($id);
        $animal->setname($name);
        $animal->setalimentation($food);
        $animal->setidhabitat($habitat);
        $animal->setimage($imageName);
        $animal->editanimale(); 
    }
}
?>

<div id="editAnimalForm"
    class="relative flex min-h-screen w-full flex-col items-center justify-center bg-background-light dark:bg-background-dark p-4 sm:p-6 lg:p-8">
    <form method="POST" enctype="multipart/form-data"
        class="relative z-10 w-full max-w-2xl bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 font-display p-6 sm:p-8">
        <h2 class="text-2xl font-bold text-[#131811] dark:text-gray-100 mb-4">Edit Animal</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            <label class="flex flex-col">
                <p class="pb-2">Animal's Name</p>
                <input name="nam" value="<?= htmlspecialchars($current['name_animal']) ?>"
                    class="form-input h-12 p-3 rounded-lg" placeholder="e.g., Leo the Lion">
            </label>

            <label class="flex flex-col">
                <p class="pb-2">Favorite Food</p>
                <select name="food" class="form-select h-12 p-3 rounded-lg">
                    <option value="">Select a food type</option>
                    <option value="Carnivore" <?= $current['alimentation'] == 'Carnivore' ? 'selected' : '' ?>>Carnivore
                    </option>
                    <option value="Herbivore" <?= $current['alimentation'] == 'Herbivore' ? 'selected' : '' ?>>Herbivore
                    </option>
                    <option value="Omnivore" <?= $current['alimentation'] == 'Omnivore' ? 'selected' : '' ?>>Omnivore</option>
                </select>
            </label>

            <label class="flex flex-col">
                <p class="pb-2">Habitat</p>
                <select name="habitats" class="form-select h-12 p-3 rounded-lg">
                    <option value="1" <?= $current['id_habitat'] == 1 ? 'selected' : '' ?>>Jungle</option>
                    <option value="2" <?= $current['id_habitat'] == 2 ? 'selected' : '' ?>>Savannah</option>
                    <option value="3" <?= $current['id_habitat'] == 3 ? 'selected' : '' ?>>Arctic</option>
                    <option value="4" <?= $current['id_habitat'] == 4 ? 'selected' : '' ?>>Ocean</option>
                </select>
            </label>

            <label class="flex flex-col">
                <p class="pb-2">Image</p>
                <input type="file" name="img" class="form-input h-12 p-3 rounded-lg">
                <small>Current: <?= htmlspecialchars($current['image']) ?></small>
            </label>
        </div>

        <div class="flex justify-end gap-4 mt-6">
            <a href="admin_animaux.php" class="px-6 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:brightness-110">Update
                Animal</button>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="mt-4 text-red-600">
                <?php foreach ($errors as $err)
                    echo "<p>$err</p>"; ?>
            </div>
        <?php endif; ?>
    </form>
</div>