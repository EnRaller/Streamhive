<?php

class Video {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function create($user_id, $title, $description, $filename, $thumbnail, $category_ids) {

        $stmt = $this->pdo->prepare("
            INSERT INTO videos (user_id, title, description, filename, thumbnail, views, created_at)
            VALUES (?, ?, ?, ?, ?, 0, NOW())
        ");
        $stmt->execute([
            $user_id,
            $title,
            $description,
            $filename,
            $thumbnail
        ]);

        $video_id = $this->pdo->lastInsertId();

        $stmt2 = $this->pdo->prepare("
            INSERT INTO video_categories (video_id, category_id)
            VALUES (?, ?)
        ");

        foreach ($category_ids as $cat_id) {
            $stmt2->execute([$video_id, $cat_id]);
        }

        return $video_id;
    }

    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT videos.*, users.username, users.icon
            FROM videos
            JOIN users ON videos.user_id = users.ID
            ORDER BY videos.ID DESC
        ");

        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT videos.*, users.username, users.icon
            FROM videos
            JOIN users ON videos.user_id = users.ID
            WHERE videos.ID = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function addView($id) {
        $stmt = $this->pdo->prepare("
            UPDATE videos SET views = views + 1 WHERE ID = ?
        ");
        $stmt->execute([$id]);
    }

    public function getCategoriesByVideo($video_id) {
        $stmt = $this->pdo->prepare("
            SELECT c.*
            FROM categories c
            JOIN video_categories vc ON vc.category_id = c.ID
            WHERE vc.video_id = ?
        ");

        $stmt->execute([$video_id]);
        return $stmt->fetchAll();
    }
}