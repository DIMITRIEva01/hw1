const params = new URLSearchParams(window.location.search);
const mangaQuery = params.get("query");
const userId = document.body.dataset.userid;
const contenitoreManga = document.getElementById("manga-container");

if (!mangaQuery || mangaQuery.length < 2) {
  contenitoreManga.textContent = "Inserisci almeno 2 caratteri per la ricerca.";
} else {
  fetch(`https://api.mangadex.org/manga?title=${encodeURIComponent(mangaQuery)}&limit=12&includes[]=cover_art`)
    .then(res => {
      if (!res.ok) {
        throw new Error(`Errore HTTP! Status: ${res.status}`);
      }
      return res.json();
    })
    .then(function (data) {
      if (!data.data || data.data.length === 0) {
        contenitoreManga.textContent = "Nessun manga trovato.";
        return;
      }

      contenitoreManga.innerHTML = "";

      data.data.forEach(function (manga) {
        const attr = manga.attributes;
        const title = Object.values(attr.title)[0] || "Senza titolo";
        const id = manga.id;

        // Trova la cover art
        const coverRel = manga.relationships.find(r => r.type === "cover_art");
        const coverUrl = coverRel
          ? `https://uploads.mangadex.org/covers/${id}/${coverRel.attributes.fileName}.256.jpg`
          : "img/no_cover.jpg";

        creaManga(coverUrl, title, id);
      });

      function creaManga(coverUrl, title, id) {
        const div = document.createElement("div");
        div.className = "articolo";
      
        // ❤️ Preferiti
        const cuore = document.createElement("div");
        cuore.className = "heart-icon";
        cuore.textContent = "🤍";
        cuore.addEventListener("click", function () {
          const isPreferito = cuore.classList.toggle("clicked");
          cuore.textContent = isPreferito ? "❤️" : "🤍";
      
          const formData = new FormData();
          formData.append("user_id", userId);
          formData.append("manga_id", id);
          formData.append("titolo", title);
          formData.append("copertina_url", coverUrl);
      
          fetch("gestione_preferito.php", {
            method: "POST",
            body: formData
          })
            .then(res => res.json())
            .then(data => {
              if (!data.ok) {
                console.error("Errore preferiti:", data.errore);
                cuore.classList.toggle("clicked");
                cuore.textContent = cuore.classList.contains("clicked") ? "❤️" : "🤍";
              }
            })
            .catch(err => {
              console.error("Errore di rete preferiti:", err);
              cuore.classList.toggle("clicked");
              cuore.textContent = cuore.classList.contains("clicked") ? "❤️" : "🤍";
            });
        });
      
        // 📚 Immagine
        const img = document.createElement("img");
        img.src = coverUrl;
        img.alt = title;
        img.width = 200;
        img.dataset.id_manga = id;
        img.onclick = function () {
          window.location.href = `dettagli.php?id=${encodeURIComponent(id)}`;
        };
      
        // 🖊️ Titolo
        const titolo = document.createElement("div");
        titolo.className = "titolo-articolo";
        titolo.textContent = title;
      
        // 💰 Prezzo casuale
        const prezzoValue = Math.round((Math.random() * (15 - 5) + 5) * 100) / 100;

        const prezzo = document.createElement("div");
        prezzo.className = "prezzo-articolo";
        prezzo.textContent = prezzoValue + " €";
      
        // 🛒 Bottone carrello
        const btnCarrello = document.createElement("div");
        btnCarrello.className = "button";
        btnCarrello.textContent = "Aggiungi al carrello";
        btnCarrello.addEventListener("click", function () {
          const formData = new FormData();
          formData.append("user_id", userId);
          formData.append("manga_id", id);
          formData.append("titolo", title);
          formData.append("copertina_url", coverUrl);
          formData.append('prezzo', prezzoValue);
      
          fetch("gestione_carrello.php", {
            method: "POST",
            body: formData
          })
            .then(res => res.json())
            .then(data => {
              if (data.ok) {
                alert("Aggiunto al carrello!");
              } else {
                throw new Error(data.errore || "Errore sconosciuto");
              }
            })
            .catch(err => {
              console.error("Errore carrello:", err);
              alert("Articolo gia presente nel carrello o errore di rete.");
            });
        });
      
        // Aggiungi elementi al div
        div.appendChild(cuore);
        div.appendChild(img);
        div.appendChild(titolo);
        div.appendChild(prezzo);
        div.appendChild(btnCarrello);
      
        // Aggiungi al contenitore principale
        contenitoreManga.appendChild(div);
      }
    })
      
    .catch(err => {
      console.error("Errore nella ricerca manga:", err);
      contenitoreManga.textContent = "Errore durante la ricerca. Riprova più tardi.";
});
}
