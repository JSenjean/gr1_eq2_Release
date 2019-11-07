<?php 

    /**
     * Destroy the session and unset the associated variables
     */
    function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['id']);
        unset($_SESSION['role']);
        session_destroy();
    }

?>
