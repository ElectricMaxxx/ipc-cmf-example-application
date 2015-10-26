# Eine Symfony Application um CMS Funktionen erweitern

`composer update` ausführen, klar


und dann für das PHPCR:

```
php app/console doctrine:database:create
php app/console doctrine:phpcr:init:dbal
php app/console doctrine:phpcr:workspace:create my_workspace
php app/console doctrine:phpcr:repository:init
php app/console -v doctrine:phpcr:fixtures:load           
``

Initial auf master ausführen. Zum Probieren und schauen kann man `s/Step-[1-5]`
auschecken. Um dann jeweils die Fixture zu laden kann man dann pro Step:
`php app/console doctrine:phpcr:fixtures:load` ausführen.

Mit Hilfe von `php app/console -v doctrine:phpcr:node:dump` kann man sich den Baum auch in der Console
anschauen.

Fragen an `@ElectricMaxxx` über Twitter oder hier als Issue.
