<?php
    include './NodeInterface.php'

    class Node implements NodeInterface {

        function addChild(child){
            echo '+++' + child
        }
        function getChildren() {

        }
        function __construct() {

        }
        function __toString() {

        }
        function getName() {

        }
    }

    /*
        Возникла проблема реализации т.к. ранее не писал на php.
        Прочитал в интернете подробнее про интерфейсы, думаю, что основную мысль понял,
        создал класс Node с необходимыми функциями, однако с реализацией функционала возникли проблемы
        Очень хотелось бы, чтобы подробнее разобрали это задание
     */