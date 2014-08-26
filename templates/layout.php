<div class="wrap">
	<h2><a href="<?php echo $this->getAdminPanelUrl(); ?>" >layout home slider</a>
		<a href="<?php echo $this->getAdminPanelUrl(array('view' => 'form')); ?>" class="add-new-h2">dodaj nowy slide</a>
	</h2>
	<?php if ($this->hasFlashMsg()): ?>
	
	<div class="<?php echo $this->getFlashMsgStatus(); ?>" id="message">
		<p><?php echo $this->getFlashMsg(); ?></p>
	</div>
	
	<?php endif; ?>
	
	
	<?php require_once $view; ?>
	
	<br style="clear: both;" >
</div>