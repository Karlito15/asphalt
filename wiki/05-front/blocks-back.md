## List of Blocks

{% block meta %}{% endblock %}
{% block title %}{% endblock %}
{% block favicons %}{% endblock %}
{% block stylesheets %}{% endblock %}
{% block javascripts %}
    {% block importmap %}{{ importmap('app') }}{% endblock %}
{% endblock %}
{% block bodyClass %}{% endblock %}
{% block body %}
    {% block preloader %}{% endblock %}
    {% block notification %}{% endblock %}
    {% block header %}{% endblock %}
    {% block main %}{% endblock %}
    {% block footer %}{% endblock %}
{% endblock %}
