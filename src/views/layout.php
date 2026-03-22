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

    <script>
        // Анимация для кнопок и элементов
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.btn, .action-link, .add-user-btn, .btn-back');
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    this.appendChild(ripple);
                    
                    const x = e.clientX - e.target.offsetLeft;
                    const y = e.clientY - e.target.offsetTop;
                    
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>
</body>
</html>