<?php
declare(strict_types=1);

namespace App;

use PDO;

final class NotesRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllNotes(): array
    {
        $stmt = $this->pdo->query('SELECT id, title, content, created_at, updated_at FROM notes ORDER BY updated_at DESC');
        return $stmt->fetchAll();
    }

    public function createNote(string $title, string $content): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO notes (title, content) VALUES (?, ?)');
        $stmt->execute([$title, $content]);
        return (int)$this->pdo->lastInsertId();
    }

    public function updateNote(int $id, string $title, string $content): void
    {
        $stmt = $this->pdo->prepare('UPDATE notes SET title = ?, content = ? WHERE id = ?');
        $stmt->execute([$title, $content, $id]);
    }

    public function deleteNote(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM notes WHERE id = ?');
        $stmt->execute([$id]);
    }
}


