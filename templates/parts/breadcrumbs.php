<?php if (!empty($tp->breadcrumbs) && $tp->template !== '404'): ?>
	<nav class="breadcrumbs">
		<h2>Breadcrumbs</h2>
		<?php echo $tp->get_page_breadcrumb_markup(); ?>
	</nav>
<?php endif; ?>