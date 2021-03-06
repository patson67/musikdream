<?php
    if ( !isset( $_SESSION['login'] ) ) {
        header('Location: index.php?page=login');
        exit;
    }

    if ( isset( $_POST['action'] ) ) {
        // var_dump($_POST);
        if ($_POST['action'] == 'ajout') {

            $panier_manager = new PanierManager( $link );
            $produit_manager = new ProduitManager( $link );
            try {
                $produit = $produit_manager->findById( $_POST['id'] );
                $panier = $panier_manager->getCurrent();
                $panier->addProduit( $produit );
                $panier_manager->update( $panier );

                header('Location: index.php?page=panier');
                exit;            
            }

            catch ( Exception $exception ){
                $error = $exception->getMessage();
            }        

        }
       
        if ($_POST['action'] == 'retirer') {
            // var_dump($POST);
            $panier_manager = new PanierManager( $link );
            $produit_manager = new ProduitManager( $link );
            try {
                $produit = $produit_manager->findById( $_POST['idProduit'] );
                $panier = $panier_manager->getCurrent();
                $panier_manager->removeProduitPanier($panier,  $produit );

                header('Location: index.php?page=panier');
                exit;            
            }

            catch ( Exception $exception ){
                $error = $exception->getMessage();
            }        

        }

        if ($_POST['action'] == 'acheter') {

            $utilisateurM = new UtilisateurManager( $link );
            try {
                $utilisateur = $utilisateurM->getById( $_SESSION['id'] );
                $designation = $utilisateur->getAdresseFacturation()->getDesignation();
                $rue = $utilisateur->getAdresseFacturation()->getRue();
                $cp = $utilisateur->getAdresseFacturation()->getCp();
                $ville = $utilisateur->getAdresseFacturation()->getVille();
                $pays = $utilisateur->getAdresseFacturation()->getPays();

                $designation1 = $utilisateur->getAdresseLivraison()->getDesignation();
                $rue1 = $utilisateur->getAdresseLivraison()->getRue();
                $cp1 = $utilisateur->getAdresseLivraison()->getCp();
                $ville1 = $utilisateur->getAdresseLivraison()->getVille();
                $pays1 = $utilisateur->getAdresseLivraison()->getPays();
            }
            catch (Exception $exception) {
                $error = $exception->getMessage();
            }

            if( $designation && $rue && $cp && $ville && $pays &&
                $designation1 && $rue1 && $cp1 && $ville1 && $pays1)
            {
                // ICI ACHETER ET CHANGER LE STATUT DU PANIER
                try{
                    $panier_manager = new PanierManager( $link );
                    $panier = $panier_manager->getCurrent();
                    $panier->setStatus(1);
                    $panier_manager->update($panier);
                }
                catch (Exception $exception) {
                    $error = $exception->getMessage();
                }
                // var_dump($panier);
                header('Location: index.php?page=recap_panier');
                exit;
            }
            else{
                header('Location: index.php?page=profil');
            }  
        }
    }
?>