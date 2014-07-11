<?php
class UsersController extends AppController
{
    public function login()
    {
        if(!$this->Session->check("loginRedirectUrl"))
        {
            $this->Session->write("loginRedirectUrl", $this->referer());
        }
    
        if(!empty($this->data))
        {
            // Sleep for a random number of milliseconds to help prevent password sniffing
            usleep(mt_rand(200, 1200)); // between 200ms and 1.2s
        
            $user = $this->User->find("first", array(
                "conditions" => array(
                    "User.email" => $this->data["User"]["email"],
                ),
            ));            
            
            if(!empty($user) && $user["User"]["password"] == $this->User->hashPassword($this->data["User"]["password"], $user["User"]["password_salt"]))
            {
                $this->loginUser($user["User"]);
            }
            else
            {
                throw new NotFoundException("Invalid email and/or password!");
            }
        }
    }
    
    public function logout()
    {
        $this->Session->delete("CurrentUser");
        if($this->Session->check("CurrentOrganization"))
        {
            $this->redirect("/o/{$this->Session->read("CurrentOrganization.slug")}", 302);
        }
        else
        {
            $this->redirect("/", 302);
        }
    }
    
    public function register()
    {
        if(!empty($this->data))
        {
            if($this->User->save($this->data))
            {
                $this->request->data["User"]["id"] = $this->User->id;
                if($this->Session->check("CurrentOrganization"))
                {
                    if($this->Session->read("CurrentOrganization.alert_user_registration_email") != "")
                    {
                        App::uses("CakeEmail", "Network/Email");
                        $email = new CakeEmail();
                        $email->from("do-not-reply@vlifetech.com");
                        $email->to($this->Session->read("CurrentOrganization.alert_user_registration_email"));
                        $email->subject("new User Registered");
                        $email->emailFormat("html");
                        $email->template("alert_user_registration_email");
                        $email->varViews(array(
                            "user" => $this->data,
                        ));
                        $email->send();
                    }
                
                    $this->redirect("/o/{$this->Session->read("CurrentOrganization.slug")}users/send_verification_email/{$this->data["User"]["id"]}");
                }
                else
                {
                    $this->redirect("/users/send_verification_email/{$this->data["User"]["id"]}");
                }
            }
        }
    }
    
    public function password_reset()
    {
        if(!empty($this->params->query["email"]))
        {
            $user = $this->User->find("first", array(
                "conditions" => array(
                    "User.email" => $this->params->query["email"],
                ),
            ));
            
            if(!empty($user))
            {
                $token = array(
                    mt_rand(0, 9999),
                    time(),
                    $user["User"]["id"],
                );
                $token[] = sha1(implode(":", $token) . Configure::read("Security.salt"), true);
                $token = base64_encode(implode(":", $token));
                
                App::uses("CakeEmail", "Network/Email");
                $email = new CakeEmail();
                $email->from("do-not-reply@vlifetech.com");
                $email->to($this->params->query["email"]);
                $email->subject("Password reset");
                $email->emailFormat("html");
                $email->template("password_reset");
                $email->viewVars(array(
                    "token" => $token,
                ));
                $email->send();
            }
        }
    }
    
    public function change_password()
    {
        if(!empty($this->params->query["token"]))
        {
            $tokenParts = explode(":", base64_decode(urldecode($this->params->query["token"])));
            if(count($tokenParts) == 4)
            {
                $testToken = "{$tokenParts[0]}:{$tokenParts[1]}:{$tokenParts[2]}";
                $testHash = sha1($testToken . Configure::read("Security.salt"), true);
                if($tokenParts[3] == $testHash)
                {                
                    if($tokenParts[1] + 60 * 15 > time())
                    {
                        if(!empty($this->data))
                        {
                            $user = $this->User->find("first", array(
                                "conditions" => array(
                                    "User.id" => $tokenParts[2],
                                ),
                            ));
                            $user["User"]["password"] = $this->data["User"]["password"];
                            if($this->User->save($user))
                            {
                                $this->Session->setFlash("Password changed!", "flashes/success");
                                $this->loginUser($tokenParts[2]);
                            }
                            else
                            {
                                $this->Session->setFlash("Could not change password", "flashes/error");
                            }
                        }
                    }
                    else
                    {
                        $this->Session->setFlash("Token is expired!", "flashes/error");
                        $this->render(false);
                    }
                }
                else
                {
                    $this->Session->setFlash("Invalid token!", "flashes/error");
                    $this->render(false);
                }
            }
            else
            {
                $this->Session->setFlash("Malformed token!", "flashes/error");
                $this->render(false);
            }
        }
        else
        {
            $this->Session->setFlash("Token required!", "flashes/error");
            $this->render(false);
        }
    }
    
