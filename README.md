# Kingsman Barbershop — Web Application

Веб-приложение для барбершопа **«Kingsman»**, написанное на чистом PHP (Native PHP 8.x) с использованием паттерна проектирования **MVC** (Model-View-Controller). Проект выполнен в тёмном стиле (темно-серые/черные тона с золотыми акцентами) с функционалом клиентской записи и полноценной административной панелью.

---

## Технологический стек

* **Backend**: Native PHP 8.x (без сторонних фреймворков), PDO.
* **Database**: MySQL (utf8mb4).
* **Frontend**: HTML5, CSS3, JavaScript (Fetch API / AJAX), Bootstrap 5.
* **Environment**: Open Server Panel (Apache / Nginx + PHP 8.x + MySQL).

---

## Структура проекта

```text
kingsman.local/
├── app/
│   ├── controllers/         # Контроллеры приложения
│   │   ├── AdminController.php
│   │   ├── AppointmentController.php
│   │   ├── AuthController.php
│   │   ├── BarberController.php
│   │   ├── CabinetController.php
│   │   ├── ContactController.php
│   │   ├── HomeController.php
│   │   └── ServiceController.php
│   ├── core/                # Ядро системы (MVC)
│   │   ├── Controller.php
│   │   ├── Database.php
│   │   └── Router.php
│   ├── models/              # Модели работы с БД
│   │   ├── Appointment.php
│   │   ├── Barber.php
│   │   ├── Service.php
│   │   └── User.php
│   └── views/               # Представления (HTML-шаблоны)
│       ├── admin/
│       ├── appointment/
│       ├── auth/
│       ├── barbers/
│       ├── cabinet/
│       ├── contacts/
│       ├── home/
│       ├── layout/
│       └── services/
├── public/                  # Точка входа и статические ресурсы
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── main.js
│   ├── .htaccess            # Перенаправление всех запросов на index.php
│   └── index.php            # Главная точка входа в приложение
├── schema.sql               # Дамп структуры БД и стартовых данных
└── README.md
```

---

## Установка и запуск (Open Server)

### 1. Клонирование / Перенос файлов
Поместите файлы проекта в директорию Open Server:
`C:\OSPanel\home\kingsman.local\`

### 2. База данных
1. Создайте базу данных `kingsman_db` с кодировкой `utf8mb4_unicode_ci`.
2. Импортируйте файл `schema.sql` в базу данных через phpMyAdmin или CLI.
3. При необходимости проверьте реквизиты подключения в `app/core/Database.php`:
   ```php
   $host = '127.0.0.1';
   $db   = 'kingsman_db';
   $user = 'root';
   $pass = '';
   ```

---

## Основной функционал

### Клиентская часть
* **Главная страница**: Промо-блок, краткая информация об услугах и мастерах.
* **Услуги (`/services`)**: Полный каталог услуг с ценами и длительностью.
* **Мастера (`/barbers`)**: Карточки барберов с аватарами, специализацией и стажем работы.
* **Онлайн-запись (`/appointment/create`)**: Запись к конкретному мастеру и на определенную услугу (работает через AJAX / POST).
* **Авторизация / Регистрация (`/login`, `/register`)**: Хеширование паролей (`password_hash`), валидация полей.
* **Личный кабинет (`/cabinet`)**: Просмотр истории собственных записей и их статусов.

### Панель администратора (`/admin`)
Доступна только пользователям с ролью `admin`:
* **Управление записями**: Изменение статусов (`pending`, `confirmed`, `completed`, `cancelled`) в режиме реального времени.
* **Управление услугами**: Добавление новых услуг и удаление существующих.
* **Управление мастерами**: Добавление барберов с указанием прямых ссылок на фото/аватары и удаление мастеров.

---

## Безопасность и архитектура

* **Защита от SQL-инъекций**: Все запросы к БД выполняются через подготовленные выражения PDO (`PDO::prepare`).
* **Единая точка входа**: Доступ к файлам вне папки `public` закрыт веб-сервером через `.htaccess`.
* **Автозагрузка классов (Autoload)**: Использование пространства имен (`namespace App\...`) по стандарту PSR-4.
