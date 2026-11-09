<section class="py-5 bg-black text-white text-center border-bottom border-secondary">
    <div class="container py-5">
        <h1 class="display-3 text-gold fw-bold text-uppercase mb-3">KINGSMAN BARBERSHOP</h1>
        <p class="lead text-light mb-4">Премиальный уход, классические традиции и безупречный стиль в каждом движении.</p>
        <a href="/appointment/create" class="btn btn-gold btn-lg fw-bold px-5 py-3">ЗАПИСАТЬСЯ ОНЛАЙН</a>
    </div>
</section>

<section class="py-5 bg-dark text-white">
    <div class="container py-4">
        <h2 class="text-gold text-center text-uppercase fw-bold mb-2">Наши услуги</h2>
        <p class="text-muted text-center mb-5">Качественный уход за вашими волосами и бородой</p>

        <div class="row g-4">
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $service): ?>
                    <div class="col-md-4">
                        <div class="card bg-black text-white border-secondary h-100 p-4 shadow-sm">
                            <h4 class="card-title text-gold mb-3"><?= htmlspecialchars($service['title']) ?></h4>
                            <p class="card-text text-secondary mb-4"><?= htmlspecialchars($service['description'] ?? 'Премиум услуга от наших мастеров.') ?></p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="fs-4 fw-bold text-white"><?= number_format($service['price'], 0, '', ' ') ?> ₽</span>
                                <a href="/appointment/create" class="btn btn-outline-warning btn-sm">Записаться</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12"><p class="text-center text-muted">Список услуг временно пуст.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="py-5 bg-dark text-white border-top border-secondary">
    <div class="container py-4">
        <h2 class="text-gold text-center text-uppercase fw-bold mb-2">Наши работы</h2>
        <p class="text-muted text-center mb-5">Примеры стрижек и укладок от мастеров Kingsman</p>
        
        <div class="row g-4">
            <?php if (!empty($gallery)): ?>
                <?php foreach ($gallery as $item): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="card bg-black text-white border-secondary h-100 overflow-hidden shadow-sm">
                            <img src="<?= htmlspecialchars($item['image']) ?>" 
                                class="card-img-top object-fit-cover" 
                                alt="Работа барбера"
                                style="height: 260px;">
                            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                                <span class="card-text small text-secondary">
                                    <?= htmlspecialchars($item['title'] ?? 'Стрижка & Укладка') ?>
                                </span>
                                <?php if (!empty($item['barber_name'])): ?>
                                    <span class="badge bg-gold text-dark"><?= htmlspecialchars($item['barber_name']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12"><p class="text-center text-muted">Галерея пока пуста.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="py-5 bg-dark text-white border-top border-secondary">
    <div class="container py-4">
        <h2 class="text-gold text-center text-uppercase fw-bold mb-2">Отзывы гостей</h2>
        <p class="text-muted text-center mb-4">Что о нас говорят постоянные клиенты</p>

        <div class="row justify-content-center mb-5">
            <div class="col-md-6 text-center">
                <div class="p-3 bg-black border border-secondary rounded shadow-sm d-inline-block px-4">
                    <span class="fs-4 text-gold fw-bold me-2">★ <?= number_format($reviewStats['rating'] ?? 5.0, 1) ?></span>
                    <span class="text-muted border-start border-secondary ps-3 ms-2">
                        Всего отзывов: <strong class="text-white"><?= $reviewStats['total'] ?? 0 ?></strong>
                    </span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="col-md-4">
                        <div class="card bg-black text-white border-secondary h-100 p-4 shadow-sm">
                            <div class="mb-3 text-gold">
                                <?php 
                                    $rating = (int)($review['rating'] ?? 5);
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $rating ? '★' : '☆';
                                    }
                                ?>
                            </div>
                            <p class="card-text fst-italic text-light mb-4">
                                "<?= htmlspecialchars($review['comment']) ?>"
                            </p>
                            <div class="mt-auto pt-3 border-top border-secondary d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="text-gold d-block"><?= htmlspecialchars($review['client_name']) ?></strong>
                                    <?php if (!empty($review['barber_name'])): ?>
                                        <small class="text-muted">Мастер: <?= htmlspecialchars($review['barber_name']) ?></small>
                                    <?php endif; ?>
                                </div>
                                <small class="text-muted"><?= date('d.m.Y', strtotime($review['created_at'])) ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12"><p class="text-center text-muted">Отзывов пока нет.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>