<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
        <div>
            <h2 class="text-gold fw-bold mb-1">ЛИЧНЫЙ КАБИНЕТ</h2>
            <p class="text-secondary mb-0">Добро пожаловать, <span class="text-white fw-semibold"><?= htmlspecialchars($userName) ?></span>!</p>
        </div>
        <a href="/appointment/create" class="btn btn-gold px-4">+ Новая запись</a>
    </div>

    <?php if (!empty($_SESSION['toast'])): ?>
        <div class="alert alert-success bg-dark text-success border-success mb-4 alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['toast']) ?>
            <?php unset($_SESSION['toast']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['toast_error'])): ?>
        <div class="alert alert-danger bg-dark text-danger border-danger mb-4 alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['toast_error']) ?>
            <?php unset($_SESSION['toast_error']); ?>
        </div>
    <?php endif; ?>

    <div class="card bg-dark text-white border-secondary shadow-sm p-4">
        <h4 class="text-gold mb-4">Мои записи на визит</h4>

        <?php if (empty($appointments)): ?>
            <div class="text-center py-5">
                <p class="text-secondary mb-3">У вас пока нет активных или завершенных записей.</p>
                <a href="/appointment/create" class="btn btn-outline-warning">Записаться прямо сейчас</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle">
                    <thead>
                        <tr class="text-secondary border-secondary">
                            <th>Мастер</th>
                            <th>Услуга</th>
                            <th>Дата и время</th>
                            <th>Стоимость</th>
                            <th>Статус</th>
                            <th class="text-end">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $app): ?>
                            <tr class="border-secondary border-opacity-25">
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if (!empty($app['barber_photo'])): ?>
                                            <img src="<?= htmlspecialchars($app['barber_photo']) ?>" 
                                                 alt="" 
                                                 class="rounded-circle object-fit-cover" 
                                                 style="width: 45px; height: 45px;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-dark fw-bold" 
                                                 style="width: 45px; height: 45px;">
                                                <?= mb_substr($app['barber_name'], 0, 1) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-semibold text-white"><?= htmlspecialchars($app['barber_name']) ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($app['barber_specialization']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium text-gold"><?= htmlspecialchars($app['service_title']) ?></span>
                                </td>
                                <td>
                                    <div class="text-white"><?= date('d.m.Y', strtotime($app['appointment_date'])) ?></div>
                                    <small class="text-muted">в <?= date('H:i', strtotime($app['appointment_time'])) ?></small>
                                </td>
                                <td class="fw-bold text-white">
                                    <?= number_format($app['service_price'], 0, '', ' ') ?> ₽
                                </td>
                                <td>
                                    <?php 
                                        $statusMap = [
                                            'pending' => ['В обработке', 'bg-warning text-dark'],
                                            'confirmed' => ['Подтверждено', 'bg-success text-white'],
                                            'completed' => ['Завершено', 'bg-secondary text-white'],
                                            'cancelled' => ['Отменено', 'bg-danger text-white']
                                        ];
                                        $st = $statusMap[$app['status']] ?? [$app['status'], 'bg-light text-dark'];
                                    ?>
                                    <span class="badge <?= $st[1] ?> px-3 py-2"><?= $st[0] ?></span>
                                </td>
                                <td class="text-end">
                                    <?php if (in_array($app['status'], ['pending', 'confirmed'])): ?>
                                        <form action="/cabinet" method="POST" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите отменить эту запись?');">
                                            <input type="hidden" name="action" value="cancel_appointment">
                                            <input type="hidden" name="appointment_id" value="<?= $app['id'] ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-3">Отменить</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted small">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>