<?php

session_unset();
session_destroy();

redirectToLoginPage("Wylogowano!", "ok");
exit();
