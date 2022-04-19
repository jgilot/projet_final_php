<?php
 try{
    $db = new PDO('mysql:host=localhost;dbname=php_final_project;charset=utf8', 'root', '');
} catch(Exception $e){
    die( 'Problème avec la base de données ! ' . $e->getMessage() );
}
require 'includes/recaptchaValid.php';
echo "<pre>";
print_r($_POST);
echo "</pre>";


// appel des variables
if (
isset($_POST['email']) &&
isset($_POST['password']) &&
isset($_POST['confirm-password']) &&
isset($_POST['pseudonym']) &&
isset($_POST['g-recaptcha-response'])

) {
    // Bloc de vérifs
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'L\'email est invalide !';
    }
    if (!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[ !"#\$%&\'()*+,\-.\/:;<=>?@[\\\\\]\^_`{\|}~]).{8,4096}$/u', $_POST['password'])) {
        $errors[] = 'Le mot de passe doit comprendre au moins 8 caractères dont 1 lettre minuscule, 1 majuscule, un chiffre et un caractère spécial.';
    }
    if ($_POST['password'] != $_POST['confirm-password']) {
        $errors[] = 'Les mots de passe de coresspondent pas !';
    }
    if (!preg_match('/^.{1,50}$/iu', $_POST['pseudonym'])) {
        $errors[] = 'Le pseudonyme doit contenir entre 1 et 50 caractères !';
    }
    if (!recaptchaValid($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'])) {
        $errors[] = 'Veuillez remplir le reCaptcha';
    }

    // Si pas d'erreurs, on envoie le formulaire
    if (!isset($errors)) {
        $successMsg = 'Inscription réussie !';
        $db
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require 'includes/head.php'; ?>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <title>Inscription - Wikifruits</title>
</head>
<body>
<?php
require 'includes/navbar.php'; ?>

    <div class="container-fluid">

        <div class="row">

            <div class="col-12 col-md-8 offset-md-2 py-5">
                <h1 class="pb-4 text-center">Créer un compte sur Wikifruit</h1>

                <div class="col-12 col-md-6 mx-auto">
    <?php
if(isset($errors)) {
    foreach ($errors as $error) {
        echo '<p class="alert alert-danger ">' . $error . '</p>';
    }
}
?>
<?php
// Si la variable $successMsg existe, alors on l'affiche, sinon on affiche le formulaire
if(isset($successMsg)) {
    echo '<p style="color:green;">' . $successMsg . '</p>';
}
else {
?>
                        <form action="register.php" method="POST">

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input id="email" type="text" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                <input id="password" type="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="confirm-password" class="form-label">Confirmation mot de passe <span class="text-danger">*</span></label>
                                <input id="confirm-password" type="password" name="confirm-password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="pseudonym" class="form-label">Pseudonyme <span class="text-danger">*</span></label>
                                <input id="pseudonym" type="text" name="pseudonym" class="form-control">
                            </div>
                            <div class="mb-3">
                                <p class="mb-2">Captcha <span class="text-danger">*</span></p>
                                <div class="g-recaptcha" data-sitekey="6LemRYQfAAAAAEvnMkp5zx9apku4yoNHKhZivB7J"></div>
                            </div>
                            <div>
                                <input value="Créer mon compte" type="submit" class="btn btn-success col-12">
                            </div>

                            <p class="text-danger mt-4">* Champs obligatoires</p>
                        </form>
                            <?php
                    }
                    ?>
                </div>

            </div>

        </div>

    </div>
    </body>
</html>