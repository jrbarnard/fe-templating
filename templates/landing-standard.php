<h2>{{ title_landing }}</h2>
<p>{{ desc_landing }}</p>

{% if main_wysiwyg %}
<div class="wysiwyg">
	{{ main_wysiwyg | raw }}
</div>
{% endif %}

{% if carousel %}
<div class="carousel">
	<h2 class="carousel__title">
		{{ carousel.title }}
	</h2>
	<div class="slides">
		{% for slide in carousel.slides %}
			<div class="slide">
				<p>{{ slide.text }}</p>
				<img src="{{ slide.img.src }}" alt="{{ slide.img.alt }}">
			</div>
		{% endfor %}
	</div>
</div>
{% endif %}