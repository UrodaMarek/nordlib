<?php

function gen_nav($level, $chosen_option) : string {
    $nav = "";
    switch ($level) {
        case 0:
            $tab = ["Zaloguj", "Zarejestruj", "Posty", "Witaj"];
            break;
        case 1:
            $tab = [""];
            break;
        case 2:
            $tab = [];
            break;
    }

    for ($i = 0; $i < count($tab); $i++) {
        $option = $tab[$i];
        $j = count($tab) - $i - 1;
        if ($chosen_option == "$j") {
            $nav .= <<< END
                <div></div>
                <a href="index.php?option=$j" id="chosen">
                    <nav>
                        $option
                    </nav>
                </a>
            END;
            continue;
        }
        $nav .= <<< END
            <div></div>
            <a href="index.php?option=$j">
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

function menu($level, $option) : string {
    $nav = gen_nav($level, $option);

    $menu = <<< END
        <header>
            <header>
                <nav>
                    <a href="./index.php?option=0">
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

function main_content($option) : string {
    
    switch ($option) {
        case "0":
            $content = <<< END
                <article>
                    <h2>Witaj</h2>
                    <p>
                        Dziękujemy za zaufanie.
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed placerat porta elementum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam eu nisi aliquet, malesuada erat eget, volutpat orci. Nulla et turpis velit. Sed et imperdiet velit. Phasellus vulputate blandit ligula id pulvinar. Aenean accumsan id augue vel tempor. Nam neque sem, hendrerit non venenatis vitae, pellentesque a tortor. Suspendisse potenti. Nullam eget varius velit.
                        Pellentesque vestibulum felis eget ipsum viverra, eget ornare dolor porta. Nullam velit felis, fermentum ac mi sit amet, consectetur convallis nibh. Sed blandit rutrum neque id molestie. Duis vitae augue mi. Donec porttitor mi scelerisque, dictum felis eu, egestas diam. Morbi lacinia nunc tortor, at dictum dolor rutrum vel. Donec nec lacus et est sodales porttitor non sed nisl. Integer cursus auctor sem, sit amet feugiat mauris feugiat et. Aliquam at eros quam.
                    </p>
                <article>
            END;
            break;
        case "1":
            $content = <<< END
                <article class="post">
                    <section class="date">
                        15:30<br>
                        15/04/2024
                    </section>
                    <h2>Tytuł posta</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed placerat porta elementum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam eu nisi aliquet, malesuada erat eget, volutpat orci. Nulla et turpis velit. Sed et imperdiet velit. Phasellus vulputate blandit ligula id pulvinar. Aenean accumsan id augue vel tempor. Nam neque sem, hendrerit non venenatis vitae, pellentesque a tortor. Suspendisse potenti. Nullam eget varius velit.
                        Pellentesque vestibulum felis eget ipsum viverra, eget ornare dolor porta. Nullam velit felis, fermentum ac mi sit amet, consectetur convallis nibh. Sed blandit rutrum neque id molestie. Duis vitae augue mi. Donec porttitor mi scelerisque, dictum felis eu, egestas diam. Morbi lacinia nunc tortor, at dictum dolor rutrum vel. Donec nec lacus et est sodales porttitor non sed nisl. Integer cursus auctor sem, sit amet feugiat mauris feugiat et. Aliquam at eros quam.
                    </p>
                    <section class="subtitle">Administracja</section>
                </article>
            END;
            break;
        case "2":
            $content = <<< END
                Opcja 3
            END;
            break;
        case "3":
            $content = <<< END
                Opcja 4
            END;
            break;
        default:
            $content = "";
    }

    return $content;
}

function footer(): string {
    return "<footer>2024 &copy; Wszelkie prawa zastrzeżone </footer>";
}