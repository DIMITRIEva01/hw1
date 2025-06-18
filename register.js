// Oggetto per tracciare lo stato dei campi
const formStatus = {
    name: false,
    surname: false,
    email: false,
    username: false,
    password: false,
    confirmPassword: false,
    terms: false
};

// Funzioni di validazione di base
function checkName(event) {
    const input = event.currentTarget;
    const errorSpan = input.nextElementSibling;
    
    if (input.value.trim().length === 0) {
        input.classList.add('errorj');
        errorSpan.textContent = "Il nome è obbligatorio";
        formStatus.name = false;
    } else {
        input.classList.remove('errorj');
        errorSpan.textContent = "";
        formStatus.name = true;
    }
}

function checkSurname(event) {
    const input = event.currentTarget;
    const errorSpan = input.nextElementSibling;
    
    if (input.value.trim().length === 0) {
        input.classList.add('errorj');
        errorSpan.textContent = "Il cognome è obbligatorio";
        formStatus.surname = false;
    } else {
        input.classList.remove('errorj');
        errorSpan.textContent = "";
        formStatus.surname = true;
    }
}

function checkEmail(event) {
    const input = event.currentTarget;
    const errorSpan = input.nextElementSibling;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    // Controllo formato email
    if (!emailRegex.test(input.value)) {
        input.classList.add('errorj');
        errorSpan.textContent = "Email non valida";
        formStatus.email = false;
    } else {
        // Verifica disponibilità email
        fetch("check_email.php?q=" + encodeURIComponent(input.value.toLowerCase()))
            .then(response => {
                if (!response.ok) throw new Error("Errore di rete");
                return response.json();
            })
            .then(json => {
                if (json.exists) {
                    input.classList.add('errorj');
                    errorSpan.textContent = "Email già registrata";
                    formStatus.email = false;
                } else {
                    input.classList.remove('errorj');
                    errorSpan.textContent = "";
                    formStatus.email = true;
                }
            })
            .catch(error => {
                console.error("Errore:", error);
                input.classList.add('errorj');
                errorSpan.textContent = "Errore di verifica email";
                formStatus.email = false;
            });
    }
}

function checkUsername(event) {
    const input = event.currentTarget;
    const errorSpan = input.nextElementSibling;
    const usernameRegex = /^[a-zA-Z0-9_]{1,15}$/;
    
    // Controllo formato username
    if (!usernameRegex.test(input.value)) {
        input.classList.add('errorj');
        errorSpan.textContent = "Sono ammesse lettere, numeri e underscore. Max. 15";
        formStatus.username = false;
    } else {
        // Verifica disponibilità username
        fetch("check_username.php?q=" + encodeURIComponent(input.value))
            .then(response => {
                if (!response.ok) throw new Error("Errore di rete");
                return response.json();
            })
            .then(json => {
                if (json.exists) {
                    input.classList.add('errorj');
                    errorSpan.textContent = "Username già utilizzato";
                    formStatus.username = false;
                } else {
                    input.classList.remove('errorj');
                    errorSpan.textContent = "";
                    formStatus.username = true;
                }
            })
            .catch(error => {
                console.error("Errore:", error);
                input.classList.add('errorj');
                errorSpan.textContent = "Errore di verifica username";
                formStatus.username = false;
            });
    }
}

function checkPassword(event) {
    const input = event.currentTarget;
    const errorSpan = input.nextElementSibling;
    
    if (input.value.length < 8) {
        input.classList.add('errorj');
        errorSpan.textContent = "La password deve avere almeno 8 caratteri";
        formStatus.password = false;
    } else {
        input.classList.remove('errorj');
        errorSpan.textContent = "";
        formStatus.password = true;
    }
    
    // Verifica anche la conferma password se già compilata
    const confirmInput = document.querySelector('#confirm_password');
    if (confirmInput.value.length > 0) {
        checkConfirmPassword({currentTarget: confirmInput});
    }
}

function checkConfirmPassword(event) {
    const input = event.currentTarget;
    const errorSpan = input.nextElementSibling;
    const password = document.querySelector('#password').value;
    
    if (input.value !== password) {
        input.classList.add('errorj');
        errorSpan.textContent = "Le password non coincidono";
        formStatus.confirmPassword = false;
    } else {
        input.classList.remove('errorj');
        errorSpan.textContent = "";
        formStatus.confirmPassword = true;
    }
}

function checkTerms(event) {
    const checkbox = event.currentTarget;
    const errorSpan = checkbox.closest('.terms').querySelector('span');
    
    if (!checkbox.checked) {
        errorSpan.textContent = "Devi accettare i termini di servizio";
        formStatus.terms = false;
    } else {
        errorSpan.textContent = "";
        formStatus.terms = true;
    }
}

// Controllo finale al submit
document.querySelector('#registrazione form').addEventListener('submit', function(event) {
    // Verifica che tutti i campi siano validi
    const allValid = Object.values(formStatus).every(status => status === true);
    
    if (!allValid) {
        event.preventDefault();
        alert("Correggi gli errori nel form prima di procedere con la registrazione.");
    }
});

// Aggiungi event listeners
document.querySelector('#name').addEventListener('blur', checkName);
document.querySelector('#surname').addEventListener('blur', checkSurname);
document.querySelector('#email').addEventListener('blur', checkEmail);
document.querySelector('#username').addEventListener('blur', checkUsername);
document.querySelector('#password').addEventListener('blur', checkPassword);
document.querySelector('#confirm_password').addEventListener('blur', checkConfirmPassword);
document.querySelector('#terms').addEventListener('change', checkTerms);