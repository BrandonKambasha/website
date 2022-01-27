<?php
namespace carsdb\controllers;
class manufacturer 
                {
                    private $manuTable;
                    private $carTable;
                
                    public function __construct($manuTable,$carTable) 
                        {
                        $this->manuTable = $manuTable;
                        $this->carTable = $carTable;
                        }

                    public function list()
                        {
                            $cars=$this->carTable->find('manufacturerId',$_GET['manufacturerId']);
                            $manu = $this->manuTable->find('id',$_GET['manufacturerId']);
                            $manus = $manu[0];
                      
                            return ['template' => 'manufacturer.php',
                                    'title' => $manus['name'],
                                    'left' => load('../templates/leftPanel.html.php'),
                                    'variables' => [
                                    'cars' => $cars,
                                    'manus' => $manus                                             
                                ]];
                        }  
                        
                        public function manufacturers()
                        {
                            session_start();
        
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) 
                                {
                                    $categories = $this->manuTable->findAll();
                                return ['template' => 'adminManu.php',
                                        'title' => 'Manufacturers',
                                        'left' => load('../templates/adminLeft.php'),
                                        'variables' => ['categories'=>$categories]];   
                                }
        
                                else 
                                {
                                    header('location: /admin/index');
                                                
                                }
                        }
                        
                        public function addManu()
                            {  
                                 session_start();
                                if (isset($_POST['submit'])) {

                                    $criteria = [
                                        'name' => $_POST['name']
                                    ];
                                     
                                    $stmt = $this->manuTable->save($criteria);

                                    header('location: /manus/manufacturers');

                                }
                                else {
                                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                    
                                        return ['template' => 'addManufacturer.html.php',
                                            'title' => 'Add Manufacturer',
                                            'left' => load('../templates/adminLeft.php'),
                                            'variables' => ['']];
                                        
                                    }
                            
                                    else {
                                        
                                        header('location: /admin/index');
                                    }
                            
                                }
                            }
                        public function edit()
                            {
                                session_start();
                                if (isset($_POST['submit'])) {

                                    $criteria = [
                                        'name' => $_POST['name'],
                                        'id' => $_POST['id']
                                    ];
                            
                                    $stmt = $this->manuTable->update($criteria);
                            
                                    header('location: /manus/manufacturers');
                                }
                                else {
                                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                        
                                        $currentMan = $this->manuTable->find('id',$_GET['id']);

                                        return ['template' => 'editMan.html.php',
                                        'title' => 'Edit Manufacturer ',
                                        'left' => load('../templates/adminLeft.php'),
                                        'variables' => ['currentMan'=>$currentMan[0]]];
                                        
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

                                    $products = $this->manuTable->delete($_POST['id']);
                                    header('location: /manus/manufacturers');
                        
                                }
                        
                                else {
                                    header('location: /admin/index');
                                }
                        
                            }    
                }