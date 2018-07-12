## G11n Bundle

The G11n bundle integrates the [G11n language library](https://github.com/elkuku/g11n) into Synfony projects.

### Installation

    composer require elkuku/g11n-bundle

If you are **not** using Flex add

````php
# /config.bundles.php
    ...
    ElKuKu\G11nBundle\ElKuKuG11nBundle::class => ['all' => true],
    ...
````

### Usage

See the [G11n Wiki](https://github.com/elkuku/g11n/wiki) for general information.

#### Twig

A shorthand function `_()` is provided for usage in twig templates

```twig
{{ _('Translate this string') }}
```

### Configuration

#### Default values

* Default language: `en-GB`
* Debug: `off`

To change those values create the file

```yaml
# /config/packages/elkuku_g11n.yaml
elkuku_g11n:
  defaultLang: en-GB
  debug: false

```

### Commands

#### `g11n:templates`

Create or update the language template files.

#### `g11n:langfiles`

Create or update the language files.

### Templates

#### Language switcher

There is a simple language switcher template that you might take as a ... template ;)

```twig
{% import "@ElKuKuG11n/_macro/g11n.html.twig" as g11n %}
...
{{ g11n.switcher(getLangs(), getCurrentLang()) }}

```

### Debugging

Te enable debugging set the `debug` flag in the config file to `1`.

[screenshot]

