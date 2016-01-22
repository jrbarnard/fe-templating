<aside>
	<?php //TODO: Work on integrating methods for sidenav stuff into base class ?>
	
	<?php // Example of getting the sidenav of the overall top level parent ?>
	<?php if (isset($tp->structure[$tp->uri_structure[0]]['children'])): ?>
	    <?php echo $tp->build_nav($tp->structure[$tp->uri_structure[0]]['children'], $tp->build_uri($tp->uri_structure[0])); ?>
	<?php endif; ?>
	
	<?php // example of checking if parent has children and if so showing direct parent children ?>
	<?php if (isset($tp->parent->page['children']) && !empty($tp->parent->page['children'])): ?>
		<nav class="sidenav">
			<h2 class="sidenav__parent"><a href="<?php echo $tp->build_uri($tp->parent->uri); ?>"><?php echo $tp->get_parent_title(); ?></a></h2>
			<?php $tp->build_nav($tp->parent->page['children'], $tp->build_uri($tp->get_parent_uri())); ?>
		</nav>
	<?php endif; ?>
</aside>

