# php-foreachable
A trait to create custom PHP DataSets/Collections faster


## 📦 Install it with composer

````bash
composer config repositories.0 '{"type": "vcs", "url": "https://github.com/TurboLabIt/php-foreachable.git", "no-api": true}'
composer require turbolabit/php-foreachable:dev-master
````

## 🔁 A base for your DataSet/Collections

Use it to quickly create collections of objects. You can then iterate over it.

````php
 use TurboLabIt\Foreachable\Foreachable;
 
 class Listing implements \Iterator, \Countable, \ArrayAccess
 {
    use Foreachable;
    ...
    ...
 }
 
 ...
 
 $collListing = new Listing();
 foreach($collListing as $oneItem) {
 
    ...
 }
````

