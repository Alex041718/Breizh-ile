export function Toast(message, type) {
    let toast = document.createElement("div");
    toast.classList.add("toast");
    toast.classList.add(`toast--${type}`);
    switch (type) {
        case "success":
            toast.innerHTML = '<i class="fa-solid fa-check"></i>';
            break;
        case "error":
            toast.innerHTML = '<i class="fa-solid fa-exclamation"></i>';
            break;
        case "warning":
            toast.innerHTML = '<i class="fa-solid fa-exclamation-triangle"></i>';
            break;
        default:
            toast.innerHTML = '<i class="fa-solid fa-info"></i>';
            break;
    }
    toast.innerHTML += message;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}


console.log("Toast loaded");

//Toast("Hello", "success");