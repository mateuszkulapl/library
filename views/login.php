<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Zaloguj", "zaloguj się na konto"); ?>
<?php 
?>
<body>
    <?php showHeader("Zaloguj się", "Zaloguj się na swoje konto, aby uzyskać dostęp do aplikacji</br>lub utwórz nowe konto"); ?>
    <?php
    if ($message)
        showMessage($message, $messageType);
    //showButtons('login');
    ?>
    <div class="two-column">
        <div class="center">
            <h2 data-tippy-content="aaaaa">Zaloguj się</h2>
            <form action="index.php?action=login" method="post">
                <label>login:<br><input type="text" name="login" id="login" required></label><br>
                <label>password:<br><input type="password" name="password" id="password" required></label><br>
                <input type="submit" value="Zaloguj się">
            </form>
        </div>
        <div class="center">
            <h2>Utwórz konto</h2>
            <p>Uzyskaj dostęp do najciekawszych książek</h2>
            <form action="index.php?action=register-step2" method="POST" onsubmit="return validate();">
                <label>Login<br>
                    <input type="text" minlength="3" maxlength="30" name="registerName" id="registerName" required autocomplete="off">
                </label></br>
                <input type="hidden" name="action" value="add">
                </br>
                <!-- <div class="errorDiv"> </div> -->
                <input type="submit" id="register-button" disabled="disabled" value="Zarejestruj się">
                <script>
                    const tippyregisterName = tippy(document.querySelector('#registerName'));
                    tippyregisterName.setContent('Wpisz nazwę użytkownika, którą będziesz logował się do aplikacji');
                    tippyregisterName.setProps({
                        placement: 'right'
                            });
                            var validRegisterName=false;
                    function validate() {
                        
                        var errorDiv = document.querySelector(".errorDiv"),
                            regex = /^[a-z0-9]+$/,
                            str = document.getElementById("registerName").value;
                            str=str=str.toLowerCase();
                            document.getElementById("registerName").value=str;
                            str = document.getElementById("registerName").value;
                        if ((str.length >= 3) && (str.length <= 30) && regex.test(str)) {
                            //errorDiv.innerHTML = "Prawidłowa nazwa użytkownika";
                            tippyregisterName.setContent('Login spełnia wymagania');
                            
                            tippyregisterName.setProps({
                                theme: 'success'
                            });
                            tippyregisterName.show();
                            document.querySelector('#register-button').disabled = false;
                            if(validRegisterName==false)
                            $("#register-button").effect( "bounce", {times:3}, 300 );
                            validRegisterName=true;
                            return true;
                        } else {
                            validRegisterName=false;
                            document.querySelector('#register-button').disabled = true;
                            //errorDiv.innerHTML = "Nazwa użytkownika powinna mieć od 3 do 30 znaków alfanumerycznych";
                            tippyregisterName.setContent('Nazwa użytkownika powinna mieć od 3 do 30 znaków alfanumerycznych. Tylko małe litery.');
                            tippyregisterName.setProps({
                                theme: 'error'
                            });
                            tippyregisterName.show();
                            return false;
                        }
                    }
                    
                    $("#registerName").on('change keydown paste input', function() {
                        validate();
                    });
                </script>
            </form>
        </div>
    </div>

</body>

</html>