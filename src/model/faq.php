<?php
/** Faq
 *  ---
 *  @file
 *  @brief Various functions to communicate with the faq
 *  and faq_comments table of the database. Essentially
 *  CRUD functions
 */

    /**
     * @brief This function get the id of a faq category from its name
     * @param nameCat The name of the faq category
     * @return id The id of the category specified by its name
     */
    function getIdCategory($nameCat) {
        try {
            $bdd = dbConnect();
            $stmt = $bdd->prepare("SELECT id FROM faq_category WHERE category=:nameCat");
            $stmt->execute(array(
                'nameCat' => $nameCat
            ));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        } catch (PDOException $e) {
            echo  "<br>" . $e->getMessage();
        }
    }


    /**
     * @brief This function get all the couples questions/answers belonging to a given faq category
     * @param category The faq category we want the q/a from
     * @return qa All the elements in the faq table corresponding the the specified category
     */
    function getQA($category) {
        try {
            $bdd = dbConnect();
            $id_category = getIdCategory($category);
            $stmt = $bdd->prepare(
                "SELECT faq.id, faq.question, faq.answer, faq_category.category
                FROM faq
                INNER JOIN faq_category ON faq.id_category = faq_category.id
                WHERE faq.id_category=:id_category"
            );
            $stmt->execute(array(
                'id_category' => $id_category
            ));
            return $stmt;
        } catch (PDOException $e) {
            echo  "<br>" . $e->getMessage();
        }
    }


    /**
     * @brief Modify the informations of a question/answer element from its id (given by a POST request)
     * For administrators only
     * @param id The id of the element from the faq table
     */
    function editQA($id) {
        if ($_SESSION['role'] == 'admin') {
            if (isset ($_POST ['submit'])) {
                $bdd = dbConnect();
                $question = trim(strip_tags($_POST['question']));
                $answer = trim(strip_tags($_POST['answer'], '<a>'));
                $category = trim(strip_tags($_POST['category']));
                $id_category = getIdCategory($category);
                if (!empty($_POST['question']) AND !empty($_POST['answer'])) {
                    try {
                        $bdd = dbConnect();
                        $stmt = $bdd->prepare("UPDATE faq SET id_category=:id_category, question=:question, answer=:answer WHERE id=:id");
                        $stmt->execute(array(
                            'id_category' =>$id_category,
                            'question' => $question,
                            'answer' => $answer,
                            'id' => $id
                        ));
                    } catch (PDOException $e) {
                        echo  "<br>" . $e->getMessage();
                    }
                }
            } 
        }
    }


    /**
     * @brief Add a new question/answer element to the faq table
     * The q/a is get from a POST request
     * For administrators only
     */
    function addQA() {
        if ($_SESSION['role'] == 'admin') {
            try {
                $bdd = dbConnect();
                $question = trim(strip_tags($_POST['question']));
                $answer = trim(strip_tags($_POST['answer'], '<a>'));
                $category = trim(strip_tags($_POST['category']));
                $id_category = getIdCategory($category);
                $stmt = $bdd->prepare("INSERT INTO faq(id_category, question , answer) VALUES(:id_category, :question, :answer)");
                $stmt->execute(array(
                    'id_category' => $id_category,
                    'question' => $question,
                    'answer' => $answer
                ));
            } catch (PDOException $e) {
                echo  "<br>" . $e->getMessage();
            }
        }
    }


    /**
     * @brief Delete a question/answer element from the faq table from its id
     * For administrators only
     * @param id The id of the question/answer element we want to delete
     */
    function delQA($id) {
        if ($_SESSION['role'] == 'admin') {
            try {
                $bdd = dbConnect();
                $stmt = $bdd->prepare("DELETE FROM faq WHERE id=:id");
                $stmt->execute(array(
                    'id' => $id
                ));
            } catch (PDOException $e) {
                echo  "<br>" . $e->getMessage();
            }
        }
    }


    /**
     * @brief Get all question/answer elements from the faq table that match the given keyword
     * @param keywords The keywords that will be searched in the database
     * @return qa All the question/answer elements that match the request
     */
    function searchQA($keywords) {
        try {
            $bdd = dbConnect();
            $stmt = $bdd->prepare(
                "SELECT faq.id, faq.question, faq.answer, faq_category.category
                FROM faq
                INNER JOIN faq_category ON faq.id_category = faq_category.id
                WHERE question like '%$keywords%'"
            );
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo  "<br>" . $e->getMessage();
        }
    }


    /**
     * @brief Add a new faq category to the database
     * The category is get by a POST request
     * For administrators only
     */
    function addCategory() {
        if ($_SESSION['role'] == 'admin') {       
            try {
                $bdd = dbConnect();
                $category = trim(strip_tags($_POST['category']));
                $stmt = $bdd->prepare("INSERT INTO faq_category(category) VALUES(:category)");
                $stmt->execute(array(
                    'category' => $category
                ));
            } catch (PDOException $e) {
                echo  "<br>" . $e->getMessage();
            }
        }
    }


    /**
     * @brief Delete a faq category (and all the question/answer elements it contains by using sql cascades)
     * The category is get by POST request
     * For administrators only
     */
    function delCategory() {
        if ($_SESSION['role'] == 'admin') {  
            try {
                $bdd = dbConnect();
                $stmt = $bdd->prepare("DELETE FROM faq_category WHERE category=:category");
                $stmt->execute(array(
                    'category' => $_POST['category']
                ));
            } catch (PDOException $e) {
                echo  "<br>" . $e->getMessage();
            }
        }
    }


    /**
     * @brief Get all the faq catagories that exist in the database
     * @return categories All the categories found in the database
     */
    function getCategories() {
        try {
            $bdd = dbConnect();
            $stmt = $bdd->prepare("SELECT * FROM faq_category");
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo  "<br>" . $e->getMessage();
        }
    }

?>