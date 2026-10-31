<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="text-gold fw-bold">НАШИ МАСТЕРА</h2>
        <hr class="w-25 mx-auto text-gold">
        <p class="text-secondary">Опытные барберы, которые создадут ваш индивидуальный стиль.</p>
    </div>

    <div class="row">
        <?php foreach ($barbers as $barber): ?>
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white border-secondary h-100 shadow-sm overflow-hidden barber-card">
                    <?php if (!empty($barber['photo'])): ?>
                        <div class="barber-img-wrapper position-relative" style="height: 280px; overflow: hidden;">
                            <img src="<?= htmlspecialchars($barber['photo']) ?>" 
                                 alt="<?= htmlspecialchars($barber['name']) ?>" 
                                 class="w-100 h-100 object-fit-cover transition-transform">
                            <div class="position-absolute bottom-0 start-0 w-100 h-25 bg-gradient-to-top"></div>
                        </div>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column text-center p-4">
                        <h5 class="card-title text-gold fw-bold mb-2"><?= htmlspecialchars($barber['name']) ?></h5>
                        <p class="text-secondary small fw-semibold mb-3"><?= htmlspecialchars($barber['specialization']) ?></p>
                        <div class="mt-auto pt-2 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Опыт: <strong><?= $barber['experience_years'] ?> лет</strong></span>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="/appointment/create" class="btn btn-outline-warning btn-sm px-3">Записаться</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>