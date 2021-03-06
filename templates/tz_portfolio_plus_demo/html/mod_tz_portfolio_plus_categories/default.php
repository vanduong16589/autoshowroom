<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2015 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

if ($list):
    ?>

    <div class="category-menu">
        <?php $i = 0; ?>
        <?php $str = null; ?>
        <?php ob_start(); ?>
        <?php foreach ($list as $item): ?>

            <?php
            if (count($list) > 1 AND isset($list[$i + 1]->level))
                $subLevel = (int)$list[$i + 1]->level - (int)$list[$i]->level;
            else
                $subLevel = 0;
            ?>
            <?php if ($subLevel == 0): ?>
                <div class="level00">
                    <?php if ($params -> get('show_image', 1) && $item->images) {
                        echo '<a href="' . $item->link . '"><img src="' . JUri::base() . $item->images . '" alt="' . $item->title . '"/></a>';
                    } ?>
                    <?php if ($params -> get('show_title',1)): ?>
                        <a href="<?php echo $item->link ?>"><?php echo $item->title; ?>
                            <?php if (isset($item->total)): ?>
                                <span>(<?php echo $item->total ?>)</span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($params -> get('show_desc', 1) && $item->description) {
                        echo '<div class="tz_desc">' . $item->description . '</div>';
                    } ?>
                </div>
            <?php elseif ($subLevel > 0): ?>
                <div class="level00 haschild">

                <a id="category-btn-<?php echo $item->id; ?>" href="#category-<?php echo $item->id; ?>"
                   data-toggle="collapse" data-toggle="button" class="collapsed">
                    <span class="tz_button fa fa-chevron-right"></span>
                </a>

                <?php if ($params -> get('show_image', 1) && $item->images) {
                    echo '<a href="' . $item->link . '"><img src="' . JUri::base() . $item->images . '" alt="' . $item->title . '"/></a>';
                } ?>
                <?php if ($params -> get('show_title', 1)): ?>
                    <a href="<?php echo $item->link ?>"><?php echo $item->title; ?>
                        <?php if (isset($item->total)): ?>
                            <span>(<?php echo $item->total ?>)</span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <?php if ($params -> get('show_desc',1) && $item->description) {
                    echo '<div class="tz_desc">' . $item->description . '</div>';
                } ?>

                <div class="sub-menu-category sub-menu-category-<?php echo $subLevel ?> collapse fade" id="category-<?php echo $item->id; ?>">
            <?php elseif ($subLevel < 0): ?>
                <div class="level00">
                    <?php if ($params -> get('show_image',1) && $item->images) {
                        echo '<a href="' . $item->link . '"><img src="' . JUri::base() . $item->images . '" alt="' . $item->title . '"/></a>';
                    } ?>
                    <?php if ($params -> get('show_title',1)): ?>
                        <a href="<?php echo $item->link ?>"><?php echo $item->title; ?>
                            <?php if (isset($item->total)): ?>
                                <span>(<?php echo $item->total ?>)</span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($params -> get('show_desc',1) && $item->description) {
                        echo '<div class="tz_desc">' . $item->description . '</div>';
                    } ?>
                </div>
                <?php for ($k = 0; $k > $subLevel; $k--): ?>
                    </div>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>

            <?php $i++; ?>
        <?php endforeach; ?>
        <?php $str = ob_get_contents() ?>
        <?php ob_end_clean(); ?>
        <?php echo $str; ?>
    </div>
<?php endif; ?>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('.category-menu').find('[id^=category-btn-]').each(function (index, btn) {
            var btn = jQuery(btn);
            btn.on('click', function () {
                jQuery(this).find('span').toggleClass('fa-chevron-right')
                    .toggleClass('fa-chevron-down')
                    .end().next('a').toggleClass('active');
            });
        });
    });
</script>
