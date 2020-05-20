<div id="content">
<a href="http://chat"><< На главную</a> || <a href="http://chat/avto.php">Авторизация >></a>
<div class="login"><h1>Регистрация</h1></div>
<form name="thisform" method="post">
<p>Логин:<br /><input type="text" name="login" value="" /></p>
<p>Пароль:<br /><input type="password" name="password" value="" /></p>
<p>E-mail:<br /><input type="email" name="email" value="" class="email" />
<div class="errorEmail"></div><a href="#" onclick="getEmail()">Проверить корректность</a></a></p>
<p><input type="submit" value="Регистрация" class="button" onclick="return getValidate(this.form)"/></p>
</form>
</div>