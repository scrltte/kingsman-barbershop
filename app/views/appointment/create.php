<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white border-secondary p-4 shadow-sm">
                <h3 class="text-gold mb-4 text-center">ОНЛАЙН-ЗАПИСЬ</h3>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger bg-dark text-danger border-danger mb-4">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="/appointment/create" method="POST">
                    <div class="mb-3">
                        <label class="form-label text-secondary">Выберите услугу</label>
                        <select name="service_id" class="form-select bg-dark text-white border-secondary" required>
                            <option value="" selected disabled>— Услуга —</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= $service['id'] ?>">
                                    <?= htmlspecialchars($service['title']) ?> (<?= number_format($service['price'], 0, '', ' ') ?> ₽)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Выберите мастера</label>
                        <select name="barber_id" class="form-select bg-dark text-white border-secondary" required>
                            <option value="" selected disabled>— Барбер —</option>
                            <?php foreach ($barbers as $barber): ?>
                                <option value="<?= $barber['id'] ?>">
                                    <?= htmlspecialchars($barber['name']) ?> (<?= htmlspecialchars($barber['specialization']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Дата визита</label>
                        <input type="date" 
                               name="appointment_date" 
                               class="form-control bg-dark text-white border-secondary" 
                               min="<?= date('Y-m-d'); ?>" 
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary">Время визита</label>
                        <input type="time" 
                               name="appointment_time" 
                               class="form-control bg-dark text-white border-secondary" 
                               step="1800" 
                               required>
                        <div class="form-text text-muted">Доступна запись с интервалом в 30 минут.</div>
                    </div>

                    <button type="submit" class="btn btn-gold w-100 py-2 fw-bold">Подтвердить запись</button>
                </form>
            </div>
        </div>
    </div>
</div>