<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Appointment;
use App\Core\Database;

class AppointmentController extends Controller {
    public function create(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientId = $_SESSION['user_id'];
            $serviceId = (int)($_POST['service_id'] ?? 0);
            $barberId = (int)($_POST['barber_id'] ?? 0);
            $date = $_POST['appointment_date'] ?? '';
            $time = $_POST['appointment_time'] ?? '';

            if ($serviceId && $barberId && $date && $time) {
                // Используем глобальный класс \DateTime с обратным слэшем
                $selectedDateTime = \DateTime::createFromFormat('Y-m-d H:i', "{$date} {$time}");
                $currentDateTime = new \DateTime();

                if (!$selectedDateTime || $selectedDateTime < $currentDateTime) {
                    $error = 'Нельзя записаться на прошедшее время!';
                } else {
                    Appointment::create($clientId, $barberId, $serviceId, $date, $time);

                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        http_response_code(200);
                        exit;
                    }

                    $_SESSION['toast'] = 'Запись успешно создана!';
                    header('Location: /cabinet');
                    exit;
                }
            } else {
                $error = 'Пожалуйста, заполните все поля.';
            }
        }

        $db = Database::getConnection();
        $services = $db->query("SELECT * FROM services")->fetchAll();
        $barbers = $db->query("SELECT * FROM barbers")->fetchAll();

        $this->render('appointment/create', [
            'services' => $services,
            'barbers' => $barbers,
            'error' => $error
        ]);
    }
}