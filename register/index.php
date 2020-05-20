<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>форма реєстрації</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/csss.css">
</head>
<body>
   <div class="container mt-4">
       <?php
    //    еслі куки пусте показує форми
       if($_COOKIE['user'] == ''):
       
       ?>
        <div class="row">
            <div class="col col-md-6">
                <h1>форма реєстрації</h1><br>
                <form action="check.php" method="POST"><br>
                    <input type="text" class="form-control" name="login" id="login" placeholder="введите login"><br>
                    <input type="text" class="form-control" name="name" id="name" placeholder="введите name"><br>
                    <input type="password" class="form-control" name="pass" id="pass" placeholder="введите password"><br>
                    <button class="btn btn-success" type="submit">зарегать</button><br>
                </form>
            </div>
            <div class="col col-md-6">
                <h1>форма авторизації</h1><br>
                <form action="auth.php" method="POST"><br>
                    <input type="text" class="form-control" name="login" id="login" placeholder="введите login"><br>
                    <input type="password" class="form-control" name="pass" id="pass" placeholder="введите password"><br>
                    <button class="btn btn-success" type="submit">аторизуватись</button><br>
                </form>

            </div>
        </div>
      <!--якшо значення тру то кукі має значення то перекидує на сторінку exit.php -->
       <?php else: ?>
        <p>привет<?=$_COOKIE['user']?>. штоби вийти сюда вася <a href="/exit.php">здесь</a>.</p>
        <!-- закінчення кду php -->
       <?php endif;?>
    </div>
</body>
</html>