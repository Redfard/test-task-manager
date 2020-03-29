<? include 'layouts/top.php'?>

<div class="container">
    <div class="row mb-3 mt-3">
        <div class="col-8">
            <div>
                Сортировка:
                <a href="?sort=user_name<?= removeQueryStringVar('sort') ?>"
                   <? if ($_GET['sort'] == 'user_name'): ?> class="font-weight-bold" <? endif; ?>
                >
                    По имени
                </a>

                <a href="?sort=email<?= removeQueryStringVar('sort') ?>"
                   <? if ($_GET['sort'] == 'email'): ?> class="font-weight-bold" <? endif; ?>
                >
                    По почте
                </a>

                <a href="?sort=done<?= removeQueryStringVar('sort') ?>"
                   <? if ($_GET['sort'] == 'done'): ?> class="font-weight-bold" <? endif; ?>
                >
                    По статусу
                </a>

                <a href="?page=<?= $pageNumb ?>">Сбросить</a>
            </div>

            <div>
                Порядок:
                <a href="?direction=asc<?= removeQueryStringVar('direction') ?>"
                   <? if ($_GET['direction'] == 'asc'): ?> class="font-weight-bold" <? endif; ?>
                >
                    По возрастанию
                </a>

                <a href="?direction=desc<?= removeQueryStringVar('direction') ?>"
                   <? if ($_GET['direction'] == 'desc'): ?> class="font-weight-bold" <? endif; ?>
                >
                    По убыванию
                </a>
            </div>
        </div>

        <div class="col-4 text-right">
            <? if($isAdmin): ?>
                <a href="/logout">Выйти</a>
            <? else: ?>
                <a href="/login">Войти</a>
            <? endif ?>
        </div>
    </div>

    <? if($successAddMsg): ?>
        <div class="alert alert-success mt-5" role="alert">
            Задача успешно добавлена
        </div>
    <? endif; ?>


    <? foreach ($tasks as $task): ?>
        <form action="/update-task" method="post" class="mt-5">

            Статус:
            <input type="checkbox"
                   name="done"
                   value="1"
                   class="t-status"
                   <? if($task['done']): ?> checked <? endif; ?>
                   <? if (!$isAdmin): ?> disabled <? endif; ?>
            >

            <input type="hidden" name="id" value="<?= $task['id'] ?>">
            <input type="hidden" name="query_string" value="<?= $queryString; ?>">

            <div>
                Имя пользователя: <?= $task['user_name']; ?>
            </div>
            <div>
                E-mail: <?= $task['email']; ?>
            </div>

            <? if ($task['edited']): ?>
                <div>
                    Отредактировано администратором
                </div>
            <? endif; ?>

            <div class="mt-2">
                Описание:
                <? if ($isAdmin): ?>
                    <div class="form-group">
                        <textarea class="form-control"
                                  placeholder="Описание"
                                  name="text"
                                  required
                        ><?= $task['text']; ?></textarea>
                    </div>

                    <button class="btn btn-primary">Сохранить</button>
                <? else: ?>
                    <div>
                        <?= $task['text']; ?>
                    </div>
                <? endif; ?>
            </div>
        </form>
        <hr>
    <? endforeach; ?>

    <? echo $paginator; ?>

    <div class="row mt-2 mb-5">
        <div class="col-md-6 offset-md-3">
            <h2>Добавить задачу:</h2>
            <form action="add-task" method="post">
                <div class="form-group">
                    <label for="user_name">Имя пользователя</label>
                    <input class="form-control" required name="user_name" type="text" placeholder="Имя пользователя">
                </div>

                <div class="form-group">
                    <label for="user_name">E-mail</label>
                    <input class="form-control" required name="email" type="email" placeholder="E-mail">
                </div>

                <div class="form-group">
                    <label>Описание</label>
                    <textarea class="form-control" required placeholder="Описание" name="text"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Создать задачу</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>