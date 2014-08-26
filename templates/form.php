<?php 

$action_params = array('view' => 'form', 'action' => 'save');
if ($Slide->hasId() )
{
	$action_params['slideid'] = $Slide->getField('id');
}


?>


<form action="<?php echo $this->getAdminPanelUrl($action_params) ; ?>" method="post" id="lte-bs-slider-form">

<?php wp_nonce_field($this->action_token); ?>

	<table class="form-table">
		<tbady>
		<tr class="form-field">
			<th><label for="lte-bs-slide-url">Slide:</label></th>

			<td><a href="" class="button-secondary" id="select-slide-btn">Wybierz
					slajd z biblioteki mediów</a> 
					<input type="hidden"
				name="entry[slide_url]" id="lte-bs-slide-url" value="<?php echo $Slide->getField('slide_url'); ?>" />
				<?php if ($Slide->hasError('slide_url')): ?>
					<p class="description error"><?php echo $Slide->getError('slide_url'); ?></p>
				<?php else: ?>
					<p class="description">to pole jest wymagane</p>
				<?php endif; ?>
				<p id="slide-prewiew">
					<?php if ( $Slide->getField('slide_url') != NULL ): ?>
						<img src="<?php echo $Slide->getField('slide_url'); ?>" alt="" />
					<?php endif;?>
				</p>
			</td>
		</tr>




		<tr class="form-field">
			<th><label for="lte-bs-title">Tytuł:</label></th>

			<td><input type="text" name="entry[title]" id="lte-bs-title" value="<?php echo $Slide->getField('title'); ?>" />
				<?php if ($Slide->hasError('title')): ?>
					<p class="description error"><?php echo $Slide->getError('title'); ?></p>
				<?php else: ?>
					<p class="description">to pole jest wymagane</p>
				<?php endif; ?>
			</td>
		</tr>





		<tr class="form-field">
			<th><label for="lte-bs-caption">Podpis:</label></th>

			<td><input type="text" name="entry[caption]" id="lte-bs-caption" value="<?php echo $Slide->getField('caption'); ?>" />
				<?php if ($Slide->hasError('caption')): ?>
					<p class="description error"><?php echo $Slide->getError('caption'); ?></p>
				<?php else: ?>
					<p class="description">to pole jest wymagane</p>
				<?php endif; ?>
			</td>
		</tr>





		<tr class="form-field">
			<th><label for="lte-bs-read-more-url">Czytaj wiecej:</label></th>

			<td><input type="text" name="entry[read_more_url]"
				id="lte-bs-read-more-url" value="<?php echo $Slide->getField('read_more_url'); ?>" />
				<?php if ($Slide->hasError('read_more_url')): ?>
					<p class="description error"><?php echo $Slide->getError('read_more_url'); ?></p>
				<?php else: ?>
					<p class="description">to pole jest opcjonalne</p>
				<?php endif; ?>
			</td>
		</tr>





		<tr>
			<th><label for="lte-bs-position">Pozycja:</label></th>

			<td><input type="text" name="entry[position]" id="lte-bs-position" value="<?php echo $Slide->getField('position'); ?>" />
				<a href="#" class="button-secondary" id="get-last-pos">pobierz
					ostatnią wolną pozycję</a>
				<?php if ($Slide->hasError('position')): ?>
					<p id="pos-info" class="description error"><?php echo $Slide->getError('position'); ?></p>
				<?php else: ?>
					<p id="pos-info" class="description">to pole jest wymagane</p>
				<?php endif; ?>
			</td>
		</tr>





		<tr>
			<th>
				<label for="lte-bs-published">Opublikowany:</label>
			</th>

			<td>
				<input type="checkbox" name="entry[published]" id=lte-bs-published value="yes" <?php echo ($Slide->isPublished() ) ? 'checked="checked"' : ''; ?> />
			</td>
		</tr>

		</tbady>
	</table>


	<p class="submit">
		<a href="" class="button-secondary">Wstecz</a> &nbsp; <input
			type="submit" class="button-primary" value="Zapisz zmiany" />
	</p>
</form>