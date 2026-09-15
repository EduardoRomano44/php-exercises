<?php
require_once __DIR__ . '/database/connection.php';

function addTask(string $task): ?array {
    try {
        $pdo = getConnection();

        $stmt = $pdo->prepare("INSERT INTO task (task) VALUES (?)");
        if (!$stmt->execute([$task])) {
            return ['ok' => false, 'error' => 'insert_failed'];
        }

        return ['ok' => true, 'id' => $pdo->lastInsertId()];
    } catch (PDOException $e) {
        return ['ok' => false, 'error' => 'insert_failed'];
    }
}

function getTasks(): ?array {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM task ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return ['ok' => false, 'error' => 'Task fetch failed'];
    }

}

function deleteTask(int $id): ?array {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("DELETE FROM task WHERE id = ?");
        if (!$stmt->execute([$id])) {
            return ['ok' => false, 'error' => 'delete_failed', 'id' => $id];
        }

        if ($stmt->rowCount() === 0) {
            return ['ok' => false, 'error' => 'task_not_found', 'id' => $id];
        }

        return ['ok' => true, 'id' => $id];
    } catch (PDOException $e) {
        return ['ok' => false, 'error' => 'delete_failed', 'id' => $id];
    }
}

function completeTask(int $id): ?array {
    try {
        $pdo = getConnection();
        $stmtFind = $pdo->prepare("SELECT * FROM task WHERE id = ? AND status = 'Completed'");
        if (!$stmtFind->execute([$id])) {
            return ['ok' => false, 'error' => 'complete_failed', 'id' => $id];
        }

        if ($stmtFind->rowCount() !== 0) {
            return ['ok' => false, 'error' => 'task_already_completed', 'id' => $id];
        }

        $stmt = $pdo->prepare("UPDATE task SET status = 'Completed' WHERE id = ?");
        if (!$stmt->execute([$id])) {
            return ['ok' => false, 'error' => 'complete_failed', 'id' => $id];
        }

        if ($stmt->rowCount() === 0) {
            return ['ok' => false, 'error' => 'task_not_found', 'id' => $id];
        }

        return ['ok' => true, 'id' => $id];
    } catch (PDOException $e) {
        return ['ok' => false, 'error' => 'complete_failed', 'id' => $id];
    }
}

function handleRequest(): void {
    if (isset($_POST['add-task'])) {
        $task = trim($_POST['task'] ?? '');
        
        if ($task !== '') {
            addTask($task);
            header('Location: index.php');
            exit;
        }
        
    } else if (isset($_GET['delete'])){
        $task = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);

        if ($task !== false && $task !== null) {
            deleteTask($task);
            header('Location: index.php');
            exit;
        }
    } else if (isset($_GET['complete'])){
        $task = filter_input(INPUT_GET, 'complete', FILTER_VALIDATE_INT);

        if ($task !== false && $task !== null) {
            completeTask($task);
            header('Location: index.php');
            exit;
        }
    }
}