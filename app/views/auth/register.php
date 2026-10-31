<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow-sm">
                <h3 class="text-center text-gold mb-4">РЕГИСТРАЦИЯ</h3>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="/register" method="POST">
                    <div class="mb-3">
                        <label class="form-label text-secondary">Имя</label>
                        <input type="text" name="name" class="form-control bg-dark text-white border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Email</label>
                        <input type="email" name="email" class="form-control bg-dark text-white border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Телефон</label>
                        <input type="tel" name="phone" class="form-control bg-dark text-white border-secondary" placeholder="+7 (...)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Пароль</label>
                        <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
                    </div>
                    <button type="submit" class="btn btn-gold w-100 py-2 mb-3">Зарегистрироваться</button>
                    <div class="text-center">
                        <small class="text-muted">Уже есть аккаунт? <a href="/login" class="text-gold">Войти</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>