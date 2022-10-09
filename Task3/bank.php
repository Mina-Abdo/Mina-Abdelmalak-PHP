<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //validation
    $errors = [];
    if (empty($_POST['name'])) {
        $errors['name'] = "<p class='alert alert-danger'> please enter your name </p>";
    }
    if (empty($_POST['loan'])) {
        $errors['loan'] = "<p class='alert alert-danger'> please enter your loan </p>";
    }
    if (empty($_POST['years'])) {
        $errors['years'] = "<p class='alert alert-danger'> please enter loan years </p>";
    }
    if (empty($errors)) {
        $calc = [];
        if ($_POST['years'] <= 3) {
            $calc['interest'] = 0.1 * $_POST['years'] * $_POST['loan'];
        } else {
            $calc['interest'] = 0.15 * $_POST['years'] * $_POST['loan'];
        }
        $calc['totalPayment'] = $calc['interest'] + $_POST['loan'];
        $calc['montlyPayment'] = round($calc['totalPayment'] / ($_POST['years'] * 12), 2);
        $resultTable = "
        <table class='table'>
            <tbody>
                <tr>
                    <td>
                        User Name
                    </td>
                    <td>
                        {$_POST['name']}</td>
                </tr>
                <tr>
                    <td>
                        Bank Interest
                    </td>
                    <td>
                        {$calc['interest']} EGP
                    </td>
                </tr>
                <tr>
                    <td>
                        Total after Interest
                    </td>
                    <td>
                        {$calc['totalPayment']} EGP
                    </td>
                </tr>
                <tr>
                    <td>
                        Monthly Payment
                    </td>
                    <td>
                        {$calc['montlyPayment']} EGP
                    </td>
                </tr>
            </tbody>
        </table>
    ";
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <title>Bank</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class=" col-12 text-center text-warning mt-5">
                <h2>Bank Task</h2>
            </div>
            <div class=" col-8 mt-5">
                <form method="post">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="<?= $_POST['name'] ?? '' ?>">
                        <?= $errors['name'] ?? "" ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Loan</label>
                        <input type="number" class="form-control" name="loan" value="<?= $_POST['loan'] ?? '' ?>">
                        <?= $errors['loan'] ?? "" ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Loan Payment years</label>
                        <input type="number" class="form-control" name="years" value="<?= $_POST['years'] ?? '' ?>">
                        <?= $errors['years'] ?? "" ?>
                    </div>
                    <button class="btn btn-success">Calculate</button>
                </form>
            </div>
            <div class="col-8 mt-3">
                <?= $resultTable ?? "" ?>
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