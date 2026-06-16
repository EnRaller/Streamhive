<?php

class Like {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function toggleVideoLike($user_id, $video_id) {
        $stmt = $this->pdo->prepare("
            SELECT id FROM likes
            WHERE user_id = ? AND video_id = ? AND comment_id IS NULL
        ");
        $stmt->execute([$user_id, $video_id]);
        $like = $stmt->fetch();

        if ($like) {
            $del = $this->pdo->prepare("DELETE FROM likes WHERE id = ?");
            $del->execute([$like['id']]);
        } else {
            $ins = $this->pdo->prepare("
                INSERT INTO likes (user_id, video_id, comment_id)
                VALUES (?, ?, NULL)
            ");
            $ins->execute([$user_id, $video_id]);
        }
    }

    public function toggleCommentLike($user_id, $comment_id) {
        $stmt = $this->pdo->prepare("
            SELECT id FROM likes
            WHERE user_id = ? AND comment_id = ?
        ");
        $stmt->execute([$user_id, $comment_id]);
        $like = $stmt->fetch();

        if ($like) {
            $del = $this->pdo->prepare("DELETE FROM likes WHERE id = ?");
            $del->execute([$like['id']]);
        } else {
            $ins = $this->pdo->prepare("
                INSERT INTO likes (user_id, video_id, comment_id)
                VALUES (?, NULL, ?)
            ");
            $ins->execute([$user_id, $comment_id]);
        }
    }

    public function countVideoLikes($video_id) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM likes
            WHERE video_id = ? AND comment_id IS NULL
        ");
        $stmt->execute([$video_id]);
        return $stmt->fetchColumn();
    }

    public function countCommentLikes($comment_id) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM likes
            WHERE comment_id = ?
        ");
        $stmt->execute([$comment_id]);
        return $stmt->fetchColumn();
    }
}