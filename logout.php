<?php
require_once 'includes/session.php';
require_once 'includes/functions.php';
set_base_depth(0);
session_destroy();
redirect('login.php');