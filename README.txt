
1. HOW TO RUN REST SERVER

This plugin is a little helper when you want to implement some REST API.

For now there is no magic regarding http method used. For today it is only GET that will be used anyway.

You should generate whole new symfony application for api purposes:
./symfony generate:app api

When you put this plugin in plugins directory you should make sure that only "api" application is actually using it.
You can achieve this like that for example:

class apiConfiguration extends sfApplicationConfiguration
{
  public function setup()
  {
        $this->enablePlugins(array('afRESTWebServicePlugin'));
  }
}

Now in any action you should just return associative array if everything goes OK.
It will be transformed to json response like:
success = true
data = DATA_RETURNED_BY_YOUR_ACTION

When something goes wrong You should throw afRESTWSException exception. It will be catched and transformed to json response like:
success = false
message = EXCEPTION_MESSAGE

You should also copy "500" error template: config/error/error.html.php to your application config/error dir.
You should also create below action in default module to properly suport 404 errors:
public function executeError404(sfWebRequest $request)
{
    throw new afRESTWSException('404 - Not found error');
}


2. HOW TO USE REST CLIENT

TODO...


3. TODOS
Some security layer based on IP address for example or some magic hash :)

4. SEE ALSO
Fabien Potencier showed on symfony camp 2008 how symfony is REST ready out of the box.
http://fabien.potencier.org/talk/16/symfony-camp-2008-REST
However I did not used that approach because for now we need simple API thas only returns data.
