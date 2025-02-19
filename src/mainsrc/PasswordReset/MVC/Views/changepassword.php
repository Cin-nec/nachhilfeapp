<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Cinnec">
    <meta name="keywords" content="Passwort zurücksetzen, TeachGym">
    <?php require_once __DIR__ . "/../../../App/Base/base.php"?>
    <title>Neues Passwort</title>
</head>
<body>
<main class="login__main">
    <div class="login__container login__container--small">
        <div class="login__container-contentholder login__container-contentholder--small">
            <h1 class="login__container-contentholder-heading login--container-contentholder-heading-small">Neues Passwort</h1>
            <p class="login__container-contentholder-subtitle"><a href="/login" class="login__link">Zurück zum Login</a></p>
            <form method="post" class="login__form">
                <div class="form--group form__group--vertical" style="margin-top: 1rem; position: relative">
                    <label class="form__input--label" for="password">Passwort</label>
                    <input oninput="passwordCheck()" type="password" minlength="8" maxlength="20" id="password" name="password" class="form__input--password" placeholder="Passwort eingeben:">
                    <div class="form__error--container"><p class="form__error"><?php if(!empty($fail["password"])){ echo $fail["password"]; }?></p></div>
                    <div onclick="showPassword()" class="form__visibility form--visibility-show">
                        <i class="fa-regular fa-eye"></i>
                    </div>
                    <div onclick="hidePassword()" class="form__visibility form--visibility-hide form__visibility--none">
                        <i class="fa-regular fa-eye-slash"></i>
                    </div>
                    <p class="form__vorgabe"><span class="form--gross">1 Großbuchstabe</span> - <span class="form--klein">1 Kleinbuchstabe</span> - <span class="form--zahl">1 Zahl</span> - <span class="form--sonder">1 Sonderzeichen</span> </p>
                </div>
                <div class="form__error--container" style="top: 4.5rem">
                    <p class="form__error"><?php if(!empty($error)){ echo $error; } ?></p>
                </div>
                <div class="form__error--container" style="top: 4.5rem">
                    <p class="form__error" style="color: #09E07E"><?php if(!empty($success)){ echo $success; } ?></p>
                </div>
                <button class="form__button" style="margin-top: 1.5rem">Passwort ändern</button>
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
