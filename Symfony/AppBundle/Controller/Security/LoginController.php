<?php

namespace Yaw\AppBundle\Controller\Security;

use HWI\Bundle\OAuthBundle\DependencyInjection\Security\Factory\OAuthFactory;
use HWI\Bundle\OAuthBundle\OAuth\OAuth1RequestTokenStorage\SessionStorage;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\FacebookResourceOwner;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\LinkedinResourceOwner;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\TwitterResourceOwner;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\YahooResourceOwner;
use HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse;
use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\SecurityEvents;
use Yaw\AppBundle\Core\BaseController;
use Yaw\AppBundle\Entity\User;

class LoginController extends BaseController
{
    public function loginAction()
    {
        $_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection

        $request = $this->getRequest();
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        $optionsFb = array(
            'client_id' =>  $this->container->getParameter('facebook.app_id'),
            'client_secret' => $this->container->getParameter('facebook.secret'),
            'scope' => "email,read_friendlists",
        );
        $optionsTwitter = array(
            'client_id' =>  "qtaXFvCENUHX1aBbbIkKdw",
            'client_secret' => 'xKq0QlYAuM4S1cBxfbmdDbGyIW2D7YLd0jjL0Vc46Y',
            //            'scope' => "email,read_friendlists",
        );
        $optionsLnkdin = array(
            'client_id' =>  "74vdk3oig20m",
            'client_secret' => '8zYxx4eJm8hK9tuU',
            //            'scope' => "email,read_friendlists",
        );
        $optionsYahoo = array(
            'client_id' =>  "dj0yJmk9WHp5TlJubmJZNEIyJmQ9WVdrOVlsYzJSMk5ETldNbWNHbzlNVFUwTWpJMk1qazJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD0zZg--",
            'client_secret' => '8cc4661f009105a7d8749f1eccdc9b3e0e305ef4',
            //            'scope' => "email,read_friendlists",
        );

        $redirectUrl = 'http://dev.yourangelwishes.com/login/oauth/';

        $twitter = new TwitterResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsTwitter, 'twitter', new SessionStorage($this->request->getSession()));
        //        $lnkedIn = new LinkedinResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsLnkdin, 'linkedin', new SessionStorage($this->request->getSession()));
        $fb      = new FacebookResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsFb, 'fb');
        //$yahoo   = new YahooResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsYahoo, 'yahoo', new SessionStorage($this->request->getSession()));

        $this->setTplVar('step', 'login');
        $this->setTplVar('last_username', $this->session->get(SecurityContext::LAST_USERNAME));
        $this->setTplVar('error', $error);
        $this->setTplVar('authTwit', $twitter->getAuthorizationUrl($redirectUrl . 'twitter'));
        $this->setTplVar('authFb', $fb->getAuthorizationUrl($redirectUrl . 'fb'));
        //$this->setTplVar('authYahoo', $yahoo->getAuthorizationUrl($redirectUrl . 'yahoo'));
        $this->setTplVar('authYahoo', 'rodo/change_this');

        return $this->render('Security:login_page', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error
        ));
    }

    public function loginPopupAction()
    {
        if ($this->request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->session->get(SecurityContext::AUTHENTICATION_ERROR);
        }


        $optionsFb = array(
            'client_id' =>  $this->container->getParameter('facebook.app_id'),
            'client_secret' => $this->container->getParameter('facebook.secret'),
            'scope' => "email,read_friendlists",
        );
        $optionsTwitter = array(
            'client_id' =>  "qtaXFvCENUHX1aBbbIkKdw",
            'client_secret' => 'xKq0QlYAuM4S1cBxfbmdDbGyIW2D7YLd0jjL0Vc46Y',
            //            'scope' => "email,read_friendlists",
        );
        $optionsLnkdin = array(
            'client_id' =>  "74vdk3oig20m",
            'client_secret' => '8zYxx4eJm8hK9tuU',
            //            'scope' => "email,read_friendlists",
        );
        $optionsYahoo = array(
            'client_id' =>  "dj0yJmk9WHp5TlJubmJZNEIyJmQ9WVdrOVlsYzJSMk5ETldNbWNHbzlNVFUwTWpJMk1qazJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD0zZg--",
            'client_secret' => '8cc4661f009105a7d8749f1eccdc9b3e0e305ef4',
            //            'scope' => "email,read_friendlists",
        );

//        $redirectUrl  ='http://dev.yourangelwishes.com/login/oauth/';
        $redirectUrl  ='http://aw.local/login/oauth/fb';

        $twitter = new TwitterResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsTwitter, 'twitter', new SessionStorage($this->request->getSession()));
        //        $lnkedIn = new LinkedinResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsLnkdin, 'linkedin', new SessionStorage($this->request->getSession()));
        $fb      = new FacebookResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsFb, 'fb');
        //$yahoo   = new YahooResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsYahoo, 'yahoo', new SessionStorage($this->request->getSession()));

        $this->setTplVar('step', 'login');
        $this->setTplVar('last_username', $this->session->get(SecurityContext::LAST_USERNAME));
        $this->setTplVar('error', $error);
        $this->setTplVar('authTwit', $twitter->getAuthorizationUrl($this->generateUrl('facebook_login', array('oauthType' => 'twitter'), TRUE)));
        $this->setTplVar('authFb', $fb->getAuthorizationUrl($this->generateUrl('facebook_login', array('oauthType' => 'fb'), TRUE)));
        //$this->setTplVar('authYahoo', $yahoo->getAuthorizationUrl($redirectUrl . 'yahoo'));
        $this->setTplVar('authYahoo', 'rodo/change_this');

        return $this->renderAjax('Security:login_form');
    }

	public function termsAction()
    {
        return $this->renderAjax('Security:terms');
    }

	public function successPopupAction()
    {
        return $this->renderAjax('Security:success');
    }
	
	public function upgradeSuccessPopupAction()
    {
        return $this->renderAjax('Security:upgradeSuccess');
    }

    public function oauthRejectAction()
    {
        return $this->render('Security:login_page');
    }

    public function oauthAction($oauthType)
    {

        $oauthResource = NULL;

        $optionsFb = array(
            'client_id' =>  $this->container->getParameter('facebook.app_id'),
            'client_secret' => $this->container->getParameter('facebook.secret'),
            'scope' => "email,read_friendlists",
        );
        $optionsTwitter = array(
            'client_id' =>  "qtaXFvCENUHX1aBbbIkKdw",
            'client_secret' => 'xKq0QlYAuM4S1cBxfbmdDbGyIW2D7YLd0jjL0Vc46Y',
//            'scope' => "email,read_friendlists",
        );
        $optionsLnkdin = array(
            'client_id' =>  "74vdk3oig20m",
            'client_secret' => '8zYxx4eJm8hK9tuU',
//            'scope' => "email,read_friendlists",
        );
        $optionsYahoo = array(
            'client_id' =>  "dj0yJmk9WHp5TlJubmJZNEIyJmQ9WVdrOVlsYzJSMk5ETldNbWNHbzlNVFUwTWpJMk1qazJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD0zZg--",
            'client_secret' => '8cc4661f009105a7d8749f1eccdc9b3e0e305ef4',
//            'scope' => "email,read_friendlists",
        );
        $oauthResource = new FacebookResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsFb, $oauthType);
        //ld($oauthResource);
        //ldd($this->request->query->all());
