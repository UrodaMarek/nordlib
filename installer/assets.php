<?php
    require_once("./functions.php");
    function wizard($param) : void {
        $country_options = "";
        $sex_options = "";

        if ($param[0][0] === "start") {
            install($param[1], $param[2], $param[3]);
        }

        if ($param === FALSE) {

            $countries = ["Polska", "Ukraina", "USA"];
            $sexs = ["mężczyzna", "kobieta"];
            $i = 1;
            $j = 1;

            foreach ($countries as $country) {
                $country_options .= <<<END
                    <option value="$i">$country</option>
                END;
                $i++;
            }

            foreach ($sexs as $sex) {
                $sex_options .= <<<END
                    <option value="$j">$sex</option>
                END;
                $j++;
            }

            $country_options .= <<<END
                <option value="" selected>?</option>
            END;

            $sex_options .= <<<END
                <option value="" selected>?</option>
            END;


            $form = <<< END
            <section id="form">
                <form method="post" action="./index.php?installation=start">
                    <section>
                        <label for="db_login">Login bazodanowy:</label>
                        <input type="text" name="db_login" placeholder="root" id="db_login">
                    </section>
                    <section>
                        <label for="db_password">Hasło bazodanowe:</label>
                        <input type="password" name="db_password" placeholder="****" id="db_password">
                    </section>
                    <section>
                        <label for="host">Host bazodanowy:</label>
                        <input type="text" name="host" placeholder="localhost" id="host">
                    </section>
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
                            Zgadzam się na <a href="../LICENSE" target="_blank">postanowienia licencyjne</a> oraz mam na uwadze że jako administrator ponoszę pełną odpowiedzialność za utratę danych, ich zniszczenie, itp.
                        </label>
                    </section>
                    <input type="submit" value="Rozpocznij instalacje"/>
                </form>
            </section>
            END;
            echo $form ;
        }
    }