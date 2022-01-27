<?php
namespace carsdb\controllers;
class careers {
    private $jobs;

    public function __construct($jobs) {
    $this->jobs = $jobs;
    }
    public function list() {
        $stories = $this->jobs->findAll();
        return ['template' => 'career.html.php',
                'title' => 'Claire\'s Careers',
                'left' => '',
                'variables' => ['stories' => $stories
                ]];
        }

        public function jobs()
        {
            session_start();
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) 
                    {
                        $cars = $this->jobs->findAll();
                        
                        return ['template' => 'addJob.php',
                                'title' => 'Jobs Available',
                                'left' => load('../templates/adminLeft.php'),
                                'variables' => ['cars'=>$cars]];
                    }  
            else 
                    {
                    header('location:/admin/index');
                    }

        }
        public function add()
            {
                session_start();
                if (isset($_POST['submit'])) 
                    {

                        $criteria = [
                            'title' => $_POST['title'],
                            'description' => $_POST['description'],
                            'user' => $_SESSION['name']
                        ];

                        $jobAdd = $this->jobs->insert($criteria);
                        header('location:/careers/jobs');
                    }
                    else
                    {
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                           
                            return ['template' => 'addCareer.php',
                                'title' => 'Add a Job',
                                'left' => load('../templates/adminLeft.php'),
                                'variables' => ['']];
                            
                        }
                        else 
                            {
                            header('locaion:/admin/index');
                            }

                     }
            }
            
            public function edit()
                {
                    session_start();
                    if (isset($_POST['submit'])) {

                        $criteria = [
                            'title' => $_POST['title'],
                            'description' => $_POST['description'],
                            'id' => $_POST['id']
                        ];
                
                        $stmt = $this->jobs->update($criteria);
                        header('location: /careers/jobs');
                    }
                    else 
                    {
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                
                            $cars = $this->jobs->find('id',$_GET['id']);
                            $car = $cars[0];
                            return ['template' => 'jobEdit.php',
                                    'title' => 'Edit Job',
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

                        $stmt = $this->jobs->delete($_POST['id']);
                        header('location: /careers/jobs');
                    }
            
                    else {
                        header('location: /admin/index');
                        }
                }    
    }