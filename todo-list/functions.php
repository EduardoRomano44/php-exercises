<?php
require_once __DIR__ . '/database/connection.php';

function addTask(string $task): ?array {
    $pdo = getConnection();
    $stmt = $pdo->prepare("INSERT INTO task (task) VALUES (?)");
    $stmt->execute([$task]);
    return ['ok' => true, 'id' => $pdo->lastInsertId()];
}

function getTasks(): array {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM task ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

function handleAddTaskRequest(): void {
    if (!isset($_POST['add-task'])) {
        return;
    }

    $task = trim($_POST['task'] ?? '');
    if ($task !== '') {
        addTask($task);
    }

    header('Location: index.php');
    exit;
}