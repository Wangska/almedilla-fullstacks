<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/NotesRepository.php';

use App\Database;
use App\NotesRepository;

// Initialize DB and repository
$pdo = Database::getConnection();
Database::ensureSchema($pdo);
$repo = new NotesRepository($pdo);

// Simple routing for CRUD
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    try {
        if ($action === 'create') {
            $title = trim((string)($_POST['title'] ?? ''));
            $content = trim((string)($_POST['content'] ?? ''));
            if ($title === '' && $content === '') {
                throw new RuntimeException('Note cannot be empty.');
            }
            $repo->createNote($title, $content);
            header('Location: /');
            exit;
        }
        if ($action === 'update') {
            $id = (int)($_POST['id'] ?? 0);
            $title = trim((string)($_POST['title'] ?? ''));
            $content = trim((string)($_POST['content'] ?? ''));
            if ($id <= 0) {
                throw new RuntimeException('Invalid note id.');
            }
            $repo->updateNote($id, $title, $content);
            header('Location: /');
            exit;
        }
        if ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id <= 0) {
                throw new RuntimeException('Invalid note id.');
            }
            $repo->deleteNote($id);
            header('Location: /');
            exit;
        }
    } catch (Throwable $t) {
        $error = $t->getMessage();
    }
}

$notes = $repo->getAllNotes();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NoteIt</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <div class="container">
        <h1>NoteIt</h1>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <section class="new-note">
            <h2>Create Note</h2>
            <form method="post">
                <input type="hidden" name="action" value="create">
                <div class="field">
                    <label>Title</label>
                    <input type="text" name="title" placeholder="Title">
                </div>
                <div class="field">
                    <label>Content</label>
                    <textarea name="content" rows="4" placeholder="Write something..."></textarea>
                </div>
                <button type="submit">Add</button>
            </form>
        </section>

        <section class="notes-list">
            <h2>Your Notes</h2>
            <?php if (empty($notes)): ?>
                <p class="muted">No notes yet. Add your first note above.</p>
            <?php else: ?>
                <?php foreach ($notes as $note): ?>
                    <article class="note">
                        <form method="post" class="note-form">
                            <input type="hidden" name="id" value="<?php echo (int)$note['id']; ?>">
                            <div class="field">
                                <label>Title</label>
                                <input type="text" name="title" value="<?php echo htmlspecialchars($note['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="field">
                                <label>Content</label>
                                <textarea name="content" rows="3"><?php echo htmlspecialchars($note['content'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>
                            <div class="actions">
                                <button type="submit" name="action" value="update">Save</button>
                                <button type="submit" name="action" value="delete" class="danger" onclick="return confirm('Delete this note?');">Delete</button>
                            </div>
                            <div class="timestamps">
                                <span>Created: <?php echo htmlspecialchars($note['created_at'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span>Updated: <?php echo htmlspecialchars($note['updated_at'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        </form>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>


