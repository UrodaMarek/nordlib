<?php
    function get_theme($session): string {
        
        
        if ($session !== FALSE) {
            $colors = get_user_color($session);
            /*
            $q = "SELECT `primary`, `secondary`, `tertiary` FROM Theme WHERE id = 0;";
            $r = query_db(0, $q)->fetch_assoc(); //TODO: Zmienić kolejność argumentów.
            
            $primary = $r['primary'];
            $primary = $r['secondary'];
            $primary = $r['tertiary'];
            */

            
        }


        $theme = <<< END
            
            //default theme

        END;
        
        return $theme;
    }

    function get_user_color($session): string {
        $q = "SELECT ";
        return $theme = <<< END
            
            //default theme
            
            END;
    }