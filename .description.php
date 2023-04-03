<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = array(
    "NAME" => GetMessage("MY_COMPONENT_NAME"),
    //показывать кнопку очистки кеша компонента в режиме редактирования сайта
    "CACHE_PATH" => "Y",
    "DESCRIPTION" => GetMessage("DESCRIPTION"),
    "PATH" => array(
        "ID" => "my_component",
    ),
);
?>