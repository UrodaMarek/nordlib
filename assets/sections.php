<?php

function gen_nav($level) : string {
    $nav = "";
    switch ($level) {
        case 0:
            $tab = ["Witaj", "Posty", "Zarejestruj", "Zaloguj"];
            break;
        case 1:
            $tab = [];
            break;
        case 2:
            $tab = [];
            break;
    }

    foreach ($tab as $option) {
        $nav .= <<< END
        
        END;
    }

    return $nav;
}

function menu($level) : string {
    $nav = gen_nav($level);

    $menu = <<< END
    <header>
        <section>LOGO</section>
        <nav>
            $nav
        </nav>
    </header>
    END;

    return $menu;
}

function main_content() : string {
    
    
    
    $content = <<< END
    
    
    END;

    return $content;
}

function footer(): string {
    return "<footer>2024 &copy; Wszelkie prawa zastrzeżone </footer>";
}