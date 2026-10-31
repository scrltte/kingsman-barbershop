-- Создание базы данных (если не создана)
CREATE DATABASE IF NOT EXISTS kingsman_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE kingsman_db;

-- 1. Таблица пользователей (посетители и администраторы)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    role ENUM('client', 'admin') DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Таблица услуг
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    duration_minutes INT NOT NULL DEFAULT 30,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Таблица мастеров (барберов)
CREATE TABLE IF NOT EXISTS barbers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialization VARCHAR(150) NOT NULL,
    experience_years INT NOT NULL DEFAULT 1,
    photo VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Таблица онлайн-записей клиентов
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    barber_id INT NOT NULL,
    service_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (barber_id) REFERENCES barbers(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ========================================================
-- НАПОЛНЕНИЕ ДАННЫМИ (6 СТРОК В КАЖДОЙ ОСНОВНОЙ ТАБЛИЦЕ)
-- ========================================================

-- Заполнение администратора по умолчанию (Пароль: admin123)
INSERT INTO users (name, email, password, phone, role) VALUES
('Администратор Kingsman', 'admin@kingsman.local', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe11yF/6X2hH.K1x0y9g.p1s9Q3l6A9iG', '+7 (999) 000-00-00', 'admin');

-- Заполнение услуг (6 строк)
INSERT INTO services (title, description, price, duration_minutes) VALUES
('Мужская стрижка', 'Классическая или современная стрижка с учетом формы головы и пожеланий, включая мытье головы и укладку.', 1500.00, 45),
('Стрижка бороды и усов', 'Моделирование формы бороды, подравнивание контуров, распаривание и уход с использованием профессиональных масел.', 1000.00, 30),
('Комплекс «Отец и сын»', 'Совместная мужская стрижка для папы и ребенка. Отличная традиция для стильных выходных.', 2500.00, 60),
('Королевское бритье', 'Традиционное опасное бритье лица с горячими компрессами, пеной и успокаивающим лосьоном.', 1200.00, 40),
('Камуфляж седины', 'Профессиональное тонирование волос или бороды для естественного скрытия седины за 10 минут.', 1000.00, 25),
('Детская стрижка', 'Аккуратная и стильная стрижка для мальчиков до 12 лет в комфортной атмосфере.', 1000.00, 30);

-- Заполнение мастеров (6 строк с фото)
INSERT INTO barbers (name, specialization, experience_years, photo) VALUES
('Александр Смирнов', 'Топ-барбер, классические стрижки и опасное бритье', 7, 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80'),
('Максим Волков', 'Мастер по современным текстурным стрижкам и Fade', 5, 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=800&q=80'),
('Илья Морозов', 'Эксперт по моделированию бороды и усов', 4, 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=800&q=80'),
('Дмитрий Соколов', 'Старший барбер, деловой стиль и бритье', 9, 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=800&q=80'),
('Артем Лебедев', 'Креативные стрижки, стайлинг и уход', 3, 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=800&q=80'),
('Евгений Васильев', 'Универсальный мастер, быстрая и точная работа', 5, 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=800&q=80');