    public function profile()
    {
        $this->requireLogin();
        
        $user = $this->User->find("first", array(
            "conditions" => array(
                "User.id" => $this->Session->read("CurrentUser.id"),
            ),
        ));
        if(!empty($this->data))
        {
            $this->request->data["User"]["id"] = $this->Session->read("CurrentUser.id");
            if($this->User->save($this->data))
            {
                $this->Session->setFlash("Account Updated!");
            }
            else
            {
                $this->Session->setFlash("Error updating Account");
            }
            
            $this->request->data["User"]["password"] = "";
            $this->request->data["User"]["password2"] = "";
        }
        else
        {
            $this->request->data = $user;
        } 
        
        $userGroupMemberships = $this->User->UserGroupMembership->find("all", array(
            "conditions" => array(
                "UserGroupMembership.user_id" => $user["User"]["id"],
            ),
            "contain" => array(
                "UserGroup",
            ),
        ));
        $this->set("userGroupMemberships", $userGroupMemberships);
        
        if($this->Session->check("CurrentOrganization"))
        {
            $subscriptions = $this->User->Subscription->find("all", array(
                "conditions" => array(
                    "Subscription.user_id" => $user["User"]["id"],
                ),
                "contain" => array(
                    "Container",
                ),
            ));
            $this->set("subscriptions", $subscriptions);
        }
        else
        {
            $this->set("subscriptions", null);
        }
    }
    
    public function view($id = null)
    {
        $this->requireLogin();
        
        $user = $this->User->find("first", array(
            "conditions" => array(
                "User.id" => $this->Session->read("CurrentUser.id"),
            ),
        ));
        if(!empty($user))
        {
            $this->set("user", $user);
        }
        else
        {
            throw new NotFoundException("User not found");
        }
    }
    
    public function upload_avatar()
    {
        $this->requireLogin();
        
        $validFileExteions = array(
            ".jpg",
            ".gif",
            ".png",
        );
        if(!empty($_FILES))
        {
            $fileExtesion = substr($_FILES["Filedata"]["name"], strrpos($_FILES["Filedata"]["name"], "."));
            if(in_array($fileExtesion, $validFileExteions))
            {
                $usersDirectoryUri = "files/users/{$this->Session->read("CurrentUser.id")}";
                $newFileUri = "{$usersDirectoryUri}/avatar";
                
                @mkdir($usersDirectoryUri);
                
                if(move_uploaded_file($_FILES["Filedata"]["tmp_name"], $newFileUri))
                {
                    $this->User->id = $this->Session->read("CurrentUser.id");
                    if($this->User->saveField("avatar_url", "/{$newFileUri}")) {
                        $response = array(
                            "uri" => "/{$newFileUri}",
                        );
                        $this->set("response", $response);
                        $this->set("_serialize", array("response"));
                    }
                }
            }
        }
    }
    
    public function send_verification_email($id = null)
    {
        $user = $this->User->find("first", array(
            "conditions" => array(
                "User.id" => $id,
            ),
        ));
        
        if(!empty($user))
        {
            if(!$user["User"]["email_verified"])
            {
                $token = array(
                    mt_rand(0, 9999),
                    time(),
                    $id,
                );
                $token[] = sha1(implode(":", $token) . Configure::read("Security.salt"), true);
                $token = base64_encode(implode(":", $token));
                
                App::uses("CakeEmail", "Network/Email");
                $email = new CakeEmail();
                $email->from("do-not-reply@vlifetech.com");
                $email->to($user["User"]["email"]);
                $email->subject("Verify your account");
                $email->emailFormat("html");
                $email->template("verification_email");
                $email->viewVars(array(
                    "token" => $token,
                ));
                $email->send();
            }
            else
            {
                $this->Session->setFlash("User is already verified");
                $this->render(false);
            }
        }
        else
        {
            $this->Session->setFlash("User is not found");
            $this->render(false);
        }
    }
    
    public function verify_email()
    {
        if(!empty($this->params->query["token"]))
        {
            $tokenParts = explode(":", base64_decode(urldecode($this->params->query["token"])));
            if(count($tokenParts) == 4)
            {
                $testToken = "{$tokenParts[0]}:{$tokenParts[1]}:{$tokenParts[2]}";
                $testHash = sha1($testToken . Configure::read("Security.salt"), true);
                
                if($tokenParts[3] == $testHash)
                {                
                    if($tokenParts[1] + 60 * 15 > time())
                    {
                        $this->User->id = $tokenParts[2];
                        if($this->User->saveField("email_verified", 1))
                        {
                            $this->Session->setFlash("Email verified!", "flashes/success");
                            $this->loginUser($tokenParts[2]);
                        }
                        else
                        {
                            $this->Session->setFlash("Error validating email!", "flashes/error");
                        }
                    }
                    else
                    {
                        $this->Session->setFlash("Token is expired!", "flashes/error");
                    }
                }
                else
                {
                    $this->Session->setFlash("Invalid token!", "flashes/error");
                }
            }
        }
    }
    
