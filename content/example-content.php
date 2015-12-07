<?php
/**
 * This is an example of a content array for use with an associated twig template
 * In order to use, this file name (without .php) must be specified within the structure file in the app directory i.e "content" => "example-content".
 * You can specify any number of vars and values here within the returned array.
 */
return array(
	"title_example"	=> "Example title", // Example var -> var_name => var_value
	"desc_example"	=> "Example Description",
	"main_wysiwyg"	=> " 
		<h2>Example heading wysiwyg</h2>
		<ul>
			<li>Test list item 1</li>
			<li>Test list item 2</li>
		</ul>
	", // Example html var -> var_name => var_value -> when echoing out you must specificy raw
	"carousel" => array( // example multidimensional array var_name => array - These can be looped within the twig templates and accessed using dot notation e.g carousel_slide.text
		"title" => "carousel title",
		"slides" => array(
			"1" => array(
				"text" => "slide 1 text",
				"img" => array(
					"src" => "slide 1 image src",
					"alt" => "slide 1 image alt"
				)
			),
			"2" => array(
				"text" => "slide 2 text",
				"img" => array(
					"src" => "slide 2 image src",
					"alt" => "slide 2 image alt"
				)
			),
			"3" => array(
				"text" => "slide 3 text",
				"img" => array(
					"src" => "slide 3 image src",
					"alt" => "slide 3 image alt"
				)
			),	
		)
	)
);