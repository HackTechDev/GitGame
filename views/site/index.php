<?php

/* @var $this yii\web\View */

$this->title = 'Git Game';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Git Game</h1>
    </div>

    <div class="body-content">
        <div class="row">
            <table>
            <?php
            //echo $min . " " . $max;
            $scale = 500 / ( $max - $min);

            foreach($dataTeam as $Team) {
                echo "<tr>";
                echo "<td>" . $Team["name"] . "</td><td>&nbsp;" . $Team["project"] . "</td><td>&nbsp;</td><td>&nbsp;";
                $length =  $Team["commit"] * $scale;
                echo "<img src=\"/image/car.png\" style=\"height: 10px; width: " . $length . "px\">";

                /*
                for($i = 0 ; $i < $Team["commit"]; $i++) {
                    echo "@";
                }*/
                echo  "&nbsp;" . $Team["commit"];
                echo  "&nbsp;|&nbsp;" . $Team["step"];
                echo "</td></tr>";
            }
            
            ?>
            </table>
        </div>

    </div>
</div>
