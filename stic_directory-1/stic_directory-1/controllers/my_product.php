<?php

function my_product_show_controller(){

    if (!array_key_exists('form', set()) || empty($resultatsql)) {
        set('form', params('produit'));
    }
    //my_product_action_filtre_controller();
    return render('my_product.html.php');
}



function my_product_action_filtre_controller(){
    $errors = array();
    $form = array();
    /*-------------------------------------------------------------------------------------
    ================================ RECEPTION DES DONNEES ================================
    ________________________________________________________________________________________*/
    
    $produit = params('produit');
    $user = params('user');

    $form = $_POST['filtre'];

    if($form["choix"]=="coucou" && $form["genre"]=="coucou"){
        $errors[] = "vous n'avez pas choisit de filtre";
    }
    
    if($errors){
        set('form', $form);
        set('errors', $errors);
        return my_product_show_controller();
    }
    //var_dump("form[choix] = ".$form['choix']);
    //var_dump("form[genre] = ".$form['genre']);
    // Nettoyage des données reçues
    foreach ($form as $key => $value)
    {
        $value      = trim($value);
        //var_dump($value);
        $value      = strip_tags($value);
        //var_dump($value);
        $form[$key] = '' != $value ? $value : null;
        //var_dump($form);
    }
    

    /*-------------------------------------------------------------------------------------
    ================================ TRAITEMENT DES FILTRES ===============================
    ________________________________________________________________________________________*/

    if(!empty($form)){  
        echo "palier1";
        if($form["choix"] == "prix" || $form["choix"] == "date"){
            echo "palier2";
            if($form["choix"] == "prix" && $form["genre"] == "coucou"){
                echo "si prix plein et genre vide => filtre prix plus petit au plus grand";
                $sql = 'SELECT `idProduit`, `genreProduit`, `nomProduit`, `descriptionProduit`, `photoProduit`, `prixDDProduit`, `prixDVProduit`, `dateDMELProduit`, `dateDVProduit`,`user_idUser` FROM produit, user WHERE user_idUser = idUser AND idUser = :id_user ORDER BY `prixDVProduit` ASC';
                $query = option('db') -> prepare($sql);
                $query -> bindValue(':id_user', $user['idUser']);
            }
            else if($form["choix"] == "date" && $form["genre"] =="coucou"){
                echo "si date plein et genre vide => filtre date de vente la plus proche";
                $sql = 'SELECT `idProduit`, `genreProduit`, `nomProduit`, `descriptionProduit`, `photoProduit`, `prixDDProduit`, `prixDVProduit`, `dateDMELProduit`, `dateDVProduit`,`user_idUser` FROM produit, user WHERE user_idUser = idUser AND idUser = :id_user ORDER BY `dateDVProduit` DESC';
                $query = option('db') -> prepare($sql);
                $query -> bindValue(':id_user',$_SESSION['user_id']);
            }
            else if($form["choix"] == "prix" && isset($form["genre"])){
                echo"si prix plein et genre plein => filtre le genre choisit par prix";
                $sql = 'SELECT `idProduit`, `genreProduit`, `nomProduit`, `descriptionProduit`, `photoProduit`, `prixDDProduit`, `prixDVProduit`, `dateDMELProduit`, `dateDVProduit`,`user_idUser` FROM produit, user WHERE user_idUser = idUser AND idUser = :id_user AND genreProduit = :genre ORDER BY prixDVProduit ASC';

                $query = option('db') -> prepare($sql);
                $query -> bindValue(':id_user',$_SESSION['user_id']);
                $query -> bindValue(':genre',(int)$form['genre']);
            }
            
            else if($form["choix"] == "date" && isset($form["genre"])){
                echo "si date plein et genre plein => filtre le genre choisit par date";
                $sql ='SELECT `idProduit`, `genreProduit`, `nomProduit`, `descriptionProduit`, `photoProduit`, `prixDDProduit`, `prixDVProduit`, `dateDMELProduit`, `dateDVProduit`,`user_idUser` FROM produit, user WHERE user_idUser = idUser AND idUser = :id_user AND genreProduit = :genre ORDER BY `dateDVProduit` DESC';

                $query = option('db') -> prepare($sql);
                $query -> bindValue(':id_user',$_SESSION['user_id']);
                $query -> bindValue(':genre',(int)$form['genre']);
            }
            
        }
        else if($form['choix'] == "coucou" && isset($form['genre'])){
            echo "si date et prix vide et genre plein => filtre le genre choisit par date";
            $sql ='SELECT `idProduit`, `genreProduit`, `nomProduit`, `descriptionProduit`, `photoProduit`, `prixDDProduit`, `prixDVProduit`, `dateDMELProduit`, `dateDVProduit`,`user_idUser` FROM produit, user WHERE user_idUser = idUser AND idUser = :id_user AND genreProduit = :genre ORDER BY `dateDVProduit` DESC';

            $query = option('db') -> prepare($sql);
            $query -> bindValue(':id_user',$_SESSION['user_id']);
            $query -> bindValue(':genre',(int)$form['genre']);
        }       
    }
    //var_dump($query);
    $query -> execute();
    $row = $query -> rowCount();
    $form = $query -> fetch();

    

     params('row',$row);
     set('row',$row);
    
    var_dump($row);
    var_dump($resultatsql);
    redirect_to('my_product');
}





