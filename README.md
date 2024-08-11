# php-foreachable
A PHP Trait to create custom DataSets/Collections


## 📦 Install it with composer

````bash
composer require turbolabit/php-foreachable:dev-main

````

## 🏗️ Create your DataSet/Collection

[Example here](https://github.com/TurboLabIt/php-foreachable/blob/main/src/ForeachableCollection.php)

You can now use it:

````php
 <?php
 $collListing = new Listing();
 foreach($collListing as $oneItem) {
 
    // ..
 }
````

See: [MyDataSet](https://github.com/TurboLabIt/php-foreachable/blob/main/tests/MyDataSet.php) | [Usage](https://github.com/TurboLabIt/php-foreachable/blob/main/tests/ForeachableTest.php)


## 🧪 Test it

````bash
git clone git@github.com:TurboLabIt/php-foreachable.git
cd php-foreachable
clear && bash script/test_runner.sh

````
