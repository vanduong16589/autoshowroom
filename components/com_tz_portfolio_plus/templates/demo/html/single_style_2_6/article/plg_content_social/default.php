<?php
/*------------------------------------------------------------------------
# plg_extravote - ExtraVote Plugin
# ------------------------------------------------------------------------
# author    Joomla!Vargas
# copyright Copyright (C) 2010 joomla.vargas.co.cr. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://joomla.vargas.co.cr
# Technical Support:  Forum - http://joomla.vargas.co.cr/forum
-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

if(isset($this -> item) && $this -> item){
	$url = $this -> item -> fullLink;
	$title = $this -> item -> title;
    $params = $this -> params;
?>
    <?php if(($params -> get('show_twitter_button',1)) OR ($params -> get('show_facebook_button',1))
        OR ($params -> get('show_google_button',1)) OR $params -> get('show_pinterest_button',1)
        OR $params -> get('show_linkedin_button',1)):?>
        <div class="tz_portfolio_plus_like_button">
            <div class="TzLikeButtonInner">
                <?php
                // Facebook Button
                if($params -> get('show_facebook_button',1)):
                ?>
                    <a class="st facebook" rel="bookmark" id="fb-share"
					   onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title; ?>&amp;p[url]=<?php echo $url; ?>','sharer','toolbar=0,status=0,width=580,height=325');" href="javascript: void(0)">
						<i class="fa fa-facebook"></i>
					</a>
                <?php endif; ?>

                <?php
                // Twitter Button
                if($params -> get('show_twitter_button',1)):
                    ?>
                    <div class="TwitterButton">
                        <a id ="tw-share" class="st twitter"
						   onClick="window.open('http://twitter.com/share?text=<?php echo $title; ?>&amp;url=<?php echo $url; ?>','shar.er','toolbar=0,status=0,width=580,height=325');" href="javascript: void(0)">
							<i class="fa fa-twitter"></i>
						</a>
						<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
                    </div>
                <?php endif; ?>

                <?php
                // Google +1 Button
                if($params -> get('show_google_button',1) == 1):
                    ?>
                    <div class="GooglePlusOneButton">
                        <a id="g-share" class="st google"
						   onClick="window.open('https://plus.google.com/share?url=<?php echo $url; ?>','sharer','toolbar=0,status=0,width=580,height=325');" href="javascript: void(0)">
							<i class="fa fa-google-plus-square"></i>
						</a>
                    </div>
                <?php endif; ?>

                <?php
                // Pinterest Button
                if($params -> get('show_pinterest_button',1)):
                    ?>
                    <a class="st pin" data-pin-do="buttonPin" data-pin-custom="true"
                       href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url; ?>">
                        <i class="fa fa-pinterest-p"></i>
                    </a>
                    <script async defer src="//assets.pinterest.com/js/pinit.js"></script>
                <?php endif;?>

                <?php
                // Linkedin Button
                if($params -> get('show_linkedin_button',1)):
                    ?>
                    <!-- Linkedin Button -->
                    <div class="LinkedinButton">
                        <a class="st linkedin" href="javascript: void(0)"
                           onClick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>','sharer','toolbar=0,status=0,width=580,height=325');">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </div>
                <?php endif;?>
                <div class="clearfix"></div>
            </div>
        </div>
    <?php endif; ?>
<?php }