function my_product_action_ajout_controller(){
    
    /*-------------------------------------------------------------------------------------
    ================================ RECEPTION DES DONNEES ================================
    ________________________________________________________________________________________*/
    
    $produit = params('produit');
    $user = params('user');

    $form = $_POST['produit'];
    
    // Nettoyage des données reçues
    foreach ($form as $key => $value)
    {
        $value      = trim($value);
        //var_dump($value);
        $value      = strip_tags($value);
        //var_dump($value);
        $form[$key] = '' != $value ? $value : null;
        //var_dump($form);
    }
    /*-------------------------------------------------------------------------------------
    ================================ DETECTION DES ERREURS ================================
    ________________________________________________________________________________________*/

    $errors = array();

    
    // erreur de pseudo
    if (empty($form['nom_produit']) || $form['nom_produit']==" ") {
        $errors[] = 'name of product is missing';
    }

    // erreur de description
    if (empty($form['description_produit']) || $form['description_produit'] == " " ) {
        $errors[] = 'description of product is missing';
    }

    //erreur de genre
    if (empty($form['genre_produit'])) {
        $errors[] = 'genre of product is missing';
        //var_dump($form['genre_produit']);
    }

    //erreur de prix
    $resultat = str_split($form['prixDD_produit'], 1);
    $form['prixDD_produit'] ="";
    foreach ($resultat as $value) {
        //var_dump($value);
        if($value == "0" || $value == "1" || $value == "2" || $value == "3" || $value == "4" || $value == "5" || $value == "6" || $value == "7" || $value == "8" || $value == "9"){

            $form['prixDD_produit'] = $form['prixDD_produit'].$value;
            (int)$form['prixDD_produit'];//NE MARCHE PAS ????
            //var_dump($form['prixDD_produit']);
        }
    }
    if (empty($form['prixDD_produit']) || $form['prixDD_produit'] == " " ) {
        $errors[] = 'price of product is missing or price of product is not a valid number';
    }


    //erreurs pour la photo

    if ($_FILES['produit']['error']['photo'] <> 4)
    {
        //var_dump($_FILES['produit']['error']['photo']);
        if (false === strpos($_FILES['produit']['type']['photo'], 'image/')) {
            $errors[] = 'Wrong photo type';
        }
        elseif ($_FILES['produit']['error']['photo'] <> 0) {
            $errors[] = 'Upload photo error detected';
        }
        else {
            
            $sql = 'SELECT idProduit, idUser FROM user, produit WHERE produit.user_idUser=user.idUser AND idUser = :id_user';
            $query = option('db')->prepare($sql);
            $query -> bindValue(':id_user',$_SESSION['user_id']);
            $query -> execute();
            $table = $query -> fetch();
            $nbligne = $query -> rowCount();
            if($nbligne >= 0){
            $form['photo'] = $nbligne+1 . '.' . pathinfo($_FILES['produit']['name']['photo'], PATHINFO_EXTENSION);
            }
            /*else if($nbligne == 1 || $nbligne>1){
            $form['photo'] = $nbligne+2 . '.' . pathinfo($_FILES['produit']['name']['photo'], PATHINFO_EXTENSION);  
            }*/
            // SI CHANGEMENT DE PHOTO
            if (array_key_exists('photo', $form))
            {
                // SI NOUVELLE PHOTO

                if ($form['photo']) {
                    

                    if ($nbligne==0){
                        mkdir('public/user/'.$_SESSION['user_id']);
                        $name_img_dest = $nbligne;
                    }
                    
                    move_uploaded_file($_FILES['produit']['tmp_name']['photo'], option('root_dir') . '/public/user/'. $_SESSION['user_id'] .'/'. $form['photo']);
                }
                // SI SUPPRESSION DE PHOTO
                elseif (null == $form['photo']) {
                    unlink(option('root_dir') . '/public/user/' . $user['photo']);
                }
            }
            else {
                $form['photo'] = $produit['photo'];
            }
        }
    }
    
    if ($errors){
        set('form', $form);
        set('errors', $errors);

        return my_product_show_controller();
        redirect_to('my_product');
    }
    
    $sql= 'INSERT INTO produit (genreProduit, nomProduit, descriptionProduit, photoProduit, prixDDProduit, prixDVProduit, dateDMELProduit, dateDVProduit, user_idUser) 
            VALUES (:genre_produit, :nom_produit,:description_produit, :photo_produit, :prix_de_depart, :prix_de_vente, NOW(), :date_de_vente, :id_user)';
                                                
    $m=date("m"+1);
    $dateDVProduit = date("Y-".$m."-d G-i-s");
    $query = option('db')->prepare($sql);
    $query->bindValue(':nom_produit',$form['nom_produit']);
    $query->bindValue(':genre_produit',$form['genre_produit']);
    $query->bindValue(':description_produit',$form['description_produit']);
    $query->bindValue(':photo_produit',$form['photo']);
    $query->bindValue(':prix_de_depart',$form['prixDD_produit']);
    $query->bindValue(':prix_de_vente',NULL);
    $query->bindValue(':date_de_vente',$dateDVProduit);
    $query->bindValue(':id_user',$user['idUser']);
    $query->execute();

    // MESSAGE DE SUCCESS
    flash('success', 'Changes saved');

    //REDIRECTION
    redirect_to('/my_product');
}



