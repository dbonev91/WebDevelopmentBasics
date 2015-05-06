# WebDevelopmentBasics
Pproject for SoftUni course WebDevelopmentBasics

# Framework Documentation:
1. Installation:
	1.1. Create directory "GF" (recommended away from public directory) and paste files in it
	1.2. Include "App.php" in your index
	1.3. $app = \GF\App::getInstance();
	1.4. $app->run();

2. Config folder:
	- By default config folder is "../config". You can change it via $app->setConfigFolder("SOME FOLDER") 
	in your index;
	- By default config file is "app.php". If you woud like to change it:
		2.1. GF/Config.php -> setConfigFolder() -> $this->app['namespaces'] -> change "app"
		to what did you want.
		2.2. config file must be .php file with name equal to step 2.1.
	- You can view in browser your config file via $app->getConfig()->app. The result is Array.
	- Structure of "app.php" is an array "$cnf". You can rename it how would you like and in the end you should return it.

3. FrontController:
	- getDefaultController() and getDefaultMethod() both return "index". If you are Ok with them you
	dont need to explicity call them in config file.
	- If you want to change them in config file (app.php) you should to add:
		$cnf['default_controller'] = 'default controller name';
		$cnf['default_method'] = 'default method name';

3. Routes:
	- routes.php is in config folder and have an array structure.
	The array $cnf.
	- Controller files shuld be uppercase first letter
	- $cnf['*']['namespace'] is mandatory, because this is our default router. Without it there is no routes.
	- When we would like to add some namespace in routes.php:
		3.1. $cnf['controllerName']['namespace'] = 'Controllers/...';
		3.2. in app.php we should explain this namespace like this:
			$cnf['namespaces']['Controllers'] = 'PATH TO DIRECTORY';
	- Set controller and method in url:
		$cnf['CONTROLLER NAMESPACE']['namespace'] = 'Controllers\Admin';
		$cnf['CONTROLLER NAMESPACE']['controllers']['OUR CONTROLLER']['to'] = 'index';
		$cnf['CONTROLLER NAMESPACE']['controllers']['OUR CONTROLLER']['methods']['OUR METHOD'] = 'index3';
		
		And now the url will looks like this:
			http://mysite.com/index.php/CONTROLLER NAMESPACE/OUR CONTROLLER/OUR METHOD/param1/param2/.../paramN
		
		params CONTROLLER NAMESPACE, OUR CONTROLLER, OUR METHOD can be all different from our filesistem. That means
		our url can be how we would like to be no mather of filesystem. Only the value of the arrays shouuld be equal according to
		"namespace", "controllerName", "methodName".
		
4. Routers:
	- In our index, we can set router like this:
		$app->setRouter('OUR ROUTER');
	- In app run, we can see which are all allready installed routers. And we can too add our custom router.
	
5. database:
	Write this in our "database.php" in our config directory.
	$cnf['default']['connection_uri'] = 'mysql:host=localhost;dbname=gftest';
	$cnf['default']['username'] = 'root';
	$cnf['default']['password'] = 'vertrigo';
	$cnf['default']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'";
	$cnf['default']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	
	If we have would like to have more than one connection we can just copy paste
	this array and to change the word "default" to something else.

	5.1. Database queries:
		5.1.1. $db = new \GF\DB\SimpleDB();
		5.1.2. create the query:
			5.1.2.1. Without params and formatting output:
				$db->prepare('OUR QUERY WITHOUT PARAMS')->execute();
			5.1.2.2. With params and without formatting:
				$db->prepare('OUR QUERY param1=? AND param2=?')->execute(array("param1Value", "param2Value"));
			5.1.2.3. Without params and with formatting:
				$db->prepare('OUR QUERY WITHOUT PARAMS')->execute()->fetchAllAssoc()
				All formatting function are placed in "SimpleDB.php"

6. Sessions:
	6.1. Native session:
		If we would like to use native session we should place "native" as value of $cnf['session']['type'] in "app.php" file.
		We can call it by:
			$app->getSession()->counter+=1;
			echo $app->getSession()->counter;
		Now for each refresh of browser we will've incrementing value with one.
	
	6.2. Database session:
		If we would like to use native session we should place "database" as value of $cnf['session']['type'] in "app.php" file.
		We can call it by:
			$app->getSession()->counter+=1;
			echo $app->getSession()->counter;
		Now for each refresh of browser we will've incrementing value with one.

7. Views:
	7.1. Instance view:
		$view = \GF\View::getInstance();
	7.2. Create some variables to use in layouts (for example "title"):
		$view->title = 'dbonev';
		after that we can access it in out views and layouts like this:
			$this->title;
	7.3. Append something to layout:
		$view->appendToLayout('KEY OF LAYOUT', 'PATH TO VIEW');
		'KEY OF LAYOUT' is initialized in $this->getLayoutData('KEY OF LAYOUT') in layout or view files
		'PATH TO VIEW' is directory inclusive the file name (without file extension) of view, separated with '.', for example:
			admin.index = admin/index.php
	7.4. Display layout:
		$view->display('PATH TO LAYOUT', 'ARRAY VALUES', 'BOOL');
		'PATH TO LAYOUT' is just like a 'PATH TO VIEW' in 7.3. step in folder layouts
		'ARRAY VALUES' is an array in style "array('c' => array(1, 2, 3, 4))" where we can put usable info which can be accessable by
		the layout from 'PATH TO LAYOUT' as:
			foreach ($this->c as $v) {
				echo $v . '<br />';
			}
		'BOOL' is bool (default false) param which determines how will layputs and views recive the passed params:
			true = as string
			false = as object

8. Validation:
	8.1. Instance validation:
		$val = new \GF\Validation();
		8.1.1. Using private rule:
			$val->setRule('PRIVATE OR CUSTOM RULE', 'VARIABLE FOR CHECK', 'PARAM FOR COMPARE')->setRule('PRIVATE OR CUSTOM RULE', 'VARIABLE FOR CHECK', 'PARAM FOR COMPARE')->...;
			'PRIVATE OR CUSTOM RULE' is parameter which takes as string the name of rule which we would like to use. All private rules
			can be found in "Validation.php" file.
			'VARIABLE FOR CHECK' is variable which we will check is it correct
			'PARAM FOR COMPARE' is constant value with which we will compare 'VARIABLE FOR CHECK' to check is it correct.
		8.1.2. Using custom rule:
			If we would like to use CUSTOM rule we can write down it like this:
			$val->setRule('custom', 'VARIABLE FOR CHECK', 'CALLBACK FUNCTION');
			'custom' is a cnstant string which indicates that we will write our custom validation method.
			'VARIABLE FOR CHECK' is the variable which we would like to be shure it is correct.
			'COLLBACK FUNCTION' is the body of our custom validation function, which take as param 'VARIABLE FOR CHECK'.

				example:
					$val->setRule('custom', 5, function ($a) {
	        	    			echo $a;
        				});
	8.2. Validate:
		$val->validate();
		return value is bool;

9. Error Handling:
	$this->app->displayError('ERROR CODE');
	'ERROR CODE' is the name of file contains in views/errors without '.php' extension.
	
11. Default constroller:
	11.1. namespace:
		\GF\DefaultController
	11.2. Usage:
		It contains shortcuts of framework resources. $this->app, $this->view, $this->config, $this->router.
		If we extend it by controller we can use this shortcuts instead of instance our resources every time.
