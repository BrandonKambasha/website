<?php
namespace carsdb\controllers;
class showroom
{
    private $showroom;
    private $manufacturers;
    

    public function __construct($showroom,$manufacturers) 
    {
        $this->showroom = $showroom;
        $this->manufacturers = $manufacturers;
        
    }
        
    public function list() 
    {
        $stories = $this->showroom->findLimit(10);
        return ['template' => 'showroom.php',
                'title' => 'Our Cars',
                'left' => load('../templates/leftPanel.html.php'),
                'variables' => ['stories' => $stories
                ]];
    }

    public function archives()
    {
        session_start();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) 
        {
            $cars = $this->showroom->find('archive','1');
            return ['template' => 'archive.html.php',
                'title' => 'Archives',
                'left' => load('../templates/adminLeft.php'),
                'variables' => ['cars' => $cars]];
        }
        else 
                {
                header('location:/admin/user');
                }
    }
    public function restore()
        {
            session_start();
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                $archives = $this->showroom->find('id',$_GET['id']);
            
                $archive= ['id'=>$_GET['id'],
                            'archive'=>0];
  
                    $stmt = $this->showroom->update($archive);
                  
                header('location:/showroom/archives');
            }
            else 
                {
                header('location:/admin/user');
                }
        }

    public function archive()
        {
            session_start();
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                $archives = $this->showroom->find('id',$_GET['id']);
            
                $archive = [
                            'id'=>$_GET['id'],
                            'archive'=> 1
                ];
                    $stmt = $this->showroom->update($archive);
            
                header('location:/showroom/cars');
            }
            else 
                {
                header('location:/admin/user');
                }
        }
    public function cars()
                {
                    session_start();

                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    
                        $cars = $this->showroom->find('archive',0);

                        return ['template' => 'car.html.php',
                                    'title' => 'Cars',
                                    'left' => load('../templates/adminLeft.php'),
                                    'variables' => ['cars'=>$cars]]; 
                    }

                    else 
                        {
                            header('location: /admin/index');
                        }
                } 
    public function add()
        {
            session_start();
            if (isset($_POST['submit'])) {

                $criteria = [
                    'name' => $_POST['model'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'manufacturerId' => $_POST['manufacturerId'],
                    'mileage' => $_POST['mileage'],
                    'engine' => $_POST['engine']
                ];
            
                $car = $this->showroom->insert($criteria);

                   
                $totalfiles = count($_FILES['file']['name']);
                
                for($i=0;$i<$totalfiles;$i++)
                    {
                        if ($_FILES['file']['error'][$i]== 0) 
                        {
                            $fileName = $this->showroom->lastInsertIds() ."_".$i. '.jpg';
                            move_uploaded_file($_FILES['file']['tmp_name'][$i], 'images/cars/' . $fileName);
                        }
                    }
            
                header('location: /showroom/cars');
            }
            
            else 
                {
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    
                        $stmt = $this->manufacturers->findAll();
                        return ['template' => 'addCarTemplate.php',
                                    'title' => 'Add a Car',
                                    'left' => load('../templates/adminLeft.php'),
                                    'variables' => ['stmt'=>$stmt]];
                        
            }
            
            else 
                {
                    header('location: /admin/index');
                }
            
            }
        }
        
    public function edit()
        {
            session_start();
            

            if (isset($_POST['submit'])) {
                $prices = $this->showroom->find('id',$_POST['id']);
                $price = $prices[0];
                if($price['price']>$_POST['price'])
                {
                    $values= ['oldPrice'=>$price['price'],
                                'id' => $_POST['id'] ];
                    $price=$this->showroom->update($values);
                }
                elseif($price['price']<$_POST['price'])
                {
                    $values= ['oldPrice'=>0,
                                'id' => $_POST['id'] ];
                    $price=$this->showroom->update($values);
                }
        
                $criteria = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'manufacturerId' => $_POST['manufacturerId'],
                    'id' => $_POST['id'],
                    'mileage' => $_POST['mileage'],
                    'engine' => $_POST['engine']
                ];
        
                $stmt = $this->showroom->update($criteria);
        
                $totalfiles = count($_FILES['file']['name']);
                for($i=0;$i<$totalfiles;$i++)
                    {
                        if ($_FILES['file']['error'][$i]== 0) 
                        {
                            $fileName = $this->showroom->lastInsertIds() ."_".$i. '.jpg';
                            move_uploaded_file($_FILES['file']['tmp_name'][$i], 'images/cars/' . $fileName);
                        }
                    }
                header('location:/showroom/cars');
                
            }
            else 
            {
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        
                    $carr = $this->showroom->find('id',$_GET['id']);
                    $car = $carr[0];

                    $stmt = $this->manufacturers->findAll();

                    return ['template' => 'adminEdit.php',
                                    'title' => 'Edit a Car',
                                    'left' => load('../templates/adminLeft.php'),
                                    'variables' => ['car'=>$car,
                                                    'stmt'=>$stmt]];
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

                    $stmt = $this->showroom->delete($_POST['id']);
        
                    header('location: /showroom/cars');
                }
        
                else {
                    header('location: /admin/index');
                    }
            }

        public function images()
            {
                $path = glob('images/cars/' . $_GET['id']."_*.jpg");
                
                return ['template' => 'image.php',
                                    'title' => '',
                                    'left' => "",
                                    'variables' => ['path'=>$path]];
            }
}

