<?php
namespace App\Models;

use App\Core\Database;

class Gallery {
    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT g.*, b.name AS barber_name 
            FROM gallery g 
            LEFT JOIN barbers b ON g.barber_id = b.id 
            ORDER BY g.id DESC
        ");
        return $stmt->fetchAll();
    }
}