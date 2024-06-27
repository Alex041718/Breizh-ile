<?php
    require_once("../../../services/HousingService.php");
    require_once("../../../services/OwnerService.php");
    require_once("../../../services/TypeService.php");
    require_once("../../../services/CategoryService.php");
    require_once("../../../services/ArrangementService.php");

    if(isset($_POST['q']) && $_POST['q'] != "") {
        $q = intval($_POST['q']);
    } else {
        $q = 1;
    }

    if(isset($_POST['sort']) && $_POST['sort'] != "undefined" && !empty($_POST['sort'])) {
        $sort = $_POST['sort'];
    } else {
        $sort = "H.priceIncl";
    }

    if(isset($_POST['desc']) && $_POST['desc'] == 1) $desc = 1;
    else $desc = 0;
    if(isset($_POST["nbPerson"]) && $_POST["nbPerson"] != "" && $_POST["nbPerson"] != "null") $nbPerson = $_POST["nbPerson"];
    else $nbPerson = null;
    if(isset($_POST["city"]) && $_POST["city"] != "" && $_POST["city"] != "null") $city = $_POST["city"];
    else $city = null;
    if(isset($_POST["beginDate"]) && $_POST["beginDate"] != "" && $_POST["beginDate"] != "null") $beginDate = $_POST["beginDate"];
    else $beginDate = null;
    if(isset($_POST["endDate"]) && $_POST["endDate"] != "" && $_POST["endDate"] != "null") $endDate = $_POST["endDate"];
    else $endDate = null;
    if(isset($_POST["minPrice"]) && $_POST["minPrice"] != "" && $_POST["minPrice"] != "null") $minPrice = $_POST["minPrice"];
    else $minPrice = null;
    if(isset($_POST["maxPrice"]) && $_POST["maxPrice"] != "" && $_POST["maxPrice"] != "null") $maxPrice = $_POST["maxPrice"];
    else $maxPrice = null;
    if(isset($_POST["appartement"]) && $_POST["appartement"] != "" && $_POST["appartement"] != "null") $appartement = $_POST["appartement"];
    else $appartement = null;
    if(isset($_POST["chalet"]) && $_POST["chalet"] != "" && $_POST["chalet"] != "null") $chalet = $_POST["chalet"];
    else $chalet = null;
    if(isset($_POST["maison"]) && $_POST["maison"] != "" && $_POST["maison"] != "null") $maison = $_POST["maison"];
    else $maison = null;
    if(isset($_POST["bateau"]) && $_POST["bateau"] != "" && $_POST["bateau"] != "null") $bateau = $_POST["bateau"];
    else $bateau = null;
    if(isset($_POST["villa"]) && $_POST["villa"] != "" && $_POST["villa"] != "null") $villa = $_POST["villa"];
    else $villa = null;
    if(isset($_POST["insol"]) && $_POST["insol"] != "" && $_POST["insol"] != "null") $insol = $_POST["insol"];
    else $insol = null;
    if(isset($_POST["t1"]) && $_POST["t1"] != "" && $_POST["t1"] != "null") $t1 = $_POST["t1"];
    else $t1 = null;
    if(isset($_POST["t2"]) && $_POST["t2"] != "" && $_POST["t2"] != "null") $t2 = $_POST["t2"];
    else $t2 = null;
    if(isset($_POST["t3"]) && $_POST["t3"] != "" && $_POST["t3"] != "null") $t3 = $_POST["t3"];
    else $t3 = null;
    if(isset($_POST["t4"]) && $_POST["t4"] != "" && $_POST["t4"] != "null") $t4 = $_POST["t4"];
    else $t4 = null;
    if(isset($_POST["t5"]) && $_POST["t5"] != "" && $_POST["t5"] != "null") $t5 = $_POST["t5"];
    else $t5 = null;
    if(isset($_POST["t6"]) && $_POST["t6"] != "" && $_POST["t6"] != "null") $t6 = $_POST["t6"];
    else $t6 = null;
    if(isset($_POST["f1"]) && $_POST["f1"] != "" && $_POST["f1"] != "null") $f1 = $_POST["f1"];
    else $f1 = null;
    if(isset($_POST["f2"]) && $_POST["f2"] != "" && $_POST["f2"] != "null") $f2 = $_POST["f2"];
    else $f2 = null;
    if(isset($_POST["f3"]) && $_POST["f3"] != "" && $_POST["f3"] != "null") $f3 = $_POST["f3"];
    else $f3 = null;
    if(isset($_POST["f4"]) && $_POST["f4"] != "" && $_POST["f4"] != "null") $f4 = $_POST["f4"];
    else $f4 = null;
    if(isset($_POST["f5"]) && $_POST["f5"] != "" && $_POST["f5"] != "null") $f5 = $_POST["f5"];
    else $f5 = null;

    if(isset($_POST["baignade"]) && $_POST["baignade"] != "" && $_POST["baignade"] != "null") $baignade = $_POST["baignade"];
    else $baignade = null;
    if(isset($_POST["voile"]) && $_POST["voile"] != "" && $_POST["voile"] != "null") $voile = $_POST["voile"];
    else $voile = null;
    if(isset($_POST["canoe"]) && $_POST["canoe"] != "" && $_POST["canoe"] != "null") $canoe = $_POST["canoe"];
    else $canoe = null;
    if(isset($_POST["golf"]) && $_POST["golf"] != "" && $_POST["golf"] != "null") $golf = $_POST["golf"];
    else $golf = null;
    if(isset($_POST["equitation"]) && $_POST["equitation"] != "" && $_POST["equitation"] != "null") $equitation = $_POST["equitation"];
    else $equitation = null;
    if(isset($_POST["accrobranche"]) && $_POST["accrobranche"] != "" && $_POST["accrobranche"] != "null") $accrobranche = $_POST["accrobranche"];
    else $accrobranche = null;
    if(isset($_POST["randonnee"]) && $_POST["randonnee"] != "" && $_POST["randonnee"] != "null") $randonnee = $_POST["randonnee"];
    else $randonnee = null;

    if(isset($_POST["jardin"]) && $_POST["jardin"] != "" && $_POST["jardin"] != "null") $jardin = $_POST["jardin"];
    else $jardin = null;
    if(isset($_POST["balcon"]) && $_POST["balcon"] != "" && $_POST["balcon"] != "null") $balcon = $_POST["balcon"];
    else $balcon = null;
    if(isset($_POST["terrasse"]) && $_POST["terrasse"] != "" && $_POST["terrasse"] != "null") $terrasse = $_POST["terrasse"];
    else $terrasse = null;
    if(isset($_POST["piscine"]) && $_POST["piscine"] != "" && $_POST["piscine"] != "null") $piscine = $_POST["piscine"];
    else $piscine = null;
    if(isset($_POST["jacuzzi"]) && $_POST["jacuzzi"] != "" && $_POST["jacuzzi"] != "null") $jacuzzi = $_POST["jacuzzi"];
    else $jacuzzi = null;

    $housings = HousingService::GetHousingsByOffset($city, $beginDate, $endDate, $nbPerson, $minPrice, $maxPrice, $appartement, $chalet, $maison, $bateau, $villa, $insol, $t1, $t2, $t3, $t4, $t5, $t6, $f1, $f2, $f3, $f4, $f5, $baignade, $voile, $canoe, $golf, $equitation, $accrobranche, $randonnee, $jardin, $balcon, $terrasse, $piscine, $jacuzzi, $q*9, $sort, $desc);

    if($housings != false && sizeof($housings) > 0) {
        for ($i=0; $i < count($housings); $i++) {
            require_once("../HousingCard/HousingCard.php");
            require_once("../../../models/Housing.php");
            require_once("../../../models/Type.php");
            require_once("../../../models/Image.php");
            require_once("../../../models/Address.php");
            require_once("../../../models/Category.php");
            require_once("../../../models/Owner.php");
            require_once("../../../models/Gender.php");
    
            HousingCard::render($housings[$i]);
        }
        if(sizeof($housings) == 9): ?>
            <hr class="show-more">
            <button onclick='showUser(<?= $q+1 ?>,"<?= $sort ?>", <?= $desc ?>, false)' class="show-more btn btn--center">Voir davantage</button>
        <?php endif; ?>

  <?php  }
    else { ?>
        <p class="show-more">Aucun résultat n'a été trouvé...</p>
    <?php } ?>