//        $redirect = 'http://dev.yourangelwishes.com/login/oauth/' . $oauthType;
        $redirect = 'http://aw.local/login/oauth/' . $oauthType;

        switch($oauthType) {
            case 'fb' : $oauthResource = new FacebookResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsFb, $oauthType);
                $options = $optionsFb;
                break;
            case 'linkedin' : $oauthResource = new LinkedinResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsLnkdin, $oauthType, new SessionStorage($this->request->getSession()));
                $options = $optionsLnkdin;
                break;
            case 'twitter' : $oauthResource = new TwitterResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsTwitter, $oauthType, new SessionStorage($this->request->getSession()));
                $options = $optionsTwitter;
                break;
            case 'yahoo' : $oauthResource = new YahooResourceOwner(new \Buzz\Client\Curl(), new HttpUtils(), $optionsYahoo, $oauthType, new SessionStorage($this->request->getSession()));
                $options = $optionsYahoo;
                break;
//            case 'yahoo' : ;break;
        }

        if (NULL === $oauthResource) {
            throw new Exception('Unknown OAuth type');
        }

        $token = $oauthResource->getAccessToken($this->request, $this->generateUrl('facebook_login', array('oauthType' => $oauthType), TRUE), $options);
        //ldd($token);
        //$this->container->get('security.context')->setToken($token);
        /** @var $userInfo PathUserResponse */
        /*$userInfo = $oauthResource->getUserInformation($token);
        ldd($userInfo);
        //ld($userInfo->getRealName());
        $user = new User();
        $user->setRoles(array('ROLE_USER'));
        $oToken = new OAuthToken($token, $user->getRoles());
        $oToken->setResourceOwnerName($oauthType);
        $oToken->setUser($user);
        $oToken->setAuthenticated(TRUE);
        ldd($oToken);

        $this->container->get('security.context')->setToken($oToken);

        // Since we're "faking" normal login, we need to throw our INTERACTIVE_LOGIN event manually
        $this->container->get('event_dispatcher')->dispatch(
            SecurityEvents::INTERACTIVE_LOGIN,
            new InteractiveLoginEvent($this->container->get('request'), $oToken)
        );

        //$user->setFirstName($userInfo->getResponse()['first_name']);
        //$user->setEmail($userInfo->getResponse()['email']);
        //$oauth_token = new OAuthToken($token);
        //$this->container->get('security.context')->setToken($oauth_token);
        //ld($oauth_token);
        //$sf_token = new UsernamePasswordToken($user, )
        $token = $this->container->get('security.context')->getToken();
        ld($token);
        if (is_object($token)) {
            ld($token->getUser());
        }
        ldd($userInfo);*/

        return $this->render('FrontOffice:home');
    }
}

