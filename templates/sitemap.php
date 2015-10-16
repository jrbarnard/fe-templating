<nav class="sitemap">
	<!-- Example of getting an attribute from the global template object (things like uri, title etc. See template-class.php for options) -->
	<h2>{{ tp_attr('title') }}</h2>
	
	<!-- Example of getting the full sitemap (boolean parameter if you want to only show items that have existing template files) -->
	{{ sitemap(true) }}
</nav>