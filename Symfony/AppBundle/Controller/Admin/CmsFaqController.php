<?php
namespace Yaw\AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Yaw\AppBundle\Core\BaseController;

class CmsFaqController extends BaseController
{


    public function faq()
    {
        return $this->render('Cms:faq');
    }


}
