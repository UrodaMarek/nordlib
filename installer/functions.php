<?php
    function conRoot($credentials) : mysqli {
        try {
        $dbr = new mysqli($credentials[0], $credentials[1], $credentials[2]);
        }
        catch (mysqli_sql_exception $exception) {
            $exception_mess = $exception->getMessage();
            $exception_num = $exception->getCode();

            echo <<< END
                <section id="form">
                    <p>
                        Wyjatek info: $exception_mess | numer: $exception_num
                        Blad polaczenia z serwerem baz danych.
                    </p>

                    <br><br>
                    <form action="index.php">
                        <input type="submit" value="Sprubuj jeszcze raz">
                    </form>
                </section>
            END;
        }
        return $dbr;
    }


    function install($credentials, $new_users_pass, $new_admin_data) {
        
        //TODO: Make here new_admin_data validation

        $salt = "4c42ad5dcec81f9f14086478f9b1b4f9719b4ee0f8709b060c0562ed4a2866ec19195ced78944c67ea05158a310757dd86b5506324f0e8afd83d2e08c61c7ce3";
        $admin_password = hash('sha512', $salt . $new_admin_data[9]);
        $admin_password = "'".$admin_password."'";
        
        $file_path = "./library.sql";
        $sql_file = fopen($file_path, "r");
        $sql_instructions = fread($sql_file, filesize($file_path));
        fclose($sql_file);
        //TODO: TRY check

        $sql_instructions = preg_replace("/(-- \+)(.*)?|(-- \*)(.*)?|(-- )(.*)?/", "", $sql_instructions);
        $sql_instructions = preg_replace("/(\n\n\n)|(\n\n)|(\n)/", " ", $sql_instructions);
        $sql_instructions = trim($sql_instructions);
        $sql_instructions = preg_replace("/(\n\n\n)|(\n\n)|(\n)/", " ", $sql_instructions);
        $sql_instructions = preg_replace("/(; )/", ";", $sql_instructions);
        
        $sql_instructions = preg_replace("/(!localhost!)/", $credentials[0], $sql_instructions);
        
        $sql_instructions = preg_replace("/(!password0!)/", $new_users_pass[0], $sql_instructions);
        $sql_instructions = preg_replace("/(!password1!)/", $new_users_pass[1], $sql_instructions);
        $sql_instructions = preg_replace("/(!password2!)/", $new_users_pass[2], $sql_instructions);
        $sql_instructions = preg_replace("/(!password3!)/", $new_users_pass[3], $sql_instructions);
        $sql_instructions = preg_replace("/(!password4!)/", $new_users_pass[4], $sql_instructions);

        $new_admin_data2 = [];
        foreach($new_admin_data as $data) {
            if (!($data=="NULL" or preg_match_all("/^([0-9])([0-9])?$/", $data))) {
                $data = "'".$data."'";
            }
            $new_admin_data2[] =  $data;
        }
        $new_admin_data = $new_admin_data2;

        $sql_instructions = preg_replace("/('!admin_first_name!')/", $new_admin_data[2], $sql_instructions);
        $sql_instructions = preg_replace("/('!admin_second_name!')/", $new_admin_data[3], $sql_instructions);
        $sql_instructions = preg_replace("/('!admin_third_name!')/", $new_admin_data[4], $sql_instructions);
        $sql_instructions = preg_replace("/('!admin_surname!')/", $new_admin_data[5], $sql_instructions);
        $sql_instructions = preg_replace("/('!admin_sex_id!')/", $new_admin_data[8], $sql_instructions);
        $sql_instructions = preg_replace("/('!admin_telephone!')/", $new_admin_data[6], $sql_instructions);
        $sql_instructions = preg_replace("/('!admin_country_id!')/", $new_admin_data[7], $sql_instructions);
        $sql_instructions = preg_replace("/('!admin_interested_in!')/", $new_admin_data[10], $sql_instructions);

        $sql_instructions = preg_replace("/('!admin_nick!')/", $new_admin_data[0], $sql_instructions);
        $sql_instructions = preg_replace("/('!admin_pass!')/", $admin_password, $sql_instructions);
        $sql_instructions = preg_replace("/('!admin_email!')/", $new_admin_data[1], $sql_instructions);

        preg_match_all('/([^;]*;)/', $sql_instructions, $array_of_sql_instructions);

        // TODO: MAKE IT SMARTER
        $dbr = conRoot($credentials);

        foreach($array_of_sql_instructions[1] as $sql_instruction) {
            $r  = $dbr -> query($sql_instruction);
        }
        //? Dlaczego $r -> close() wykrzacza aplikacje?
        
        $dbr -> close();
        // TODO: try it
        // TODO: Make it smarter
        echo <<< END
            <section id="form">
                <h2>Instalacja przebiegła pomyślnie</h2>
                <form method="post" action="../index.php">
                    <input type="submit" value="Powrot do strony glownej"/>
                </form>
            </section>
        END;
    }