function my_product_action_mail_controller(){

    /*-------------------------------------------------------------------------------------
    ================================ RECEPTION DES DONNEES ================================
    ________________________________________________________________________________________*/
    $mail = params('mail');
    $user = params('user');

    $form = $_POST['mail'];
    
    // Nettoyage des données reçues
    foreach ($form as $key => $value)
    {
        $value      = trim($value);
        //var_dump($value);
        $value      = strip_tags($value);
        //var_dump($value);
        $form[$key] = '' != $value ? $value : null;
        //var_dump($form);
    }

    // erreur de saisie de pseudo
    if (empty($form['pseudo_mail'])) {
        $errors[] = 'pseudo is missing';
    }
    else if (!empty($form['pseudo_mail'])) {
        $sql = 'SELECT pseudoUser, mailUser FROM user WHERE pseudoUser = :pseudo_mail';
        $query = option('db') -> prepare($sql);
        $query -> bindValue(':pseudo_mail',$form['pseudo_mail']);
        $query -> execute();
        $resutatsql = $query -> fetch();
        if($query -> rowCount() < 1){
            $errors[] = 'pseudo id missing';
        }
        else if ($query -> rowCount() >1){
            $errors[] = 'trop de pseudo'; 
        }
    }
    

    if(!empty($_POST)){
        if($resutatsql['pseudoUser'] == $form['pseudo_mail']){          
            if(isset($form["objet_mail"])){

                $form["objet_mail"]=htmlspecialchars($form["objet_mail"]);
                $form["message_mail"]=htmlspecialchars($form["message_mail"]);

                if(isset($form['message_mail'])){ $result_message = htmlspecialchars($form['message_mail']); } else{ $form['message_mail'] = "toutes nos excuses le champ message n\'a pas été pourvu par l'uilisateur"; }
                $result_message = stripslashes($result_message);
                    
                //Création du / des déstinataire(s)
                $destinataire = $resutatsql['mailUser'];

                //vérification du serveur mail
                if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $resutatsql['mailUser'])){
                    $passage_ligne = "\r\n";
                }
                else{
                    $passage_ligne = "\n";
                }

                // Création du message au format html
                $message_html="<html><head></head>";
                $message_html.="<body><table><tr><td> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br/>";
                $message_html.="<span class='header'> l'utilisateur' ".$user['pseudoUser']." à cherché à nous joindre par notre messagerie :";
                $message_html.="<br/> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </td></tr>";
                $message_html.="<tr><td>".$result_message."<br/></td></tr>";
                $message_html.="<tr><td> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </td></tr>";
                $message_html.="<tr><td id='recapitulatif'>Contact : ".$user['prenomUser']." ".$user['nomUser']."<br/>";
                $message_html.="Société : ".$user['societyUser']."<br/>";
                $message_html.="@mail : ".$user['mailUser']."</td></tr></table></body></html>";

                // Création de la boundary
                $boundary = "-----=".md5(rand());

                // Création du sujet du mail
                $sujet = "l'utilisateur' ".$form['pseudo_mail']." vous a envoyé un mail";

                // Création du header
                $header = "From: \"site_enchere\"<alainche@240plan.ovh.net>".$passage_ligne;
                $header .= "Reply-to: \"RETOUR\" <alainche@240plan.ovh.net>".$passage_ligne; 
                $header .= "MIME-Version: 1.0".$passage_ligne;
                $header .= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

                //Création du message
                $message = $passage_ligne."--".$boundary.$passage_ligne;
                $message .= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
                $message .= 'Content-Transfer-Encoding:8bit'.$passage_ligne;
                $message .= $passage_ligne.$message_html.$passage_ligne;
                    
                $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
                $message.= $passage_ligne."--".$boundary."--".$passage_ligne;

                // Assemblage du mail
                 //mail($destinataire, $sujet, $message, $header);
                 $errors[] = "le mail a été envoyé";
            }
            else{
                $errors[] = 'objet is missing';
            }
        }
        else{
            $errors[] = 'pseudo is wrong';
        }
    }
    else{
        $errors[] = 'formulaire is empty'; 
    }


    if ($errors){
        set('form', $form);
        set('errors', $errors);

        return my_product_show_controller();
        redirect_to('/my_product');
    }

    // MESSAGE DE SUCCESS
    flash('success', 'Email send');

    //REDIRECTION
    redirect_to('/my_product');
}





