<!DOCTYPE html>
<html>
<head>
    <title>Учет пользователей</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="header">
        <span>Управление пользователями <?= isset($_SESSION['admin']) ? "/ Админский режим" : "" ?></span>
    </header>
    
    <main class="container">
        <?php echo $content; ?>
    </main>
</body>
</html>