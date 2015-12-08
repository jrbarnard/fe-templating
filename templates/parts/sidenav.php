<aside>
	<?php //TODO: Work on integrating methods for sidenav stuff into base class ?>
	
	<?php // Example of getting the sidenav of the overall top level parent ?>
	<?php echo $tp->build_nav($tp->structure[$tp->uri_structure[0]]['children'], $tp->build_uri($tp->uri_structure[0])); ?>
	
	<?php // example of checking if parent has children and if so showing direct parent children ?>
	<?php if (isset($template->parent->page['children']) && !empty($template->parent->page['children'])): ?>
		<nav class="sidenav">
			<h2 class="sidenav__parent"><a href="<?php echo $template->build_uri($template->parent->uri); ?>"><?php echo $template->get_parent_title(); ?></a></h2>
			<?php $template->build_nav($template->parent->page['children'], $template->build_uri($template->get_parent_uri())); ?>
		</nav>
	<?php endif; ?>
</aside>

