<?php
    $title = "Review";
    include "layouts/header.php";
    include "middlewares/auth.php";
    include "layouts/navbar.php";

    $reviewTableHead= ['Questions' , 'Bad' , 'Good' , 'Very Good' , 'Excellent'];
    $reviewTableQuestions = ["Q1"=>'Are You satisfied with the cleaness level?' ,"Q2"=> 'Are you satisfied about service price ?' , "Q3"=> 'Are you satisfied about nursing level ?' , "Q4"=> 'Are you satisfied about our Doctors ?' , "Q4"=> 'Are you satisfied about our calmness level ?'];
    
    // function to draw review table
    function drawReviewTable($tableHeads , $tableQuestions){
        $table="
            <table class='table'>
                <thead>";
                    foreach($tableHeads as $head){
                        $table.="<th>{$head}</th>";
                    }
                $table.="</thead>
                <tbody>";
                    foreach($tableQuestions as $key=>$question){
                        $table.="
                        <tr>
                            <td >{$question}</td>
                            <td class='text-center'><input class='form-check-input' type='radio' name='{$key}' value='0'></td>
                            <td class='text-center'><input class='form-check-input' type='radio' name='{$key}' value='3'></td>
                            <td class='text-center'><input class='form-check-input' type='radio' name='{$key}' value='5'></td>
                            <td class='text-center'><input class='form-check-input' type='radio' name='{$key}' value='10'></td>
                        </tr>
                        ";
                    }
                $table.="</tbody>
            </table>
        ";
        return $table;
    };
    $table1 = drawReviewTable($reviewTableHead , $reviewTableQuestions);
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $errors = [];
        foreach($reviewTableQuestions as $key=>$question){
            if(!isset($_POST[$key])){
                $errors['input'] = "<p class='alert alert-danger mt-3'> please answer all questions </p>";
            }
            if(empty($errors)){
                $reviewResult = 0;
                $reviewAnswers = [];
                foreach($reviewTableQuestions as $key=>$question){
                    $reviewResult+=$_POST[$key];
                    if($_POST[$key] == 0){
                        $reviewAnswers+=[$key=>'Bad'];
                    }elseif($_POST[$key] == 3){
                        $reviewAnswers+=[$key=>'Good'];
                    }elseif($_POST[$key] == 5){
                        $reviewAnswers+=[$key=>'Very Good'];
                    }elseif($_POST[$key] == 10){
                        $reviewAnswers+=[$key=>'Excellent'];
                    }
                }

                $_SESSION['result'] = $reviewResult;
                $_SESSION['reviewAnsers'] = $reviewAnswers;
                $_SESSION['reviewQuestions'] = $reviewTableQuestions;
                header("location:Result.php");
                die;

            }
        }
    }
?>

<section class="container my-3">
    <div class="continer">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="text-info text-center">Hospital Task</h2>
            </div>
            <div class="col-8">
                <form method="post">
                    <?= $table1 ?? ""?>
                    <?= $errors['input'] ?? ""?>
                    <input type="submit" class="btn btn-success" value="submit">    
                </form>
            </div>
            
        </div>
    </div>

</section>

<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>