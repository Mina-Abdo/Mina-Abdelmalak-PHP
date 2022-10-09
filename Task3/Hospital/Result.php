<?php
    $title = "Result";
    include "layouts/header.php";
    include "layouts/navbar.php";
    function drawResultTable($questions){
        $table="
            <table class='table'>
                <thead>
                    <th>Questions</th>
                    <th>Answer</th>
                </thead>
                <tbody>";
                    foreach($_SESSION['reviewQuestions'] as $key=>$question){
                        $table.="
                        <tr>
                            <td>{$question}</td>
                            <td>{$_SESSION['reviewAnsers'][$key]}</td>
                        </tr>
                        ";
                    }
                    $table.="
                        <tr>
                            <td>Total Review</td>";
                            if($_SESSION['result']<25){
                                $table.="<td class='text-danger'>Bad</td></tr>";
                                
                            }else{
                                $table.="<td class='text-success'>Good</td></tr>";
                                
                            }
                $table.="</tbody>
            </table>";
            if($_SESSION['result']<25){
                $table.="<p class='p-2 alert alert-danger'>Our Team will contact your kind side on the submitted number of {$_SESSION['contactNumber']}</p>";
            }else{
                $table.= "<p class='p-2 alert alert-success'>thank you for taking the time to giv us your review</p>";
            }
        return $table;
    }

    $review = drawResultTable($_SESSION['reviewQuestions']);
    // print_r($_SESSION);
?>

<section class="container" style="margin-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-8">
            <h2 class="text-center my-3 text-info">Review Results</h2>
            <?= $review ?? "" ?>
        </div>
    </div>
</section>

<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>