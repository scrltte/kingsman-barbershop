<!-- Hero секция -->
<div class="p-5 mb-4 bg-dark text-white rounded-0 border-bottom border-secondary hero-section">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold text-gold">БУДЬ В ФОРМЕ С KINGSMAN</h1>
        <p class="col-lg-8 mx-auto fs-5 text-light mb-4">Классические стрижки, опасное бритье и профессиональный уход за бородой в лучших традициях мужского стиля.</p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a class="btn btn-gold btn-lg px-4" href="/appointment/create">Онлайн-запись</a>
        <?php else: ?>
            <a class="btn btn-gold btn-lg px-4" href="/login">Войти для записи</a>
        <?php endif; ?>
    </div>
</div>

<div class="container py-5">
    <!-- Популярные услуги -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="text-gold fw-bold">ПОПУЛЯРНЫЕ УСЛУГИ</h2>
            <hr class="w-25 mx-auto text-gold">
        </div>
        <?php foreach ($services as $service): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-gold"><?= htmlspecialchars($service['title']) ?></h5>
                        <p class="card-text text-secondary flex-grow-1"><?= htmlspecialchars($service['description']) ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fs-5 fw-bold text-white"><?= number_format($service['price'], 0, '', ' ') ?> ₽</span>
                            <span class="text-muted small"><?= $service['duration_minutes'] ?> мин.</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Наши мастера -->
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="text-gold fw-bold">НАШИ МАСТЕРА</h2>
            <hr class="w-25 mx-auto text-gold">
        </div>
        <?php foreach ($barbers as $barber): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title text-gold mt-2"><?= htmlspecialchars($barber['name']) ?></h5>
                        <p class="text-secondary small"><?= htmlspecialchars($barber['specialization']) ?></p>
                        <p class="text-muted">Опыт: <?= $barber['experience_years'] ?> лет</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>