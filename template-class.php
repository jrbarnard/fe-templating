<?php

/**
 * Class to build up your pages and structure based off a single structure file for your page structure
 *
 *
 *
 */
class Template {
	
	public $structure = array(); // storage for structure tree
	public $uri; // storage for current uri in it's base form e.g test/test2/test3/
	public $uri_structure = array(); // storage for the uri structure in an array e.g array('test', 'test2', 'test3')
	public $pages = 0; // number of pages in uri structure (simple count of $uri_structure in construct)
	public $template = '404'; // template for current page (defaults to 404 if template doesn't exist)
	public $currentpage; // current page (current page object including structure)
	public $parent; // parent object (parent page object including structure)
	public $title = '404'; // title of page to load into head
	public $breadcrumbs = array(); // breadcrumbs for current page 
	
	
	function __construct($structure) {
		// store passed in php structure tree
		$this->structure = $structure;
		// store current uri
		$this->uri = $this->current_uri();
		//store uri structure array
		$this->uri_structure = $this->uri == '/' ? array('/') : $this->uri_structure($this->uri);
		
		// get num of pages
		$this->pages = count($this->uri_structure);
		// search for currentpage (end of structure)
		$this->currentpage = $this->search_for_page($this->uri_structure[$this->pages - 1]);
		// get parent object
		$this->parent = $this->search_for_page($this->get_parent());
		
		// if current page has been found (not 404)
		if ($this->currentpage !== false && $this->currentpage->page !== false) {
			$this->template = $this->currentpage->page['template']; // get template
			$this->title = $this->currentpage->page['title']; // get title
			$this->breadcrumbs = $this->get_page_breadcrumbs(); // get the breadcrumbs
		}
	}
	
	
	/**
	 * Gets current uri
	 *
	 * @return string url
	 */
	private function current_uri() {
	    if (empty($_GET['p']))
			$_GET['p'] = '/';
	    
	    return $_GET['p'];
	}
	
	
	/**
	 * Gets uri structure (e.g test/hello goes to array('test', 'hello'))
	 *
	 * @param $uri - string url e.g test/test2
	 *
	 * @return array - exploded url
	 */
	private function uri_structure($uri) {
		if (empty($uri))
			return array();
		// explode into array
		$arr = explode('/', $uri);
		// check for empty values, unset and then reindex
		foreach ($arr as $i => $val) {
			if ($val === "")
				unset($arr[$i]);
		}
		$arr = array_values($arr);
		
		return $arr;
	}
	
	
	/**
	 * Gets current page of uri structure (end one) and returns it
	 *
	 * @param $page - page slug
	 * @param $array - array to check in, defaults to base structure stored in structure property
	 *
	 * @return page tree or false if fails
	 */
	private function get_page($page, $array = array()) {
		if (empty($array)) // if array is empty or default then set array to the general stored structure
			$array = $this->structure;
		
		if (array_key_exists( $page , $array ))
			return $array[$page];
		else
			return false;
	}
	
	
	/**
	 * Searches through the structure for a page, if it exists it returns the page, else returns false
	 * NB: this only checks within the current uri structure (as it's only for getting valid pages - searching the tree without a route would be overly inefficient for our needs)
	 *
	 * @param $page - page slug to search for
	 *
	 * @return page object or false if doesn't exist
	 */
	public function search_for_page($page) {
		// check for single case and return value
		if ($this->pages == 1) {
			$return = new stdClass();
			$return->uri = $this->uri_structure[0];
			$return->page = $this->get_page($this->uri_structure[0]);
			$return->level = 0;
			return $return;
		}
		
		// store a pointer so we can walk to array
		$pointer = $this->structure;
		// iterate over pages
		for ($i = 0; $i < $this->pages; $i++) {
			if ($i > 0) {
				$pointer = $pointer['children'];
			}
			$pointerpage = $this->get_page($this->uri_structure[$i], $pointer);
			// if there is a page on this level as part of the uri structure
			if ($pointerpage !== false) {
				// there is a page so check if it is the one we're looking for
				if ($this->uri_structure[$i] == $page) {
					// it is, store the page and level in an object and return
					$return = new stdClass();
					$return->uri = $this->uri_structure[$i];
					$return->page = $pointerpage;
					$return->level = $i;
					return $return;
				}
				// else set the pointer and iterate
				$pointer = $pointerpage;
			} else {
				return false;
			}
		}
	}
	
	
	/**
	 * Method to build a uri based off a value in the uri structure
	 *
	 * @param $uri - CONTINUE HERE
	 */
	public function build_uri($uri, $uristring = '') {
		//get index of uri in array
		$index = array_search($uri, $this->uri_structure);
		if ($index >= 0) {
			$uristring = '/' . $uri . $uristring;
			// now check if we can build a next level
			if ($index > 0) {
				return $this->build_uri($this->uri_structure[$index - 1], $uristring);
				// return $this->uri_structure[$index - 1];
			} else {
				return $uristring;
			}
		} else {
			return $uristring;
		}
	}
	
	/**
	 * Method to check if a template exists
	 */
	public function template_exists($template = "") {
		if (empty($template)) {
			$template = $this->template;
		}
		global $template_path;
		
		return file_exists($template_path . $template . '.php');
	}
	
