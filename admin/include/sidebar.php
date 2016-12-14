    <!--    sidebar-->
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Добро пожаловать в Админ-панель, <span class="text-primary"><?php echo ($_SESSION['email']); ?></div>
            <div class="panel-body">
                <div class="list-group">
<!--                    <a href="../../full.php?id=--><?php //echo $last_article;?><!--" class="list-group-item">просмотр последней статьи</a>-->
                    <a href="#" class="list-group-item">Всего статей: <strong><?php echo $art; ?></strong>/ Cuckoo: <strong><?php echo $artCuckoo; ?></strong></a>
                    <a href="#" class="list-group-item">Зарегистрированных пользователей: <strong><?php echo $users; ?></strong></a>
                    <a href="#" class="list-group-item">Комментраии к статьям:<strong><?php echo $comments; ?></strong></a>
                    <a href="../admin/all_article_from_users.php" class="list-group-item"><strong>Рецепты пользователей</strong></a>
                    <a href="../../profile.php?id=<?php echo ($_SESSION['user_id']);?>" class="list-group-item"><strong>Мой Аккаунт</strong></a>
                </div>
            </div>
        </div>
    </div>
    <!--    /sidebar-->