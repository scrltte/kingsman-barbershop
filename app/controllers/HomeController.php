<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

class HomeController extends Controller {
    public function index(): void {
        $db = Database::getConnection();
        
        // Получаем популярные услуги для главной страницы
        $services =$db->query("SELECT * FROM services LIMIT 3")->fetchAll();
        
        // Получаем список мастеров
        $barbers =$db->query("SELECT * FROM barbers LIMIT 3")->fetchAll();

        $this->render('home/index', [
            'services' => $services,
            'barbers' => $barbers
        ]);
    }
}