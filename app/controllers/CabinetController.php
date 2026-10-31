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

        $clientId = $_SESSION['user_id'];
        $appointments = Appointment::getByClient($clientId);

        // Получаем тост-уведомление, если оно есть
        $toast = $_SESSION['toast'] ?? null;
        unset($_SESSION['toast']);

        $this->render('cabinet/index', [
            'appointments' => $appointments,
            'toast' => $toast
        ]);
    }
}