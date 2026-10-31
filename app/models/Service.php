<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Service {
    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM services ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(string $title, string $description, float $price, int $duration): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO services (title, description, price, duration_minutes) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $description, $price, $duration]);
    }

    public static function update(int $id, string $title, string $description, float $price, int $duration): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE services SET title = ?, description = ?, price = ?, duration_minutes = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $price, $duration, $id]);
    }

    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
}