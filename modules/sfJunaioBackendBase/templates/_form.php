<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<div class="inputArea">
<form action="<?php echo url_for('sfJunaioBackendBase/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>
<fieldset class="mandatory">
<?php echo $form['name']->renderLabel() ?>
<?php echo $form['name']->renderError() ?>
<?php echo $form['name'] ?>
<?php echo $form['description']->renderLabel() ?>
<?php echo $form['description']->renderError() ?>
<?php echo $form['description'] ?>
</fieldset>
<fieldset class="latlng">
<?php echo $form['latitude']->renderLabel() ?>
<?php echo $form['latitude']->renderError() ?>
<?php echo $form['latitude'] ?>
<?php echo $form['longitude']->renderLabel() ?>
<?php echo $form['longitude']->renderError() ?>
<?php echo $form['longitude'] ?>
</fieldset>
&nbsp;<a class="backtolist" href="<?php echo url_for('sfJunaioBackendBase/index') ?>">Back to list</a>
<?php if (!$form->getObject()->isNew()): ?>
<div style="float: left;">
&nbsp;<?php echo link_to('Delete', 'sfJunaioBackendBase/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?><br/>
&nbsp;<a href="#" onClick="parent.editPOI('form', <?php echo $form->getObject()->getId(); ?>, '<?php echo $form->getObject()->getName(); ?>');return false;">Edit Details</a>
</div>
<?php endif; ?><input type="submit" value="Save" /><div class="clear"></div>
</form>
</div>