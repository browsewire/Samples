<?php

namespace Yaw\AppBundle\Controller\Security;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Yaw\AppBundle\Core\BaseController;
use Yaw\AppBundle\Core\Service\WePay\WePayService;
use Yaw\AppBundle\Entity\Loan;
use Yaw\AppBundle\Entity\Settings;
use Yaw\AppBundle\Entity\User;
use Yaw\AppBundle\Entity\UserVerification;
use Yaw\AppBundle\Entity\WepayTransaction;
use Yaw\AppBundle\Entity\ZipCode;
use Yaw\AppBundle\Form\Type\LoanFormType;
use Yaw\AppBundle\Form\Type\RegisterType;
use Yaw\AppBundle\Form\Type\UserFormType;
use Yaw\AppBundle\Form\Type\UserVerificationFormType;

class RegisterController extends BaseController
{
    private $step = 1;
    /**
     * Register page
     * The same as first step
     *
     * @return Response
     */
    public function indexAction()
    {
        $this->setTplVar('step', 1);

        // Check for existing values in a session
        if ($step_1 = $this->session->get('step_1')) {
            $this->setTplVar('curr_step', $step_1);
        }

        return $this->render('Security:reg_index');
    }

    /**
     * Shows terms and conditions
     *
     * @return $this
     */
    public function facebookalertAction()
    {
        return $this->renderAjax('Security:facebookalert');
    }
    
    
    /**
     * Shows terms and conditions
     *
     * @return $this
     */
    public function termsAction()
    {
        return $this->renderAjax('Security:terms');
    }


    //--------------------------------------------------------------//
    //------------- BLOCK: REGISTRATION EXTRA METHODS --------------//
    //--------------------------------------------------------------//
    /**
     * Process user data & entity & form
     *
     * @internal param \Symfony\Component\Form\Form $form
     * @return array
     */
    private function processUser()
    {
        $user = new User();
        $form = $this->createForm(new UserFormType($this->getVGroup()), $user);

        $sess_data = $this->sessGet($form->getName());
        $request_data = $this->request->request->get($form->getName());

        if (!isset($sess_data)) {
            $view = $form->createView();
            $result = array(
                'profile_type' => 1,
                '_token' => $view->children['_token']->vars['value']
            );
        } else {
            $result = array_merge((array)$sess_data, (array)$request_data);
        }

        if (!isset($request_data['zip']) && !isset($result['zip'])) {
            $result['zip'] = NULL;
        }

        if (isset($result['zip']) && $result['zip'] !== NULL && !is_object($result['zip'])) {
            // Get location by zip
            /** @var $location ZipCode */
            $location = $this->repo('ZipCode')->findOneBy(array('zip' => $result['zip']));
            $result['zip'] = $location;
            if (!empty($location)) {
                $result['city'] = $location->getPrimaryCity();
                $result['state'] = $location->getState();
            }
        }

        $form->bind($result);

        if ($form->isValid()) {
            $this->sessSet($form->getName(), $result);
        }

        return array($form, $result, $user);
    }

    /**
     * Process user data & entity & form
     *
     * @internal param \Symfony\Component\Form\Form $form
     * @return array
     */
    private function processLoan()
    {
        $loan = new Loan();
        $data = array(
            'vgroup' => 'step_' . ($this->step - 1),
            'post' => $this->request->request->all()
        );

        $form = $this->createForm(new LoanFormType($data), $loan);

        $sess_data = $this->sessGet($form->getName());
        $request_data = $this->request->request->get($form->getName());

        if (!isset($sess_data)) {
            $view = $form->createView();
            $result = array(
                'frequency' => 'once',
                '_token' => $view->children['_token']->vars['value']
            );
        } else {
            $result = array_merge((array)$sess_data, (array)$request_data);
        }
		//echo $result['amount'];die();
        if ($this->step == 6) {
            $result['amount'] = preg_replace('/[^0-9.]/', '', $result['amount']);
        }

		
        $form->bind($result);

        if ($form->isValid()) {
            $this->sessSet($form->getName(), $result);
        }

        return array($form, $result, $loan);
    }

    /**
     * Process verifycation data & entity & form
     *
     * @internal param \Symfony\Component\Form\Form $form
     * @return array
     */
    private function processVeryfication()
    {
        $verify = new UserVerification();
        $form = $this->createForm(new UserVerificationFormType($this->getVGroup()), $verify);

        $sess_data = $this->sessGet($form->getName());
        $request_data = $this->request->request->get($form->getName());

        if (!isset($sess_data)) {
            $view = $form->createView();
            $result = array(
                '_token' => $view->children['_token']->vars['value']
            );
        } else {
            $result = array_merge((array)$sess_data, (array)$request_data);
        }

        if (isset($result['fin_evals'])) {
            $flip = array_flip($result['fin_evals']);
            if (isset($flip[16])) {
                $result['fin_evals'] = array(16);
            }
        }

        $form->bind($result);

        if ($form->isValid()) {
            $this->sessSet($form->getName(), $result);
        }

        return array($form, $result, $verify);
    }

