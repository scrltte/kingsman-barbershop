<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class User {
    public static function findByEmail(string $email): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public static function create(string $name, string $email, string $password, string $phone): bool {
        $db = Database::getConnection();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $db->prepare("INSERT INTO users (name, email, password_hash, role, phone) VALUES (?, ?, ?, 'client', ?)");
        return $stmt->execute([$name, $email, $passwordHash, $phone]);
    }
}