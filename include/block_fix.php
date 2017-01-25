<div class="col-md-3  home_wrapp">
    <div class="home_last_art">
        <div class="home_last_art_head">
            <span class="span_last_art_head">Последние рецепты</span>
        </div>
<!--        --><?php //foreach ($LastArtLimitTwo as $item): ?>
<!--        <div class="home_last_art_body">-->
<!--            <a href="http://--><?php //echo $_SERVER['HTTP_HOST']; ?><!--/article/--><?php //echo $item['id']; ?><!--">-->
<!--            <div class="home_left_last_art">-->
<!--                <img src="http://--><?php //echo $_SERVER['HTTP_HOST']; ?><!--/admin/images/--><?php //echo $item['intro_image']; ?><!--" alt="" class="last_prev_img">-->
<!--            </div>-->
<!--            <div class="home_right_last_art">-->
<!--                <div class="home_title_last_art">-->
<!--                    --><?php //echo $item['title']; ?>
<!--                </div>-->
<!--            </div>-->
<!--            </a>-->
<!--        </div>-->
<!--        --><?php //endforeach;?>
        <div class="bf_last_wrapp">
                    <?php foreach ($LastArtLimitTwo as $item): ?>
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/article/<?php echo $item['id']; ?>">
            <div class="bf_last_pnl">
                <div class="bf_last_img">
                     <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/images/<?php echo $item['intro_image']; ?>" alt="" class="bf_last_imglink">
                </div>
                <div class="bf_last_title">
                    <?php echo $item['title']; ?>
                </div>

            </div>
            </a>
                    <?php endforeach;?>
        </div>
        <div class="home_last_forum">
            <span class="span_last_forum">Топики</span>
        </div>
        <?php foreach ($LastForumLimitTwo as $item): ?>
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/topictheme/<?php echo $item['id']; ?>">
                <div class="home_last_wrapp_forum">
                    <div class="home_last_img_forum">
                        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/img/avatars/<?php echo $item['user_ava']; ?>"
                             alt="" class="home_img_prev">
                    </div>
                    <div class="home_last_art_forum">
                        <div class="home_title_last_forum">
                           <?php echo substr(($item['title']), 0, 80); ?>
                            <span>...</span>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach;?>
        <div class="home_last_forum_watch">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/forum" class="span_last_forum_watch">посмотреть все</a>
        </div>
    </div>
</div>