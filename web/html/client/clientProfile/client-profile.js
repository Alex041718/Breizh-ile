document.addEventListener("DOMContentLoaded", function() {
    const passwordInput = document.querySelector('#firstPasswordEntry input');
    const lengthCriteria = document.getElementById('length');
    const uppercaseCriteria = document.getElementById('uppercase');
    const lowercaseCriteria = document.getElementById('lowercase');
    const digitCriteria = document.getElementById('digit');
    const containsCriteria = document.getElementById('contains');

    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

    passwordInput.addEventListener('input', function () {
        const password = passwordInput.value;
        // Longueur
        lengthCriteria.style.color = password.length >= 8 ? 'green' : 'red';
        // Majuscule
        uppercaseCriteria.style.color = /[A-Z]/.test(password) ? 'green' : 'red';
        // Minuscule
        lowercaseCriteria.style.color = /[a-z]/.test(password) ? 'green' : 'red';
        // Chiffre
        digitCriteria.style.color = /\d/.test(password) ? 'green' : 'red';
        // Mot de passe contient Majuscule, Minuscule, Chiffre
        containsCriteria.style.color = passwordRegex.test(password) ? 'green' : 'red';
    });

    const infos = document.getElementById('infos');
    const security = document.querySelector('.content__security');

    const infosBtn = document.getElementById('infos__btn');
    const securityBtn = document.getElementById('security__btn');

    const securityForm = document.querySelector('.content__security form');
    const personalDataForm = document.querySelector('.content__personnal-data form');

    securityBtn.addEventListener("click", toggle);
    infosBtn.addEventListener("click", toggle);

    function toggle() {
        securityBtn.classList.toggle("active");
        infosBtn.classList.toggle("active");
        infos.classList.toggle('content__display');
        security.classList.toggle('content__display');
    }

    function handleFormSubmit(form) {
        form.addEventListener('submit', function(event) {
            console.log("test");
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(form);

            // Check if passwords match before submitting
            const firstPassword = formData.get('firstPasswordEntry');
            const secondPassword = formData.get('secondPasswordEntry');

            if (firstPassword !== secondPassword) {
                Toast("Les mots de passe sont différents.", "warning"); // Log "KO" if passwords do not match
                return; // Exit function if passwords do not match
            }

            // If passwords match, proceed with form submission
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    Toast("Modification terminée.", "success");
                    form.reset(); // Optionally reset the form
                } else {
                    return response.text().then(text => { throw new Error(text) });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Toast("Une erreur est survenue. Veuillez réessayer.", "error");
            });
        });
    }

    // Handle submission for security form
    handleFormSubmit(securityForm);

    // Handle submission for personal data form (if needed)
    handleFormSubmit(personalDataForm);
});
