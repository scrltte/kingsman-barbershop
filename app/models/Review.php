<?php
namespace App\Models;

use App\Core\Database;

class Review {
    public static function getApproved(): array {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT r.*, u.name AS client_name 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            ORDER BY r.created_at DESC 
            LIMIT 6
        ");
        return $stmt->fetchAll();
    }
}