	/**
	 * Method to get the parent uri of the current page
	 *
	 */
	private function get_parent() {
		$parentindex = $this->pages - 2;
		// if first level or home then return /
		if ($parentindex < 0) {
			return '/';
		}
		return $this->uri_structure[$this->pages - 2];
	}
	
	/**
	 * Method to build nav into markup
	 *
	 */
	public function build_nav($structure = array(), $parent = "", $alllevels = true, $honorhidden = true, $showonlyvalid = false) {
		if (empty($structure)) {
			$structure = $this->structure;
		}
		
		// loop through structure ?>
		<ul class="<?php if (!empty($parent)): echo 'subnav-contents'; endif; ?>">
			<?php foreach ($structure as $uri => $values): ?>
				<?php if ((!isset($values['hidden']) || !$values['hidden']) || !$honorhidden):
					// check if you only want to show valid links
					if (!$showonlyvalid || $this->template_exists($values['template'])): ?>
						<?php
							//check if has children
							$children = (($alllevels && (isset($values['children']) && !empty($values['children']))) ? true : false);
						?>
						<li <?php echo ($children ? 'class="has-children"' : ''); ?>>
							<div class="nav-name <?php echo $this->get_classes($uri); ?>">
								<a href="<?php echo $parent . '/' . $uri; ?>"><?php echo $values['title']; ?></a>
							</div>
							<?php
								if ($children) {
									$this->build_nav($values['children'], $parent . '/' . $uri);
								}
							?>
						</li>
					<?php endif; // end check if to show only valid ?>
				<?php endif; // end hidden check ?>
			<?php endforeach; // end build loop ?>
		</ul>
		<?php
	}
	
	/**
	 * Method to build site sitemap
	 *
	 */
	public function sitemap($showonlyvalid = false) {
		// call build nav
			//empty array for all structure
			//empty string for parent
			//true for alllevels
			//false to not honor hidden
		$this->build_nav(array(), "", true, false, $showonlyvalid);
	}
	
	/**
	 * Method to get top level nav only
	 *
	 */
	public function toplevelnav() {
		ob_start(); ?>
			<ul>
				<?php
				$count = 0;
				// loop over top level structure
				foreach($this->structure as $uri => $values):
					// this checks if show top level is there and true then it shows
					// however if not there or false and set to hidden then don't show
					if ((isset($values['show-top-level']) && $values['show-top-level']) || (!isset($values['hidden']) || !$values['hidden'])): ?>
						<?php if ($count !== 0): echo '-->'; endif; ?><li><a href="<?php echo $uri; ?>" class="<?php echo $this->get_classes($uri); ?>"><?php echo $values['title']; ?></a></li><?php echo '<!--'; $count++; ?>
					<?php endif;
				endforeach; ?>
				<?php echo '-->'; ?>
			</ul>
		<?php
		// return the caught output above
		return ob_get_clean();
	}
	
	/**
	 * Method to check if a uri is active
	 *
	 */
	private function is_active($uri) {
		if (in_array($uri, $this->uri_structure)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Method to check if a uri is current
	 *
	 */
	private function is_current($uri) {
		if ($uri == $this->currentpage->uri) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Method to create class string for nav
	 *
	 */
	public function get_classes($uri) {
		if (empty($uri))
			return false;
		
		$classes = "";
		if ($this->is_active($uri))
			$classes .= "active ";
		if ($this->is_current($uri))
			$classes .= "current";
		
		return $classes;
	}
	
	/**
	 * Method to get uri of parent
	 *
	 */
	public function get_parent_uri() {
		return $this->parent->uri;
	}
	
	/**
	 * Method to get title of parent
	 *
	 */
	public function get_parent_title() {
		return $this->parent->page['title'];
	}
	
	/**
	 * Method to get breadcrumbs array for page
	 *
	 */
	private function get_page_breadcrumbs() {
		// check if currentpagedoesnt want breadcrumbs
		if (isset($this->currentpage->page['breadcrumbs']) && !$this->currentpage->page['breadcrumbs']) {
			return array();
		}
		$homeuri = '/';
		$breadcrumbs = array($homeuri => $this->structure[$homeuri]['title']);
		foreach($this->uri_structure as $uri) {
			//search for the page
			$page = $this->search_for_page($uri);
			// add an item to breadcrumbs array of uri => title
			$breadcrumbs[$this->build_uri($uri)] = $page->page['title'];
		}
		return $breadcrumbs;
	}
	
	/**
	 * Method to get breadcrumb markup for page
	 *
	 */
	public function get_page_breadcrumb_markup() {
		// start recording output
		ob_start();
		?>
		<ul>
			<?php
			$count = 0;
			$total = count($this->breadcrumbs) - 1;
			// iterate over uri structure to build breadcrumbs
			foreach ($this->breadcrumbs as $uri => $title): ?>
				<li>
					<?php if ($count < $total): ?>
						<a href="<?php echo $uri; ?>"><?php echo $title; ?></a>
					<?php else: ?>
						<span><?php echo $title; ?></span>
					<?php endif; ?>
				</li>
			<?php
				$count++;
				endforeach; // finish uri structure loop
			?>
		</ul>
		<?php
		// return recorded output and empty
		return ob_get_clean();
	}
}


/**
 * Function for formatted var dump
 */
function rr_d($contents) {
	echo '<pre>';
	var_dump($contents);
	echo '</pre>';
}
