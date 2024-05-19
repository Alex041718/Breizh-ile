const checkboxes = document.getElementsByName("checkbox");
const checkboxAll = document.getElementsByName("checkboxAll");
const exportationButton = document.getElementById(" exportationButton ");
let selected_reservations = [];

exportationButton.classList.toggle("button--disabled");
exportationButton.disabled = true;

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

// index and value
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