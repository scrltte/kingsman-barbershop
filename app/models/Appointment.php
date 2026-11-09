<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Appointment {
    public static function create(int $clientId, int $barberId, int $serviceId, string $date, string $time): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO appointments (client_id, barber_id, service_id, appointment_date, appointment_time, status) 
            VALUES (?, ?, ?, ?, ?, 'pending')
        ");
        return $stmt->execute([$clientId, $barberId, $serviceId, $date, $time]);
    }

    public static function getByClient(int $clientId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT a.*, s.title as service_title, s.price, b.name as barber_name 
            FROM appointments a
            JOIN services s ON a.service_id = s.id
            JOIN barbers b ON a.barber_id = b.id
            WHERE a.client_id = ?
            ORDER BY a.appointment_date DESC, a.appointment_time DESC
        ");
        $stmt->execute([$clientId]);
        return $stmt->fetchAll();
    }

    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT a.*, u.name as client_name, u.phone, s.title as service_title, b.name as barber_name 
            FROM appointments a
            JOIN users u ON a.client_id = u.id
            JOIN services s ON a.service_id = s.id
            JOIN barbers b ON a.barber_id = b.id
            ORDER BY a.appointment_date DESC, a.appointment_time DESC
        ");
        return $stmt->fetchAll();
    }

    public static function updateStatus(int $id, string $status): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE appointments SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public static function getByClientId(int $clientId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT a.*, 
                s.title AS service_title, 
                s.price AS service_price, 
                b.name AS barber_name, 
                b.specialization AS barber_specialization,
                b.photo AS barber_photo
            FROM appointments a
            JOIN services s ON a.service_id = s.id
            JOIN barbers b ON a.barber_id = b.id
            WHERE a.client_id = ?
            ORDER BY a.appointment_date DESC, a.appointment_time DESC
        ");
        $stmt->execute([$clientId]);
        return $stmt->fetchAll();
    }

    public static function cancelByClient(int $appointmentId, int $clientId): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            UPDATE appointments 
            SET status = 'cancelled' 
            WHERE id = ? AND client_id = ? AND status IN ('pending', 'confirmed')
        ");
        return $stmt->execute([$appointmentId, $clientId]);
    }
}