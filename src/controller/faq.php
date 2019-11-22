<?php

require_once "model/faq.php";

// Add a new question/answer
if (isset($_POST['addQA'])) {
    addQA();
}
// Add a new category
if (isset($_POST['addCategory'])) {
    addCategory();
}
// Delete a category
if (isset($_POST['delCategory'])) {
    delCategory();
}
// Search in the FAQ
if (isset($_POST['search_faq'])) {
    $keywords = $_POST['search'];
    $search = searchQA($keywords);
}

// Edit question/answer
if (isset($_SESSION['qaToEdit'])) {
    if ($_SESSION['role'] == 'admin') {
        editQA($_SESSION['qaToEdit']);
        unset($_SESSION['qaToEdit']);
    } else {
        include_once "view/errors/noRights.php";
    }
}

// Delete question/answer
if (isset($_SESSION['qaToDelete'])) {
    if ($_SESSION['role'] == 'admin') {
        delQA($_SESSION['qaToDelete']);
        unset($_SESSION['qaToDelete']);
    } else {
        include_once "view/errors/noRights.php";
    }
}


if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin')) {
    include_once "view/modHeader.php";
} elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'user') {
    include_once "view/memberHeader.php";
} else {
    include_once "view/header.php";
}

include_once "view/faq.php";
