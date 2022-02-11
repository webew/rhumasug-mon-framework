<main>
    <section class="home">
        <?php foreach ($catalogue as $produit) : ?>
            <span><?= $produit["libelleProduit"] ?></span>
            <p><?= $produit["descriptionProduit"] ?></p>
            <p data-id="<?= $produit["idProduit"] ?>">
                <button class="btnProduit btnMoins" data-role="-" data-id="<?= $produit["idProduit"] ?>" <?= $_SESSION["panier"][$produit["idProduit"]] ?? "disabled" ?>>-</button>
                <input type="text" class="inputsProduits" disabled value="<?= $_SESSION["panier"][$produit["idProduit"]] ?? 0 ?>">
                <button class="btnProduit btnPlus" data-role="+" data-id="<?= $produit["idProduit"] ?>">+</button>
            </p>
            <hr>
        <?php endforeach ?>
    </section>
</main>