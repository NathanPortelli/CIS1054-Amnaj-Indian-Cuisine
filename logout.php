<?php

session_start();
session_unset();
session_destroy();//destroys all session information and ends the session
header("Location: index.php");//redirects the user back to the home page