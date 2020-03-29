<? include 'layouts/top.php'?>

<div class="row">
    <div class="col-md-4 offset-md-4 mt-5">
        <? if ($loginError): ?>
            <div class="alert alert-danger" role="alert">
                Неверные логин или пароль
            </div>
        <? endif; ?>

        <form action="/login" method="post">
            <div class="form-group">
                <label for="login">Логин</label>
                <input class="form-control" required type="text" name="login" placeholder="Логин">
            </div>

            <div class="form-group">
                <label for="pass">Пароль</label>
                <input class="form-control" required type="password" name="pass" placeholder="Пароль">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Войти</button>
            </div>
        </form>
    </div>
</div>
