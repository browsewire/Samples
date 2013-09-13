<?php

namespace Yaw\AppBundle\Controller\Admin;

use Yaw\AppBundle\Core\BaseController;

/**
 * This controller uses for protected actions
 * such as cache clearing
 * Class SudoController
 * @package Yaw\AppBundle\Controller\Admin
 */
class SudoController extends BaseController
{
    protected $access_role = 'ROLE_ADMIN';

    public function clearCacheAction()
    {
        $this->cache->flushAll();
        $this->response->setContent('Cleared succesfully.');

        return $this->response;
    }
}
