<div class="col-md-3">
    <div class="menu_open">
        <div class="block_auth">
            <?php
            if (isset($_SESSION['email'])):
                include("blocks/user_panel.php"); ?>
            <?php else: ?>
                <div class="col-md-12" id="blocks_input">
                    <form method="POST" action="">
                        <input type="text" name="e_email" placeholder="Введите email" id="form_email">
                </div>
                <div class="col-md-12" id="blocks_input">
                    <input type="password" name="e_password" placeholder="Введите пароль" id="form_password">
                </div>
                <div class="col-md-12" id="blocks_input">
                    <div class="btn_forget">
                        <a href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/remindpass"
                           class="button_forget_pass">Забыли
                            пароль?</a>
                        <button type="submit" name="enter" id="button_enter">Войти</button>
                    </div>
                    </form>
                </div>

                <div class="wrapp_all_stuff">
                    <div class="all_stuff">
                        <a class="stuff_menu" id="stuff_menu_search" href="#">
                            <div class="left_icon"><i class="fa fa-search" aria-hidden="true"></i></div>
                            <div class="right_info"><span class="span_left">поиск по сайту</span></div>
                        </a>
                        <a class="stuff_menu_search_field" href="#" style="display: none;">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <form action="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/search"
                                      class="navbar-form navbar-left"
                                      role="search">
                                    <input type="text" name="search" placeholder="Поиск" id="form_search">
                                    <button type="submit" id="search_button" name="search_submit"
                                            style="float: right;">Go!
                                    </button>
                            </div>
                            </form>
                        </a>

                        <a class="stuff_menu" href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/allusers"
                           style="margin-bottom: 20px;">
                            <div class="left_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                            <div class="right_info"><span class="span_left">пользователи</span></div>
                        </a>
                        <a class="stuff_menu" href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/forum"
                           style="margin-bottom: 20px;">
                            <div class="left_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                            <div class="right_info"><span class="span_left">ФОРУМ</span></div>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>