    #region Manage Methods
    public function manage_index()
    {
        $primaryModel = $this->uses[0];
        $modelSchema = $this->$primaryModel->schema();
        
        $conditions = array(
            "User.created_by_organization_id" => $this->Session->read("CurrentOrganization.id"),
        );
        
        $results = $this->Paginator->paginate("User", $conditions);
        $this->set("results", $results);
        
        $this->set('_serialize', array('results'));
    }
    
    public function manage_create()
    {
        if(!empty($this->data))
        {
            $this->request->data["User"]["created_by_organization_id"] = $this->Session->read("CurrentOrganization.id");
            $this->request->data["User"]["created_by_user_id"] = $this->Session->read("CurrentUser.id");
        }
        
        $this->redirectsEnabled = false;
        if(parent::manage_create())
        {
            App::uses('CakeEmail', 'Network/Email');
            $email = new CakeEmail();
            $email->from(array("do-not-reply@vlifetech.com" => "vLifeTech ({$this->Session->read("CurrentOrganization.name")})"));
            $email->to($this->request->data["User"]["email"]);
            $email->emailFormat("html");
            $email->subject("You've been invited to join {$this->Session->read("CurrentOrganization.name")} over at vLife!");
            $email->template("invite_user");
            $email->viewVars(array(
                "organization" => $this->Session->read("CurrentOrganization"),
                "username" => $this->request->data["User"]["username"],
                "password" => $this->request->data["User"]["password"],
            ));
            $email->send();
        }
    }
    
    public function manage_send_invite_email()
    {
        $user = $this->User->find("first", array(
            "conditions" => array(
                "User.email" => $this->params->query["email"],
            ),
        ));
        
        if(!empty($user))
        {
            $newPassword = substr(sha1(mt_rand()),0 ,6);
            
            App::uses('CakeEmail', 'Network/Email');
            $email = new CakeEmail();
            $email->from(array("do-not-reply@vlifetech.com" => "vLifeTech ({$this->Session->read("CurrentOrganization.name")})"));
            $email->to($user["User"]["email"]);
            $email->emailFormat("html");
            $email->subject("You've been invited to join {$this->Session->read("CurrentOrganization.name")} over at vLife!");
            $email->template("invite_user");
            $email->viewVars(array(
                "organization" => $this->Session->read("CurrentOrganization"),
                "username" => $user["User"]["username"],
                "password" => $newPassword,
            ));
            $email->send();
            
            $user["User"]["password"] = $newPassword;
            $user["User"]["require_password_reset"] = true;
            if($this->User->save($user))
            {
                $this->Session->setFlash("Email sent!");
            }
            else
            {
                $this->Session->setFlash("Error sending invite.");
            }
        } else {
            $this->Session->setFlash("User with email ({$this->params->query["email"]}) not found!");
        }
        $this->render(false);
    }
    
     public function manage_edit($id = null)
    {
        if(!empty($this->data))
        {
            if($this->data["User"]["password"] !== $this->data["User"]["password"])
            {
                $this->User->validationErrors["passwordMisMatch"] = "Passwords don't match";
            }
            $this->request->data["User"]["created_by_organization_id"] = $this->Session->read("CurrentOrganization.id");
            $this->request->data["User"]["created_by_user_id"] = $this->Session->read("CurrentUser.id");
        }
        
        $subscriptions = $this->User->Subscription->find("all", array(
            "conditions" => array(
                "Subscription.user_id" => $id,
                "Container.organization_id" => $this->Session->read("CurrentOrganization.id"),
            ),
            "contain" => array(
                "Container",
            ),
        ));
        $this->set("subscriptions", $subscriptions);
        
        $userGroupMemberships = $this->User->UserGroupMembership->find("all", array(
            "conditions" => array(
                "UserGroupMembership.user_id" => $id,
            ),
            "contain" => array(
                "UserGroup",
            ),
        ));
        $this->set("userGroupMemberships", $userGroupMemberships);
        
        parent::manage_edit($id);
    }
    
