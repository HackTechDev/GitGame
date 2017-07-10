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

            foreach($dataTeam as $Team) {
                echo "<tr>";
                echo "<td>" . $Team["name"] . "</td><td>&nbsp;" . $Team["project"] . "</td><td>&nbsp;" . $Team["step"]. "</td><td>&nbsp;";
                for($i = 0 ; $i < $Team["commit"]; $i++) {
                    echo "@";
                }
                echo  "&nbsp;" . $Team["commit"];
                echo "</td></tr>";
            }
            
            ?>
            </table>
        </div>

    </div>
</div>
