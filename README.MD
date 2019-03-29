##Setting Up Symfony Boilerplate

###Create new Symfony Project
`composer create-project symfony/skeleton symfonyBoilerplate`

###Initialize new git repository
```
git init
git add .
git commit -m "Initial Commit"
```

###Add required packages/bundles

composer require server --dev

composer require debug --dev

composer require sec-checker --dev

composer require profiler --dev

composer require annotations

composer require generator

composer require asset

composer require doctrine

composer require swiftmailer-bundle

composer require twig

###FOS User Bundle
composer require friendsofsymfony/user-bundle "~2.0"

create a new fiel /config/packages/fos_user.yml
```
fos_user:
  db_driver: orm # other valid values are 'mongodb' and 'couchdb'
  firewall_name: main
  user_class: App\Entity\User
  from_email:
      address: "admin@thedevclan.com"
      sender_name: "TheDevClan"
```

Create a new User entity

php bin/console make:entity

```
use FOS\UserBundle\Model\User as BaseUser;
Class User extends BaseUser 
{
}
```

 in `config\packages\framework.yml` add
 
 ```
 framework:
    templating:
        engines: ['twig', 'php']
 ```
Further FOSUserBundle Docs
https://symfony.com/doc/master/bundles/FOSUserBundle/index.htm` 

Create & Run Migrations
 
`php bin/console doctrine:migrations:diff`
`php bin/console doctrine:migrations:migrate`
 
###Adding SonataAdminBundle
``composer require sonata-project/admin-bundle``

``composer require sonata-project/doctrine-orm-admin-bundle``

``composer require sonata-project/block-bundle``

https://symfony.com/doc/master/bundles/SonataAdminBundle/getting_started/installation.html

###Create Admin User
``php bin/console fos:user:create``

``php bin/console fos:user:promote``
 
 
###Adding JWT Auth

``composer require jwt-auth``

https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#prerequisites

``composer require gesdinet/jwt-refresh-token-bundle``

https://github.com/gesdinet/JWTRefreshTokenBundle

###Adding Serializer
``composer require symfony/serializer``


``composer require symfony/apache-pack``


``composer require symfony/translation``

``composer require stof/doctrine-extensions-bundle``

##Create admin user
``php bin/console pp:create-admin-user``