    public function manage_subscriptions($id = null)
    {
        if(!empty($this->data))
        {
            if(is_array($this->data["Subscription"]))
            {
                // Delete all current subscriptions for user...
                $this->User->Subscription->deleteAll(array(
                    "Subscription.user_id" => $id,
                ));
                
                // Build new subscriptions...
                foreach($this->data["Subscription"] as $containerId => $level)
                {
                    if($level !== "")
                    {
                        $this->User->Subscription->create();
                        $this->User->Subscription->save(array(
                            "Subscription" => array(
                                "user_id" => $id,
                                "container_id" => $containerId,
                                "level" => $level,
                            ),
                        ));
                    }
                }
            }
        }
        
        $containers = $this->User->Subscription->Container->find("all", array(
            "conditions" => array(
                "Container.organization_id" => $this->Session->read("CurrentOrganization.id"),
            ),
            "contain" => array(
                "Subscription"
            ),
        ));
        $this->set("containers", $containers);
    }
    
    public function manage_delete($ids = null)
    {
        if(!is_array($ids))
        {
            $ids = explode(",", $ids);
        }
        
        foreach($ids as $key => $id)
        {
            $user = $this->User->find("first", array(
                "conditions" => array(
                    "User.id" => $id,
                    "User.created_by_organization_id" => $this->Session->read("CurrentOrganization.id"),
                ),
            ));
            
            if(empty($user))
            {
                unset($ids[$key]);
            }
        }
        
        if(isset($this->request->query["confirmed"]))
        {
            foreach($ids as $id)
            {
                $this->User->delete($id);
            }
            
            if(isset($this->params->query["referer"]))
            {
                $this->redirect($this->params->query["referer"]);
            }
            else
            {
                $this->redirect($this->referer());
            }
        }
        else
        {
            $this->Session->setFlash("This action permently removes " . (count($ids) > 1 ? "these items" : "this item") . ", are you sure?", "flashes/confirm");
        }
        $this->render(false);
    }
    #endregion
    
    #region Protected methods
    protected function loginUser($userCredentials, $redirect=true)
    {
        if(!is_array($userCredentials))
        {
            $conditions = array();
            if(is_numeric($userCredentials))
            {
                $conditions["User.id"] = $userCredentials;
            }
            else
            {
                $conditions["User.username"] = $userCredentials;
            }
        
            $userCredentials = $this->User->find("first", array(
                "conditions" => $conditions,
            ));
            $userCredentials = $userCredentials["User"];
        }
        
        unset($userCredentials["password"]);
        unset($userCredentials["password_salt"]);
        $this->Session->write("CurrentUser", $userCredentials);        
        
        $userGroupMemberships = $this->User->UserGroupMembership->find("all", array(
            "conditions" => array(
                "UserGroupMembership.user_id" => $userCredentials["id"],
            ),
        ));
        foreach($userGroupMemberships as &$userGroupMembership)
        {
            $userGroupMembership = $userGroupMembership["UserGroupMembership"];
        }
        $userCredentials["UserGroupMemberships"] = $userGroupMemberships;
        
        $this->Session->write("CurrentUser", $userCredentials);
        
        $this->User->id = $userCredentials["id"];
        $this->User->saveField("last_login", date(DATE_SQL));
        
        // Log user into Viafoura chat
        /*
        Current deal with Viafoura does not have OAuth2 support enabled, so this is kind of pointless -- leaving for future implementation if we get it enabled
        
        App::uses('HttpSocket', 'Network/Http');
        $httpSocket = new HttpSocket();
        
        $request = array(
            "method" => "POST",
            "uri" => array(
                "scheme" => "http",
                "host" => "api.viafoura.com",
                "port" => 80,
                "user" => "3930000000307",
                "pass" => "mgcAqp0ZXDb2rpc4v66+h58hWQeAgy+DxA9cVrlY5NhvukAvk0tcVx8qri8Nm6Ym",
                "path" => "oauth2/token",
                "query" => null,
                "fragment" => null
            ),
            "auth" => array(
                "method" => "Basic",
                "user" => null,
                "pass" => null
            ),
            "version" => "1.1",
            "body" => "",
            "line" => null,
            "header" => array(
                "Connection" => "close",
                "User-Agent" => "CakePHP"
            ),
            "raw" => null,
            "redirect" => false,
            "cookies" => array()
        );
        
        $response = $httpSocket->request($request);
        //debug($response);
        //exit;
        */
        
        if($redirect)
        {
        
            if(0 && $this->Session->check("loginRedirectUrl")) // disabled atm
            {
                $url = $this->Session->read("loginRedirectUrl");
                $this->Session->delete("loginRedirectUrl");
                $this->redirect($url);
            }
            else
            {
                App::import("Model", "Organization");
                $this->Organization = new Organization();
                $organization = $this->Organization->find("first", array(
                    "conditions" => array(
                        "Organization.id" => $this->Session->read("CurrentUser.created_by_organization_id"),
                    ),
                ));
                
                if(!empty($organization))
                {
                    $this->redirect("/o/{$organization["Organization"]["slug"]}/users/profile");
                }
                else
                {
                    $this->redirect("/");
                }
            }
        }
    }
    #endregion
}