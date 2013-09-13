<?php

namespace Yaw\AppBundle\Controller\Admin;

use Yaw\AppBundle\Core\BaseController;
use Yaw\AppBundle\Form\Type\CmsPageType;
use Symfony\Component\HttpFoundation\Request;
use Yaw\AppBundle\Entity\CmsPage;
use Symfony\Component\Config\Definition\Exception\Exception;

class CmsPageController extends BaseController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param                                           $param
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($param)
    {
        $pages = $this->repo('CmsPage')->findAll();
        $this->setTplVar('pages', $pages);

        return $this->render('Cms:pages');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param                                           $param
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Config\Definition\Exception\Exception
     */
    public function edit($param)
    {
        /** @var $page CmsPage */
        $page = $this->repo('CmsPage')->findOneBy(array('id' => $param));
        if ($page == NULL)
        {
            throw new Exception('Unable to find this page in database');
        }

        $form = $this->createForm(new CmsPageType(), $page);

        /*if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $this->dFlush();
                return $this->gotopage('admin_cms_page');
            }
        }*/

        return $this->render('Cms:page_edit', array(
            'action' => 'edit',
            'param'  => $page->getId(),
            'form'   => $form->createView()
        ));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param                                           $param
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add($param)
    {
        $page = new CmsPage();
        $page->setContent('&nbsp;');
        $form = $this->createForm(new CmsPageType(array('id')), $page);

        /*if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $this->dPersist($page);
                $this->dFlush();
                return $this->gotopage('admin_cms_page');
            }
        }*/

        return $this->render('Cms:page_edit', array(
            'action' => 'add',
            'form'   => $form->createView()
        ));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param                                           $param
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Config\Definition\Exception\Exception
     */
    public function delete($param)
    {
        /** @var $page CmsPage */
        $page = $this->repo('CmsPage')->findOneBy(array('id' => $param));
        if ($page == NULL)
        {
            throw new Exception('Unable to find this page in database');
        }

        $this->dRemove($page);
        $this->dFlush();

        return $this->gotopage('admin_cms_page');
    }

    public function menus()
    {
        return $this->render('Cms:menus');
    }

    public function installMenuAction()
    {
        $em = $this->getDoctrine()->getManager();

        // public main menu
        $m = new CmsMenu();
        $m->setName('public_account');
        $m->setAttr(array('class' => 'horisontal'));

        $i1 = new CmsMenuItem();
        $i1->setValue('Login');
        $i1->setPath('/login');
        $i1->setPosition(1);
        $i1->setMenu($m);
        $em->persist($i1);

        $i2 = new CmsMenuItem();
        $i2->setValue('Logout');
        $i2->setPath('/logout');
        $i2->setPosition(2);
        $i2->setMenu($m);
        $em->persist($i2);

        $i3 = new CmsMenuItem();
        $i3->setValue('Register');
        $i3->setPath('/register');
        $i3->setPosition(3);
        $i3->setMenu($m);
        $em->persist($i3);

        $em->persist($m);
        $em->flush();

        // public main menu
        $m = new CmsMenu();
        $m->setName('public_main');
        $m->setAttr(array('class' => 'horisontal'));

        $i1 = new CmsMenuItem();
        $i1->setValue('How it Works');
        $i1->setPath('/howitworks');
        $i1->setPosition(1);
        $i1->setMenu($m);
        $em->persist($i1);

        $i2 = new CmsMenuItem();
        $i2->setValue('Get');
        $i2->setPath('/get');
        $i2->setPosition(2);
        $i2->setMenu($m);
        $em->persist($i2);

        $i3 = new CmsMenuItem();
        $i3->setValue('Give');
        $i3->setPath('/give');
        $i3->setPosition(3);
        $i3->setMenu($m);
        $em->persist($i3);

        $em->persist($m);
        $em->flush();

        // admin main menu
        $m = new CmsMenu();
        $m->setName('admin_main');
        $m->setAttr(array('class' => 'horisontal'));

        $i1 = new CmsMenuItem();
        $i1->setValue('Dashboard');
        $i1->setPath('/admin/dashboard');
        $i1->setPosition(1);
        $i1->setMenu($m);
        $em->persist($i1);

        $i2 = new CmsMenuItem();
        $i2->setValue('Users');
        $i2->setPath('/admin/users');
        $i2->setPosition(2);
        $i2->setMenu($m);
        $em->persist($i2);

        $i3 = new CmsMenuItem();
        $i3->setValue('Cms');
        $i3->setPath('/admin/cms');
        $i3->setPosition(3);
        $i3->setMenu($m);
        $em->persist($i3);

        $em->persist($m);
        $em->flush();

        // admin cms menu
        $m = new CmsMenu();
        $m->setName('admin_cms');
        $m->setAttr(array('class' => 'horisontal'));

        $i1 = new CmsMenuItem();
        $i1->setValue('Pages');
        $i1->setPath('/admin/cms/pages');
        $i1->setPosition(1);
        $i1->setMenu($m);
        $em->persist($i1);

        $i2 = new CmsMenuItem();
        $i2->setValue('FAQ');
        $i2->setPath('/admin/cms/faq');
        $i2->setPosition(2);
        $i2->setMenu($m);
        $em->persist($i2);

        $i3 = new CmsMenuItem();
        $i3->setValue('Menus');
        $i3->setPath('/admin/cms/menus');
        $i3->setPosition(3);
        $i3->setMenu($m);
        $em->persist($i3);

        $em->persist($m);
        $em->flush();

        return $this->response;
    }
}
