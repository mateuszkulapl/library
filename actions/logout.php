<?php

session_unset();
session_destroy();
addAlert("Wylogowano","success");
redirectToLoginPage("Wylogowano!", "ok");
exit();
