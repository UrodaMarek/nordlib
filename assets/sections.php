<?php

function gen_nav($level) : string {
    $nav = "";
    switch ($level) {
        case 0:
            $tab = ["Zaloguj", "Zarajestruj", "Posty", "Witaj"];
            break;
        case 1:
            $tab = [""];
            break;
        case 2:
            $tab = [];
            break;
    }

    foreach ($tab as $option) {
        $nav .= <<< END
            <nav>
                <a href="#">
                    $option
                </a>
            </nav>
        END;
    }

    return $nav;
}

function menu($level) : string {
    $nav = gen_nav($level);

    $menu = <<< END
        <header>
            <header>
                <nav>
                    <a href="#">
                        <h1>
                            NordLib
                        </h1>
                    </a>
                </nav>
            </header>
            <section>
                $nav
            </section>
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