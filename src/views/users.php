<div class="search-container">
    <div class="search-input-group">
        <input type="text" 
               id="searchInput" 
               class="search-input" 
               placeholder="🔍 Поиск по фамилии" 
               value="<?= htmlspecialchars($_GET['filter'] ?? '') ?>">
        <button id="searchBtn" class="search-btn">Искать</button>
        <?php if (!empty($_GET['filter'])): ?>
            <a href="/users" class="reset-btn">Сбросить</a>
        <?php endif; ?>
    </div>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Пол</th>
                <th>Дата рождения</th>
                <th>Место рождения</th>
                <th>Создан</th>
                <th>Обновлен</th>
                <th colspan="2">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><strong><?= htmlspecialchars($user->name) ?></strong></td>
                        <td><?= htmlspecialchars($user->sername) ?></td>
                        <td><?= $user->sex === 'М' ? 'Мужской' : 'Женский' ?></td>
                        <td><?= $user->birthDate ? date('d.m.Y', strtotime($user->birthDate)) : '-' ?></td>
                        <td><?= htmlspecialchars($user->birthPlace) ?: '-' ?></td>
                        <td><?= str_replace('_', ' ', $user->createdDate) ?></td>
                        <td><?= str_replace('_', ' ', $user->updatedDate) ?></td>
                        <td>
                            <a href="users/upsert?id=<?= $user->id ?>" class="action-link">
                                Редактировать
                            </a>
                        </td>
                        <td>
                            <form action="/users/delete?id=<?= $user->id ?>" method="post">
                                <button type="submit" class="action-link delete-link" onclick="return confirm('Вы уверены, что хотите удалить пользователя <?= htmlspecialchars($user->name) ?>?')">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="empty-state">
                        📭 Пользователей пока нет
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div style="margin-top: 24px; text-align: right;">
    <a href="users/upsert" class="add-user-btn">
        ➕ Добавить пользователя
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        
        function performSearch() {
            const searchValue = searchInput.value.trim();
            const currentUrl = new URL(window.location.href);
            
            if (searchValue) {
                currentUrl.searchParams.set('filter', searchValue);
            } else {
                currentUrl.searchParams.delete('filter');
            }
            
            window.location.href = currentUrl.toString();
        }
        
        searchBtn.addEventListener('click', performSearch);
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });
    });
</script>