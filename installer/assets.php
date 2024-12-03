<?php
    require_once("./functions.php");
    function wizard($param) : void {
        if ($param[0][0] === "start") {
            install($param[1]);
        }

        if ($param === FALSE) {
            $form = <<< END
            <form method="post" action="./installer.php?installation=start">
                <label for="login">Login: </label>
                <input type="text" name="login" id="login"><br><br>
                <label for="password">Hasło</label>
                <input type="password" name="password" id="password"><br><br>
                <label for="host">Host:</label>
                <input type="text" name="host" id="host"><br><br>
                <input type="submit" value="Rozpocznij instalacje"/>
            </form>
            END;
            echo $form ;
        }
    }