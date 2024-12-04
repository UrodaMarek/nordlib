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
            <div></div>
            <a href="#">
                <nav>
                    $option
                </nav>
            </a>
        END;
    }
    $nav = ltrim($nav);
    $nav = ltrim($nav, "<div></div>");
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
                            <span id="nord">Nord</span><span id="lib">Lib</span>
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