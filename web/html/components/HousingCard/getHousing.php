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
        $sort = "_Housing.priceIncl";
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

    $housings = HousingService::GetHousingsByOffset($city, $beginDate, $endDate, $nbPerson, $minPrice, $maxPrice, $q*9, $sort, $desc);

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

