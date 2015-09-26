<header>
	<h1>Navigation - all</h1>
	<nav>
		<!-- Here is an example of getting the entire tree structure nav markup -->
		<?php echo $tp->build_nav(); ?>
	</nav>
	<h2>Navigation - just top level</h2>
	<nav>
		<!-- Here is an example of getting just the top level nav items and not recursively going down the tree -->
		<?php echo $tp->toplevelnav(); ?>
	</nav>
</header>