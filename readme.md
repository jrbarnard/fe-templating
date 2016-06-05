# Front end templating framework #

This project is made to help rapid development of front end website prototypes with a component based system and a non folder based route structure.

- It helps to speed up development by helping you create, update, move and delete pages. It does this by moving your entire page structure within a json file, then dynamically building your pages per request.
- It helps you split your pages into components using the highly extensible Twig templating language.
- It allows you to reuse templates and components, building the page up on the fly using the attributes you set in the json structure file.
- It dynamically builds navigation based off your structure if you want it, helping to make quick, non-breaking changes in one place as opposed to multiple in a more traditional prototype.
- It's extensible using the built in Extension API. - COMING SOON

------

## Contents ##

1. [Project setup](#projectsetup)
2. [Usage](#usage)
    - [Structure general](#usage:structure)
    - [Creating a template](#usage:template-create)
    - [Linking a page to a template](#usage:page-template-linking)
    - [Going further with page content](#usage:page-content-going-further)
    - [Going further with templating](#usage:templating-going-further)
3. [Menus](#menus)
4. [Development helpers](#devel)
    - [Clearing cache](#devel:cache)
    - [Development twig functions](#devel:twig-dump)

------

## <a id="projectsetup">Project setup</a> ##

1. Clone / download the framework into your project directory.
2. Run composer install in the project root, if you don't have composer download [here](https://getcomposer.org/)
3. Run a webserver and point it to the project directory
 - You can either do this by using Wamp, Mamp, Xampp, Vagrant etc.
 - Or by running the utility helper (only available in php 5.4+):
    - In the root
    ```
    php fetemp serve
    ```
You will then have the example project set up!
Take some time to look at the examples, how it's used and any comments.

--

## <a id="usage">Usage</a> ##

You are free to use, extend, edit etc however you wish, however the generic usage to get you started is below.

### <a id="usage:structure">Structure general:</a> ###

The underlying structure of this tool is the routes you set up in your structure.json file, this is located in the root
of the project.

The rough structure is:
```json
{
    "routes": {
        "locations" : { // single uri of the route, not the combined route
            "title": "Company Locations", // the title to display with the page
            "link-title": "Locations", // the title to display in navigation links (this is optional)
            "description": "I am some description", // used for meta descriptions and potentially elsewhere
            "template": "location-landing", // the template name to use
            "content": "locations", // the content name to use (this can also be json directly - [see below](#usage:page-template-linking))
            "hidden": true, // whether to hide from navigation menus which honor the hidden flag
            "breadcrumbs": false, // whether we want to display breadcrumbs - this may be removed in the future and determined by templates
            "children": { // the children of the route
                // Children follow identical options as above
                "france": {
                    "title": "French Location",
                    "template": "location-single",
                    "content": {
                        "some_variable_name": "some_variable_value",
                        // this can then be accessed in twig like: {{ some_variable_name }}
                        "some_other_variable_name": {
                            "multi_dimensional_variable": true
                            // this can then be accessed in twig like: {{ some_other_variable_name.multi_dimensional_variable }}
                        }
                    }
                }
            }
        },

    }
}
```

### <a id="usage:template-create">Creating a template:</a> ###
Create a file within the templates directory with a .twig extension, e.g location-detail.twig
Most templates will extend a base or set of base templates, at the top of your page, ensure to extend the relevant one.
```twig
{#
    Bear in mind that if your templates are in subdirectories of the templates directory you will need to specify, e.g bases/base.twig
    The paths are always relative to the templates directory not from the current file
#}
{% extends 'base.twig' %}

// content
```

You can then hook into the extended templates [blocks](http://twig.sensiolabs.org/doc/tags/block.html)
For example, in the example files base.twig it has a block called 'content', to hook into this do:
```twig
{% extends 'base.twig' %}

{% block content %}
    I am the content that will appear within the content block on the base template
{% endblock %}
```

### <a id="usage:page-template-linking">Linking a page to a template</a> ###

Now you have a template you can link a page up to it.

- Go to your structure.json file in App/structure.json.
- Add a new page entry (route):
```json
"new-page": {
  "title": "New page",
  "template": "new-template" // is the name of the template you just created, we automatically append the .twig
}
```
- If you now visit {domain}/new-page in your url you will see the template and text you just added

That's pretty cool, but it gets old real fast when you have multiple pages that would use the same template, but uses different text
So you can add multiple pages that share templates:

- Add another couple of page entries (routes):
```json
"new-page": {
  "title": "New page",
  "template": "new-template",
  "content": {
    "page_text": "I am page 1"
  }
},
"new-page-2": {
  "title": "New page two",
  "template": "new-template",
  "content": {
    "page_text": "I am page 2"
  }
}
```
- Note we've added a new option called content, this specifies page / route specific content to be served along with the template, giving you a tonne of flexibility.
- Now if you reopen your new-template.twig template and replace the text with a twig placeholder:
```twig
{% extends 'base.twig' %}

{% block content %}
    {{ page_text }}
{% endblock %}
```
- Now if you visit {domain}/new-page and {domain}/new-page-2 you will see the same template, but varying content

### <a id="usage:page-content-going-further">Going further with page content</a> ###

You can pass content as json directly to the content attribute of a page in structure.json, however if you have lots of per page content with heavily nested data, it can get very very messy.
A better way sometimes would be to seperate out your content to a file and then reference that.

- Create a json file in the content directory
```json
// file content/new-page.json

{
  "page_text": "I am page 2"
}
```
- Go to the relevant page in your structure.json file and replace the content json with a string filename (minus the .json)
```json
"new-page": {
  "title": "New page",
  "template": "new-template",
  "content": "new-page"
}
```

### <a id="usage:templating-going-further">Going further with templating</a> ###

Because this uses Twig for templating, it means you can use all available 'twigness' in your prototype to assist with
your development, for full documentation visit: [http://twig.sensiolabs.org/](http://twig.sensiolabs.org/)

---

## <a id="menus">Menus</a> ##

Built into this are a few helpers to help generate common menus within your twig templates.

Within the example application are implementations of all of them.

For instance, for the top menu, we use the template part: templates/parts/topnav.twig:
```twig
<!-- Importing the nav builder allows us to build recursive menus just by passing it a set of menuItems -->
{% import "builders/nav-builder.twig" as navBuilders %}

<!-- Before we can call our nav builder we need to actually get the menu we want, here, we are simply getting the full
 standard menu, however, because we're passing 2 as the parameter, it will only get 2 levels deep.
 If we want to get all levels, don't pass any parameter -->
{% set menu = getMenu(2) %}

<!-- Now we have the menu items, simply call the nav builder you want, dropdown is a simple bootstrap dropdown example
 but you can use it to build out your own as needed, there is also a standard nav builder, that gets the nav without
 and formatting so is quite a good base for your custom ones -->
<ul class="nav navbar-nav">
    {{ navBuilders.dropdown(menu) }}
</ul>
```

It also comes with the following navigation examples:
- Breadcrumbs - templates/parts/breadcrumbs.twig
- Sidenav - templates/parts/sidenav.twig (NB: this only gets the siblings of the current page,
you can also pass a number of levels to recursively iterate, like the full menu)
- FullNav / sitemap - templates/parts/fullnav.twig (NB: this doesn't honor the hidden flags you've set within your structure)

If you need further custom ones, you will be able to extend the built in navigation options soon.

---

## <a id="devel">Development helpers</a> ##

To assist with development there are a few utilities and helpers you can use throughout prototyping.

### <a id="devel:cache">Clearing caches</a> ###

In order to speed up the load times of the prototype, we cache the twig templates so we don't have to render on every request.
This however can cause problems when changing things, by default if you set your environment to dev, it will automatically
prevent the twig cache, however if you change this, or you have old twig caches, it may become necessary to clear it.

To do so, go to the command line in the root of the project and run:
```
php fetemp cache:clear
```

### <a id="devel:twig-dump">Twig dumper</a> ###

The built in twig dumper is useful, however it isn't exactly easy to use / see the things you're dumping to the screen.

As a development dependency this project uses the symfony dumper and there are a couple of twig functions available to you.

In a twig template do the following:
```twig

<!-- This dumps and then dies to stop any further data from being printed to the screen, helpful when
 encountering bugs and exceptions -->
{{ dd(var) }}

<!-- This dumps any var to the screen -->
{{ d(var) }}

<!-- This dumps the entire current context to the screen -->
{{ d(_context) }}
```

### <a id="devel:env">Accessing variables set in your .env file</a> ###

Your .env file is for setting environment variables in one central, non committed location.

This allows you to have different settings for general environment settings, third party services etc.
depending on the environment where your code is.

For instance if you have an integration with twitter, you may want to have different settings or credentials depending
on whether your prototype is currently local or on uat, so you can set these on the environments own .env file
and therefore when your prototype boots there it will automatically get those details.

In order to gain access to your .env variables within twig follow the below:
```twig
<!-- Say if you need to output a variable into a script you could do the following -->
<script>
var some_variable = {{ app.googleApiKey|escape('js') }}
</script>

<!-- Or just generally in a page -->
{{ app.environment }}
```