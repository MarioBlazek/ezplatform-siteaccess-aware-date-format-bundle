Documentation
=============

## Usage

Bundle provides simple and easy to use Twig filter `datetime`. By default it will use date format specified by given siteaccess locale.

```twig
{{ ez_field_value(content, 'my_date').date|datetime }}
```

Which will format date by `IntlDateFormatter::SHORT` format by default, or by any of this listed 
[constants](https://www.php.net/manual/en/class.intldateformatter.php#intl.intldateformatter-constants) 
in case any of them is specified in overridden config.

```twig
{{ ez_field_value(content, 'my_date').date|datetime('my_custom_format') }}
```

Will format date by `my_custom_format` which must be specified in configuration.

### Date field type - examples

eZ Platform Twig statements:

```twig
{{ ez_field_value(content, 'my_date').date|datetime }}
```

```twig
{{ ez_field_value(content, 'my_date').date|datetime('my_custom_format') }}
```

In case of Netgen's Site API:

```twig
{{ content.fields.my_date.value.date|datetime }}
```

```twig
{{ content.fields.my_date.value.date|datetime('my_custom_format') }}
```

### DateAndTime field type - examples

eZ Platform Twig statements:
 
 ```twig
 {{ ez_field_value(content, 'my_date').value|datetime }}
 ```
 
 ```twig
 {{ ez_field_value(content, 'my_date').value|datetime('my_custom_format') }}
 ```
 
 In case of Netgen's Site API:
 
 ```twig
 {{ content.fields.my_date.value.value|datetime }}
 ```
 
 ```twig
 {{ content.fields.my_date.value.value|datetime('my_custom_format') }}
 ```

## Configuration

As default format `IntlDateFormatter::SHORT` is presumed, but other values can be set under defaults format configuration key.

This example config overrides default format for `eng` siteaccess and sets format to `IntlDateFormatter::LONG`, defines two custom formats for `eng`
siteaccess and one custom format for `default`.

```yaml
marek_site_access_aware_date_format:
    system:
        eng:
            defaults:
                format: 'long'
            formats:
                long_date: "y.m.d"
                short_date: "y.m."
        default:
            formats:
                short_date: "Y"
```

Under `formats` section, any valid format character from [documentation](https://www.php.net/manual/en/function.date.php#refsect1-function.date-parameters) can be specified.