    private function getPrevStep($data)
    {
        $this->ajax->setAction('Yaw.SecurityRegister.showStep_' . ($this->step - 1));
        $data = array_merge(array(
            'step' => ($this->step - 1)
        ), $data);
        return $this->renderAjax('Security:reg_step_' . ($this->step - 1), $data);
    }

    /**
     * Render response for the current step.
     * This function is implemented just in order to
     * don't care about current step number in each step action
     *
     * @param $data
     *
     * @return $this
     */
    private function getCurrStep($data)
    {
        $data = array_merge(array(
            'step' => $this->step
        ), $data);
        return $this->renderAjax('Security:reg_step_' . $this->step, $data);
    }

    /**
     * This is short functions to fast get option for enable
     * some validation groups for entity
     *
     * @return array
     */
    private function getVGroup()
    {
        return array('vgroup' => 'step_' . ($this->step - 1));
    }

    /**
     * Get avatars list from specified folder
     *
     * @return array
     */
    private function getAvatars()
    {
        // Get all the images from "avatar" folder
        $finder = new Finder();
        $finder->files()->in($this->get('kernel')->getRootDir() . '/../web/bundles/yawapp/images/avatar/');
        $avatar = array();
        /** @var $value \SplFileInfo */
        foreach ($finder as $value) {
            $avatar[] = '/avatar/' . $value->getBasename();
        }

        return $avatar;
    }
    //--------------------------------------------------------------//
    //---------------------- END BLOCK -----------------------------//
    //--------------------------------------------------------------//

    /**
     * Type only email
     *
     * @return Response
     */
    public function step_1Action()
    {
        // Set the current step number
        $this->step = 1;

        /* @var $user_form Form */
        list($user_form) = $this->processUser();

        return $this->getCurrStep(array('form' => $user_form->createView()));
    }

    /**
     * Type of account
     *
     * @return Response
     */
    public function step_2Action()
    {
        // Set the current step number
        $this->step = 2;

        /* @var $user_form Form */
        list($user_form) = $this->processUser();

        // Go back if the form is not valid
        if (!$user_form->isValid()) {
            return $this->getPrevStep(array(
                'form' => $user_form->createView(),
            ));
        // Or return current step
        } else {
            return $this->getCurrStep(array(
                'form' => $user_form->createView(),
                'max'  => $this->repo('Settings')->getLoanMaxValues(TRUE),
            ));
        }
    }

    /**
     * Type names, email, pass, ZIP and choose Avatar
     *
     * @return Response
     */
    public function step_3Action()
    {
        // Set the current step number
        $this->step = 3;

        /* @var $user_form Form */
        list($user_form,$user_data) = $this->processUser();
 
        // Go back if the form is not valid
        if (!$user_form->isValid()) {
            return $this->getPrevStep(array(
                'form' => $user_form->createView(),
                'max'  => $this->repo('Settings')->getLoanMaxValues(TRUE),
            ));
        // Or return current step
        } else {
            return $this->getCurrStep(array(
                'form'     => $user_form->createView(),
                'profile_type' => (int)$user_data['profile_type'],
                'ava_list' => $this->getAvatars()
            ));
        }
    }

    /**
     * Specify finantial evaluations
     *
     * @return Response
     */
    public function step_4Action()
    {
        $this->step = 4;

        /* @var $user_form Form */
        /** @var $user_entity User */
        list($user_form, $user_data, $user_entity) = $this->processUser();

        // Go back if the form is not valid
        if (!$user_form->isValid()) {
            return $this->getPrevStep(array(
                'form' => $user_form->createView(),
                'max'  => $this->repo('Settings')->getLoanMaxValues(TRUE),
            ));
            // Or return current step
        } else {
            return $this->getCurrStep(array(
                'form'     => $user_form->createView(),
                'ava_list' => $this->getAvatars()
            ));
        }
    }

    /**
     * Specify the loan amount, date period, reasons, interests & ID verification
     *
     * @return Response
     */
    public function step_5Action()
    {
        $this->step = 5;

        /* @var $user_form Form */
        list($user_form, $user_data) = $this->processUser();

        // Go back if the form is not valid
        if (!$user_form->isValid()) {
            return $this->getPrevStep(array(
                'form'     => $user_form->createView(),
                'ava_list' => $this->getAvatars()
            ));
        // Or return current step
        } else {
            /* @var $loan_form Form */
            list($loan_form) = $this->processLoan();

            return $this->getCurrStep(array(
                'form' => $loan_form->createView(),
                'option' => $user_data['profile_type'],
                'max'  => $this->repo('Settings')->getLoanMaxValues(TRUE),
            ));
        }
    }

