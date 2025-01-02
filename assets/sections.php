<?php

function gen_nav($is_loged, $chosen_option): string
{
    $nav = "";
    $options = [];
    $hrefs = [];
    $count = 0;
    if ($is_loged) {
        $username = $_SESSION['login'];
        $password = $_SESSION['password'];
        $q = "SELECT `Interface`.`name`, `Interface`.`id_name` FROM `Interface_privileges` JOIN `Interface` ON `Interface`.`id`=`Interface_privileges`.`interface_id` JOIN `Roles` ON `Roles`.`id`=`Interface_privileges`.`role_id` JOIN `Users` ON `Users`.`role_id`=`Interface_privileges`.`role_id` WHERE `Interface_privileges`.`show`=TRUE AND `Users`.`pass`=$password AND `Users`.`username`=$username ORDER BY `Interface_privileges`.`show_order` DESC;";
        $result = query_db($q, 3);
        while ($row = $result -> fetch_row()) {
            $options[]= $row[0];
            $hrefs[]= $row[1];
            $count++;
        }

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
        $username = $_SESSION['login'];
        $password = $_SESSION['password'];
        if (check_user($username, $password)) {
            if ($option === FALSE)
            {
                $q = "SELECT `Interface`.`id_name` FROM `Interface_privileges` JOIN `Interface` ON `Interface`.`id`=`Interface_privileges`.`interface_id` JOIN `Roles` ON `Roles`.`id`=`Interface_privileges`.`role_id` JOIN `Users` ON `Users`.`role_id`=`Interface_privileges`.`role_id` WHERE `Interface_privileges`.`show`=TRUE AND `Users`.`pass`=$password AND `Users`.`username`=$username ORDER BY `Interface_privileges`.`show_order` LIMIT 1;";
                $result = query_db($q, 3);
                $interfaces_array = $result -> fetch_row();
                $option = $interfaces_array[0];
                $flag = true;
            }
            else
            {
                $q = "SELECT `Interface_privileges`.`show` FROM `Interface_privileges` JOIN `Interface` ON `Interface`.`id`=`Interface_privileges`.`interface_id` JOIN `Roles` ON `Roles`.`id`=`Interface_privileges`.`role_id` JOIN `Users` ON `Users`.`role_id`=`Interface_privileges`.`role_id` WHERE `Interface`.`id_name`='$option' AND `Users`.`pass`=$password AND `Users`.`username`=$username;";
                $result = query_db($q, 3);
                $priv = $result -> fetch_row();
                if ($priv[0] == true)
                {
                    $flag = true;
                }
            }
        }
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
                $sex_options = "";
                $country_options = "";

                $q = "SELECT `Sex`.`id`, `Sex`.`name` FROM `Sex`";

                $result = query_db($q);

                while ($row = $result -> fetch_row()) {
                    $sex_value = $row[0];
                    $sex = $row[1];
                    $sex_options .= <<<END
                        <option value="$sex_value">$sex</option>
                    END;
                }

                $sex_options .= <<<END
                    <option value="" selected>?</option>
                END;

                $q = "SELECT `Countries`.`id`, `Countries`.`name` FROM `Countries`";

                $result = query_db($q);

                while ($row = $result -> fetch_row()) {
                    $country_value = $row[0];
                    $country = $row[1];
                    $country_options .= <<<END
                        <option value="$country_value">$country</option>
                    END;
                }

                $country_options .= <<<END
                    <option value="" selected>?</option>
                END;


                $content = <<<END
                    <section id="form">
                        <h2>Rejestracja</h2>
                        <form method="post" action="./index.php?action=register">
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
                                    bazy danych oraz serwera hostingowego.
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
                        <form method="post" action="./index.php?action=log_in">
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
            case "main":
                $content = <<<END
                    <section id="search_bar">
                        <form action="index.html?action=send">
                            <input type="text" name="search_field">
                            |
                            <button type="submit">S</button>
                        </form>
                    </section>
                    <article class="post">
                        <section class="date">
                            15:30<br>
                            15/04/2024
                        </section>
                        <h2>Tytuł posta</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed placerat porta elementum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam eu nisi aliquet, malesuada erat eget, volutpat orci. Nulla et turpis velit. Sed et imperdiet velit. Phasellus vulputate blandit ligula id pulvinar. Aenean accumsan id augue vel tempor. Nam neque sem, hendrerit non venenatis vitae, pellentesque a tortor. Suspendisse potenti. Nullam eget varius velit.
                            Pellentesque vestibulum device-widthfelis eget ipsum viverra, eget ornare dolor porta. Nullam velit felis, fermentum ac mi sit amet, consectetur convallis nibh. Sed blandit rutrum neque id molestie. Duis vitae augue mi. Donec porttitor mi scelerisque, dictum felis eu, egestas diam. Morbi lacinia nunc tortor, at dictum dolor rutrum vel. Donec nec lacus et est sodales porttitor non sed nisl. Integer cursus auctor sem, sit amet feugiat mauris feugiat et. Aliquam at eros quam.
                        </p>
                        <section class="subtitle">Adam</section>
                    </article>
                END;
                break;
            case "messages":
                $content = <<<END
                <aside class="messenger" id="contacts">
                    <nav>
                        <div></div>
                        <button>Adrian</button><br/>
                        <div></div>
                        <button>Wacek</button><br/>
                        <div></div>
                        <button>Kacek</button><br/>
                        <div></div>
                        <button>Rycho</button><br/>
                        <div></div>
                        <button>Paweł</button><br/>
                        <div></div>
                        <button>Roman</button><br/>
                        <div></div>
                        <button>+</button>
                    </nav>
                    <button>
                        >
                    </button>
                </aside>
                <section class="messenger" id="chat">
                    <section id="messages">
                        <article title="" class="message">
                            <div></div>
                            <p>Hej</p>
                        </article>
                        <article title="" class="response">
                            <p>Hej co u Ciebie słychać?</p>
                            <div></div>
                        </article>
                        <article title="" class="message">
                            <div></div>
                            <p>AAAAAAAAAAA</p>
                        </article>
                        <article title="" class="response">
                            <p>BBBBBBBBB</p>
                            <div></div>
                        </article>
                        <article title="" class="message">
                            <div></div>
                            <p>WARKA
                            Barka</p>
                        </article>
                        <article title="" class="message">
                            <div></div>
                            <p>Hej</p>
                        </article>
                        <article title="" class="response">
                            <p>Hej co u Ciebie słychać?</p>
                            <div></div>
                        </article>
                        <article title="" class="message">
                            <div></div>
                            <p>AAAAAAAAAAA</p>
                        </article>
                        <article title="" class="response">
                            <p>BBBBBBBBB</p>
                            <div></div>
                        </article>
                        <article title="" class="message">
                            <div></div>
                            <p>WARKA
                            Barka</p>
                        </article>
                        <article title="" class="message">
                            <div></div>
                            <p>Hej</p>
                        </article>
                        <article title="" class="response">
                            <p>Hej co u Ciebie słychać?</p>
                            <div></div>
                        </article>
                        <article title="" class="message">
                            <div></div>
                            <p>AAAAAAAAAAA</p>
                        </article>
                        <article title="" class="response">
                            <p>BBBBBBBBB</p>
                            <div></div>
                        </article>
                        <article title="" class="message">
                            <div></div>
                            <p>WARKA
                            Barka</p>
                        </article>
                        <article title="" class="message">
                            <div></div>
                            <p>Hej</p>
                        </article>
                        <article title="" class="response">
                            <p>Hej co u Ciebie słychać?</p>
                            <div></div>
                        </article>
                        <article title="" class="message">
                            <div></div>
                            <p>AAAAAAAAAAA</p>
                        </article>
                        <article title="" class="response">
                            <p>BBBBBBBBB</p>
                            <div></div>
                        </article>
                        <article title="" class="message">
                            <div></div>
                            <p>WARKA
                            Barka</p>
                        </article>
                    </section>
                    <section id="prompt">
                        <form action="index.html?action=send">
                            <input type="text" name="search_field">
                            <button type="submit">></button>
                        </form>
                    </section>
                </section>
                <aside class="messenger" id="information">
                    <button>
                        <
                    </button>
                    <section>
                        <header>
                            <h2>
                                Nazwa grupy
                            </h2>
                        </header>
                        <section>
                            <header>
                                <h3>
                                    Akcesoria
                                </h3>
                            </header>
                            <ul>
                                <li>
                                    <button>Uprawnienia</button>
                                </li>
                                <li>
                                    <button>Urzytkownicy</button>
                                </li>
                            </ul>
                        </section>
                        <section>
                            <header>
                                <h3>
                                    Kanały
                                </h3>
                            </header>
                            <nav>
                                <ul>
                                    <li>
                                        <button>Witaj</button>
                                    </li>
                                    <li>
                                        <button>Ogólny</button>
                                    </li>
                                    <li>
                                        <button>Drony</button>
                                    </li>
                                    <li>
                                        <button>Wrony</button>
                                    </li>
                                </ul>
                            </nav>
                        </section>
                    <section>
                </aside>
                <script>
                </script>
                END;
                break;
            case "library":
                $content = <<<END
                    <aside id="libraries">
                        <nav>
                            <div></div>
                            <button>Fantastyka</button><br/>
                            <div></div>
                            <button>Kryminały</button><br/>
                            <div></div>
                            <button>Od Dzika</button><br/>
                            <div></div>
                            <button>Marcina</button><br/>
                            <div></div>
                            <button>Lektury</button><br/>
                            <div></div>
                            <button>
                                +
                            </button>
                        </nav>
                        <button>
                            <
                        </button>
                    </aside>
                    <section id="books">
                        <header>
                            <h2>Nazwa</h2>
                            <section>
                                <button>U</button>
                                <button>+</button>
                            </section>
                        </header>
                        <section>
                            <table>
                                <tr>
                                    <th>Tytuł</th>
                                    <th>Autor</th>
                                    <th>
                                        Opcje
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>Jakś tytuł</td>
                                            </tr>
                                            <tr>
                                                <td>Jakiś tytuł</td>
                                            </tr>
                                            <tr>
                                                <td>Jakiś tytuł</td>
                                            </tr>
                                            <tr>
                                                <td>Jakiś tytuł</td>
                                            </tr>
                                            <tr>
                                                <td>Jakiś tytuł</td>
                                            </tr>
                                            <tr>
                                                <td>Jakiś tytuł</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>Imię i Nazwisko</td>
                                            </tr>
                                            <tr>
                                                <td>Imię i Nazwisko</td>
                                            </tr>
                                            <tr>
                                                <td>Imię i Nazwisko</td>
                                            </tr>
                                            <tr>
                                                <td>Imię i Nazwisko</td>
                                            </tr>
                                            <tr>
                                                <td>Imię i Nazwisko</td>
                                            </tr>
                                            <tr>
                                                <td>Imię i Nazwisko</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td><button>R</button></td>
                                                <td><button>S</button></td>
                                                <td><button>-</button></td>
                                            </tr>
                                            <tr>
                                                <td><button>R</button></td>
                                                <td><button>S</button></td>
                                                <td><button>-</button></td>
                                            </tr>
                                            <tr>
                                                <td><button>R</button></td>
                                                <td><button>S</button></td>
                                                <td><button>-</button></td>
                                            </tr>
                                            <tr>
                                                <td><button>R</button></td>
                                                <td><button>S</button></td>
                                                <td><button>-</button></td>
                                            </tr>
                                            <tr>
                                                <td><button>R</button></td>
                                                <td><button>S</button></td>
                                                <td><button>-</button></td>
                                            </tr>
                                            <tr>
                                                <td><button>R</button></td>
                                                <td><button>S</button></td>
                                                <td><button>-</button></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </section>
                    </section>
                    <section>
                    </section>
                END;
                break;
            case "statistics":
                break;
            case "logs":
                break;
            case "posts_adm":
                break;
            case "users_adm":
                break;
            case "log_out":
                unset($_SESSION['password'], $_SESSION['login']);
                header('Location: ./index.php');
                break;
            case "settings":
                $content = <<<END
                    <section id="form">
                        <h2>Ustawienia</h2>
                        <p>
                            Typ konta: Użytkownik
                        </p>
                        <form method="post" action="./index.php?action=">
                            <fieldset>
                                <legend>Wygląd:</legend>
                                <section>
                                    <label placeholder="?" for="theme">Motyw: </label>
                                    <select name="theme" id="theme">

                                    </select>
                                </section>
                                <section>
                                    <label placeholder="?" for="font">Czcionka: </label>
                                    <select name="font" id="font">

                                    </select>
                                </section>
                                <section>
                                    <label placeholder="?" for="icons">Ikony: </label>
                                    <select name="icons" id="icons">

                                    </select>
                                </section>
                            </fieldset>
                            <fieldset>
                                <legend>Dane osobowe:</legend>
                                <section>
                                    <label for="nick">Nick: </label>
                                    <input type="text" name="nick" id="nick" value="Misiaty303">
                                </section>
                                <section>
                                    <label for="email">Email:</label>
                                    <input type="text" name="email" id="email" value="email@example.com">
                                </section>
                                <section>
                                    <label for="name">Imię:</label>
                                    <input type="text" name="name" id="name" value="Grzegorz">
                                </section>
                                <section>
                                    <label for="name2">Drugie imię:</label>
                                    <input type="text" name="name2" id="name2" value="Waldemar">
                                </section>
                                <section>
                                    <label for="name3">Trzecie imię:</label>
                                    <input type="text" name="name3" id="name3" value="Mirosław">
                                </section>
                                <section>
                                    <label for="surname">Nazwisko:</label>
                                    <input type="text" name="surname" id="surname" value="Brzęczyszczykiewicz">
                                </section>
                                <section>
                                    <label for="tel">Telefon:</label>
                                    <input type="text" name="tel" id="tel" value="+48666777888">
                                </section>
                                <section>
                                    <label for="country">Kraj:</label>
                                    <select name="country" id="country">

                                    </select>
                                </section>
                                <section>
                                    <label placeholder="?" for="sex">Płeć: </label>
                                    <select name="sex" id="sex">

                                    </select>
                                </section>
                                <section>
                                    <label for="password">Hasło:</label>
                                    <input type="password" name="password" id="password" vale="">
                                </section>
                                <section>
                                    <label for="password2">Powtórz hasło:</label>
                                    <input type="password" name="password2" id="password2" value="">
                                </section>
                                <section id="textarea">
                                    <label for="interesting">Zainteresowania:</label><br>
                                    <textarea rows="5" name="interesting" id="interesting" placeholder="Lubię misie"></textarea>
                                </section>
                            </fieldset>

                            <input type="submit" value="Zapisz"/>
                            <input type="button" value="Usuń konto"/>
                        </form>
                    </section>
                END;
                break;
            case "profile":
                $content = <<<END
                    <header id="users_card">
                        <h2>Imię Nazwisko</h2>
                        <p>liczba znajomych: 255</p>
                    </header>
                    <section id="users_posts">
                        <button>+</button>
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