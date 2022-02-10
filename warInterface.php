<?php
    interface Warinterface {
        function __construct($army1, $army2, $ice, $rain);

        function calc_army_damage_health($army): int;

        function get_total_params();

        function get_units_winner();

        function get_army_values($armies, $army);

        function get_winner();

        function show_units($idx);
    }
?>