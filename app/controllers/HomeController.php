<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Gallery;
use App\Models\Review;
use App\Core\Database;

class HomeController extends Controller {
    public function index(): void {
        $db = Database::getConnection();
        
        // Надежно получаем данные из таблиц
        $services     = $db->query("SELECT * FROM services ORDER BY price ASC LIMIT 6")->fetchAll();
        $barbers      = $db->query("SELECT * FROM barbers ORDER BY id ASC")->fetchAll();
        $galleryItems = Gallery::getAll();
        $reviews      = Review::getApproved();

        $this->render('home/index', [
            'services' => $services,
            'barbers'  => $barbers,
            'gallery'  => $galleryItems,
            'reviews'  => $reviews
        ]);
    }
}