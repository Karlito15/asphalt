{% block table %}

    <tbody>
    {% for item in entities %}
    {% else %}
        {{ component('TableEmpty', {value: 11}) }}
    {% endfor %}
    </tbody>

    <thead>
        {{ _self.legend() }}
    </thead>
    <tfoot>
        {{ _self.legend() }}
    </tfoot>
{% endblock %}

{% macro legend() %}
    <tr>
        <th>{{ 'text.id'|trans }}</th>
        <th>{{ 'text.category'|trans }}</th>
        <th>{{ 'text.label'|trans }}</th>
        <th>{{ 'text.value'|trans }}</th>
        <th>{{ 'text.filter'|trans }}</th>
        <th>{{ 'text.position'|trans }}</th>
        <th>{{ 'text.active'|trans }}</th>
        <th>{{ 'text.slug'|trans }}</th>
        <th>{{ 'text.date.created.at'|trans }}</th>
        <th>{{ 'text.date.updated.at'|trans }}</th>
        <th>{{ 'text.action'|trans }}</th>
    </tr>
{% endmacro %}

{% extends '@App/contents/back/list.html.twig' %}
