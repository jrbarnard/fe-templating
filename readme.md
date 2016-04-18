# Front end templating framework #

This project is made to help rapid development of front end website prototypes with a component based system and a non folder based route structure.

- It helps to speed up development by helping you create, update, move and delete pages. It does this by moving your entire page structure within a json file, then dynamically building your pages per request.
- It helps you split your pages into components using the highly extensible Twig templating language.
- It allows you to reuse templates and components, building the page up on the fly using the attributes you set in the json structure file.
- It dynamically builds navigation based off your structure if you want it, helping to make quick, non-breaking changes in one place as opposed to multiple in a more traditional prototype.
- It's extensible using the built in Extension API. - COMING SOON


## Project setup ##

1. Clone / download the framework into your project directory.
2. Run composer install in the project root, if you don't have composer download [here](https://getcomposer.org/)
3. Run a webserver and point it to the project directory
 - You can either do this by using Wamp, Mamp, Xampp, Vagrant etc.
 - Or by running the utility helper:
    - In the root
    ```
    php fetemp serve
    ```
You will then have the example project set up!
Take some time to look at the examples, how it's used and any comments.

## Usage ##

You are free to use, extend, edit etc however you wish, however the generic usage to get you started is below.

### Creating a template: ###
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

### Linking a page to a template ###

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

### Going further with page content ###

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

### Going further with templating ###

Because this uses Twig for templating, it means you can use all available 'twigness' in your prototype to assist with your development, for full documentation visit: [http://twig.sensiolabs.org/](http://twig.sensiolabs.org/)

