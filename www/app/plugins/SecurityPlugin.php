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

  public function __construct() {
    // Register roles
    $this->role = [
      RoleLevel::Admin => new Role(RoleLevel::Admin),
      RoleLevel::User  => new Role(RoleLevel::User),
      RoleLevel::Guest => new Role(RoleLevel::Guest)
    ];
  }

	/**
	 * Returns an existing or new access control list
	 *
	 * @returns AclList
	 */
	public function getAcl()
	{
    if(!isset($this->persistent->acl))
    {
      //admin-only area resources
      $adminResources = [
        'admin'     => ['index']
      ];

      //Private area resources
      $privateResources = [
        'search'   => ['index'],
        'account'  => ['index', 'logout'],
        'upload'   => ['index']
      ];

      //Public area resources
      $publicResources = [
        'dashboard'     => ['index'],
        'account'       => ['register', 'login', 'recover'],
        'error'         => ['show401', 'show403', 'show404', 'show500'],
        'installation'  => ['index'],
        'api'           => ['api']
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

      //Setup guest permissions
      foreach ($publicResources as $resource => $actions) {
        foreach ($actions as $action){
          $acl->allow($this->role[RoleLevel::Guest]->getName(), $resource, $action);
        }
      }

      //Setup user permissions
      foreach ($privateResources as $resource => $actions) {
        foreach ($actions as $action){
          $acl->allow($this->role[RoleLevel::User]->getName(), $resource, $action);
        }
      }

      //Setup admin permissions
      foreach ($adminResources as $resource => $actions) {
        foreach ($actions as $action){
          $acl->allow($this->role[RoleLevel::Admin]->getName(), $resource, $action);
        }
      }

      //Inheritance
      $acl->addInherit($this->role[RoleLevel::Admin], $this->role[RoleLevel::User]);
      $acl->addInherit($this->role[RoleLevel::Admin], $this->role[RoleLevel::Guest]);
      $acl->addInherit($this->role[RoleLevel::User],  $this->role[RoleLevel::Guest]);

      //The acl is stored in session, APC would be useful here too
      $this->persistent->acl = $acl;
    }

		return $this->persistent->acl;
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
    if (!$auth)
    {
      $r = $this->role[RoleLevel::Guest]->getName();
    }
    else
    {
      $r = $this->role[$auth->role]->getName();
    }

		if (!$acl->isResource($controller)) {
			$dispatcher->forward([
				'controller' => 'error',
				'action'     => 'show404'
			]);

      unset($this->persistent->acl);

			return false;
		}

		$allowed = $acl->isAllowed($r, $controller, $action);

		if (!$allowed) {
			$dispatcher->forward([
				'controller' => 'error',
				'action'     => 'show401'
			]);

			return false;
		}
	}
}
