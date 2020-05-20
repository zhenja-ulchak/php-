<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    

    <title>installation CHAT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="result"><?=$result?></div>
    <div id="soft">
        <h2>регистрация адмистратора</h2>
        <img src="/installation/imgs/software.png" alt="" srcset="">
        <form action="index.php" method="post">
            <p><b>введите логин:</b><br><input type="text" name="login" class="login"></p>
            <p><b>введите пароль:</b><br><input type="password" name="password" class="password"></p>
            <p><input type="submit" value="установить чат" class="button"></p>


        </form>
    </div>
    <div id="copy">Все права захищені &COPY; 2020 ZuChat</div>
</body>
</html>
