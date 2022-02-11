<header>
    <div id="logo">LOGO
    </div>
    <nav>
        <a href="accueil">Catalogue</a>
        <?php if (isset($_SESSION["idUser"])) : ?>
            <a href="logout">Logout</a>
        <?php else : ?>
            <a href="login">Login</a>
        <?php endif ?>
        <a href="panier">Mon Panier</a>
    </nav>
    <div class="panierCount">
        <span>Panier </span><span id="panierQte"><?= isset($_SESSION["panier"]) ? count($_SESSION["panier"]) : 0 ?></span>
    </div>
</header>