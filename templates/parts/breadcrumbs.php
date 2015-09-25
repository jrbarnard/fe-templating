<?php if (!empty($tp->breadcrumbs) && $tp->template !== '404'): ?>
	<div class="width-screen">
		<div class="width-page">
			<nav class="breadcrumbs">
				<?php echo $tp->get_page_breadcrumb_markup(); ?>
			</nav>
		</div>
	</div>
<?php endif; ?>