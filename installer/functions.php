<?php
    function conRoot($credentials) : mysqli {
        try {
        $dbr = new mysqli($credentials[0], $credentials[1], $credentials[2]);
        }
        catch (mysqli_sql_exception $exception) {
            $exception_mess = $exception->getMessage();
            $exception_num = $exception->getCode();

            echo <<< END
                <p>
                    Wyjatek info: $exception_mess | numer: $exception_num
                    Blad polaczenia z serwerem baz danych.
                </p>

                <br><br>

                <form action="index.php">
                    <input type="submit" value="Sprubuj jeszcze raz">
                </form>
            END;
        }
        return $dbr;
    }


    function install($credentials) {
        $file_path = "./library.sql";
        $sql_file = fopen($file_path, "r");
        $sql_instructions = fread($sql_file, filesize($file_path));
        fclose($sql_file);
        //TODO: TRY check

        $sql_instructions = preg_replace("/(-- \+)(.*)?|(-- \*)(.*)?|/", "", $sql_instructions);
        $sql_instructions = preg_replace("/(\n\n\n)|(\n\n)|(\n)/", " ", $sql_instructions);
        $sql_instructions = trim($sql_instructions);
        $sql_instructions = preg_replace("/(\n\n\n)|(\n\n)|(\n)/", " ", $sql_instructions);
        $sql_instructions = preg_replace("/(; )/", ";", $sql_instructions);

        preg_match_all('/([^;]*;)/', $sql_instructions, $array_of_sql_instructions);

        // TODO: MAKE IT SMARTER
        
        $dbr = conRoot($credentials);

        foreach($array_of_sql_instructions[1] as $sql_instruction) {
            $r  = $dbr -> query($sql_instruction);
        }
        //? Dlaczego $r -> close() wykrzacza aplikacje?
        $dbr -> close();
        // TODO: try it
        
        echo <<< END
            Instalacja przebiegła pomyślnie<br><br>
            <a href="../index.php">
                <button>
                    Powrót do strony głównej
                </button>
            </a>
        END;
    }