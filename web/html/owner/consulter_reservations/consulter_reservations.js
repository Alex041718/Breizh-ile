function main() {
    const reservations = document.querySelector(".reservations");
    const columns = document.querySelectorAll(".title p");

    const checkboxes = document.getElementsByName("checkbox");
    const checkboxAll = document.getElementsByName("checkboxAll");
    const exportationButton = document.getElementById(" exportationButton ");

    let selected_reservations = [];

    exportationButton.classList.toggle("button--disabled");
    exportationButton.disabled = true;

    reservations.innerHTML = "Chargement...";

    function clearSort() {
        checkboxAll[0].checked = false;
        selected_reservations = [];
        columns.forEach(column => {
            column.classList.remove("title--selected");
        });
    }

    function applyCheckboxes() {
        checkboxAll[0].addEventListener("change", () => {
            checkboxes.forEach(checkbox => {
                checkbox.checked = checkboxAll[0].checked;
            });
    
            if (checkboxAll[0].checked) {
                selected_reservations = Array.from({length: checkboxes.length}, (_, index) => index);
            } else {
                selected_reservations = [];
            }
    
            let isAtLeastOneChecked = selected_reservations.length > 0;
            exportationButton.classList.toggle("button--disabled", !isAtLeastOneChecked);
            exportationButton.disabled = !isAtLeastOneChecked;
        });

        checkboxes.forEach((checkbox, index) => {
            checkbox.addEventListener("change", () => {
                if (!checkbox.checked) {
                    checkboxAll[0].checked = false;
                    selected_reservations = selected_reservations.filter(reservation => reservation !== index);
                } else {
                    selected_reservations.push(index);
                }

                let isAtLeastOneChecked = selected_reservations.length > 0;
                exportationButton.classList.toggle("button--disabled", !isAtLeastOneChecked);
                exportationButton.disabled = !isAtLeastOneChecked;
            });
        });
    }

    function showReservations(sort="", isReverse=false) {
        let xhr = new XMLHttpRequest();
        let params = (sort === "") ? "" : `sort=${sort}&isReverse=${isReverse}`;

        xhr.open("POST", "getReservations.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                reservations.innerHTML = this.responseText;
                applyCheckboxes();
            }
        };
        xhr.send(params);
    }

    columns.forEach((column) => {
        column.addEventListener("click", () => {
            let sort = column.dataset.sort;

            let isReverse = false;
            if(column.classList.contains("title--selected")) isReverse = true;
            if(column.classList.contains("title--reverse")) isReverse = false;

            clearSort();

            column.classList.add("title--selected");
            column.classList.toggle("title--reverse", isReverse);

            switch (sort) {
                case "date-resa":
                    showReservations("getBeginDate", isReverse);
                    break;
                case "date-arrivee":
                    showReservations("getBeginDate", isReverse);
                    break;
                case "date-depart":
                    showReservations("getEndDate", isReverse);
                    break;
                default:
                    showReservations();
                    break;
            }
        });
    });

    showReservations();
}

document.addEventListener("DOMContentLoaded", () => {
    main();
});