<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Dokończ rejestrację", "Dokończ rejestrację"); ?>

<body id="register-step2">
    <?php
    ?>
    <div class="center">
        <h1>Jeszcze tylko jeden krok<br>
            aby zakończyć rejestrację jako <?php echo $registerName; ?></h1>


        <form id="form-register-step2" action="index.php?action=register-step3" method="POST" onsubmit="return validate();">
            <input type="hidden" name="registerName" value=<?php echo $registerName; ?>>
            <label>Hasło<br>
                <input type="password" minlength="5" data-isvalid="false" maxlength="30" name="password" id="password" required autocomplete="off">
            </label></br>
            <label>Email<br>
                <input type="email" minlength="3" data-isvalid="false" maxlength="100" name="email" id="email" required>
            </label></br>
            <label>Telefon<br>
                <input type="phone" data-isvalid="false" name="phone" id="phone" required>
            </label></br>
            <label>Data urodzenia<br>
                <input type="date" name="data_urodzenia" data-isvalid="false" id="data_urodzenia" required autocomplete="off">
            </label></br>

            <input type="hidden" name="action" value="add">
            </br>
            <!-- <div class="errorDiv"> </div> -->
            <input type="submit" id="register-button" disabled="disabled" title="wypełnij wszystkie pola" value="Zarejestruj się">
            <script>
                //haslo
                const tippyHaslo = tippy(document.querySelector('#password'));
                tippyHaslo.setContent('Wpisz hasło składające się z minimum 5 znakow');
                tippyHaslo.setProps({
                    placement: 'right'
                });
                document.validHaslo = false;

                function validateHaslo(tippyElement) {
                    regex = /^[a-z0-9]+$/,
                        str = document.getElementById("password").value;
                    if ((str.length >= 5) && (str.length <= 30) && (regex.test(str) || 1 == 1)) {
                        tippyElement.setContent('Hasło spełnia wymagania');
                        tippyElement.setProps({
                            theme: 'success'
                        });
                        tippyElement.show();
                        document.validHaslo = true;
                        document.getElementById("password").dataset.isvalid = true;
                        validAll();
                        return true;
                    } else {
                        document.validHaslo = false;
                        validAll();
                        document.getElementById("password").dataset.isvalid = false;
                        tippyElement.setContent('Hasło musi mieć od 5 do 30 znaków');
                        tippyElement.setProps({
                            theme: 'error'
                        });
                        tippyElement.show();
                        return false;
                    }
                }
                $("#password").on('change keydown paste input', function() {
                    validateHaslo(tippyHaslo);
                });
                //email
                const tippyEmail = tippy(document.querySelector('#email'));
                tippyEmail.setContent('Email do kontaktu');
                tippyEmail.setProps({
                    placement: 'right'
                });
                document.validEmail = false;

                function validateEmail(tippyElement) {
                    console.log("start validateEmail");
                    regex = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/,
                        str = document.getElementById("email").value;
                    var bezBleduDwochMalp = true;
                    var bezBleduSpacji = true;
                    if (str.includes('@')) {
                        indexOfFirst = str.indexOf("@");
                        fromFirst = (str.substr(indexOfFirst + 1));
                        if (fromFirst.includes('@') == true) {
                            bezBleduDwochMalp = false;
                        }
                    }
                    if (str.includes(' ')) {
                        bezBleduSpacji = false;
                    }
                    if ((str.length >= 3) && (str.length <= 100) && bezBleduDwochMalp && bezBleduSpacji && (regex.test(str))) {
                        tippyElement.setContent('Poprawny email');
                        tippyElement.setProps({
                            theme: 'success'
                        });
                        tippyElement.show();
                        document.validEmail = true;
                        document.getElementById("email").dataset.isvalid = true;
                        validAll();
                        return true;
                    } else {
                        document.validEmail = false;
                        document.getElementById("email").dataset.isvalid = false;
                        validAll(false);
                        var errorText = "Podany adres nie jest poprawny";

                        if (bezBleduSpacji == false) {
                            errorText = "Email nie może zawierać spacji";
                        }
                        if (str.includes('@') == false) {
                            errorText = "Adres nie zawiera @";
                        } else {
                            if (str.includes('@')) {
                                indexOfFirst = str.indexOf("@");
                                fromFirst = (str.substr(indexOfFirst + 1));
                                if (fromFirst.includes('@') == true) {
                                    errorText = "Adres musi zawierać 1x @";
                                } else {
                                    var mailUser = str.split('@');
                                    if (!(mailUser[0].length > 0)) {
                                        errorText = "W adresie nie ma nazwy użytkownika";
                                    }
                                    if (mailUser[1].includes('..') == true) {
                                        errorText = "Nazwa domeny nie może zawierać następujących po sobie kropek";
                                    } else {
                                        if (mailUser[1].length > 0) {
                                            if (mailUser[1].includes('.') == false) {
                                                errorText = "Nazwa domeny nie zawiera kropki";
                                            } else {
                                                var mailUserDomain = mailUser[1].split('.');
                                                if (!(mailUserDomain[1].length > 0)) {
                                                    errorText = "Nieprawidłowe rozszerzenie domeny";
                                                }
                                                if (!(mailUserDomain[0].length > 0)) {
                                                    errorText = "Nieprawidłowa domena";
                                                }
                                            }
                                        } else {
                                            errorText = "Wpisz domenę";
                                        }
                                    }
                                }
                            }

                        }
                        tippyElement.setContent(errorText);
                        tippyElement.setProps({
                            theme: 'error'
                        });
                        tippyElement.show();
                        return false;
                    }
                }
                $("#email").on('change keydown paste input', function() {
                    validateEmail(tippyEmail);
                });



                ////telefon
                const tippyTelefon = tippy(document.querySelector('#phone'));
                tippyTelefon.setContent('Wpisz telefon komórkowy w formacie 000000000');
                tippyTelefon.setProps({
                    placement: 'right',
                    allowHTML: true
                });
                document.validTelefon = false;
                document.getElementById("phone").dataset.isvalid = false;

                function validateTelefon(tippyElement) {
                    prefixError = "";
                    str = document.getElementById("phone").value;
                    if (str.includes("+48")) {
                        prefixError = "<br>Prefiks Polski został automatycznie usunięty";
                    }
                    str = str.replace("+48", '');
                    str = str.replace(/[^0-9\+]/g, '');
                    document.getElementById("phone").value = str;
                    str = document.getElementById("phone").value;
                    regex = /^\d{9}$/,
                        str = document.getElementById("phone").value;
                    if (regex.test(str)) {
                        tippyElement.setContent('Numer spełnia wymagania' + prefixError);
                        tippyElement.setProps({
                            theme: 'success'
                        });
                        tippyElement.show();
                        document.validTelefon = true;
                        document.getElementById("phone").dataset.isvalid = true;
                        validAll();
                        return true;
                    } else {
                        document.validTelefon = false;
                        document.getElementById("phone").dataset.isvalid = false;
                        validAll(false);
                        tippyElement.setContent('Podaj numer w formacie 000000000' + prefixError);
                        tippyElement.setProps({
                            theme: 'error'
                        });
                        tippyElement.show();
                        return false;
                    }
                }
                $("#phone").on('change keydown paste input', function() {
                    validateTelefon(tippyTelefon);
                });



                //data urodzenia
                data_urodzenia.max = new Date().toISOString().split("T")[0];
                data_urodzenia.min = "1910-02-26"
                const tippyData = tippy(document.querySelector('#data_urodzenia'));
                tippyData.setContent('Wybierz date urodzenia');
                tippyData.setProps({
                    placement: 'right',
                    allowHTML: true
                });
                document.validData = false;
                document.getElementById("data_urodzenia").dataset.isvalid = false;

                function validateDate(tippyElement) {
                    const maxDate = new Date();
                    const minDate = new Date("1910-02-26");
                    str = document.getElementById("data_urodzenia").value;
                    var strDate = new Date(str);
                    errorText = null;
                    if (strDate > maxDate) {
                        errorText = "data nie może być późniejsza niż dzisiaj";
                    }
                    if (strDate < minDate) {
                        errorText = "data nie może być wcześiejsza niż 26.02.1910";
                    }

                    if (!(strDate >= minDate && strDate <= maxDate)) {
                        errorText = "Wybierz datę z zakresu od 26.02.1910 do dzisiaj";
                    }

                    if (errorText != null) {
                        tippyElement.setContent(errorText);
                        tippyElement.setProps({
                            theme: 'error'
                        });
                        tippyElement.show();
                        document.validData = false;

                        document.getElementById("data_urodzenia").dataset.isvalid = false;
                        validAll(false);
                        return true;
                    } else {
                        tippyElement.setContent("Prawidłowa data");
                        tippyElement.setProps({
                            theme: 'success'
                        });
                        tippyElement.show();
                        document.validData = true;

                        document.getElementById("data_urodzenia").dataset.isvalid = true;
                        validAll();
                        return true;
                    }

                }
                $("#data_urodzenia").on('change keydown paste input', function() {
                    validateDate(tippyData);
                });
                //przycisk
                const tippyRegisterButton = tippy(document.querySelector('#register-button'));
                tippyRegisterButton.setProps({
                    placement: 'right'
                });

                tippyRegisterButton.setContent('Kliknij, aby się zarejestrować');

                function validAll(canBeTrue) {
                    if (canBeTrue == false) {
                        document.querySelector('#register-button').disabled = true;
                    } else {
                        if (document.validHaslo && document.validEmail && document.validTelefon && document.validData) {
                            document.querySelector('#register-button').disabled = false;
                            tippyRegisterButton.setContent('Kliknij, aby się zarejestrować');
                            tippyRegisterButton.setProps({
                                theme: 'success'
                            });
                            document.querySelector('#register-button').title = "";
                        } else {
                            document.querySelector('#register-button').disabled = true;
                            tippyRegisterButton.setContent('Nie wszystkie pola zostały poprawnie uzupełnione');
                            tippyRegisterButton.setProps({
                                theme: 'error',
                                placement: 'right'
                            });
                            tippyRegisterButton.show();
                            document.querySelector('#register-button').title = "Wypełnij wszystkie pola";
                        }
                    }
                }
                validAll();
            </script>
        </form>
        <a style="margin-top:20px;display:block;color: #fff;text-decoration: none;" href="?action=login">Anuluj rejestrację</a>
    </div>

    </div>

</body>

</html>