<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm">
                <h3 class="text-center text-gold mb-4">ОНЛАЙН-ЗАПИСЬ</h3>
                
                <form id="appointmentForm" action="/appointment/create" method="POST">
                    <div class="mb-3">
                        <label class="form-label text-secondary">Выберите услугу</label>
                        <select name="service_id" class="form-select bg-dark text-white border-secondary" required>
                            <option value="">-- Услуга --</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['title']) ?> (<?= number_format($service['price'], 0, '', ' ') ?> ₽)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Выберите мастера</label>
                        <select name="barber_id" class="form-select bg-dark text-white border-secondary" required>
                            <option value="">-- Барбер --</option>
                            <?php foreach ($barbers as $barber): ?>
                                <option value="<?= $barber['id'] ?>"><?= htmlspecialchars($barber['name']) ?> (<?= htmlspecialchars($barber['specialization']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Дата визита</label>
                        <input type="date" name="appointment_date" class="form-control bg-dark text-white border-secondary" min="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Время визита</label>
                        <input type="time" name="appointment_time" class="form-control bg-dark text-white border-secondary" min="10:00" max="20:00" required>
                    </div>

                    <button type="submit" class="btn btn-gold w-100 py-2">Подтвердить запись</button>
                </form>
            </div>
        </div>
    </div>
</div>