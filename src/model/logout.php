<?php 
/** logout
 *  -------
 *  @file
 *  @brief This file contains only one function that allows you to disconnect from the website 
 */


    /**
     * @brief This function removes session variables to disconnect the user . 
     */
    function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['id']);
        unset($_SESSION['role']);
        session_destroy();
    }

?>
