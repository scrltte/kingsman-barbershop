<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Appointment;

class AppointmentController extends Controller {

    public function create(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientId  = (int)$_SESSION['user_id'];
            $serviceId = (int)($_POST['service_id'] ?? 0);
            $barberId  = (int)($_POST['barber_id'] ?? 0);
            $date      = trim($_POST['appointment_date'] ?? '');
            $time      = trim($_POST['appointment_time'] ?? '');

            if ($serviceId && $barberId && $date && $time) {
                $selectedDateTime = \DateTime::createFromFormat('Y-m-d H:i', "{$date} {$time}");
                $currentDateTime  = new \DateTime();

                if (!$selectedDateTime || $selectedDateTime < $currentDateTime) {
                    $error = 'Нельзя записаться на прошедшее время!';
                } 
                else {
                    $minutes = (int)$selectedDateTime->format('i');
                    if ($minutes % 30 !== 0) {
                        $error = 'Запись возможна только на время, кратное 30 минутам (например, 12:00 или 12:30).';
                    } 
                    elseif (Appointment::isTimeSlotTaken($barberId, $date, $time)) {
                        $error = 'К сожалению, это время у выбранного мастера уже занято. Пожалуйста, выберите другое время.';
                    } 
                    else {
                        Appointment::create($clientId, $barberId, $serviceId, $date, $time);

                        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                            http_response_code(200);
                            echo json_encode(['success' => true]);
                            exit;
                        }

                        $_SESSION['toast'] = 'Запись успешно создана!';
                        header('Location: /cabinet');
                        exit;
                    }
                }
            } else {
                $error = 'Пожалуйста, заполните все поля.';
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => $error]);
                exit;
            }
        }

        $db = Database::getConnection();
        $services = $db->query("SELECT * FROM services ORDER BY title ASC")->fetchAll();
        $barbers  = $db->query("SELECT * FROM barbers ORDER BY name ASC")->fetchAll();

        $this->render('appointment/create', [
            'services' => $services,
            'barbers'  => $barbers,
            'error'    => $error
        ]);
    }
}