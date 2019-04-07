Installation instructions
=========================

Requirements
------------

* eZ Platform 1.13+

Installation steps
------------------

### Use Composer

Run the following from your website root folder to install MarekSiteAccessAwareDateFormatBundle:

```bash
$ composer require marioblazek/ezplatform-siteaccess-aware-date-format-bundle
```

### Activate the bundle

Activate required bundles in `app/AppKernel.php` file by adding them to the `$bundles` array in `registerBundles` method:

```php
public function registerBundles()
{
    ...
    $bundles[] = new Marek\SiteAccessAwareDateFormatBundle\MarekSiteAccessAwareDateFormatBundle();

    return $bundles;
}
```


### Clear the caches

Clear the eZ Publish caches with the following command:

```bash
$ php app/console cache:clear
```

For more detailed configuration, please check [documentation](DOC.md).
