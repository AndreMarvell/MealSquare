
<img alt="MealSquare logo" width="300px" src="http://mealsquare.ovh/images/ico/logo.jpg"><img src="http://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2014/12/1418948033symfony-logo.png" alt="Logo Foodsquare" width="40px"/>
MealSquare
========================

MealSquare est une application web de gestion de recette MARMITON like. Développé avec le framework PHP [Symphony2](http://symfony.com/), il permettra d'apporter en plus une multitude de fonctionnalités.

## Configuration

Creer un fichier parameters.yml dans le repertoire app/config/

``` yml
# app/config/parameters.yml
parameters:
    database_driver: pdo_mysql
    database_host: localhost
    database_port: null
    database_name: mealsquare
    database_user: root
    database_password: root
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    locale: fr
    secret: #votre token symfony
    debug_toolbar: true
    debug_redirects: false
    use_assetic_controller: true

```

Ensuite faite un *update* de composer (qui va se charger de télécharger toutes les dépendances), puis un *assets:install* pour installer l'ensemble des ressources publiques des bundles.

En cas de probleme lors de l'ajout d'une image

``` sql

INSERT INTO `mealsquare`.`classification__category` (`id`, `parent_id`, `context`, `media_id`, `name`, `enabled`, `slug`, `description`, `position`, `created_at`, `updated_at`) VALUES (NULL, NULL, 'recette', NULL, 'recette', '1', 'recette', 'recette', NULL, CURRENT_DATE(), CURRENT_DATE());
UPDATE `mealsquare`.`classification__context` SET `created_at` = CURRENT_DATE(), `updated_at` = CURRENT_DATE() WHERE `classification__context`.`id` = 'recette';

```
PS: Le faire egalement pour ingredient, news et badge

## Etude du projet

* [Analyse de l'Existant](https://docs.google.com/document/d/10p8Gan_y7VeFLJafD-QfdiX5IQnd3LB7GdZUqgi77-g/edit?usp=sharing)
* [Cahier Des Charges](https://docs.google.com/document/d/1RbOdiiK2akafREWbWRhC1Ex9-V12-f2nDHw8FGvWYSw/edit?usp=sharing)
* [Architecture Logicielle](https://docs.google.com/document/d/1u1c3gPALwxo6a0-C_f_I0IeMPwsPmG6CDFH0WiMWC1M/edit?usp=sharing)
* [Spécification de l'interface utilisateur](https://docs.google.com/document/d/1tPG85t8LVak_-eMQjlCB-AHq-cH_YsisKIwKE7JWEKY/edit?usp=sharing)
* [Mise au point jeux de tests](https://docs.google.com/document/d/1igT7lMqY--6ZY5yZn5fRaG-OHgDmCFlxZhb8V0Pjmwg/edit?usp=sharing)



## License

* [Apache Version 2.0](http://www.apache.org/licenses/LICENSE-2.0.html)


## Documentation



## Plus d'infos


## Bundles Utilisés

