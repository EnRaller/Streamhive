<?php

class Video {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($user_id, $title, $description, $filename, $thumbnail, $category_id) {
        $stmt = $this->pdo->prepare("
            INSERT INTO videos (user_id, title, description, filename, thumbnail, views, created_at, category_id)
            VALUES (?, ?, ?, ?, ?, 0, NOW(), ?)
        ");

        return $stmt->execute([
            $user_id,
            $title,
            $description,
            $filename,
            $thumbnail,
            $category_id
        ]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT videos.*, users.username, users.icon
            FROM videos
            JOIN users ON videos.user_id = users.ID
            ORDER BY videos.id DESC
        ");

        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT videos.*, users.username, users.icon
            FROM videos
            JOIN users ON videos.user_id = users.ID
            WHERE videos.id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function addView($id) {
        $stmt = $this->pdo->prepare("UPDATE videos SET views = views + 1 WHERE id = ?");
        $stmt->execute([$id]);
    }
}