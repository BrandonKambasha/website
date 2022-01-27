<?php
namespace carsdb\controllers;
class admin 
        {
                
                private $userTable;
                
            
            public function __construct($userTable) {
                
                $this->userTable = $userTable;
              
                }
            public function index(){
                session_start();
                if (isset($_POST['submit'])) {
                    
                        $values=[
                            'username' => $_POST['username']];
                        
                        $stmt=$this->userTable->find('username',$_POST['username']);
                        $user = $stmt[0];    


                    if (password_verify($_POST['password'],$user['password'])) {
                        
                        $_SESSION['loggedin'] = true;
                        $_SESSION['name'] = $user['name'];
                        $_SESSION['admin'] = $user['admin'];	
                    }
                    
                }
                
                
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    return ['template' => 'adminIndex.php',
                            'title' => 'You are now logged in',
                            'left' => load('../templates/adminLeft.php'),
                            'variables' => ['']];
                
                }
                
                else {
                    return ['template' => 'login.php',
                            'title' => 'Log in',
                            'left' => '',
                            'variables' => ['']];
                }
            }
            
                public function logout() 
                    {
                        session_start();

                        unset($_SESSION['loggedin']);

                        header('location: /admin/index');
                    }
                public function register()
                    {
                        session_start();

                        if(isset($_POST['submit'])&&isset($_POST['name'])&& isset($_POST['username'])&&isset($_POST['password']))
                        {

                                $values = 
                                [
                                    'name' => $_POST['name'],
                                    'username' => $_POST['username'],
                                    'password' => password_hash($_POST['password'],PASSWORD_DEFAULT)
                                ];

                            $stmt=$this->userTable->insert($values);

                            if($_POST['name']!=""&&$_POST['username']!=""&&$_POST['password']!="")
                            {
                                header('location: /admin/accounts');
                            }
                            else
                            {
                                return [
                                    'title' => 'Register',
                                    'template' => 'register.html.php',
                                    'left' => load('../templates/adminLeft.php'),
                                    'variables'=>['']];
                            }
                        }
                        else{
                            return [
                                'title' => 'Register',
                                'template' => 'register.html.php',
                                'left' => load('../templates/adminLeft.php'),
                                'variables'=>['']];
                        }
                    }   

                    public function accounts()
                        {
                            session_start();
                            $cars = $this->userTable->findAll();
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['admin']=='YES') {
                            
                                return ['template' => 'account.html.php',
                                    'title' => 'Users',
                                    'left' => load('../templates/adminLeft.php'),
                                    'variables' => ['cars'=>$cars]];
                              
                            }

                            else 
                            {
                            header('location: /admin/index');
                            }
                        }
                        public function edit()
                        {
                            session_start();
                            if (isset($_POST['submit'])) {
        
                                $criteria = [
                                    'id' => $_POST['id'],
                                    'name' => $_POST['name'],
                                    'username' => $_POST['username'],
                                    'password' => password_hash($_POST['password'],PASSWORD_DEFAULT)
                                ];
                        
                                $stmt = $this->userTable->update($criteria);
                                header('location: /admin/accounts');
                            }
                            else 
                            {
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        
                                    $cars = $this->userTable->find('id',$_GET['id']);
                                    $car = $cars[0];
                                    return ['template' => 'editAccount.php',
                                        'title' => 'Edit Account',
                                        'left' => load('../templates/adminLeft.php'),
                                        'variables' => ['car'=>$car]];
                                }
                        
                                else {
                                    header('location: /admin/index');
                                    }
                        
                            }
                        }
                        public function delete()
                            {
                                session_start();
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

                                    $stmt = $this->userTable->delete($_POST['id']);
                                    header('location: /admin/accounts');
                                }
                        
                                else {
                                    header('location: /admin/index');
                                    }
                            }          

        }