<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form class="detailsform" action="<?php echo url_for('/sfJunaioBackendDetails/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="inputArea inputAreaAccordionLeft">
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>
    <div id="accordionleft">
        <h3><a href="#">Main Data</a></h3>
        <div>
            <?php echo $form['name']->renderLabel() ?>
            <?php echo $form['name']->renderError() ?>
            <?php echo $form['name'] ?>

            <?php echo $form['description']->renderLabel() ?>
            <?php echo $form['description']->renderError() ?>
            <?php echo $form['description'] ?>
        </div>
        <h3><a href="#">Contact</a></h3>
        <div>
            <?php echo $form['phone']->renderLabel() ?>
            <?php echo $form['phone']->renderError() ?>
            <?php echo $form['phone'] ?>

            <?php echo $form['mail']->renderLabel() ?>
            <?php echo $form['mail']->renderError() ?>
            <?php echo $form['mail'] ?>

            <?php echo $form['homepage']->renderLabel() ?>
            <?php echo $form['homepage']->renderError() ?>
            <?php echo $form['homepage'] ?>
        </div>
        <h3><a href="#">Coordinate</a></h3>
        <div>
            <?php echo $form['altitude']->renderLabel() ?>
            <?php echo $form['altitude']->renderError() ?>
            <?php echo $form['altitude'] ?>

            <?php echo $form['latitude']->renderLabel() ?>
            <?php echo $form['latitude']->renderError() ?>
            <?php echo $form['latitude'] ?>

            <?php echo $form['longitude']->renderLabel() ?>
            <?php echo $form['longitude']->renderError() ?>
            <?php echo $form['longitude'] ?>
        </div>
        <h3><a href="#">Parameter</a></h3>
        <div>
            <?php echo $form['perimeter']->renderLabel() ?>
            <?php echo $form['perimeter']->renderError() ?>
            <?php echo $form['perimeter'] ?>

            <?php echo $form['maxdistance']->renderLabel() ?>
            <?php echo $form['maxdistance']->renderError() ?>
            <?php echo $form['maxdistance'] ?>

            <?php echo $form['minaccuracy']->renderLabel() ?>
            <?php echo $form['minaccuracy']->renderError() ?>
            <?php echo $form['minaccuracy'] ?>
        </div>
    </div>
</div>
<div class="inputArea inputAreaAccordionRight">
    <div id="accordionright">
        <h3><a href="#">Theme</a></h3>
        <div>
            <?php echo $form['thumbnail']->renderLabel() ?>
            <?php echo $form['thumbnail']->renderError() ?>
            <?php echo $form['thumbnail'] ?>

            <?php echo $form['icon']->renderLabel() ?>
            <?php echo $form['icon']->renderError() ?>
            <?php echo $form['icon'] ?>
        </div>
        <h3><a href="#">Media</a></h3>
        <div>
            <?php echo $form['mtype']->renderLabel() ?>
            <?php echo $form['mtype']->renderError() ?>
            <?php echo $form['mtype'] ?>

            <?php echo $form['mainresource']->renderLabel() ?>
            <?php echo $form['mainresource']->renderError() ?>
            <?php echo $form['mainresource'] ?>
            <br/><img class="resouceicon" height="40" src="<?php echo $form['mainresource']->getValue() ?>" alt="<?php echo $form['mainresource']->getValue() ?>"/>
            
        </div>
    </div>
</div>
</form>
<script type="text/javascript" >
$(function() {
    $( "#accordionleft" ).accordion();
    $( "#accordionright" ).accordion();
});

jQuery(document).ready(function(){
    $('.accordionleft .head').click(function() {
            $(this).next().toggle('slow');
            return false;
    }).next().hide();
    
    $('.accordionright .head').click(function() {
            $(this).next().toggle('slow');
            return false;
    }).next().hide();
});
</script>