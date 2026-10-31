<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Barber;

class BarberController extends Controller {
    public function index(): void {
        $barbers = Barber::getAll();
        $this->render('barbers/index', ['barbers' => $barbers]);
    }
}