<?php

function gen_nav($is_loged, $chosen_option): string
{
    $nav = "";
    $options = [];
    $hrefs = [];
    $count = 0;
    if ($is_loged) {

    } else {
        $q = "SELECT `Interface`.`name`, `Interface`.`id_name` FROM `Interface_privileges` JOIN `Interface` ON `Interface`.`id`=`Interface_privileges`.`interface_id` JOIN `Roles` ON `Roles`.`id`=`Interface_privileges`.`role_id` WHERE `Interface_privileges`.`show`=TRUE AND `Roles`.`name`='anonymous' ORDER BY `Interface_privileges`.`show_order` DESC;";
        $result = query_db($q);
        while ($row = $result -> fetch_row()) {
            $options[]= $row[0];
            $hrefs[]= $row[1];
            $count++;
        }

    }
    if ($chosen_option === FALSE) {
        $chosen_option = $hrefs[$count-1];
    }
    for ($i = 0; $i < $count; $i++) {
        $option = $options[$i];
        $href = $hrefs[$i];
        if ($chosen_option == $href ) {
            $nav .= <<<END
                <div></div>
                <a href="index.php?option=$href" id="chosen">
                    <nav>
                        $option
                    </nav>
                </a>
            END;
            continue;
        }
        $nav .= <<<END
            <div></div>
            <a href="index.php?option=$href">
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

function menu($is_loged, $option): string
{
    $nav = gen_nav($is_loged, $option);

    $menu = <<<END
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

function main_content($is_loged, $option): string
{
    $flag = false;
    $content = "";

    if ($is_loged)
    {

    }
    else
    {
        if ($option === FALSE)
        {
            $q = "SELECT `Interface`.`id_name` FROM `Interface_privileges` JOIN `Interface` ON `Interface`.`id`=`Interface_privileges`.`interface_id` JOIN `Roles` ON `Roles`.`id`=`Interface_privileges`.`role_id` WHERE `Interface_privileges`.`show`=TRUE AND `Roles`.`name`='anonymous' ORDER BY `Interface_privileges`.`show_order` LIMIT 1;";
            $result = query_db($q);
            $interfaces_array = $result -> fetch_row();
            $option = $interfaces_array[0];
            $flag = true;
        }
        else
        {
            $q = "SELECT `Interface_privileges`.`show` FROM `Interface_privileges` JOIN `Interface` ON `Interface`.`id`=`Interface_privileges`.`interface_id` JOIN `Roles` ON `Roles`.`id`=`Interface_privileges`.`role_id` WHERE `Interface`.`id_name`='$option' AND `Roles`.`name`='anonymous';";
            $result = query_db($q);
            $priv = $result -> fetch_row();
            if ($priv[0] == true)
            {
                $flag = true;
            }
        }
    }

    if ($flag) {
        switch ($option)
        {
            case "welcome":
                $content = <<<END
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
            case "posts_an":
                $content = <<<END
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
            case "register":
                $countries = ["Polska", "Ukraina", "USA"];
                $sexs = ["mężczyzna", "kobieta"];

                foreach ($countries as $country) {
                    $country_options .= <<<END
                        <option value="$country">$country</option>
                    END;
                }

                foreach ($sexs as $sex) {
                    $sex_options .= <<<END
                        <option value="$sex">$sex</option>
                    END;
                }

                $country_options .= <<<END
                    <option value="" selected>?</option>
                END;

                $sex_options .= <<<END
                    <option value="" selected>?</option>
                END;


                $content = <<<END
                    <section id="form">
                        <h2>Rejestracja</h2>
                        <form method="post" action="./index.php">
                            <section>
                                <label for="nick">Nick: </label>
                                <input type="text" name="nick" id="nick" placeholder="Misiaty303">
                            </section>
                            <section>
                                <label for="email">Email:</label>
                                <input type="text" name="email" id="email" placeholder="email@example.com">
                            </section>
                            <section>
                                <label for="name">Imię:</label>
                                <input type="text" name="name" id="name" placeholder="Grzegorz">
                            </section>
                            <section>
                                <label for="name2">Drugie imię:</label>
                                <input type="text" name="name2" id="name2" placeholder="Waldemar">
                            </section>
                            <section>
                                <label for="name3">Trzecie imię:</label>
                                <input type="text" name="name3" id="name3" placeholder="Mirosław">
                            </section>
                            <section>
                                <label for="surname">Nazwisko:</label>
                                <input type="text" name="surname" id="surname" placeholder="Brzęczyszczykiewicz">
                            </section>
                            <section>
                                <label for="tel">Telefon:</label>
                                <input type="text" name="tel" id="tel" placeholder="+48666777888">
                            </section>
                            <section>
                                <label for="country">Kraj:</label>
                                <select name="country" id="country">
                                    $country_options
                                </select>
                            </section>
                            <section>
                                <label placeholder="?" for="sex">Płeć: </label>
                                <select name="sex" id="sex">
                                    $sex_options
                                </select>
                            </section>
                            <section>
                                <label for="password">Hasło:</label>
                                <input type="password" name="password" id="password" placeholder="*********">
                            </section>
                            <section>
                                <label for="password2">Powtórz hasło:</label>
                                <input type="password" name="password2" id="password2" placeholder="********">
                            </section>
                            <section id="textarea">
                                <label for="interesting">Zainteresowania:</label><br>
                                <textarea rows="5" name="interesting" id="interesting" placeholder="Lubię misie"></textarea>
                            </section>
                            <section id="checkbox">
                                <input type="checkbox" name="sure" id="sure">
                                <label for="sure">
                                    Świadomie zgadzam się na przetwarzanie moich danych osobowych przez Administratora strony internetowej, 
                                    bazy danych oraz serwera hostingowego. Twoimi administratorami są: ADMIN1, ADMIN2, ADMIN3
                                </label>
                            </section>
                            <input type="submit" value="Zarejestruj się"/>
                        </form>
                    </section>
                END;
                break;
            case "login":
                $content = <<<END
                    <section id="form">
                        <h2>Logowanie</h2>
                        <form method="post" action="./index.php">
                            <section>
                                <label for="login">Login: </label>
                                <input type="text" name="login" id="login" placeholder="email@example.com / nick">
                            </section>
                            <section>
                                <label for="password">Hasło:</label>
                                <input type="password" name="password" id="password" placeholder="*************">
                            </section>
                            <input type="submit" value="Zaloguj się"/>
                        </form>
                    </section>
                END;
                break;
            default:
                $content = "";
        }
    }
    return $content;
}

function footer(): string
{
    return "<footer>2024 &copy; Wszelkie prawa zastrzeżone </footer>";
}