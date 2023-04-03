<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

class FeedbackForm extends CBitrixComponent implements Controllerable {

    protected bool $onPage = false;
    protected bool $hasEmptyFields = true;
    protected bool $emptyFields = true;
    protected bool $isSendMessage = false;
    protected $isValidEmail = false;
    protected array $data = array();

    public function onPrepareComponentParams($arParams): array {

        if (!Loader::includeModule("iblock")) {
            ShowError(Loc::getMessage("NOT_INSTALLED_MESSAGE"));
        }
        if (!isset($arParams["CACHE_TIME"])) {
            $arParams["CACHE_TIME"] = 36000000;
        }
        return $arParams;
    }

    // Метод c action не будет вызван при ajax запросе!!!!!!!!!!!!!!!!!!!
    public function executeComponent(): void {
        //если кэш есть, то вернется html вёрстка
        if ($this->startResultCache()) {
            $this->data = $this->sendAction();
            $this->arResult = $this->data;
            $this->checkEmptyFields();
            $this->validateEmail($this->data["email"]);
            $this->sendData($this->data);
            $this->includeComponentTemplate();
        } else {
            $this->abortResultCache();;
        }
    }

    function checkUserAuth(): bool {
        return (new CUser)->IsAuthorized();
    }

    function validateEmail($email): void {
        if (!$this->hasEmptyFields && $this->onPage) {
            $expression = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
            if (preg_match($expression, $email)) {
                $this->isValidEmail = true;
            } else {
                $this->arResult["ERROR"] = "email isn't valid";
            }
        }
    }

    function sendData($data): void {
        $name = $data["name"];
        $message = $data["message"];
        $email = $data["email"];
        if ($this->onPage && $this->isValidEmail && !$this->hasEmptyFields) {
            $loadArr = array(
                "IBLOCK_SECTION_ID" => false,
                "IBLOCK_ID" => $this->arParams["IBLOCK_ID_DB"],
                "NAME" => "23223",
                "PROPERTY_VALUES" => ["NAME" => $name,
                    "EMAIL" => $email,
                    "MESSAGE" => $message]
            );
            $this->isSendMessage = true;
            (new CIBlockElement)->Add($loadArr);
            mail("$name", $email, "$name\n$email\n$message");
            $this->arResult["ERROR"] = "сообщение отправлено";
            unset($this->arResult["name"]);
            unset($this->arResult["email"]);
            unset($this->arResult["message"]);
        }
    }

    //ajax output catch method
    function sendAction(): array {
        if ($this->request->isPost()) {
            $this->onPage = true;
            $name = htmlspecialchars($this->request->get("name") ?? '');
            $email = htmlspecialchars($this->request->get("email") ?? '');
            $message = htmlspecialchars($this->request->get("message") ?? '');
            return ["name" => $name, "message" => $message, "email" => $email];
        }
        return [];
    }

    function checkEmptyFields() {
        if ($this->data["name"] && $this->data["message"] && $this->data["email"]) {
            $this->hasEmptyFields = false;;
        }
        if ($this->onPage && $this->hasEmptyFields) {
            $this->arResult["ERROR"] = "Заполните все поля";
        }
    }

    function configureActions($name = '', $email = '', $message = ''): array {
        return [];
    }
}