    /**
     * Specify finantial evaluations
     *
     * @return Response
     */
    public function step_6Action()
    {
        $this->step = 6;


        /* @var $loan_form Form */
        list($loan_form, $loan_data, $loan_entity) = $this->processLoan();
        /* @var $user_form Form */
        /** @var $user_entity User */
        list($user_form, $user_data, $user_entity) = $this->processUser();

        // Go back if the form is not valid
        if (!$loan_form->isValid()) {
            return $this->getPrevStep(array(
                'form' => $loan_form->createView(),
                'option' => $user_data['profile_type'],
                'max'  => $this->repo('Settings')->getLoanMaxValues(TRUE),
            ));
        }

        if ((int)$user_data['profile_type'] === 1) {
            try {
                $mailer = $this->get('fos_user.mailer');
                $generator = $this->get('fos_user.util.token_generator');

                /** @var $loan_entity Loan */
                $user_entity->setEnabled(FALSE);
                if (NULL === $user_entity->getConfirmationToken()) {
                    $user_entity->setConfirmationToken($generator->generateToken());
                }

                $user_entity->setZip($this->repo('ZipCode')->findOneBy(array('zip' => $user_data['zip'])));
                $loan_entity->setUser($user_entity);
               
                $this->dPersist($loan_entity);
                $this->dPersist($user_entity);
                $this->dFlush();

                $this->session->remove($user_form->getName());
                $this->session->remove($loan_form->getName());

                $mailer->sendConfirmationEmailMessage($user_entity);

                $this->ajax->setAction('Yaw.SecurityRegister.showStep_8');
                return $this->renderAjax('Security:reg_step_8', array(
                    'step' => 8,
                    'form' => $user_form->createView(),
                ));

            } catch (\Exception $e) {
                $logger = $this->get('logger');
                $logger->err('Error while saving the user ' . $user_entity->getEmail() . ': ' . $e->getMessage());

                $this->ajax->setAction('Yaw.CorePopup.showErrorPopup');
                return $this->renderAjax('Layouts:error_popup', array(
                    'message' =>
                        'Something wrong while saving the data.<br> Please contact our customer support using <a href="#">contact form</a>'
                ));
            }

        } else {
            /* @var $verify_form Form */
            list($verify_form) = $this->processVeryfication();

            $this->ajax->setData('type', $user_data['profile_type']);

            return $this->getCurrStep(array(
                'type' => (int)$user_data['profile_type'],
                'user_form' => $user_form->createView(),
                'form' => $user_form->createView(),
                'user' => $user_entity,
                'verify_form' => $verify_form->createView(),
                'evals' => $this->repo('Settings')->getEvals(),
            ));
        }

    }

    /**
     * Show payment form
     *
     * @return $this
     */
    public function step_7Action()
    {
        $this->step = 7;

        /* @var $user_form Form */
        /** @var $user_entity User */
        list($user_form, $user_data, $user_entity) = $this->processUser();
        /* @var $verify_form Form */
        /* @var $verify_entity UserVerification */
        list($verify_form, $verify_data, $verify_entity) = $this->processVeryfication();

        // Go back if the form is not valid
        if (!$user_form->isValid() || !$verify_form->isValid()) {
            $has_lovation = FALSE;
            if (isset($user_data['state']) && isset($user_data['city'])) {
                $has_lovation = TRUE;
            }

            return $this->getPrevStep(array(
                'type' => $user_data['profile_type'],
                'user_form' => $user_form->createView(),
                'form' => $user_form->createView(),
                'has_location' => $has_lovation,
                'verify_form' => $verify_form->createView(),
                'evals' => $this->repo('Settings')->getEvals(),
            ));
        }

        $total_eval = 0;
        /* @var $fin_eval Settings */
        foreach ($verify_entity->getFinEvals() as $fin_eval) {
            $total_eval += (float)$fin_eval->getValue();
        }
        $total_eval = $total_eval + (($total_eval*7) / 100);
       
        /** @var $wp WePayService */
        $wp       = $this->get('my_wepay');
        $response = $wp->charge(
            $total_eval,
            'Financial Evaluations Fee',
            'SERVICE',
            array(
                'name' => $user_entity->getFirstName() . ' ' . $user_entity->getLastName(),
                'email' => $user_entity->getEmail(),
                'address' => $user_entity->getAddress1(),
                'city' => $user_entity->getCity(),
                'state' => $user_entity->getState(),
                'zip' => $user_entity->getZip()->getZip()
            )
        );

        return $this->getCurrStep(array(
            'form'         => $user_form->createView(),
            'checkout_id'  => $response->checkout_id,
            'checkout_uri' => $response->checkout_uri,
        ));
    }

