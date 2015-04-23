
<img alt="MealSquare logo" width="300px" src="https://lh6.googleusercontent.com/4n6_jrvkn6_qqpAkWQLEt4l9kf5lwwl4brjfvlUwvIL54u4x0FgEnHfGb7Z9WtsYSYLV2heyoCkqdN0=w1896-h865"><img src="http://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2014/12/1418948033symfony-logo.png" alt="Logo Foodsquare" width="100px"/>
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

Ensuite faite un update de composer (qui va se charger de télécharger toutes les dépendances), puis un assets:install pour installé l'ensemble des ressources publiques des bundles.

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

