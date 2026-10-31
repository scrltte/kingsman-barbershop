<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow-sm">
                <h3 class="text-center text-gold mb-4">ВХОД В СИСТЕМУ</h3>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="/login" method="POST">
                    <div class="mb-3">
                        <label class="form-label text-secondary">Email</label>
                        <input type="email" name="email" class="form-control bg-dark text-white border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Пароль</label>
                        <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
                    </div>
                    <button type="submit" class="btn btn-gold w-100 py-2 mb-3">Войти</button>
                    <div class="text-center">
                        <small class="text-muted">Нет аккаунта? <a href="/register" class="text-gold">Зарегистрироваться</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>