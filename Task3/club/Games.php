<?php
$title = "Games";

include "layouts/header.php";
include "layouts/navbar.php";
include "middlewares/auth.php";

$games = ['football' => "300", 'swimming' => '250', 'volleyball' => '150', 'others' => '100'];
function drawMemberGames($games){
    $member = "";
    for ($i = 1; $i <= $_SESSION['client']['familyMembers']; $i++) {
        $member .= "
        <table class='table my-3 border border-danger'>
            <tr>
            <label class='form-label'>Member Name</label>
            <input class='form-control' name='{$i}'>";
        $member .= $errors['memberName'] ?? "";
        $member .= "</tr>";
        foreach ($games as $key => $game) {
            $member .= "<tr>
                <div class='form-check'>
                <input class='form-check-input' type='checkbox' name='{$i}$key' value='{$game}' id='input'>
                <label class='form-check-label' for='input' >{$key}</label>
                </div>
                </tr>";
        }

        $member .= "</table>
    ";
    }
    return $member;
}
if (empty($_SESSION['client']['familyMembers'])) {
    $members = "<p class='alert alert-danger p-3'> No family members subscribed</p>";
} else {
    $members = drawMemberGames($games);
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // validation
        $errors = [];

        for ($i = 1; $i <= $_SESSION['client']['familyMembers']; $i++) {
            if (empty($_POST[$i])) {
                $errors['memberName'] = "<p class='alert alert-danger'>please enter member name</P>";
            }
            $_SESSION['client']['membersInfo'][$i] = (array)[
                "name" => $_POST[$i],
                "games" => (array)[
                    "$i.football" => $_POST[$i . 'football'] ?? "",
                    "$i.swimming" => $_POST[$i . 'swimming'] ?? "",
                    "$i.volleyball" => $_POST[$i . 'volleyball'] ?? "",
                    "$i.others" => $_POST[$i . 'others'] ?? "",
                ]

            ];
        }
        header("location:Result.php");
        die;
    }
}


?>

<section class="container mt-4" style="margin-bottom: 120px;">
    <div class="row justify-content-center">
        <div class="col-8">
            <form method="post">
                <h2><?= ucfirst($_SESSION['client']['name']) ?></h2>
                <?= $members ?>
                <button type="submit" class="btn btn-info mt-3">Subscribe</button>
            </form>
        </div>
    </div>
</section>

<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>