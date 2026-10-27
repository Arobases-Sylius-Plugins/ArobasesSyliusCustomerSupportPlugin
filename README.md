<h1 align="center">Arobases Sylius Customer support plugin</h1>

![banner_arobases](https://user-images.githubusercontent.com/39689570/219095474-12063079-528f-4be8-b006-debff3185920.jpg)

Customers open tickets about their orders from their account, the administrators answer them in the back office.
An e-mail is sent on each new message (to the channel contact e-mail or to the customer).

## Requirements

| Plugin version | Sylius version | PHP          |
|----------------|----------------|--------------|
| 2.x            | ^2.3           | ^8.2         |
| 1.x            | ^1.10 (1.14)   | ^8.1 (8.3)   |

Upgrading from 1.x? Read the [UPGRADE.md](UPGRADE.md) file.

## Install

### Composer

```bash
composer require arobases-sylius-public/sylius-customer-support-plugin
```

### Enable the plugin

```php
# config/bundles.php
return [
    // ...
    Arobases\SyliusCustomerSupportPlugin\ArobasesSyliusCustomerSupportPlugin::class => ['all' => true],
];
```

### Import the configuration

Create the file `config/packages/arobases_sylius_customer_support_plugin.yaml`:

```yaml
imports:
    - { resource: "@ArobasesSyliusCustomerSupportPlugin/Resources/config/resources.yaml" }
```

### Import the routes

Create the file `config/routes/arobases_sylius_customer_support_plugin.yaml`:

```yaml
arobases_sylius_customer_support_plugin_admin:
    resource: "@ArobasesSyliusCustomerSupportPlugin/Resources/config/admin_routing.yml"
    prefix: '/%sylius_admin.path_name%'

arobases_customer_support_plugin:
    resource: "@ArobasesSyliusCustomerSupportPlugin/Resources/config/shop_routing.yml"
```

### Update the database schema

```bash
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate
```

### Clear the cache

```bash
bin/console cache:clear
```

## Usage

* Shop: "Customer support" entry in the customer account menu (`/{_locale}/account/customer-support`).
* Admin: "Sales > Customer support" (`/admin/customer-support/`).

The pages are built with Twig hooks, they can be customized under the prefixes:

* `arobases_sylius_customer_support_plugin.admin.customer_support` (admin ticket page);
* `arobases_sylius_customer_support_plugin.shop.account.customer_support` (customer account pages).

## Development

The test application is based on `sylius/test-application` (configuration in `tests/TestApplication`).

```bash
composer install
composer test-app-init           # database + fixtures + assets
vendor/bin/console cache:clear
```
