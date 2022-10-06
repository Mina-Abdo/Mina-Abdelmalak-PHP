<?php
// dynamic table => 3 levels only
// dynamic rows //4 
// dynamic columns // 4
// check if gender of user == m ==> male // 1
// check if gender of user == f ==> female // 1

$users = [
    (object)[
        'id' => 1,
        'name' => 'ahmed',
        "gender" => (object)[
            'gender' => 'm'
        ],
        'hobbies' => [
            'football', 'swimming', 'running',
        ],
        'activities' => [
            "school" => 'drawing',
            'home' => 'painting'
        ],
        // 'phones'=>"0123123",
    ],
    (object)[
        'id' => 2,
        'name' => 'mohamed',
        "gender" => (object)[
            'gender' => 'm'
        ],
        'hobbies' => [
            'swimming', 'running',
        ],
        'activities' => [
            "school" => 'painting',
            'home' => 'drawing'
        ],
        // 'phones'=>"2345",
    ],
    (object)[
        'id' => 3,
        'name' => 'menna',
        "gender" => (object)[
            'gender' => 'f'
        ],
        'hobbies' => [
            'running',
        ],
        'activities' => [
            "school" => 'painting',
            'home' => 'drawing'
        ],
        // 'phones'=>"",
    ],
    (object)[
        'id' => 4,
        'name' => 'merna',
        "gender" => (object)[
            'gender' => 'f'
        ],
        'hobbies' => [
            'running','reading'
        ],
        'activities' => [
            "school" => 'painting',
            'home' => 'drawing'
        ],
        // 'phones'=>"",
    ]
];
// echo $users[0]->id;

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Dynamic table</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-4 text-center text-success">
        <h2>Dynamic Table</h2>
        <div class="row">
            <div class="col-8 mt-5  ms-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <?php foreach($users[0] as $key=>$val) { ?>
                                <th><?= $key?></th>
                                <?php }?>
                                
                            </tr>
                        </thead>
                        <tbody>
                                <?php 
                                    foreach($users as $key=>$user){?>
                                    <tr>
                                        <?php 
                                        foreach($user as $key=>$val){
                                            if(gettype($val)==='integer'){
                                                echo '<td>'. $val .'</td>';
                                            }
                                            elseif(gettype($val)==='string'){
                                                echo '<td>'. $val .'</td>';
                                            }elseif(gettype($val)==='object'){
                                                foreach($val as $property=>$propertyVal){
                                                    if($key === 'gender' && $property==="gender"){
                                                        if($propertyVal==="f"){
                                                            echo '<td>Female</td>';
                                                        }elseif($propertyVal==="m"){
                                                            echo '<td>Male</td>';
                                                        }
                                                    }
                                                }
                                            }elseif(gettype($val)==='array'){?>
                                                <td>
                                                    <?php foreach($val as $data1){
                                                        echo '<ul><li>'.$data1.'</li></ul>';
                                                    } ?>
                                                </td>
                                                
                                            <?php }
                                        }?>
                                        </tr>
                                <?php }?>

                        </tbody>
                </table>
                </div>
        </div>
            
    </div>
      
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>