# Twig OnPath extension

Twig extension for Symfony 2, display a string depending on current route (usefull for active menu hover).

Requires:

    - php >= 5.3.2
    - Twig >= 1.0
    - Symfony2 >= 2.1


## Installation

Through composer:

``` json
{
    "require": {
        "alcalyn/twig-extension-onpath": "dev-master"
    }
}
```


## Configuration

Just register it as a service.

> **Warning**: If you are using **Symfony < 2.4**, don't use this declaration, but the next one.

``` yaml
    twig.extension.onpath:
        class: Alcalyn\Extension\Twig\OnPath
        calls:
            - [ setRequestStack, [ @request_stack ] ]
        tags:
            - { name: twig.extension }
```

For **Symfony < 2.4**:

``` yaml
    twig.extension.onpath:
        class: Alcalyn\Extension\Twig\OnPath
        scope: request
        calls:
            - [ setRequest, [ @request ] ]
        tags:
            - { name: twig.extension }
```


## Using

You can do in your Twig template:

``` twig
{{ 'Hello'|onpath('home', 'user-index') }}
```

That displays 'Hello' only if you are on one of these routes: `home`, `user-index`.

> **Note**: You can enter more routes names.

So you can do for example in a menu navbar:

``` twig
<nav>
    <ul>
        <li class="{{ 'active'|onpath('home') }}">
            <a href="{{ path('home') }}">Home</a>
        </li>
        <li class="{{ 'active'|onpath('blog', 'blog_post', 'blog_comment') }}">
            <a href="{{ path('blog') }}">Blog</a>
        </li>
        <li class="{{ 'active'|onpath('about') }}">
            <a href="{{ path('about') }}">About</a>
        </li>
    </ul>
</nav>
```
