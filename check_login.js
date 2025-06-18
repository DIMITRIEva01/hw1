const loginForm = document.querySelector('#login form');
const loginUsername = document.querySelector('#login #username');
const loginPassword = document.querySelector('#login #password');

function checkLoginUsername(event) {
    const input = event.currentTarget;
    if (input.value.length === 0) {
        input.classList.add('errorj');
        input.nextElementSibling?.textContent = "Campo obbligatorio";
    } else {
        input.classList.remove('errorj');
    }
}

function checkLoginPassword(event) {
    const input = event.currentTarget;
    if (input.value.length === 0) {
        input.classList.add('errorj');
        input.nextElementSibling?.textContent = "Campo obbligatorio";
    } else {
        input.classList.remove('errorj');
    }
}
loginUsername.addEventListener('blur', checkLoginUsername);
loginPassword.addEventListener('blur', checkLoginPassword);

loginForm.addEventListener('submit', function(event) {
    var isValid = true;
    
    if (loginUsername.value.length === 0) {
        loginUsername.classList.add('errorj');
        isValid = false;
    } else {
        loginUsername.classList.remove('errorj');
    }
    
    if (loginPassword.value.length === 0) {
        loginPassword.classList.add('errorj');
        isValid = false;
    } else {
        loginPassword.classList.remove('errorj');
    }
    
    if (!isValid) {
        event.preventDefault();
        alert("Compila tutti i campi obbligatori!");
    }
});