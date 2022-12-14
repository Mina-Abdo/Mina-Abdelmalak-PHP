<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

    <?php
        if($_POST){
            $percentage = (((int)$_POST['Physics'] + (int)$_POST['Chemistry'] + (int)$_POST['Biology'] + (int)$_POST['Mathematics'] + (int)$_POST['Computer'])/500) *100 ;
            if($percentage >= 0 && $percentage<40){
                $message = "<ul>
                <li> Percentage {$percentage} %</li>
                <li> Grade F</li>
                </ul>";
            }elseif ($percentage >= 40 && $percentage<60) {
                $message = "<ul>
                <li> Percentage {$percentage} %</li>
                <li> Grade E</li>
                </ul>";
            }elseif ($percentage >= 60 && $percentage<70) {
                $message = "<ul>
                <li> Percentage {$percentage} %</li>
                <li> Grade D</li>
                </ul>";
            }elseif ($percentage >= 70 && $percentage<80) {
                $message = "<ul>
                <li> Percentage {$percentage} %</li>
                <li> Grade C</li>
                </ul>";
            }elseif ($percentage >= 80 && $percentage<90) {
                $message = "<ul>
                <li> Percentage {$percentage} %</li>
                <li> Grade B</li>
                </ul>";
            }elseif ($percentage >= 90 && $percentage<=100) {
                $message = "<ul>
                <li> Percentage {$percentage} %</li>
                <li> Grade A</li>
                </ul>";
            }else{
                $message = "invalid subject grades";
            }
        }
        
        
    ?>

    <div class="container col-8 ms-auto mt-5 ">
        <h2 class="text-success text-center mt-3">Grade Task</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="">Physics</label>
                <input type="number" class="form-control" name="Physics" placeholder="">
                <label for="">Chemistry</label>
                <input type="number" class="form-control" name="Chemistry" placeholder="">
                <label for="">Biology</label>
                <input type="number" class="form-control" name="Biology" placeholder="">
                <label for="">Mathematics </label>
                <input type="number" class="form-control" name="Mathematics" placeholder="">
                <label for="">Computer</label>
                <input type="number" class="form-control" name="Computer" placeholder="">
            </div>
            <button class="btn btn-success text-center">Calculate</button>
        </form>

        <div class="alert alert-success mt-3"><?php  echo $message ??"" ?></div>
    </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>