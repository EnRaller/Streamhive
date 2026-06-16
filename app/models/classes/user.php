<?php

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getIcon($id) {
        $user = $this->getById($id);
        return $user['icon'] ?? 'default.png';
    }

    public function getUsername($id) {
        $user = $this->getById($id);
        return $user['username'] ?? 'unknown';
    }
}