<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">Arobases Sylius Customer support plugin</h1>

<p align="center">Skeleton for starting Sylius plugins.</p>

## Install from an another projet

### Composer

  ```bash
  composer require arobases-sylius-public/sylius-customer-support-plugin
  ```
### Copy resource

Create file `config/packages/arobases_sylius_customer_support.yaml` with this content

```
imports:
- { resource: "@ArobasesSyliusCustomerSupportPlugin/Resources/config/resources.yaml" }
```

### Copy routes

Create file `config/routes/arobases_sylius_customer_support.yaml` with this content
```
arobases_sylius_customer_support_plugin_admin:
    resource: "@ArobasesSyliusCustomerSupportPlugin/Resources/config/admin_routing.yml"

arobases_customer_support:
    resource: "@ArobasesSyliusCustomerSupportPlugin/Resources/config/shop_routing.yml"
 ```

### Update shema 
```
php bin/console d:s:u -f
 ```


### Load assets
```
php bin/console asset:install &&
php bin/console sylius:theme:asset:install &&
yarn install &&
yarn build &&
yarn encore dev &&
php bin/console ca:clear
 ```





