<?php
$title="Result";
include "layouts/header.php";
include "layouts/navbar.php";
include "middlewares/auth.php";
$result = "
<table class='table'>
    <tbody>
        <tr class='bg-info'>
            <td>Subscriper</td>
            <td>".ucfirst($_SESSION['client']['name'])."</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>";
        $membersGamesTotal= 0;
        $clubsTotal = ['football'=>0 , 'swimming'=>0 , "volleyball"=>0 , "others"=>0];
        foreach($_SESSION['client']['membersInfo'] as $memberInfo){
            
            $result.="
                <tr>
                    <td>".ucfirst($memberInfo['name'])."</td>";
                    $memberGamesTotal = 0;
                    foreach($memberInfo['games'] as $key=>$game){
                        if(!empty($game)){
                            $result.="<td>".ucfirst(explode(".",$key)[1])."</td>";
                        }else{
                            $result.="<td></td>";
                        }
                        
                        $memberGamesTotal += (int)$game; 
                        $clubsTotal[explode(".",$key)[1]]+= (int)$game;
                    };
                    
                    $result.="<td>{$memberGamesTotal}  EGP</td>";
                    $result.="</tr>
            ";
            $membersGamesTotal+=$memberGamesTotal;
        }
        
        $result.="<tr class='bg-info'>
            <td>Members Games Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{$membersGamesTotal}  EGP</td>
        </tr>";
            foreach($clubsTotal as $club=>$val){
                $result.="<tr><td>".ucfirst($club)." club</td>";
                
                $result.="<td>{$val}  EGP</td>";
                $result.="</tr>";

            }
            $result.="<tr>
                <td>Club subscription</td>
                <td>". (10000+($_SESSION['client']['familyMembers']*2500))."  EGP</td>
            </tr>
            <tr class='bg-info'>
                <td>Total Price</td>
                <td>".((10000+($_SESSION['client']['familyMembers']*2500))+$membersGamesTotal)." EGP</td>
            </tr>";
    $result.="</tbody>
</table>
";
// print_r($clubsTotal);
?>

<section class="container mt-5" style="margin-bottom: 120px;">
    <div class="row justify-content-center">
        <div class="col-8">
            <?= $result ?? "" ?>
        </div>
    </div>
</section>

<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>