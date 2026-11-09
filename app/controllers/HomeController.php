<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Gallery;
use App\Models\Review;
use App\Core\Database;

class HomeController extends Controller {
    public function index(): void {
        $db = Database::getConnection();
        
        $services     = $db->query("SELECT * FROM services ORDER BY price ASC LIMIT 6")->fetchAll();
        $galleryItems = Gallery::getAll();
        
        $reviews      = Review::getLatest(3);
        $reviewStats  = Review::getStats();

        $this->render('home/index', [
            'services'    => $services,
            'gallery'     => $galleryItems,
            'reviews'     => $reviews,
            'reviewStats' => $reviewStats
        ]);
    }
}