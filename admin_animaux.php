<?php

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
            class="flex items-center justify-between whitespace-nowrap border-b border-solid border-border-light dark:border-border-dark px-10 py-3 bg-surface-light dark:bg-surface-dark sticky top-0 z-50">
            <div class="flex items-center gap-4 text-text-main dark:text-white">
                <div class="size-8 text-primary">
                    <svg class="w-full h-full" fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.8261 17.4264C16.7203 18.1174 20.2244 18.5217 24 18.5217C27.7756 18.5217 31.2797 18.1174 34.1739 17.4264C36.9144 16.7722 39.9967 15.2331 41.3563 14.1648L24.8486 40.6391C24.4571 41.267 23.5429 41.267 23.1514 40.6391L6.64374 14.1648C8.00331 15.2331 11.0856 16.7722 13.8261 17.4264Z"
                            fill="currentColor"></path>
                        <path clip-rule="evenodd"
                            d="M39.998 12.236C39.9944 12.2537 39.9875 12.2845 39.9748 12.3294C39.9436 12.4399 39.8949 12.5741 39.8346 12.7175C39.8168 12.7597 39.7989 12.8007 39.7813 12.8398C38.5103 13.7113 35.9788 14.9393 33.7095 15.4811C30.9875 16.131 27.6413 16.5217 24 16.5217C20.3587 16.5217 17.0125 16.131 14.2905 15.4811C12.0012 14.9346 9.44505 13.6897 8.18538 12.8168C8.17384 12.7925 8.16216 12.767 8.15052 12.7408C8.09919 12.6249 8.05721 12.5114 8.02977 12.411C8.00356 12.3152 8.00039 12.2667 8.00004 12.2612C8.00004 12.261 8 12.2607 8.00004 12.2612C8.00004 12.2359 8.0104 11.9233 8.68485 11.3686C9.34546 10.8254 10.4222 10.2469 11.9291 9.72276C14.9242 8.68098 19.1919 8 24 8C28.8081 8 33.0758 8.68098 36.0709 9.72276C37.5778 10.2469 38.6545 10.8254 39.3151 11.3686C39.9006 11.8501 39.9857 12.1489 39.998 12.236ZM4.95178 15.2312L21.4543 41.6973C22.6288 43.5809 25.3712 43.5809 26.5457 41.6973L43.0534 15.223C43.0709 15.1948 43.0878 15.1662 43.104 15.1371L41.3563 14.1648C43.104 15.1371 43.1038 15.1374 43.104 15.1371L43.1051 15.135L43.1065 15.1325L43.1101 15.1261L43.1199 15.1082C43.1276 15.094 43.1377 15.0754 43.1497 15.0527C43.1738 15.0075 43.2062 14.9455 43.244 14.8701C43.319 14.7208 43.4196 14.511 43.5217 14.2683C43.6901 13.8679 44 13.0689 44 12.2609C44 10.5573 43.003 9.22254 41.8558 8.2791C40.6947 7.32427 39.1354 6.55361 37.385 5.94477C33.8654 4.72057 29.133 4 24 4C18.867 4 14.1346 4.72057 10.615 5.94478C8.86463 6.55361 7.30529 7.32428 6.14419 8.27911C4.99695 9.22255 3.99999 10.5573 3.99999 12.2609C3.99999 13.1275 4.29264 13.9078 4.49321 14.3607C4.60375 14.6102 4.71348 14.8196 4.79687 14.9689C4.83898 15.0444 4.87547 15.1065 4.9035 15.1529C4.91754 15.1762 4.92954 15.1957 4.93916 15.2111L4.94662 15.223L4.95178 15.2312ZM35.9868 18.996L24 38.22L12.0131 18.996C12.4661 19.1391 12.9179 19.2658 13.3617 19.3718C16.4281 20.1039 20.0901 20.5217 24 20.5217C27.9099 20.5217 31.5719 20.1039 34.6383 19.3718C35.082 19.2658 35.5339 19.1391 35.9868 18.996Z"
                            fill="currentColor" fill-rule="evenodd"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-bold leading-tight tracking-[-0.015em]">Zoo ASSAD Admin</h2>
            </div>
            <div class="flex flex-1 justify-end gap-8">
                <div class="hidden md:flex items-center gap-9">
                    <a class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal hover:text-primary transition-colors"
                        href="admin.php">Dashboard</a>
                    <a class="text-primary text-sm font-bold leading-normal" href="m_animal.php">Animals</a>
                    <a class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal hover:text-primary transition-colors"
                        href="m_habitat.php">Habitats</a>
                    <a class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal hover:text-primary transition-colors"
                        href="m_users.php">Users</a>
                </div>
                <div class="flex items-center gap-4">
                    <button
                        class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-text-main text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary-dark transition-colors">
                        <span class="truncate">Logout</span>
                    </button>
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-primary"
                        data-alt="Admin profile picture"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBDbsi97uiWI7IxnmTngu8Sqq4RydPMpjerWAgJy1RiViqhKHlSlsEWEvoy55ZeexU5b41UmVz0ED4_ukAeaTJmEmUnz5mcxaRx2-B1hv2vmeLopuu-Czq1CytPFkSZpLxerjKjM4HgGotVhRvfyaIEKKzlQMljeD3Ihosc8esjtkjLFPZy2jQCd6YhigBEz0E-PFPWwjScKvb6LLzRYRS_QRFB9098UYSJvCDeRQTiJBjGzYVpzAxvzUnhM52XWL8l4UZPrAjb0aM");'>
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
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div
                                class="group flex flex-col bg-surface-light dark:bg-surface-dark rounded-xl overflow-hidden border border-border-light dark:border-border-dark shadow-sm hover:shadow-lg transition-all hover:scale-[1.02] duration-300">
                                <div class="relative h-48 overflow-hidden">
                                    <div
                                        class="absolute top-3 right-3 bg-white/90 dark:bg-black/60 backdrop-blur-sm px-2 py-1 rounded text-xs font-bold text-text-main dark:text-white flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px] text-primary">public</span>
                                        <?= htmlspecialchars($row['hab_name']) ?>
                                    </div>
                                    <div class="w-full h-full bg-gray-200 bg-center bg-cover"
                                        style="background-image: url('images/<?= htmlspecialchars($row['image']) ?>');">
                                    </div>
                                </div>
                                <div class="p-4 flex flex-col flex-1 gap-3">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-xl font-bold text-text-main dark:text-white">
                                                <?= htmlspecialchars($row['name_animal']) ?></h3>
                                            <span
                                                class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold border border-amber-200">
                                                <?= htmlspecialchars($row['hab_name']) ?>
                                            </span>
                                        </div>
                                        <p class="text-text-secondary text-sm italic">
                                            <?= htmlspecialchars($row['alimentation']) ?></p>
                                    </div>
                                    <div
                                        class="mt-auto pt-4 flex gap-2 border-t border-border-light dark:border-border-dark">
                                        <button
                                            class="flex-1 flex items-center justify-center gap-2 h-9 rounded-lg border border-border-light dark:border-gray-600 bg-transparent text-text-main dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">edit</span> Edit
                                        </button>
                                        <button
                                            class="flex items-center justify-center w-9 h-9 rounded-lg border border-red-100 bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                            title="Delete">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
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