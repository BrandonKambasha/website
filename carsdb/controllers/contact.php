<?php
namespace carsdb\controllers;
class contact {
                    private $contacts;

                    public function __construct($contacts) {
                    $this->contacts = $contacts;
                    }
                    public function list() {
                       
                        if(isset($_POST['submit']))
                            {
                                $values = [
                                            'name'=>$_POST['name'],
                                            'email'=>$_POST['email'],
                                            'telephone'=>$_POST['telephone'],
                                            'enquiry'=>$_POST['enquiry']
                                ];
                                $stories = $this->contacts->insert($values);

                                return ['template' => 'contact.html.php',
                                        'title' => 'Enquiry Sent',
                                        'left'=> '',
                                        'variables' => ['stories' => $stories
                                ]];
                                
                               
                            }
                        else
                            {
                                $stories ='';
                                return ['template' => 'contact.html.php',
                                        'title' => 'Contact Us',
                                        'left'=>'',
                                        'variables' => ['stories' => $stories
                                ]];

                            }
                        
                        }

                    public function enquiries()
                        {
                            session_start();

                            if (isset($_POST['submit'])) {

                                $criteria = [
                                    'name' => $_POST['title'],
                                    'email' => $_POST['email'],
                                    'telephone' => $_POST['telephone'],
                                    'enquiry' => $_POST['enquiry']
                                    
                                ];
                            
                                $car = $contacts->insert($criteria);
                            
                                header('location:/contacts/enquiries');
                               
                            }
                            
                            else 
                                {
                                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) 
                                    {
                                        $cars = $this->contacts->findAll();
                                        return ['template' => 'answer.php',
                                        'title' => 'Enquiries',
                                        'left'=>load('../templates/adminLeft.php'),
                                        'variables' => ['cars' => $cars]];
                                    }
                                    
                                    else {
                                        header('location:/admin/index');
                                        
                                    }
                                    
                            }
                        }
                    public function respond()
                        {
                            session_start();
                            if (isset($_POST['submit'])) {

                                $criteria = [
                                    'id' => $_POST['id'],
                                    'user' => $_SESSION['name'],
                                    'complete' => $_POST['complete']
                                ];
                        
                                $stmt = $this->contacts->update($criteria);
                        
                                header('location:/contacts/enquiries');
                            }
                            else 
                            {
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                    $cars = $this->contacts->find('id',$_GET['id']);
                                    $car = $cars[0];
                                    return ['template' => 'email.php',
                                        'title' => 'Answer Enquiry',
                                        'left'=>load('../templates/adminLeft.php'),
                                        'variables' => ['car' => $car]];
                                    
                                }
                        
                                else {
                                    header('location:/admin/index');
                                    }
                        
                            }
                        }
                        public function delete()
                        {
                            session_start();
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

                                $stmt = $this->contacts->delete($_POST['id']);
                                header('location:/contacts/enquiries');
                            }
                    
                            else {
                                header('location:/admin/index');
                                }
                        }        
            }        