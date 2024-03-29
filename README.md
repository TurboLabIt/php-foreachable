# php-foreachable
A trait to create custom PHP DataSets/Collections faster


## 📦 Install it with composer

````bash
composer require turbolabit/php-foreachable:dev-main

````

## 🔁 A base for your DataSet/Collections

Use it to quickly create collections of objects. You can then iterate over it.

````php
<?php
 use TurboLabIt\Foreachable\Foreachable;
 
 class Listing implements \Iterator, \Countable, \ArrayAccess
 {
    use Foreachable;
 }
 ?>
 
 
 <?php
 $collListing = new Listing();
 foreach($collListing as $oneItem) {
 
    // ..
 }
 ?>
````

See: [MyDataSet](https://github.com/TurboLabIt/php-foreachable/blob/main/tests/MyDataSet.php) | [Usage](https://github.com/TurboLabIt/php-foreachable/blob/main/tests/ForeachableTest.php)


## 🧪 Test it

````bash
git clone git@github.com:TurboLabIt/php-foreachable.git
cd php-foreachable
clear && bash script/test_runner.sh

````
