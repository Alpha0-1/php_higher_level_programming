<?php
/**
 * Symfony Twig Example
 * 
 * Demonstrates Twig templating features in Symfony.
 */

// templates/base.html.twig
/*
<!DOCTYPE html>
<html>
    <head>
        <title>{% block title %}Default Title{% endblock %}</title>
    </head>
    <body>
        {% block body %}
            <div class="container">
                {% include '_flashes.html.twig' %}
                {% block content %}{% endblock %}
            </div>
        {% endblock %}
    </body>
</html>
*/

// templates/product/index.html.twig
/*
{% extends 'base.html.twig' %}

{% block title %}Products{% endblock %}

{% block content %}
    <h1>Product List</h1>
    
    <ul>
        {% for product in products %}
            <li>
                {{ product.name }} - {{ product.price|format_currency('USD') }}
                {% if product.price < 50 %}
                    (On Sale!)
                {% endif %}
            </li>
        {% endfor %}
    </ul>
{% endblock %}
*/

// Controller example:
/*
public function index()
{
    return $this->render('product/index.html.twig', [
        'products' => $this->getDoctrine()->getRepository(Product::class)->findAll()
    ]);
}
*/

echo "Twig templating examples. Key features:\n";
echo "- Template inheritance with blocks\n";
echo "- Includes and embeds\n";
echo "- Filters and functions (e.g., |upper, |date)\n";
echo "- Automatic escaping for security\n";
echo "- Macros for reusable components\n";
?>