    /**
     * Finish registration
     *
     * @return Response
     */
    public function step_8Action()
    {
        $this->step = 8;

        $mailer = $this->get('fos_user.mailer');
        $generator = $this->get('fos_user.util.token_generator');

        /* @var $user_form Form */
        /** @var $user_entity User */
        list($user_form, $user_data, $user_entity) = $this->processUser();
        /* @var $loan_form Form */
        /** @var $loan_entity Loan */
        list($loan_form, $loan_data, $loan_entity) = $this->processLoan();
        /* @var $verify_form Form */
        /* @var $verify_entity UserVerification */
        list($verify_form, $verify_data, $verify_entity) = $this->processVeryfication();

        $verify_entity->setType($user_entity->getProfileType());

        $pay_id = $this->request->query->get('checkout_id');
        $wp = $this->container->get('my_wepay');
        $pay_data = $wp->getTransInfo($pay_id);
        $wp_trans = new WepayTransaction();
        foreach ($pay_data as $key => $value) {
			if($value !='' && $key!='mode' && $key!='dispute_uri')
			{
            $setter = $this->helper->camelCase('set_'.$key);
            $wp_trans->$setter($value);
			}
        }

        $wp_trans->setUser($user_entity);

        $user_entity->setEnabled(FALSE);
        if (NULL === $user_entity->getConfirmationToken()) {
            $user_entity->setConfirmationToken($generator->generateToken());
        }
        $user_entity->setZip($this->repo('ZipCode')->findOneBy(array('zip' => $user_data['zip'])))
                    ->addLoan($loan_entity)
                    ->addVerification($verify_entity)
                    ->addWepayTransaction($wp_trans);

        $loan_entity->setUser($user_entity);
        $verify_entity->setUser($user_entity);

        try {
            $this->dPersist($wp_trans);
            $this->dPersist($verify_entity);
            $this->dPersist($loan_entity);
            $this->dPersist($user_entity);
            $this->dFlush();

            $this->session->remove($user_form->getName());
            $this->session->remove($loan_form->getName());
            $this->session->remove($verify_form->getName());

            $mailer->sendConfirmationEmailMessage($user_entity);

            return $this->render('Security:register_finish', array(
                'step' => $this->step,
                'form' => $user_form->createView(),
            ));

        } catch (\Exception $e) {
            $logger = $this->get('logger');
            $logger->err('Error while saving the user ' . $user_entity->getEmail() . ': ' . $e->getMessage());

            $this->ajax->setAction('Yaw.CorePopup.showErrorPopup');
            return $this->renderAjax('Layouts:error_popup', array(
                    'message' =>
                        'Something wrong while saving the data.<br> Please contact our customer support using <a href="#">contact form</a>'
                ));
            
        }
		

    }

    public function checkUserAction()
    {
        $user = $this->repo('User')->findBy(array('email' => $this->request->query->get('email')));
        if (empty($user)) {
            $this->ajax->setData('success', TRUE);
        } else {
            $this->ajax->setData('success', FALSE);
        }

        return $this->ajax->render();
    }
    
     public function verifyfbaccountAction(Request $request)
     {
      $facebookid=$request->request->get('facebookid');
      $user = $this->repo('User')->findOneBy(array('facebookid' => $facebookid));
      if($user){
      $message = '';
      }else{
      
      $src=$request->request->get('imgurl');
      $data = file_get_contents($src);
      //$fbavatar =$this->get('kernel')->getRootDir() . '/../web/bundles/yawapp/images/avatar/'
      $fileName = $this->get('kernel')->getRootDir() . '/../web/media/cache/avatar/avatar/'.$facebookid.'.jpg';
      $file = fopen($fileName, 'w+');
      fputs($file, $data);
      fclose($file);
      $message = '/media/cache/avatar/avatar/'.$facebookid.'.jpg';
      }
      
      return new Response($message);
     }
     
     
     public function cropfbimgAction(Request $request)
     {
     
      $x=$request->request->get('x');
      $y=$request->request->get('y');
      $w=$request->request->get('w');
      $h=$request->request->get('h');
      $src=$request->request->get('imgurl');
      $fbid=$request->request->get('fbid');
      
      $targ_w = $targ_h = 200;
      $jpeg_quality = 90;

      $img_r = imagecreatefromjpeg($src);
      $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
      
      
      $data = file_get_contents($src);
$fileName = $_SERVER['DOCUMENT_ROOT'].'/aw/web/media/'.$fbid.'.jpg';
$file = fopen($fileName, 'w+');
fputs($file, $data);
fclose($file);


      imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$w,$h);
      imagejpeg($dst_r, $fileName, $jpeg_quality);
      imagedestroy($dst_r);
      
      return new Response($fileName);
     }
     
     
}

