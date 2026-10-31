<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Barber {
    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM barbers ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM barbers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(string $name, string $specialization, int $experience, string $photo): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO barbers (name, specialization, experience_years, photo) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $specialization, $experience, $photo]);
    }
    
    public static function update(int $id, string $name, string $specialization, int $experience): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE barbers SET name = ?, specialization = ?, experience_years = ? WHERE id = ?");
        return $stmt->execute([$name, $specialization, $experience, $id]);
    }

    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM barbers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}