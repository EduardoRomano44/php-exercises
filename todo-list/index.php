<?php
require_once __DIR__ . '/functions.php';

handleAddTaskRequest();

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
    </div>
</body>
</html>