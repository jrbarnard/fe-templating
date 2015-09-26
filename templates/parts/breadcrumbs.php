<?php if (!empty($tp->breadcrumbs) && $tp->template !== '404'): ?>
	<nav class="breadcrumbs">
		<h2>Breadcrumbs</h2>
		<!-- Here is an example to get the breadcrumbs for a page (this will auto generate them based off the uri structure) -->
		<?php echo $tp->get_page_breadcrumb_markup(); ?>
	</nav>
<?php endif; ?>