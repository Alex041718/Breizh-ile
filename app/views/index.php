
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/ui.css">
    <link rel="stylesheet" href="./home/home.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>
</head>
<body>
    <main class="hero">
        <section class="hero-banner" id="scene">
            <img class="bg layer" src="assets/images/BG.jpg" />
            <img data-depth="0.2" class="house layer" src="assets/images/Houses.png" />
            <img data-depth="0.3" class="breizh layer" src="assets/images/Breizh.png" />
        </section>
    </main>
    <?php
        require_once("./components/SearchBar/SearchBar.php");
        SearchBar::render("search-bar--storybook","","./monSuperFormulaireQuiVaEtreTraiter");
    ?>
    <script>
        var scene = document.getElementById('scene');
        var parallaxInstance = new Parallax(scene, {
            relativeInput: true
        });
    </script>
</body>
</html>