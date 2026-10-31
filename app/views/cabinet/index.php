<div class="container py-5">
    <?php if (!empty($toast)): ?>
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="liveToast" class="toast show bg-dark text-white border-gold" role="alert">
                <div class="toast-header bg-dark text-gold border-secondary">
                    <strong class="me-auto">Kingsman</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    <?= htmlspecialchars($toast) ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h2 class="text-gold fw-bold">ЛИЧНЫЙ КАБИНЕТ</h2>
            <p class="text-secondary">Добро пожаловать, <?= htmlspecialchars($_SESSION['user_name']) ?>!</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="/appointment/create" class="btn btn-gold">Создать онлайн-запись</a>
        </div>
    </div>

    <div class="card p-4">
        <h4 class="text-white mb-3">Ваши записи</h4>
        <?php if (empty($appointments)): ?>
            <p class="text-muted">У вас пока нет активных записей.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-dark table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Услуга</th>
                            <th>Мастер</th>
                            <th>Дата и время</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $app): ?>
                            <tr>
                                <td><?= htmlspecialchars($app['service_title']) ?></td>
                                <td><?= htmlspecialchars($app['barber_name']) ?></td>
                                <td><?= $app['appointment_date'] ?> в <?= $app['appointment_time'] ?></td>
                                <td>
                                    <?php 
                                        $statuses = [
                                            'pending' => ['В обработке', 'bg-warning text-dark'],
                                            'confirmed' => ['Подтверждено', 'bg-success text-white'],
                                            'cancelled' => ['Отменено', 'bg-danger text-white'],
                                            'completed' => ['Завершено', 'bg-secondary text-white']
                                        ];
                                        $st = $statuses[$app['status']] ?? [$app['status'], 'bg-light'];
                                    ?>
                                    <span class="badge <?= $st[1] ?>"><?= $st[0] ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>