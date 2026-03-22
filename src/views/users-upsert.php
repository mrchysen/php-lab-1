<div class="form-card">
    <a href="../users" class="btn-back">
        ← Назад к списку
    </a>
    
    <h2 style="margin-bottom: 24px; font-size: 24px; color: var(--text-primary);">
        <?= isset($user) ? 'Редактирование' : 'Добавление' ?> пользователя
    </h2>
    
    <form action="/users/upsert" method="post">
        <?php if (isset($user)): ?>
            <input name="id" type="text" hidden value="<?= $user->id ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label>Имя *</label>
            <input name="name" type="text" placeholder="Введите имя" maxlength="32" value="<?= isset($user) ? $user->name : "" ?>" required>
        </div>
        
        <div class="form-group">
            <label>Фамилия *</label>
            <input name="sername" type="text" placeholder="Введите фамилию" maxlength="32" value="<?= isset($user) ? $user->sername : "" ?>" required>
        </div>
        
        <div class="form-group">
            <label>Пол *</label>
            <select name="sex" required>
                <option value="М" <?= ($user->sex ?? '') === 'М' ? 'selected' : '' ?>>Мужской</option>
                <option value="Ж" <?= ($user->sex ?? '') === 'Ж' ? 'selected' : '' ?>>Женский</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Дата рождения</label>
            <input name="birthDate" type="date" value="<?= isset($user) ? $user->birthDate : "" ?>" max="<?= date('Y-m-d') ?>">
        </div>
        
        <div class="form-group">
            <label>Место рождения</label>
            <input name="birthPlace" type="text" placeholder="Населенный пункт" value="<?= isset($user) ? $user->birthPlace : "" ?>" maxlength="128">
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <button type="button" id="randomBtn" class="btn btn-secondary">
                🎲 Заполнить рандомно
            </button>
            <button type="submit" class="btn btn-primary">
                💾 Сохранить
            </button>
        </div>
    </form>
</div>

<script>
    const names = { 
        М: ['Александр', 'Дмитрий', 'Максим', 'Артём', 'Иван', 'Михаил', 'Алексей', 'Сергей'], 
        Ж: ['Анна', 'Мария', 'Екатерина', 'Ольга', 'Татьяна', 'Наталья', 'Елена', 'Ирина'] 
    };
    const sernames = ['Иванов', 'Петров', 'Сидоров', 'Кузнецов', 'Смирнов', 'Волков', 'Морозов', 'Новиков'];
    const places = ['Москва', 'Санкт-Петербург', 'Казань', 'Новосибирск', 'Екатеринбург', 'Нижний-Новгород', 'Самара', 'Ростов-на-Дону'];
    
    document.getElementById('randomBtn').onclick = () => {
        const btn = document.getElementById('randomBtn');
        btn.style.transform = 'scale(0.95)';
        setTimeout(() => btn.style.transform = '', 200);
        
        const sex = Math.random() > 0.5 ? 'М' : 'Ж';
        const nameList = names[sex];
        const year = 1950 + Math.floor(Math.random() * 60);
        const month = Math.floor(Math.random() * 12);
        const day = Math.floor(Math.random() * 28) + 1;
        const randomDate = new Date(year, month, day);
        
        document.querySelector('input[name="name"]').value = nameList[Math.floor(Math.random() * nameList.length)];
        document.querySelector('input[name="sername"]').value = sernames[Math.floor(Math.random() * sernames.length)];
        document.querySelector('select[name="sex"]').value = sex;
        document.querySelector('input[name="birthDate"]').value = randomDate.toISOString().split('T')[0];
        document.querySelector('input[name="birthPlace"]').value = places[Math.floor(Math.random() * places.length)];
        
        const inputs = document.querySelectorAll('.form-group input, .form-group select');
        inputs.forEach(input => {
            input.style.transform = 'scale(1.02)';
            setTimeout(() => input.style.transform = '', 300);
        });
    };
</script>