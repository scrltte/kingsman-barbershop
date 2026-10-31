<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="text-gold fw-bold">НАШИ УСЛУГИ</h2>
        <hr class="w-25 mx-auto text-gold">
        <p class="text-secondary">Профессиональный уход, классические стрижки и премиальный сервис.</p>
    </div>

    <div class="row">
        <?php foreach ($services as $service): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-gold"><?= htmlspecialchars($service['title']) ?></h5>
                        <p class="card-text text-secondary flex-grow-1"><?= htmlspecialchars($service['description']) ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fs-5 fw-bold text-white"><?= number_format($service['price'], 0, '', ' ') ?> ₽</span>
                            <span class="text-muted small"><?= $service['duration_minutes'] ?> мин.</span>
                        </div>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="/appointment/create" class="btn btn-gold btn-sm mt-3">Записаться</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>