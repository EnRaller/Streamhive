<?php

class Comment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($user_id, $video_id, $content) {
        $stmt = $this->pdo->prepare("
            INSERT INTO comments (user_id, video_id, content, created_at)
            VALUES (?, ?, ?, NOW())
        ");

        return $stmt->execute([$user_id, $video_id, $content]);
    }

    public function getByVideo($video_id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                comments.ID AS comment_id,
                comments.user_id,
                comments.video_id,
                comments.content,
                comments.created_at,
                users.username,
                users.icon
            FROM comments
            JOIN users ON comments.user_id = users.ID
            WHERE comments.video_id = ?
            ORDER BY comments.ID DESC
        ");

        $stmt->execute([$video_id]);
        return $stmt->fetchAll();
    }
}