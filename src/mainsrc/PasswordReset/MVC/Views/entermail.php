<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Cinnec">
    <meta name="keywords" content="Passwort zurücksetzen, TeachGym">
    <?php require_once __DIR__ . "/../../../App/Base/base.php"?>
    <title>Passwort zurücksetzen</title>
</head>
<body>
<main class="login--main">
    <div class="login--container login--container-small">
        <div class="login--container-contentholder login--container-contentholder-small">
            <h1 class="login--container-contentholder-heading login--container-contentholder-heading-small">Passwort zurücksetzen</h1>
            <p class="login--container-contentholder-subtitle"><a href="/login" class="login--link">Zurück zum Login</a></p>
            <form method="post" class="login--form">
                <div class="form--group form--group-vertical" style="margin-top: 1rem">
                    <label class="form--input-label" for="email">Email Adresse</label>
                    <input type="text" id="email" name="mail" class="form--input-text" placeholder="Bitte gib deine Email-Adresse an">
                </div>
                <div class="form--error-container" style="top: 4.5rem">
                    <p class="form--error"><?php if(!empty($error)){ echo $error; } ?></p>
                </div>
                <div class="form--error-container" style="top: 4.5rem">
                    <p class="form--error" style="color: #09E07E"><?php if(!empty($success)){ echo $success; } ?></p>
                </div>
                <button class="form--button" style="margin-top: 1.5rem">Passwort zurücksetzen</button>
            </form>
        </div>
    </div>
</main>
<script src="https://kit.fontawesome.com/a043dc9ebd.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../../../../scripts/linkEvents.js"></script>
<script src="../../../../scripts/registerListener.js"></script>
</body>
</html>
