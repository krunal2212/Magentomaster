Module name : **Magentomaster_Testmodule** 

**Steps to install**
1. unzip the directory and paste into **app/code** directory.
2. Run command ```php -dmemory_limit=6G bin/magento setup:upgrade && php -dmemory_limit=6G bin/magento setup:di:compile && php -dmemory_limit=10G bin/magento setup:static-content:deploy -f && chmod -R 777 var generated pub/static```
   1. Frontend URL to Submit form : xyz.com/**magentomaster-contactform**
   2. Frontend URL to list submitted form : **magentomaster-contactform/index/contactlist**
   
3. Test case : For testing purpuse , I have added empty Json test
4. Before running test please make sure you have two installed composer library
5. allure-framework/allure-phpunit , phpunit/phpunit , If not installed follow below command to install both composer library to run unit test
   1. ```composer require  phpunit/phpunit```
   2. ```composer require allure-framework/allure-phpunit:~1.2.0 --dev```
   
6. To run test case  : ```./vendor/bin/phpunit -c dev/tests/unit/phpunit.xml.dist app/code/Magentomaster/Testmodule/Test/Unit/Model/Unittest.php```
