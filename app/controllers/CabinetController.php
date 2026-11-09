<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Appointment;

class CabinetController extends Controller {
    public function index(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = (int)$_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'cancel_appointment') {
            $appointmentId = (int)($_POST['appointment_id'] ?? 0);
            
            if ($appointmentId > 0) {
                if (Appointment::cancelByClient($appointmentId, $userId)) {
                    $_SESSION['toast'] = 'Запись успешно отменена.';
                } else {
                    $_SESSION['toast_error'] = 'Не удалось отменить запись или время визита уже прошло.';
                }
            }
            
            header('Location: /cabinet');
            exit;
        }

        $appointments = Appointment::getByClientId($userId);

        $this->render('cabinet/index', [
            'appointments' => $appointments,
            'userName' => $_SESSION['user_name'] ?? 'Клиент'
        ]);
    }
}