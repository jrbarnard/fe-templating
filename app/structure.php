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

$structure = array(
	"/" => array(
		"title" 		=> "Home",
		"template" 		=> "home",
		"hidden"		=> true,
		"show-top-level" => true,
		"breadcrumbs"	=> false
	),
	"About" => array(
		"title" 	=> "About",
		"template" 	=> "landing-standard",
		"content"	=> "about-landing"
	),
	"locations" => array(
		"title"		=> "Locations",
		"template" 	=> "landing-standard",
		"content"	=> "locations-landing",
		"children" 	=> array(
			"location_1" => array(
				"title" 	=> "Location 1",
				"template" 	=> "",
				"children" 	=> array(
					"further_info" => array(
						"title" 	=> "Location 1 further info",
						"template" 	=> ""
					),
					"contact_info" => array(
						"title" 	=> "Location 1 contact info",
						"template" 	=> ""
					)
				)
			),
			"location_2" => array(
				"title"		=> "Location 2",
				"template"	=> ""
			)
		)
	),
	"staff" => array(
		"title"		=> "Staff",
		"template"	=> ""
	),
	"volunteers" => array(
		"title"		=> "Volunteers",
		"template"	=> ""
	),
	'contact_us' => array(
		"title"		=> "Contact us",
		"template"	=> "",
		"hidden" => true,
		"breadcrumbs"	=> false,
		"show-top-level" => true
	),
	'sitemap' => array(
		"title"		=> "Sitemap",
		"template"	=> "sitemap",
		"hidden" => true
	)
)

?>