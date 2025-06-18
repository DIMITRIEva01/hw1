<?php
require_once 'dbconfig.php';
include 'auth.php';

if (checkAuth()) {
    header('Location: home.php');
    exit;
}

$connessione = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
if (!$connessione) {
    die("Connessione fallita: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['name']) && isset($_POST['surname']) &&
        isset($_POST['email']) && isset($_POST['username']) &&
        isset($_POST['password'])
    ) {
        $name = $connessione->real_escape_string($_POST['name']);
        $surname = $connessione->real_escape_string($_POST['surname']);
        $email = $connessione->real_escape_string($_POST['email']);
        $username = $connessione->real_escape_string($_POST['username']);
        $password = $_POST['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check_sql = "SELECT id FROM users WHERE username = '$username'";
        $check_result = $connessione->query($check_sql);
        if ($check_result && $check_result->num_rows > 0) {
            echo "<script>alert('Username già esistente');</script>";
        } else {
            $sql_insert = "INSERT INTO users (email, username, password, name, surname)
                           VALUES ('$email', '$username', '$hashed_password', '$name', '$surname')";

            if ($connessione->query($sql_insert) === TRUE) {
                $user_id = $connessione->insert_id;
                $_SESSION['_agora_user_id'] = $user_id;
                $_SESSION['username'] = $username;
                header("Location: home.php");
                exit();
            } else {
                echo "<script>alert('Errore durante la registrazione');</script>";
            }
        }
    } else {
        echo "<script>alert('Compila tutti i campi.');</script>";
    }

    $connessione->close();
}
?>


<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Pagina di Registrazione</title>
    <script src='script.js' defer></script>
    <script src='register.js' defer></script>
    <script src='onClick.js' defer></script>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='style-mobile.css'>
    
    <script src="https://cdn.auth0.com/js/auth0-spa-js/2.0/auth0-spa-js.production.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <main>
    
        <header>
            Spedizione gratis da €39
        </header>
        <nav-header>
            <div class="left">
                    <span id="open-modal">SERVIZIO CLIENTI</span>
            </div>
            <div class="right">
                <span id="login-user">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="hidden-sm-down" width="18px" height="18px">
                        <path fill-rule="evenodd" fill="rgb(0, 0, 0)" d="M15.364,11.636 C14.384,10.656 13.217,9.930 11.944,9.491 C13.307,8.552 14.203,6.980 14.203,5.203 C14.203,2.334 11.869,-0.000 9.000,-0.000 C6.131,-0.000 3.797,2.334 3.797,5.203 C3.797,6.980 4.693,8.552 6.056,9.491 C4.783,9.930 3.616,10.656 2.636,11.636 C0.936,13.336 0.000,15.596 0.000,18.000 L1.406,18.000 C1.406,13.813 4.813,10.406 9.000,10.406 C13.187,10.406 16.594,13.813 16.594,18.000 L18.000,18.000 C18.000,15.596 17.064,13.336 15.364,11.636 ZM9.000,9.000 C6.906,9.000 5.203,7.297 5.203,5.203 C5.203,3.110 6.906,1.406 9.000,1.406 C11.094,1.406 12.797,3.110 12.797,5.203 C12.797,7.297 11.094,9.000 9.000,9.000 Z"/>
                    </svg> 
                    Accedi
                </span>
                <span id="preferiti-header">
                    <svg class="hidden-sm-down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="17px">
                        <path fill-rule="evenodd" fill="rgb(0, 0, 0)" d="M14.357,0.000 C12.655,0.000 11.061,0.686 10.000,1.837 C8.939,0.686 7.345,0.000 5.643,0.000 C2.531,0.000 -0.000,2.254 -0.000,5.025 C-0.000,7.194 1.453,9.704 4.318,12.483 C6.523,14.622 8.921,16.279 9.604,16.735 L10.000,17.000 L10.396,16.735 C11.079,16.279 13.477,14.622 15.682,12.483 C18.547,9.704 20.000,7.194 20.000,5.025 C20.000,2.254 17.469,0.000 14.357,0.000 ZM14.711,11.689 C12.897,13.449 10.946,14.871 10.000,15.526 C9.054,14.871 7.103,13.449 5.289,11.689 C2.692,9.169 1.319,6.864 1.319,5.025 C1.319,2.902 3.258,1.174 5.643,1.174 C7.212,1.174 8.660,1.936 9.423,3.162 L10.000,4.088 L10.577,3.162 C11.340,1.936 12.788,1.174 14.357,1.174 C16.742,1.174 18.681,2.902 18.681,5.025 C18.681,6.864 17.308,9.169 14.711,11.689 Z"></path>
                    </svg> 
                    Lista dei Desideri
                </span>

                <span id="carrello-header">
                    <svg class="hidden-sm-down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22px" height="19px">
                        <path fill-rule="evenodd" fill="rgb(0, 0, 0)" d="M0.610,1.187 L2.614,1.187 L7.142,14.384 C6.187,14.707 5.500,15.589 5.500,16.625 C5.500,17.934 6.596,19.000 7.944,19.000 C9.292,19.000 10.388,17.934 10.388,16.625 C10.388,16.192 10.267,15.787 10.058,15.437 L16.219,15.437 C16.010,15.787 15.889,16.192 15.889,16.625 C15.889,17.934 16.985,19.000 18.333,19.000 C19.681,19.000 20.777,17.934 20.777,16.625 C20.777,15.315 19.681,14.250 18.333,14.250 L8.384,14.250 L7.570,11.875 L18.944,11.875 C19.207,11.875 19.441,11.711 19.524,11.469 L21.968,4.344 C22.031,4.163 21.999,3.964 21.885,3.809 C21.769,3.654 21.585,3.562 21.389,3.562 L4.718,3.562 L3.635,0.406 C3.551,0.163 3.318,-0.000 3.055,-0.000 L0.610,-0.000 C0.273,-0.000 -0.001,0.266 -0.001,0.594 C-0.001,0.922 0.273,1.187 0.610,1.187 ZM18.333,15.437 C19.007,15.437 19.555,15.970 19.555,16.625 C19.555,17.279 19.007,17.812 18.333,17.812 C17.659,17.812 17.111,17.279 17.111,16.625 C17.111,15.970 17.659,15.437 18.333,15.437 ZM7.944,15.437 C8.618,15.437 9.166,15.970 9.166,16.625 C9.166,17.279 8.618,17.812 7.944,17.812 C7.270,17.812 6.722,17.279 6.722,16.625 C6.722,15.970 7.270,15.437 7.944,15.437 ZM20.541,4.750 L18.504,10.687 L7.162,10.687 L5.125,4.750 L20.541,4.750 Z"></path>
                    </svg> 
                    Carrello
                </span>
            </div>
           
        </nav-header>
        <nav>
             <div id="open-modal-menu" class="menu-mobile">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                </svg>  
            </div>

            <div id="logo"> <img src="https://mangayo.it/modules/an_logo/img/d5721895b0230eef211ba65f3bdc34cf.svg"width="62" height="50">

            </div>
            <div id="menu">
                <span>novità</span>
                <span>manga</span>
                <span>giappone</span>
                <span>figure</span>
                <span>card game</span>
                <span>preordini</span>
                
            </div>
            <div id="carrello">
                <svg class="hidden-md-up" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="27px">
                    <path fill-rule="evenodd" fill="rgb(0, 0, 0)" d="M0.833,1.687 L3.565,1.687 L9.739,20.440 C8.437,20.900 7.499,22.152 7.499,23.625 C7.499,25.486 8.995,27.000 10.833,27.000 C12.671,27.000 14.166,25.486 14.166,23.625 C14.166,23.010 14.000,22.434 13.715,21.937 L22.117,21.937 C21.832,22.434 21.666,23.010 21.666,23.625 C21.666,25.486 23.162,27.000 25.000,27.000 C26.838,27.000 28.333,25.486 28.333,23.625 C28.333,21.764 26.838,20.250 25.000,20.250 L11.433,20.250 L10.322,16.875 L25.833,16.875 C26.192,16.875 26.510,16.643 26.624,16.298 L29.957,6.173 C30.042,5.916 29.999,5.633 29.843,5.413 C29.686,5.193 29.434,5.062 29.166,5.062 L6.433,5.062 L4.957,0.577 C4.843,0.232 4.524,-0.000 4.166,-0.000 L0.833,-0.000 C0.372,-0.000 -0.001,0.378 -0.001,0.844 C-0.001,1.310 0.372,1.687 0.833,1.687 ZM25.000,21.937 C25.919,21.937 26.666,22.694 26.666,23.625 C26.666,24.555 25.919,25.312 25.000,25.312 C24.081,25.312 23.333,24.555 23.333,23.625 C23.333,22.694 24.081,21.937 25.000,21.937 ZM10.833,21.937 C11.752,21.937 12.499,22.694 12.499,23.625 C12.499,24.555 11.752,25.312 10.833,25.312 C9.914,25.312 9.166,24.555 9.166,23.625 C9.166,22.694 9.914,21.937 10.833,21.937 ZM28.010,6.750 L25.232,15.187 L9.767,15.187 L6.989,6.750 L28.010,6.750 Z"></path>
                </svg>
            </div>
            
            <div id="ricerca">cerca
                <div class="lente">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px">
                        <path fill-rule="evenodd" fill="rgb(0, 0, 0)" d="M20.008,18.960 L19.484,19.484 L18.960,20.007 L12.071,13.119 C10.794,14.163 9.185,14.815 7.407,14.815 C3.316,14.815 -0.000,11.498 -0.000,7.407 C-0.000,3.316 3.316,-0.000 7.407,-0.000 C11.498,-0.000 14.815,3.316 14.815,7.407 C14.815,9.185 14.163,10.794 13.119,12.071 L20.008,18.960 ZM7.407,1.481 C4.135,1.481 1.481,4.135 1.481,7.407 C1.481,10.680 4.135,13.333 7.407,13.333 C10.680,13.333 13.333,10.680 13.333,7.407 C13.333,4.135 10.680,1.481 7.407,1.481 Z"></path>
                    </svg>
                </div>
            </div>
            <form action="ricerca.php" method="get" id="barra-ricerca">
                <input type="text" name="query" placeholder="Cosa stai cercando?" required>
                <button type="submit">Cerca</button>
            </form>
        </nav>
        <section id="registrazione">
    <img src="YoChanLogin_YoChanLogin_gif__460_226_.gif" alt="GIF animata" style="width: 460px; height: 226px;">
    <form action="register.php" method="post" id="register-form">
        <h2>Registrati</h2>
        <input type="text" id="name" name="name" placeholder="Nome" required>
        <span class="error"></span>
        <input type="text" id="surname" name="surname" placeholder="Cognome" required>
        <span class="error"></span>
        <input type="email" id="email" name="email" placeholder="E-mail" required>
        <span class="error"></span>
        <input type="text" id="username" name="username" placeholder="Nome utente" required>
        <span class="error"></span>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <span class="error"></span>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Conferma password" required>
        <span class="error"></span>
        <div class="terms">
            <label>
                <input type="checkbox" id="terms" name="terms" required>
                Accetto i termini di servizio
            </label>
            <span></span>
        </div>
        <button type="submit">Registrati</button>
        <p>Hai già un account? <a href="login.php">Accedi</a></p>
    </form>
</section>
        <footer>
            <div class="footer-mobile">
                <div class="sub-menu">prodotti</div>
                <div class="sub-menu">informazioni</div>
                <div class="sub-menu">il tuo account</div>
            </div>
            <div id="footer-container">
                <div class="footer-elemento">
                    <img src="https://mangayo.it/modules/an_logo/img/d5721895b0230eef211ba65f3bdc34cf.svg" alt="MANGAYO!">
                    Via Gaetano Negri, 14 <br>
                    20081 Abbiategrasso <br>
                    Milano <br>
                    Italia <br>
                    servizioclienti@mangayo.it <br> 
                    <span class="r1">Contattaci su <span class="whatsapp"> WhatsApp</span></span>
                </div>
                <div class="footer-elemento">
                    <strong>Prodotti</strong>

                    Novità <br>
                    Manga <br>
                    Giappone <br>
                    Figure <br>
                    Preordine <br>
                    Card Game
                    
                </div>
                <div class="footer-elemento">
                    <strong>Informazioni</strong>

                    Ambiente <br>
                    Termini e condizioni <br>
                    Spedizioni e resi <br>
                    Carta del Docente <br>
                    Privacy Policy <br>
                    Cookie Policy <br>
                    Cancellazione Account <br>
                    Domande Frequenti <br>
                    Lavora con noi <br>
                    Carte Cultura <br>
                    Contattaci
                </div>
                <div class="footer-elemento">
                    <strong>Il tuo account</strong>

                    Informazioni personali <br>
                    Ordini <br>
                    Note di credito <br>
                    Indirizzi <br>
                    Buoni
                
            </div>
            </div>
                <div class="end">
                    <div class="copyright">
                        ©2025 MangaYo! s.r.l. P.IVA: 15931551004
                    </div>
                    <div class="pagamenti">
                        <img src="https://mangayo.it/modules/an_trust_badges/icons/c945d6f2401779f66c47dd3eca37f85e.jpg" width="38" height="24" alt="Apple Pay" class="an_trust_badges-list-image">
                        <img src="https://mangayo.it/modules/an_trust_badges/icons/49ecf7e5a4060590c2706e4c05be7571.jpg" width="38" height="24" alt="Master Card" class="an_trust_badges-list-image">
                        <img src="https://mangayo.it/modules/an_trust_badges/icons/04e7920be72f572db303920fa4149162.jpg" width="38" height="24" alt="Visa" class="an_trust_badges-list-image">
                        <img src="https://mangayo.it/modules/an_trust_badges/icons/1ab6211526ecfc2459eb80f8d1037fba.jpg" width="38" height="24" alt="Paypal" class="an_trust_badges-list-image">
                    </div>
            </div>
        </footer>
  
    </main>
    <div id="modale1" class="modale1">
                <div class="modal-content">
                    <span id="close-modal">&times;</span>
                    <h2>Servizio Clienti</h2>
                    <div>
                        <h3><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"></path></svg>
                        I nostri contatti:</h3>
                        • Per info su prodotti o spedizioni: <br>
                        <a>servizioclienti@mangayo.it</a> <br>
                        • Per proposte commerciali: <br> <a>business@mangayo.it</a> <br>
                        • Per assistenza: <br><a>Chat su WhatsApp</a>
                    </div>
                    <div>
                        <h3><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23px" height="24px"> <path fill-rule="evenodd" fill="rgb(0, 0, 0)" d="M22.365,5.653 C22.365,5.562 22.345,5.471 22.305,5.385 C22.224,5.213 22.068,5.096 21.897,5.061 L11.653,0.061 C11.487,-0.020 11.291,-0.020 11.125,0.061 L0.780,5.106 C0.579,5.203 0.448,5.405 0.438,5.633 L0.438,5.638 C0.438,5.643 0.438,5.648 0.438,5.658 L0.438,18.321 C0.438,18.554 0.569,18.766 0.780,18.868 L11.125,23.914 C11.130,23.914 11.130,23.914 11.135,23.919 C11.150,23.924 11.165,23.929 11.180,23.939 C11.185,23.939 11.190,23.944 11.200,23.944 C11.215,23.949 11.230,23.954 11.246,23.959 C11.251,23.959 11.256,23.964 11.261,23.964 C11.276,23.969 11.296,23.969 11.311,23.974 C11.316,23.974 11.321,23.974 11.326,23.974 C11.346,23.974 11.371,23.979 11.391,23.979 C11.412,23.979 11.437,23.979 11.457,23.974 C11.462,23.974 11.467,23.974 11.472,23.974 C11.487,23.974 11.507,23.969 11.522,23.964 C11.527,23.964 11.532,23.959 11.537,23.959 C11.552,23.954 11.567,23.949 11.582,23.944 C11.588,23.944 11.593,23.939 11.603,23.939 C11.618,23.934 11.633,23.929 11.648,23.919 C11.653,23.919 11.653,23.919 11.658,23.914 L22.033,18.852 C22.239,18.751 22.375,18.539 22.375,18.306 L22.375,5.668 C22.365,5.663 22.365,5.658 22.365,5.653 ZM11.386,1.280 L20.359,5.658 L17.054,7.273 L8.082,2.895 L11.386,1.280 ZM11.386,10.036 L2.414,5.658 L6.699,3.568 L15.671,7.946 L11.386,10.036 ZM1.645,6.635 L10.783,11.094 L10.783,22.395 L1.645,17.937 L1.645,6.635 ZM11.990,22.395 L11.990,11.094 L16.280,8.999 L16.280,11.954 C16.280,12.288 16.551,12.561 16.883,12.561 C17.215,12.561 17.487,12.288 17.487,11.954 L17.487,8.406 L21.158,6.615 L21.158,17.916 L11.990,22.395 Z"></path> </svg>
                            Spedizioni:</h3>
                        Spedizioni via corriere espresso GLS in 24/48 ore. Spedizione gratuita per gli ordini superiori a 39€ altrimenti il costo della spedizione è fisso a 5,50€.
                    </div>
                    <div>
                        <h3><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23px" height="17px"> <path fill-rule="evenodd" fill="rgb(0, 0, 0)" d="M15.465,13.670 L5.785,13.670 L5.785,14.918 C5.785,15.750 4.893,16.269 4.183,15.854 L0.665,13.798 C-0.046,13.382 -0.045,12.341 0.665,11.926 L4.183,9.870 C4.895,9.454 5.785,9.976 5.785,10.806 L5.785,12.054 L15.465,12.054 C18.307,12.054 20.620,9.713 20.620,6.836 C20.620,3.958 18.307,1.617 15.465,1.617 L11.953,1.617 C11.512,1.617 11.154,1.256 11.154,0.809 C11.154,0.363 11.512,0.001 11.953,0.001 L15.465,0.001 C19.188,0.001 22.216,3.067 22.216,6.836 C22.216,10.604 19.188,13.670 15.465,13.670 ZM8.400,1.617 L5.785,1.617 C5.344,1.617 4.986,1.256 4.986,0.809 C4.986,0.363 5.344,0.001 5.785,0.001 L8.400,0.001 C8.841,0.001 9.198,0.363 9.198,0.809 C9.198,1.256 8.841,1.617 8.400,1.617 Z"></path> </svg>
                            Resi e Rimborsi:</h3>
                        Ogni prodotto è controllato e imballato dal nostro team, si accettano resi in caso di comprovate motivazioni entro i 14 giorni.
                    </div>
                    <div>
                        <h3><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M22 3c.53 0 1.039.211 1.414.586s.586.884.586 1.414v14c0 .53-.211 1.039-.586 1.414s-.884.586-1.414.586h-20c-.53 0-1.039-.211-1.414-.586s-.586-.884-.586-1.414v-14c0-.53.211-1.039.586-1.414s.884-.586 1.414-.586h20zm1 8h-22v8c0 .552.448 1 1 1h20c.552 0 1-.448 1-1v-8zm-15 5v1h-5v-1h5zm13-2v1h-3v-1h3zm-10 0v1h-8v-1h8zm-10-6v2h22v-2h-22zm22-1v-2c0-.552-.448-1-1-1h-20c-.552 0-1 .448-1 1v2h22z"></path></svg>
                            Pagamenti:</h3>
                        Carte di credito: Visa, MasterCard, Paypal, Apple Pay
                    </div>
            </div>
            </div>

            <div id="modale2" class="modale2">
                <div class="modal-content2">
                    <span id="close-modal2">&times;</span>
                    <h2>Carrello</h2>
                    <p>Accedi per visualizzare i tuoi articoli nel carrello:</p>
                    <button id="accedi">Accedi</button>
            </div>

            </div>
            <div id="modale-menu" class="modale-menu">
            
                <div class="modal-content-menu">
                <span id="close-modal-menu">&times;</span>
                    <h2><img src="https://mangayo.it/modules/an_logo/img/d5721895b0230eef211ba65f3bdc34cf.svg" width="62" height="50" alt="Logo Mangayo">
                        </h2>
                    <div class="menu-items">
                    <span>novità</span>
                    <span>manga</span>
                    <span>giappone</span>
                    <span>figure</span>
                    <span>card game</span>
                    <span>preordini</span>
                    </div>
                    <a href="preferiti.php">lista desideri</a>
                    <button id="accedi-mobile">Accedi</button>
            </div>
            </div>

</body>
</html>
