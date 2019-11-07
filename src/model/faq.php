<?php

    /**
     * Return the id of the category specified by its name
     */
    function getIdCategory($nameCat){
        try{
            $bdd = dbConnect();
            $stmt = $bdd->prepare("SELECT id FROM faq_category WHERE category=:nameCat");
            $stmt->execute(array(
                'nameCat' => $nameCat
            ));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        }
        catch(PDOException $e){
            echo  "<br>" . $e->getMessage();
        }
    }


    /**
     * Return all the FAQ from the database belonging to a specified category
     */
    function getQA($category){
        try{
            $bdd = dbConnect();
            $id_category = getIdCategory ($category);
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
        }
        catch(PDOException $e){
            echo  "<br>" . $e->getMessage();
        }
    }


    /**
     * Modify the informations of a FAQ specified by its id from a POST request
     * For administrators only
     */
    function editQA($id){
        if ($_SESSION['role'] == 'admin'){
            if (isset ($_POST ['submit'])) {
                $bdd = dbConnect();
                $question = trim(strip_tags($_POST['question']));
                $answer = trim(strip_tags($_POST['answer'], '<a>'));
                $category = trim(strip_tags($_POST['category']));
                $id_category = getIdCategory($category);
                if(!empty($_POST['question']) AND !empty($_POST['answer'])) {
                    try{
                        $bdd = dbConnect();
                        $stmt = $bdd->prepare("UPDATE faq SET id_category=:id_category, question=:question, answer=:answer WHERE id=:id");
                        $stmt->execute(array(
                            'id_category' =>$id_category,
                            'question' => $question,
                            'answer' => $answer,
                            'id' => $id
                        ));
                    }
                    catch(PDOException $e){
                        echo  "<br>" . $e->getMessage();
                    }
                }
            } 
        }
    }


    /**
     * Add a new FAQ to the database from a POST request
     * For administrator only
     */
    function addQA(){
        if ($_SESSION['role'] == 'admin'){
            try{
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
            }
            catch(PDOException $e){
                echo  "<br>" . $e->getMessage();
            }
        }
    }


    /**
     * Delete a FAQ from the database by specifying its id
     * For administrators only
     */
    function delQA($id){
        if ($_SESSION['role'] == 'admin'){
            try{
                $bdd = dbConnect();
                $stmt = $bdd->prepare("DELETE FROM faq WHERE id=:id");
                $stmt->execute(array(
                    'id' => $id
                ));
            }
            catch(PDOException $e){
                echo  "<br>" . $e->getMessage();
            }
        }
    }


    /**
     * Search in the database all the FAQ corresponding to specified keywords and return them
     */
    function searchQA($keywords){
        try{
            $bdd = dbConnect();
            $stmt = $bdd->prepare(
                "SELECT faq.id, faq.question, faq.answer, faq_category.category
                FROM faq
                INNER JOIN faq_category ON faq.id_category = faq_category.id
                WHERE question like '%$keywords%'"
            );
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e){
            echo  "<br>" . $e->getMessage();
        }
    }


    /**
     * Add a new category of FAQ to the database
     * For administrators only
     */
    function addCategory(){
        if ($_SESSION['role'] == 'admin'){       
            try{
                $bdd = dbConnect();
                $category = trim(strip_tags($_POST['category']));
                $stmt = $bdd->prepare("INSERT INTO faq_category(category) VALUES(:category)");
                $stmt->execute(array(
                    'category' => $category
                ));
            }
            catch(PDOException $e){
                echo  "<br>" . $e->getMessage();
            }
        }
    }


    /**
     * Delete a category of FAQ from the database and all the FAQ it contains
     * For administrators only
     */
    function delCategory(){
        if ($_SESSION['role'] == 'admin'){  
            try{
                $bdd = dbConnect();
                $stmt = $bdd->prepare("DELETE FROM faq_category WHERE category=:category");
                $stmt->execute(array(
                    'category' => $_POST['category']
                ));
            }
            catch(PDOException $e){
                echo  "<br>" . $e->getMessage();
            }
        }
    }


    /**
     * Return all the categories of FAQ stored in the database
     */
    function getCategories(){
        try{
            $bdd = dbConnect();
            $stmt = $bdd->prepare("SELECT * FROM faq_category");
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e){
            echo  "<br>" . $e->getMessage();
        }
    }

?>