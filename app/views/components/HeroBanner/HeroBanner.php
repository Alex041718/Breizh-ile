<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="hero" id="scene">
        <img class="bg layer" src="images/BG.jpg" />
        <img data-depth="0.4" class="house layer" src="images/Houses.png" />
        <img data-depth="0.6" class="breizh layer" src="images/Logo.png" />
        <?php
            require_once("../SearchBar/SearchBar.php");
            use views\components\SearchBar;
            SearchBar::render("search-bar--hero","","./monSuperFormulaireQuiVaEtreTraiter");
        ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>
    <script>
        var scene = document.getElementById('scene');
        var parallaxInstance = new Parallax(scene); 
    </script>
</body>
</html>