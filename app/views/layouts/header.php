<!DOCTYPE html>
<html lang="ru" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Барбершоп «Kingsman»</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Кастомные стили проекта -->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="d-flex flex-column h-100">

<header>
    <nav class="navbar navbar-expand-lg navbar-dark px-4">
        <div class="container-fluid">
            <a class="navbar-brand text-gold fw-bold tracking-wider" href="/">KINGSMAN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="/">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="/services">Услуги</a></li>
                    <li class="nav-item"><a class="nav-link" href="/barbers">Мастера</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contacts">Контакты</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item ms-3">
                            <a class="btn btn-outline-light btn-sm" href="<?= $_SESSION['user_role'] === 'admin' ? '/admin' : '/cabinet' ?>">Личный кабинет</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-outline-danger btn-sm" href="/logout">Выход</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-3">
                            <a class="btn btn-gold btn-sm" href="/login">Войти</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="flex-shrink-0">