<?php
if (isset($_GET['pages'])) $pages = $_GET['pages'];
else $pages = "home";

if ($pages == "home") include("./pages/home.php");
elseif ($pages == "tentang") include("./pages/tentang.php");
elseif ($pages == "login") include("./pages/login.php");

//---------------------USER---------------------
elseif ($pages == "informasi") include("./pages/user/informasi.php");
elseif ($pages == "profil") include("./pages/user/profil/profil.php");
elseif ($pages == "profil_edit") include("./pages/user/profil/profil_edit.php");
elseif ($pages == "profil_editpro") include("./pages/user/profil/profil_editpro.php");
