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
                <li class="<?php echo $task['status']; ?>" draggable="true" data-id="<?php echo $task['id']; ?>">
                    <strong><?= htmlspecialchars($task['task'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <div class="action">
                        <a href="index.php?complete=<?php echo $task['id']; ?>">Complete</a>
                        <a href="index.php?delete=<?php echo $task['id']; ?>">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script>
        const taskList = document.querySelector('ul');
        let draggedTask;

        taskList.addEventListener('dragstart', (event) => {
            draggedTask = event.target.closest('li');
            draggedTask.classList.add('dragging');
        });

        taskList.addEventListener('dragover', (event) => {
            event.preventDefault();
            const targetTask = event.target.closest('li');

            if (!targetTask || targetTask === draggedTask) {
                return;
            }

            const targetBox = targetTask.getBoundingClientRect();
            const insertBefore = event.clientY < targetBox.top + targetBox.height / 2;
            taskList.insertBefore(draggedTask, insertBefore ? targetTask : targetTask.nextSibling);
        });

        taskList.addEventListener('dragend', async () => {
            draggedTask.classList.remove('dragging');

            const order = [...taskList.querySelectorAll('li')].map((task) => task.dataset.id);
            const body = new URLSearchParams({ reorder: '1' });
            order.forEach((id) => body.append('order[]', id));

            const response = await fetch('index.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body
            });

            if (!response.ok || !(await response.json()).ok) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>