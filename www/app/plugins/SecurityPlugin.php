<?php

namespace Shoutzor\Plugin;

use Phalcon\Acl;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

use Shoutzor\Acl\Role;
use Shoutzor\Acl\RoleLevel;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin
{

  private $role;
  private $acl;

  public function __construct() {
    // Register roles
    $this->role = [
      'admin' => new Role(RoleLevel::Admin),
      'user'  => new Role(RoleLevel::User),
      'guest' => new Role(RoleLevel::Guest)
    ];

    //admin-only area resources
    $adminResources = [
      'admin'     => ['index']
    ];

    //Private area resources
    $privateResources = [
      'search'   => ['index'],
      'account'  => ['index', 'logout']
    ];

    //Public area resources
    $publicResources = [
      'dashboard'     => ['index'],
      'account'       => ['register', 'login', 'recover'],
      'error'         => ['show401', 'show403', 'show404', 'show500'],
      'installation'  => ['index']
    ];

    $acl = new AclList();
    $acl->setDefaultAction(Acl::DENY);

    foreach ($this->role as $r) {
      $acl->addRole($r);
    }

    //Register all resources and their actions
    foreach (array_merge_recursive($adminResources, $privateResources, $publicResources) as $resource => $actions) {
      $acl->addResource(new Resource($resource), $actions);
    }

    //Inheritance
    $acl->addInherit($this->role['admin'], $this->role['user']);
    $acl->addInherit($this->role['user'],  $this->role['guest']);

    //Setup guest permissions
    foreach ($publicResources as $resource => $actions) {
      foreach ($actions as $action){
        $acl->allow($this->role['guest']->getName(), $resource, $action);
      }
    }

    //Setup user permissions
    foreach ($privateResources as $resource => $actions) {
      foreach ($actions as $action){
        $acl->allow($this->role['user']->getName(), $resource, $action);
      }
    }

    //Setup admin permissions
    foreach ($privateResources as $resource => $actions) {
      foreach ($actions as $action){
        $acl->allow($this->role['admin']->getName(), $resource, $action);
      }
    }

    //The acl is stored in session, APC would be useful here too
    $this->acl = $acl;
  }

	/**
	 * Returns an existing or new access control list
	 *
	 * @returns AclList
	 */
	public function getAcl()
	{
		return $this->acl;
	}

	/**
	 * This action is executed before execute any action in the application
	 *
	 * @param Event $event
	 * @param Dispatcher $dispatcher
	 * @return bool
	 */
	public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
	{
		$auth       = $this->session->get('auth');
		$controller = $dispatcher->getControllerName();
		$action     = $dispatcher->getActionName();
		$acl        = $this->getAcl();

    //TODO determine role via database
    if (!$auth){
      $role = $this->role['guest']->getName();
    } else {
      $role = $this->role['admin']->getName();
    }

		if (!$acl->isResource($controller)) {
			$dispatcher->forward([
				'controller' => 'error',
				'action'     => 'show404'
			]);
			return false;
		}

		$allowed = $acl->isAllowed($role, $controller, $action);

		if (!$allowed) {
			$dispatcher->forward([
				'controller' => 'error',
				'action'     => 'show401'
			]);

      //TODO figure out why the phalcon\invo example app has this line of code..
      //I don't understand why you'd log someone out if they access a page they
      //don't have access to.
      //$this->session->destroy();

			return false;
		}
	}
}
