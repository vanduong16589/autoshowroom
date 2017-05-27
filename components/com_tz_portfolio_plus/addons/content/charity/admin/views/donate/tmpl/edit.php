<?php
/**
 * Created by PhpStorm.
 * User: thuongnv
 * Date: 3/7/2016
 * Time: 11:46 AM
 */

//no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');

$addonId    = $this -> state -> get($this -> getName().'.addon_id');

$valueAddon = json_decode($this -> item -> value);

?>

<form action="<?php echo JRoute::_(TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId)
                .'&addon_view=donate&addon_layout=edit&id='.$this -> item -> id);?>"
                method="post" name="adminForm" id="adminForm">

    <div class="form-horizontal">
        <?php
            echo JHtml::_('bootstrap.startTabSet','myTab',array('active' => 'details'));
            echo JHtml::_('bootstrap.addTab','myTab','details',JText::_('JDETAILS',true));
        ?>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <div class="control-label">
                        <?php echo $this -> form -> getLabel('firstname','value');?>
                    </div>
                    <div class="controls">
                        <?php echo $valueAddon->firstname;?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="control-label">
                        <?php echo $this -> form -> getLabel('email','value');?>
                    </div>
                    <div class="controls">
                        <?php echo $valueAddon->email;?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="control-label">
                        <?php echo $this -> form -> getLabel('money_donate','value');?>
                    </div>
                    <div class="controls">
                        <?php echo $valueAddon->money_donate;?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="control-label">
                        <?php echo $this -> form -> getLabel('address','value');?>
                    </div>
                    <div class="controls">
                        <?php echo $valueAddon->address;?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="control-label">
                        <?php echo $this -> form -> getLabel('comment','value');?>
                    </div>
                    <div class="controls">
                        <?php echo $valueAddon->comment;?>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <div class="control-label"><?php echo $this -> form -> getLabel('published');?></div>
                    <div class="controls"><?php echo $this -> form -> getInput('published');?></div>
                </div>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>
    </div>
    <input type="hidden" name="addon_task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>