<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Barber;

class AdminController extends Controller {
    public function index(): void {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            if (isset($_POST['id'], $_POST['status']) && empty($action)) {
                Appointment::updateStatus((int)$_POST['id'], $_POST['status']);
            }

            if ($action === 'add_service') {
                Service::create(
                    trim($_POST['title'] ?? ''),
                    trim($_POST['description'] ?? ''),
                    (float)($_POST['price'] ?? 0),
                    (int)($_POST['duration'] ?? 30)
                );
            }

            if ($action === 'delete_service') {
                Service::delete((int)($_POST['service_id'] ?? 0));
            }

            if ($action === 'add_barber') {
                Barber::create(
                    trim($_POST['name'] ?? ''),
                    trim($_POST['specialization'] ?? ''),
                    (int)($_POST['experience'] ?? 1),
                    trim($_POST['photo'] ?? '')
                );
            }

            if ($action === 'delete_barber') {
                Barber::delete((int)($_POST['barber_id'] ?? 0));
            }

            header('Location: /admin');
            exit;
        }

        $appointments = Appointment::getAll();
        $services = Service::getAll();
        $barbers = Barber::getAll();

        $this->render('admin/index', [
            'appointments' => $appointments,
            'services' => $services,
            'barbers' => $barbers
        ]);
    }
}