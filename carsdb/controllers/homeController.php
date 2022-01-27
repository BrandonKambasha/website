<?php
namespace carsdb\controllers;
class homeController {
                    private $homeTable;

                    public function __construct($homeTable) {
                    $this->homeTable = $homeTable;
                    }
                    public function list() {
                        $stories = $this->homeTable->findAll();
                        return ['template' => 'home.html.php',
                                'title' => 'Claire\'s Cars',
                                'left' => '',
                                'variables' => ['stories' => $stories
                                ]];
                        }

                    public function about(){
                        $stories ='';
                        return
                            [
                                'template' => 'about.html.php',
                                'title'=> 'About Us',
                                'left'=> '',
                                'variables' => ['stories' => $stories]
                            ];
                    } 
                    
                    public function story()
                        {
                            session_start();

                            $cars = $this->homeTable->findAll();
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                            
                                return
                            [
                                'template' => 'story.php',
                                'title'=> 'Stories',
                                'left'=> load('../templates/adminLeft.php'),
                                'variables' => ['cars'=>$cars]];
                                
                            }

                            else {
                                header('location: /admin/index');
                            }
                        }
                    public function addStory()
                        {
                            session_start();
                            if (isset($_POST['submit'])) {

                                $criteria = [
                                    'title' => $_POST['title'],
                                    'description' => $_POST['description'],
                                    'date' => date('Y-m-d'),
                                    'author' => $_SESSION['name']
                                    
                                ];
                            
                                $car = $this->homeTable->insert($criteria);

                                $totalfiles = count($_FILES['file']['name']);
                                
                                for($i=0;$i<$totalfiles;$i++)
                                    {
                                        if ($_FILES['file']['error'][$i]== 0) 
                                        {
                                            $fileName = $this->homeTable->lastInsertIds().'.jpg';
                                            move_uploaded_file($_FILES['file']['tmp_name'][$i], 'images/stories/' . $fileName);
                                        }
                                    }
                                        
                                header('location:/stories/story');
                            }
                            
                            else 
                                {
                                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                        return
                                        [
                                            'template' => 'addStory.php',
                                            'title'=> 'Add a Story',
                                            'left'=> load('../templates/adminLeft.php'),
                                            'variables' => ['']];
                            }
                            
                            else {
                                header('location:/admin/index');
                                }
                            
                            }
                        }
                    public function edit()
                        {
                            session_start();
                            if (isset($_POST['submit'])) {

                                $criteria = [
                                    'id'=> $_POST['id'],
                                    'title' => $_POST['title'],
                                    'description' => $_POST['description']
                                    
                                ];
                        
                                $stmt = $this->homeTable->update($criteria);
                        
                                if ($_FILES['image']['error'] == 0) {
                                    require '../db.php';
                                    $fileName = $pdo->lastInsertId() . '.jpg';
                                    move_uploaded_file($_FILES['image']['tmp_name'], 'images/stories/' . $fileName);
                                }
                                header('location:/stories/story');
                            }
                            else 
                            {
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                    $cars = $this->homeTable->find('id',$_GET['id']);
                                    $car=$cars[0];
                                    return
                                    [
                                        'template' => 'storyEdit.php',
                                        'title'=> 'Edit Story',
                                        'left'=> load('../templates/adminLeft.php'),
                                        'variables' => ['car'=>$car]];
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

                                $stmt = $this->homeTable->delete($_POST['id']);
                                header('location:/stories/story');
                            }
                    
                            else {
                                header('location:/admin/index');
                                }
                        }
            }