<h1 align="center">Arobases Sylius Customer support plugin</h1>

![banner_arobases](https://user-images.githubusercontent.com/39689570/219095474-12063079-528f-4be8-b006-debff3185920.jpg)


## Install

### Composer

  ```bash
  composer require arobases-sylius-public/sylius-customer-support-plugin
  ```
### Copy resource

Create file `config/packages/arobases_sylius_customer_support_plugin.yaml` with this content

```
imports:
- { resource: "@ArobasesSyliusCustomerSupportPlugin/Resources/config/resources.yaml" }
```

### Copy routes

Create file `config/routes/arobases_sylius_customer_support_plugin.yaml` with this content
```
arobases_sylius_customer_support_plugin_admin:
    resource: "@ArobasesSyliusCustomerSupportPlugin/Resources/config/admin_routing.yml"

arobases_customer_support_plugin:
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





