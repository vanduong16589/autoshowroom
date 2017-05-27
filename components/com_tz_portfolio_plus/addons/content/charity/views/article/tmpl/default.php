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

if(isset($this -> item) && $this -> item):

    $doc = JFactory::getDocument();
    $doc->addStyleSheet(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/css/charity.css');
    $params = $this -> params;

?>
    <div class="portfolio_cause">
        <div class="charity">
            <div class="donate-goal">
                <div class="donate-progress">
                    <?php
                    // Get donated
                    if(isset($this->donated) && !empty($this->donated)):
                        $donated    = $this->donated;

                        $donateSum  = (int)$donated["sumDonate"];
                        $goalDonate = (int)$params->get('tz_crt_goal_money',0);
                        if($donateSum != 0 && $goalDonate != 0) {
                            $tlDonate   = ($donateSum*100)/$goalDonate;
                            if($tlDonate > 100) {
                                $tlDonate = 100;
                            }
                        }else {
                            $tlDonate   = 0;
                        }
                        ?>
                        <div class="item-progress">
                            <div class="child-prgb" style="width:<?php echo $tlDonate;?>%;">
                                <div id="prgb_child" class="wow slideInLeft animated">
                                </div>
                            </div>
                        </div>
                        <div class="progress-label">
                            <div class="progress-ed">
                                <?php echo JText::_('ADDON_COLLECTED');?>
                                <span><?php echo $donateSum;?></span>
                            </div>
                            <div class="total">
                                <?php echo JText::_('ADDON_DONATOR');?>
                                <span><?php echo $donated["countDonate"];?></span>
                            </div>
                            <div class="progress-final"><?php echo JText::_('ADDON_DONATE_GOAL');?><span><?php echo $goalDonate;?></span></div>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>

                <?php
                // Check button donate
                $donated_status = $params->get('tz_crt_donated_status',0);
                if($donated_status == 1) {
                    echo JText::_('SITE_NPF_FINISHED');
                }elseif($donated_status == 2) {
                    echo JText::_('SITE_NPF_PAUSE');
                }else {
                    ?>
                    <button id="tz-charity-donate" class="btn btn-donate" type="button" data-toggle="modal" data-target="#form-charity-donate"><?php echo JText::_('SITE_BUTTON_DONATE_THIS_CAUSE');?></button>
                <?php
                }
                ?>
            </div>

            <?php if($donated_status != 1 && $donated_status != 2):?>
                <div class="tz-form-donate donate-detail">
                    <div class="modal fade donate-modal" id="form-charity-donate" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="content-head">
                                        <?php
                                        $media  = $this -> item -> media;
                                        $imgUrl = $media -> image -> url;
                                        if(isset($imgUrl) && $imgUrl != '') {
                                            if ($size = $params->get('mt_image_size', 'o')) {
                                                $image_url_ext = JFile::getExt($imgUrl);
                                                $image_url = str_replace('.' . $image_url_ext, '_' . $size . '.'
                                                    . $image_url_ext, $imgUrl);
                                                $imgUrl = JURI::root() . $image_url;
                                                echo '<div class="bg-header" style="background-image: url('.$imgUrl.')"></div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    if($form    = $this -> formDonate):
                                        ?>
                                        <form action="<?php $this -> item -> link;?>" method="post" class="form-horizontal"
                                              enctype="multipart/form-data" id="donateForm" name="donateForm">
                                            <div class="donate-tab">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li role="presentation" class="active">
                                                        <a href="#donateTab1" aria-controls="home" role="tab" data-toggle="tab">
                                                            <?php echo JText::_('SITE_DESC_STEP1_DONATE');?></a></a>
                                                    </li>
                                                    <li role="presentation">
                                                        <a href="#donateTab2" class="donateTab2" aria-controls="home" role="tab" data-toggle="tab">
                                                            <?php echo JText::_('SITE_DESC_STEP2_DONATE');?></a></a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="error-select-amount"><?php echo JText::_('SITE_DESC_PLEASE_SELECT_AMOUNT_DONATE');?></div>
                                                    <div role="tabpanel" class="tab-pane active" id="donateTab1">
                                                        <p class="desc-specify"><?php echo JText::_('SITE_DESC_PLEASE_SPECIFY_DONATE');?></p>
                                                        <?php
                                                        $amounts    = $params -> get('tz_crt_amounts','');
                                                        ?>
                                                        <div class="choose-item">
                                                            <?php
                                                            if($amounts != '') {
                                                                $arrAmount  = explode(',', $amounts);
                                                                foreach($arrAmount as $i => $amV) {
                                                                    echo '<div class="item-input"><label>'.(int)$amV.'</label>' .
                                                                        '<input name="amount" id="input_amount_'.$i.'" class="input_donate" type="radio" value="'.(int)$amV.'" />' .
                                                                        '</div>';
                                                                }

                                                            }
                                                            $ct_amounts = $params -> get('tz_crt_ct_amounts','');
                                                            if($ct_amounts != 0) {
                                                                echo '<div class="item-input amount-custom">'
                                                                    . JText::_('SITE_DESC_PLEASE_AMOUNT_DONATE_CUSTOM') .
                                                                    '<input name="amount-custom" type="text" class="form-control donate-form-text-input" placeholder="$0" value="" />' .
                                                                    '</div>'
                                                                    ;
                                                            }
                                                            ?>
                                                            <div class="donate-number-error">
                                                                <?php echo JText::_('SITE_DONATE_ONLY_NUMBER'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div role="tabpanel" class="tab-pane" id="donateTab2">
                                                        <div class="about-donate">
                                                            <div class="item">
                                                                <?php echo $form -> getInput('firstname','value');?>
                                                            </div>
                                                            <div class="item"><?php echo $form -> getInput('email','value');?></div>
                                                            <div class="item"><?php echo $form -> getInput('address','value');?></div>
                                                            <div class="item"><?php echo $form -> getInput('comment','value');?></div>
                                                            <div class="item"><?php echo $form -> getInput('money_donate','value');?></div>
                                                        </div>

                                                        <div id="donate-form-submit" class="center-btn">
                                                            <button class="btn btn-primary radius-small" name="ok" type="submit">DONATE VIA</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="option" value="com_tz_portfolio_plus"/>
                                            <input type="hidden" name="view" value="article"/>
                                            <input type="hidden" name="id" value="<?php echo $this -> item -> id;?>"/>
                                            <input type="hidden" name="return" value="<?php echo base64_encode($this -> item -> fullLink);?>" />
                                            <input type="hidden" name="addon_view" value="donate"/>
                                            <input type="hidden" name="addon_task" value="charity.donate.process_donation"/>
                                            <?php if($addon = $this -> state -> get($this -> getName().'.addon')){?>
                                                <input type="hidden" name="addon_id" value="<?php echo $addon -> id;?>"/>
                                            <?php } ?>
                                            <?php echo JHtml::_( 'form.token' ); ?>
                                        </form>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif?>

        </div>
    </div>


<?php
endif; // end if isset($this -> item) && $this -> item
?>

<script type="text/javascript">
    jQuery(document).ready(function($){
        var $ctDonate = '';
        $('.tz-form-donate .choose-item .item-input').on("click", function(){
            $('.tz-form-donate .choose-item .item-input').removeClass('selected');
            $('input[name="amount"]').prop('checked', false);
            $(this).addClass('selected');
            $(this).find('.input_donate').prop('checked', true);
//            console.log($(this).find('.input_donate').is(':checked'));
            $('.tz-form-donate .donate-form-text-input').val('');
        });

        $(".donate-form-text-input").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $(".donate-number-error").show().fadeOut(1600);
                return false;
            }else {
                $(".donate-number-error").hide().fadeOut(1600);
            }
        });

        $('.donateTab2').on("click", function(){

            if($('.tz-form-donate .donate-form-text-input').length > 0) {
                $ctDonate   = $('.tz-form-donate .donate-form-text-input').val();
            }else {
                $ctDonate   = '';
            }
            if($("input[name='amount']").is(':checked') == true || $ctDonate != '') {
                if($ctDonate == '') {
                    $ctDonate   = $("input[name='amount']:checked").val();
                }
                return true;
            }else {
                $('.error-select-amount').show().fadeOut(3000);
                return false;
            }
        });
//        console.log($ctDonate);
        $('#donate-form-submit').on("click", function() {
            $('#jform_value_money_donate').val($ctDonate);
        });

    });
</script>