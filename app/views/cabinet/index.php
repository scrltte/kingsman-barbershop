<div class="container py-5 text-white">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="text-gold fw-bold text-uppercase">Личный кабинет</h1>
            <p class="text-muted">Добро пожаловать, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Гость') ?>!</p>
        </div>
        <div class="col-text-end">
            <a href="/appointment/create" class="btn btn-gold fw-bold">Новая запись</a>
        </div>
    </div>

    <?php if (!empty($_SESSION['toast'])): ?>
        <div class="alert alert-success bg-dark text-success border-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['toast']) ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['toast']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger bg-dark text-danger border-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <h3 class="text-gold mb-3">Мои записи</h3>

    <div class="row">
        <div class="col-12">
            <?php if (!empty($appointments)): ?>
                <?php foreach ($appointments as $app): ?>
                    <div class="card bg-black text-white border-secondary mb-3 p-3 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="text-gold mb-1"><?= htmlspecialchars($app['service_title']) ?></h5>
                                <p class="text-muted small mb-0">
                                    Мастер: <span class="text-white"><?= htmlspecialchars($app['barber_name']) ?></span> | 
                                    Дата: <span class="text-white"><?= htmlspecialchars($app['appointment_date']) ?></span> в 
                                    <span class="text-white"><?= htmlspecialchars($app['appointment_time']) ?></span>
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end align-items-center justify-content-between">
                                <?php 
                                    $statusClass = 'bg-secondary';
                                    $statusText = $app['status'];
                                    if ($app['status'] === 'pending') { $statusClass = 'bg-warning text-dark'; $statusText = 'Ожидает'; }
                                    elseif ($app['status'] === 'confirmed') { $statusClass = 'bg-info text-dark'; $statusText = 'Подтверждена'; }
                                    elseif ($app['status'] === 'completed') { $statusClass = 'bg-success'; $statusText = 'Завершена'; }
                                    elseif ($app['status'] === 'cancelled') { $statusClass = 'bg-danger'; $statusText = 'Отменена'; }
                                ?>
                                <span class="badge <?= $statusClass ?> fs-6"><?= $statusText ?></span>

                                <?php if ($app['status'] === 'completed'): ?>
                                    <?php if (\App\Models\Review::existsForAppointment($app['id'])): ?>
                                        <span class="badge bg-secondary ms-2">Отзыв оставлен</span>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-outline-warning ms-2 fw-bold" data-bs-toggle="modal" data-bs-target="#reviewModal<?= $app['id'] ?>">Оставить отзыв</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if ($app['status'] === 'completed' && !\App\Models\Review::existsForAppointment($app['id'])): ?>
                        <div class="modal fade text-dark" id="reviewModal<?= $app['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content bg-dark text-white border-secondary">
                                    <form action="/cabinet/review" method="POST">
                                        <input type="hidden" name="appointment_id" value="<?= $app['id'] ?>">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title text-gold">Оцените ваш визит</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label text-secondary">Рейтинг (от 1 до 5 звезд)</label>
                                                <select name="rating" class="form-select bg-dark text-white border-secondary">
                                                    <option value="5">★★★★★ (5 - Отлично)</option>
                                                    <option value="4">★★★★☆ (4 - Хорошо)</option>
                                                    <option value="3">★★★☆☆ (3 - Нормально)</option>
                                                    <option value="2">★★☆☆☆ (2 - Плохо)</option>
                                                    <option value="1">★☆☆☆☆ (1 - Ужасно)</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-secondary">Ваш отзыв о мастере</label>
                                                <textarea name="comment" class="form-control bg-dark text-white border-secondary" rows="3" required placeholder="Напишите пару слов о качестве стрижки и сервисе..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-secondary">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Отмена</button>
                                            <button type="submit" class="btn btn-gold fw-bold">Отправить отзыв</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card bg-black text-white border-secondary p-4 text-center">
                    <p class="text-muted mb-3">У вас пока нет активных или прошедших записей.</p>
                    <a href="/appointment/create" class="btn btn-gold btn-sm mx-auto fw-bold">Записаться на первую стрижку</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>