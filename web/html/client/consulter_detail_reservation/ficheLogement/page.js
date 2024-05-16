const inputs = document.querySelectorAll(".datepicker input[type=date]");

inputs.forEach((input) => {
    flatpickr(input, {
        dateFormat: "d-m-Y",
        minDate: "today",
        maxDate: new Date().fp_incr(365)
    });
});

