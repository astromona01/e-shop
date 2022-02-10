<?php

    class War {
        public $pehota = [
            'health' => 100,
            'armour' => 10,
            'damage' => 10,
        ];
        
        public $luchniki = [
            'health' => 100,
            'armour' => 5,
            'damage' => 20,
        ];
        
        public $konnica = [
            'health' => 300,
            'armour' => 30,
            'damage' => 30,
        ];

        public $army1;
        public $army2;
        public $ice;
        public $rain;

        function __construct($army1, $army2, $ice, $rain)
        {
            $this->army1 = $army1;
            $this->army2 = $army2;
            $this->ice = $ice;
            $this->rain = $rain;
        }

        function calc_army_damage_health($army) 
        {
            $damage = 0;
            $health = 0;
            $units = [];
            foreach($army['units'] as $unit => $count)
            {
                $this->ice && $unit == "konnica" && $this->{$unit}['armour'] = 0;
                $this->rain && $unit == "luchniki" && $this->{$unit}['damage'] /= 2;

                $damage += $this->{$unit}['damage'] * $count;
                $health += $this->{$unit}['health'] * $count + $this->{$unit}['armour'] * $count;
                $units[$unit] = ['damage' => $damage, 'health' => $health];
            }
            return ['units' => $units, 'damage' => $damage, 'health' => $health];

        }
        function get_total_params()
        {
            $army1 =  $this->calc_army_damage_health($this->army1);
            $army2 = $this->calc_army_damage_health($this->army2);

            return ['army1' => $army1, 'army2' => $army2];
        }
        function get_units_winner()
        {
            $armies = $this->get_total_params();
            $army1_values = $this->get_army_values($armies, 'army1');
            $army2_values = $this->get_army_values($armies, 'army2');
            $results = [];
            foreach($army1_values as $value_name => $value)
            {
                while($value['health'] > 0 && $army2_values[$value_name]['health'] > 0)
                {
                    $value['health']-= $army2_values[$value_name]['damage'];
                    $army2_values[$value_name]['health'] -= $value['damage'];
                }
                $results["Army1 $value_name health"] = $value['health'];
                $results["Army2 $value_name health"] = $army2_values[$value_name]['health'];
            }
            return $results;
        }
        function get_army_values($armies, $army)
        {
            $army_values = [];
            foreach($armies[$army]['units'] as $unit_name => $values)
            {
                foreach($values as $value_name => $value_count)
                {
                    if ($army_values[$unit_name])
                    {
                        $army_values[$unit_name][$value_name] = $value_count; 
                    }else 
                    {
                        $army_values[$unit_name] = [$value_name => $value_count];
                    }
                }
            }
            return $army_values;
        }
        function get_winner()
        {
            $armies = $this->get_total_params();
            [$health1, $damage1] = [$armies['army1']['health'], $armies['army1']['damage']];
            [$health2, $damage2] = [$armies['army2']['health'], $armies['army2']['damage']];
            $duration = 0;
            while($health1 > 0 && $health2 > 0)
            {
                $health1 -= $damage2;
                $health2 -= $damage1;
                $duration++;
            }
            return ['health1' => $health1, 'health2' => $health2, 'duration' => $duration];
        }
        function show_units($idx)
        {
            $index = -1;
            $arr = [];
            foreach ($this->army1['units'] as $unit => $count) {
                $index++;
                $arr[$index] = $unit;
            }
            print($arr[$idx]);
        }
    }
    $army1 = [
        'name' => 'Александр Ярославич',
        'units' => [
            'pehota' => 200,
            'luchniki' => 30,
            'konnica' => 15,
        ]
    ];
    $army2 = [
        'name' => 'Ульф Фасе',
        'units' => [
            'pehota' => 90,
            'luchniki' => 65,
            'konnica' => 25,
        ]
    ];

$ex = new War($army1, $army2, false, false);
$units_results = $ex->get_units_winner();
$results = $ex->get_winner()
?>


<table border="1">
    <tr>
        <th></th>
        <th><?=$army1['name']?></th>
        <th><?=$army2['name']?></th>
    </tr>
    <tr>
        <td>
            <?=$ex->show_units(0) ?>
        </td>
        <td>
            <?=$units_results["Army1 pehota health"] ?>
        </td>
        <td>
            <?=$units_results["Army2 pehota health"] ?>
        </td>
    </tr>
    <tr>
        <td>
            <?=$ex->show_units(1) ?>
        </td>
        <td>
            <?=$units_results["Army1 luchniki health"] ?>
        </td>
        <td>
            <?=$units_results["Army2 luchniki health"] ?>
        </td>
    </tr>
    <tr>
        <td>
            <?=$ex->show_units(2) ?>
        </td>
        <td>
            <?=$units_results["Army1 konnica health"] ?>
        </td>
        <td>
            <?=$units_results["Army2 konnica health"] ?>
        </td>
    </tr>
    <tr>
        <th>Health after <?=$results['duration'] ?> hits</th>
        <td>
            <?=$results['health1'] ?>
        </td>
        <td>
            <?=$results['health2'] ?>
        </td>
    </tr>
    <tr>
        <th>Result</th>
        <td><?=$results['health1'] > $results['health2'] ? 'WINNER' : 'lOOSER' ?></td>
        <td><?=$results['health2'] > $results['health1'] ? 'WINNER' : 'lOOSER' ?></td>
    </tr>
</table>