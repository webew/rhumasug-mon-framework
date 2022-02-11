<main>
    <h1>Paiement</h1>
    <h2>Montant</h2>

    <?php var_dump($montant) ?>


    <?php if (isset($_SESSION["idUser"])) : ?>
        <form method="POST" action="validerPaiement">
            <button id="btnValiderPaiement">PAYER</button>
        </form>
    <?php endif ?>
</main>