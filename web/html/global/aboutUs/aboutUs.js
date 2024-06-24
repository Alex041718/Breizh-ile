document.addEventListener("DOMContentLoaded", function() {
    const textElement = document.getElementById('typing-text');
    const baseText = 'Nous sommes';
    const words = ['Breizh\'Ile', 'Dévoué'];
    const typingSpeed = 100;
    const erasingSpeed = 50;
    const delayBetweenWords = 1000;

    let wordIndex = 0;
    let charIndex = 0;
    let isErasing = false;

    function type() {
        if (!isErasing && charIndex < words[wordIndex].length) {
            textElement.textContent = baseText + ' ' + words[wordIndex].substring(0, charIndex + 1);
            charIndex++;
            setTimeout(type, typingSpeed);
        } else if (isErasing && charIndex > 0) {
            textElement.textContent = baseText + ' ' + words[wordIndex].substring(0, charIndex - 1);
            charIndex--;
            setTimeout(type, erasingSpeed);
        } else if (!isErasing && charIndex === words[wordIndex].length) {
            setTimeout(() => {
                isErasing = true;
                setTimeout(type, erasingSpeed);
            }, delayBetweenWords);
        } else if (isErasing && charIndex === 0) {
            isErasing = false;
            wordIndex = (wordIndex + 1) % words.length;
            setTimeout(type, typingSpeed);
        }
    }

    type();
});
