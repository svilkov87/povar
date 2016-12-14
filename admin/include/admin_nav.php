<!--navigation-->
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="admin.php">Админ-панель</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <form action="search_admin.php" class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="Найти статью">
                </div>
                <button type="search" name="search_submit" class="btn btn-default">Поиск</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="add.php">Добавить статью</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<!--/navigation-->