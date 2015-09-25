<?php
/**
 * Usage of front end templating structure:
 * - To add a page add in an array element as such:
 *   "uri-value" => array(
 *			"title" => "value to appear in nav and title meta etc",
 *			"template" => "which template to use (same as name of file in templates folder without the .php extension, if in sub folder, do subfolder/filename.",
 *			"hidden" => true or false determines if hidden from general navigation across the site, default false (optional),
 *			"show-top-level" => true or false determines if should be shown in top level nav (optional),
 *			"breadcrumbs" => true or false determines if you want to show or hide breadcrumbs for that page, default is true (optional),
 *			"children" => an array of pages like this example, which will be iterated over for navigation etc (same options as above)
 *		)
 *
 */

global $template_path;
$template_path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR; // template path

$structure = array(
	"/" => array(
		"title" 		=> "Home",
		"template" 		=> "home",
		"hidden"		=> true,
		"show-top-level" => true,
		"breadcrumbs"	=> false
	),
	"top_level_1" => array(
		"title" 	=> "Top Level 1",
		"template" 	=> ""
	),
	"top_level_2" => array(
		"title"		=> "Top Level 2",
		"template" 	=> "",
		"children" 	=> array(
			"child_1" => array(
				"title" 	=> "Child 1 of Top Level 2",
				"template" 	=> "",
				"children" 	=> array(
					"child_1" => array(
						"title" 	=> "Child 1 of Child 1 of Top Level 2",
						"template" 	=> ""
					),
					"child_2" => array(
						"title" 	=> "Child 2 of Child 1 of Top Level 2",
						"template" 	=> ""
					)
				)
			),
			"child_2" => array(
				"title"		=> "Child 2 of Top Level 2",
				"template"	=> ""
			)
		)
	),
	"top_level_3" => array(
		"title"		=> "Top Level 3",
		"template"	=> ""
	),
	"top_level_4" => array(
		"title"		=> "Top Level 4",
		"template"	=> ""
	),
	"top_level_5" => array(
		"title"		=> "Top Level 5",
		"template"	=> ""
	),
	"top_level_6" => array(
		"title"		=> "Top Level 6",
		"template"	=> ""
	),
	'top_level_7' => array(
		"title"		=> "Top Level 7",
		"template"	=> "",
		"hidden" => true,
		"breadcrumbs"	=> false
	),
	'sitemap' => array(
		"title"		=> "Sitemap",
		"template"	=> "sitemap",
		"hidden" => true
	)
)

?>