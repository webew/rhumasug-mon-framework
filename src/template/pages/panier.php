<main>
    <section>
        <?php
        if (isset($_SESSION["panier"])) {
            var_dump($_SESSION["panier"]);
            if (isset($_SESSION["idUser"])) { ?>
                <form method="POST" action="validerPanier">
                    <button id="btnValiderPanier">Valider mon panier</button>
                </form>
            <?php } else { ?>
                <p>Vous devez vous connecter pour valider votre panier. :/</p>
            <?php }
        } else { ?>
            <p>Votre panier est vide. ;)</p>
        <?php } ?>

    </section>
</main>