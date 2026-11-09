<?php
namespace App\Models;

use App\Core\Database;

class Review {

    public static function getLatest(int $limit = 3): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT r.*, u.name AS client_name, b.name AS barber_name 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            LEFT JOIN barbers b ON r.barber_id = b.id
            ORDER BY r.created_at DESC 
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public static function getStats(): array {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT 
                COUNT(*) AS total_count,
                ROUND(AVG(rating), 1) AS avg_rating
            FROM reviews
        ");
        $stats = $stmt->fetch();

        return [
            'total'  => (int)($stats['total_count'] ?? 0),
            'rating' => (float)($stats['avg_rating'] ?? 5.0)
        ];
    }


    public static function existsForAppointment(int $appointmentId): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id FROM reviews WHERE appointment_id = ?");
        $stmt->execute([$appointmentId]);
        return (bool)$stmt->fetch();
    }

    public static function create(int $userId, int $appointmentId, int $barberId, int $rating, string $comment): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO reviews (user_id, appointment_id, barber_id, rating, comment, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        return $stmt->execute([$userId, $appointmentId, $barberId, $rating, $comment]);
    }
}