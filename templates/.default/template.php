<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) ?>
<?php $cpt = new CCaptcha();
$captchaPass = COption::GetOptionString("main", "captcha_password", "");
if (strlen($captchaPass) <= 0) {
    $captchaPass = randString(10);
    COption::SetOptionString("main", "captcha_password", $captchaPass);
}
$cpt->SetCodeCrypt($captchaPass); ?>



<div>
    <form method="post" class="my_form" id="my_form">
        Имя: <input type="text" name="name" id="name" placeholder="имя" value="<?= $arResult["name"] ?>">
        <br>
        <br>
        Почта: <input type="text" name="email" id="email" placeholder="email" value="<?= $arResult["email"] ?>">
        <br>
        <br>
        <textarea name="message" id="message" placeholder="input your message" rows="5"
                  cols="40"><?= $arResult["message"] ?></textarea>
        <br>
        <br>
        <p style="color: red"><?= $arResult["ERROR"] ?></p>
        <input type="submit" id="btn-send-form" class="btn">
        <br>
        <br>
        <input name="captcha_code" value="<?= htmlspecialchars($cpt->GetCodeCrypt()); ?>" type="hidden">
        <input id="captcha_word" name="captcha_word" type="text">
        <img src="/bitrix/tools/captcha.php?captcha_code=<?= htmlspecialchars($cpt->GetCodeCrypt()); ?>">
    </form>
</div>