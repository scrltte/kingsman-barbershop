<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Service;

class ServiceController extends Controller {
    public function index(): void {
        $services = Service::getAll();
        $this->render('services/index', ['services' => $services]);
    }
}