<?php

declare(strict_types=1);

require __DIR__ . '/../app/autoload.php';

if (isset($_POST['delete-account'])) {
    $userId = $_GET['id'];
    deleteUser($pdo, $userId);
    unset($_SESSION['user']);
    redirect('/index.php');
}
