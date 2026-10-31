<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="text-gold fw-bold">ПАНЕЛЬ АДМИНИСТРАТОРА</h2>
            <p class="text-secondary">Управление записями, услугами и персоналом барбершопа «Kingsman»</p>
        </div>
    </div>

    <!-- Навигационные вкладки -->
    <ul class="nav nav-tabs mb-4 border-secondary" id="adminTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-gold bg-dark border-secondary" id="appointments-tab" data-bs-toggle="tab" data-bs-target="#appointments" type="button" role="tab">Записи клиентов</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-gold bg-dark border-secondary" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab">Услуги</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-gold bg-dark border-secondary" id="barbers-tab" data-bs-toggle="tab" data-bs-target="#barbers" type="button" role="tab">Мастера</button>
        </li>
    </ul>

    <div class="tab-content" id="adminTabContent">
        
        <!-- Секция 1: Записи -->
        <div class="tab-pane fade show active" id="appointments" role="tabpanel">
            <div class="card p-4 shadow-sm">
                <h4 class="text-white mb-3">Все записи клиентов</h4>
                <?php if (empty($appointments)): ?>
                    <p class="text-muted">В системе пока нет записей.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Клиент</th>
                                    <th>Телефон</th>
                                    <th>Услуга</th>
                                    <th>Мастер</th>
                                    <th>Дата / Время</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $app): ?>
                                    <tr>
                                        <td><?= $app['id'] ?></td>
                                        <td><?= htmlspecialchars($app['client_name']) ?></td>
                                        <td><?= htmlspecialchars($app['phone']) ?></td>
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
                                        <td>
                                            <form action="/admin" method="POST" class="d-inline-flex gap-1">
                                                <input type="hidden" name="id" value="<?= $app['id'] ?>">
                                                <select name="status" class="form-select form-select-sm bg-dark text-white border-secondary" style="width: 130px;" onchange="this.form.submit()">
                                                    <option value="pending" <?= $app['status'] === 'pending' ? 'selected' : '' ?>>В обработке</option>
                                                    <option value="confirmed" <?= $app['status'] === 'confirmed' ? 'selected' : '' ?>>Подтвердить</option>
                                                    <option value="completed" <?= $app['status'] === 'completed' ? 'selected' : '' ?>>Завершить</option>
                                                    <option value="cancelled" <?= $app['status'] === 'cancelled' ? 'selected' : '' ?>>Отменить</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Секция 2: Услуги -->
        <div class="tab-pane fade" id="services" role="tabpanel">
            <div class="row">
                <!-- Форма добавления услуги -->
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-sm">
                        <h4 class="text-white mb-3">Добавить услугу</h4>
                        <form action="/admin" method="POST">
                            <input type="hidden" name="action" value="add_service">
                            <div class="mb-3">
                                <label class="form-label text-secondary">Название</label>
                                <input type="text" name="title" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary">Описание</label>
                                <textarea name="description" class="form-control bg-dark text-white border-secondary" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary">Цена (₽)</label>
                                <input type="number" step="0.01" name="price" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary">Длительность (мин)</label>
                                <input type="number" name="duration" class="form-control bg-dark text-white border-secondary" value="30" required>
                            </div>
                            <button type="submit" class="btn btn-gold w-100">Добавить</button>
                        </form>
                    </div>
                </div>

                <!-- Список услуг -->
                <div class="col-md-8">
                    <div class="card p-4 shadow-sm">
                        <h4 class="text-white mb-3">Список услуг</h4>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Название</th>
                                        <th>Цена</th>
                                        <th>Время</th>
                                        <th>Действие</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services as $service): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($service['title']) ?></td>
                                            <td><?= number_format($service['price'], 0, '', ' ') ?> ₽</td>
                                            <td><?= $service['duration_minutes'] ?> мин.</td>
                                            <td>
                                                <form action="/admin" method="POST" onsubmit="return confirm('Удалить услугу?');">
                                                    <input type="hidden" name="action" value="delete_service">
                                                    <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Секция 3: Мастера -->
        <div class="tab-pane fade" id="barbers" role="tabpanel">
            <div class="row">
                <!-- Форма добавления мастера -->
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-sm bg-dark text-white border-secondary">
                        <h4 class="text-gold mb-3">Добавить мастера</h4>
                        <form action="/admin" method="POST">
                            <input type="hidden" name="action" value="add_barber">
                            <div class="mb-3">
                                <label class="form-label text-secondary">Имя</label>
                                <input type="text" name="name" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary">Специализация</label>
                                <input type="text" name="specialization" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary">Опыт (лет)</label>
                                <input type="number" name="experience" class="form-control bg-dark text-white border-secondary" value="3" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary">Ссылка на фото (URL)</label>
                                <input type="url" name="photo" class="form-control bg-dark text-white border-secondary" placeholder="https://...">
                            </div>
                            <button type="submit" class="btn btn-gold w-100">Добавить</button>
                        </form>
                    </div>
                </div>

                <!-- Список мастеров -->
                <div class="col-md-8">
                    <div class="card p-4 shadow-sm bg-dark text-white border-secondary">
                        <h4 class="text-gold mb-3">Список мастеров</h4>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Фото</th>
                                        <th>Имя</th>
                                        <th>Специализация</th>
                                        <th>Опыт</th>
                                        <th>Действие</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($barbers as $barber): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($barber['photo'])): ?>
                                                    <img src="<?= htmlspecialchars($barber['photo']) ?>" alt="" class="rounded-circle object-fit-cover" style="width: 40px; height: 40px;">
                                                <?php else: ?>
                                                    <span class="text-muted small">Нет</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($barber['name']) ?></td>
                                            <td><?= htmlspecialchars($barber['specialization']) ?></td>
                                            <td><?= $barber['experience_years'] ?> лет</td>
                                            <td>
                                                <form action="/admin" method="POST" onsubmit="return confirm('Удалить мастера?');">
                                                    <input type="hidden" name="action" value="delete_barber">
                                                    <input type="hidden" name="barber_id" value="<?= $barber['id'] ?>">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>