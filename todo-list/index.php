<?php
require_once __DIR__ . '/functions.php';

handleRequest();
$tasks = getTasks();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Todo List</h1>
        <form action="index.php" method="post">
            <input type="text" name="task" placeholder="Enter new task:" id="">
            <button type="submit" name="add-task">Add Task</button>
        </form>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li class="<?php echo $task['status']; ?>">
                    <strong><?= htmlspecialchars($task['task'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <div class="action">
                        <a href="index.php?complete=<?php echo $task['id']; ?>">Complete</a>
                        <a href="index.php?delete=<?php echo $task['id']; ?>">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>