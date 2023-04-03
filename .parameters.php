<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = array(
    "PARAMETERS" => array(
        //айди инфоблока продукции
        "IBLOCK_ID_DB" => array(
            "NAME" => GetMessage("IBLOCK_ID_DB"),
            "TYPE" => "STRING",
            //задаем параметры как базовые, а не дополнительные
            "PARENT" => "BASE",
        ),

        "CACHE_TIME" => array("DEFAULT" => 36000000),
    ),
);