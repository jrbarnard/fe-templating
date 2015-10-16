<nav class="sitemap">
	<h2>Sitemap</h2>
	
	<!-- Example of getting an attribute from the global template object (things like uri, title etc. See template-class.php for options) -->
	{{ tp_attr('template') }}
	
	<!-- Example of getting the full sitemap -->
	{{ sitemap(true) }}
</nav>