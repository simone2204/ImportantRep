function updateDate() {
    const today = new Date();
  
    const options = { 
                      weekday: 'long', 
                      year: 'numeric', 
                      month: 'long', 
                      day: 'numeric' 
                    };
    const formattedDate = today.toLocaleDateString('en-US', options);
  
    const dateElement = document.querySelector('#Date');
    if (dateElement) {
      dateElement.textContent = formattedDate;
    } else {
      console.error('Element with ID "Date" not found.');
    }
  }
updateDate();


const button = document.getElementById("readMore");
button.addEventListener("click", () =>{
  if(document.getElementById("paragraphs").style.visibility == "visible"){
    document.getElementById("paragraphs").style.visibility = "hidden";
    button.textContent = "read more";
    }
    else {
      document.getElementById("paragraphs").style.visibility = "visible";
      button.textContent = "reduce";
    }
});


const newContainer = document.createElement("div");
newContainer.classList.add("NewContainer");
newContainer.id = "newContainer";
const gamesContainer = document.getElementById("GamesContainer");
gamesContainer.parentNode.insertBefore(newContainer, gamesContainer);
const newElement = document.createElement("h1");
newElement.id = "newH1"
newElement.classList.add("new-h1");
newElement.textContent = "Click me to change the font-style";
document.getElementById("newContainer").append(newElement);


const button_2 = document.getElementById("newH1");
const button_3 = document.getElementById("title");
const fonts = ["Courier New","Cambria","Franklin Gothic Medium","Segoe UI","Georgia","Impact"];
let i = 0;
function changeFont() {
  i++;
  if (i >= fonts.length) i = 0;
  button_2.style.fontFamily = fonts[i];
  button_2.textContent = `This is '${fonts[i]}'`;
  button_3.style.fontFamily = fonts[i];
}
button_2.addEventListener("click", changeFont);


const image = document.getElementById("images");
const button_1 = document.getElementById("button");
const images = ["sport/sport.webp", "sport/conor.webp", "sport/tennis.jpg"];
let index = 0;
function switchImages() {
  index++;
  if (index >= images.length) index = 0;
  image.src = images[index];
}
setInterval(switchImages, 10000);
button_1.addEventListener("click", switchImages);


button_3.addEventListener("mouseover", () => {
  button_3.classList.add("hover");
});
button_3.addEventListener("mouseout", () => {
  button_3.classList.remove("hover");
});


const images_1 = document.querySelectorAll("img");
images_1.forEach(image => {
  image.addEventListener("mouseover", () => {
    const dataAttr = image.getAttribute("data-category");
    console.log(`${dataAttr}`);
    image.style.opacity='0.8';
  });
  image.addEventListener("mouseout", () => {
    image.style.opacity='1.0';
  });
});


const image_2 = document.querySelector("#Container-3 img");
image_2.addEventListener("click", () => {
  const modal = document.createElement("div");
  modal.classList.add("modal-view");

  const modalImage = document.createElement("img");
  modalImage.src = image_2.src;
  modalImage.alt = image_2.alt;
  
  modal.appendChild(modalImage);
  document.body.appendChild(modal);
  modal.addEventListener("click", () => {
    document.body.removeChild(modal);
  });
});


document.addEventListener("DOMContentLoaded", () => {
  loadHeadArticle();
  loadArticles();
});


function loadHeadArticle() {
  const h1 = document.getElementById("header-1");
  const p = document.getElementById("paragrafo");
  const sp = document.getElementById("sottoParagrafo");
  const image = document.getElementById("IMG-1");

  if (!h1 || !p || !sp || !image) {
    console.error("One or more required elements are missing.");
    return;
  }

  h1.textContent = "Loading....";
  p.textContent = "Loading...";
  sp.textContent = "loading...";
  image.textContent = "Loading image...";

  fetch('http://127.0.0.1/Projects/News_.php')
  .then(response => response.json())
  .then(data => {
    console.log("First fetch data:", data);

    if (data.title && data.abstract && data.lead_paragraph) {
      h1.textContent = data.title;
      p.textContent = data.abstract;
      sp.textContent = data.lead_paragraph;

      if (data.img) {
        const img = document.createElement("img");
        img.src = data.img;
        img.alt = "Article image";
        img.classList.add("img-api");
        image.innerHTML = "";
        image.appendChild(img);
      } else {
        image.textContent = "No image available";
      }
    } else {
      h1.textContent = "Error loading article";
      p.textContent = "Error loading article";
      sp.textContent = "Error loading article";
    }
  })
  .catch(error => {
    console.error("Error fetching data:", error);
    h1.textContent = "Request error...";
    p.textContent = "Request error...";
    sp.textContent = "Request error...";
  });
}


function loadArticles() {
  fetch('http://127.0.0.1/Projects/News.php')
  .then(response => response.json())
  .then(data => {
    console.log(data);
    if (Array.isArray(data) && data.length > 0) {
      
      document.getElementById("articles-container").innerHTML = "";

      data.forEach((article) => {
        const articleDiv = document.createElement("div");
        articleDiv.classList.add("article");

        articleDiv.innerHTML = `
          <h1>${article.title}</h1>
          <p>${article.abstract}</p>
          ${article.img ? `<img src="${article.img}" alt="Article image">` : "<p>No image available</p>"}`;

        saveArticle(article.title)
        .then(articleId => {
          console.log("Articolo salvato. ID dell'articolo:", articleId);

          articleDiv.innerHTML += `
            <br><button class="comment" dataArticle="${articleId}">Share a comment on this article</button>
            <span class="likeIcon" dataArticle="${articleId}">👍</span>
            <span class="likeCount" id="likeArticle${articleId}">0</span>
          `;
          
          document.getElementById("articles-container").appendChild(articleDiv);
          console.log(`Articolo "${article.title}" con ID: ${articleId} è stato aggiunto alla pagina.`);
        })
        .catch(error => {
          console.error("Errore nel salvataggio dell'articolo:", error);
        });
      });
    }
  })
  .catch(error => {
    console.error("Error fetching data:", error);
    h1.textContent = "Request error...";
    p.textContent = "Request error...";
    sp.textContent = "Request error...";
  });
}


function saveArticle(title) {
  return new Promise((resolve, reject) => {
    fetch("http://127.0.0.1/Projects/save_article.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ 
        articleTitle: title,
      }),
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        resolve(data.article_id);
      } else {
        reject(data.message);
      }
    })
    .catch(error => {
      console.error("Errore nella richiesta:", error);
      reject(error);
    });
  });
}


document.addEventListener("click", (event) => {
  if (event.target.classList.contains("likeIcon")) {
    console.log("userEmail: ", userEmail);

    if (!userEmail) {
      alert("Devi essere loggato per mettere like!");
      return;
    }

    const articleId = event.target.getAttribute("dataArticle");
    console.log("articleId", articleId);
    if (!articleId) {
      console.error("articleId non trovato");
      return;
    }

    const likeCountElement = document.getElementById(`likeArticle${articleId}`);
    if (!likeCountElement) {
      console.error(`Elemento con ID likeArticle${articleId} non trovato`);
      return;
    }

    fetch("http://127.0.0.1/Projects/like.php", {
      method: "POST",
      body: JSON.stringify({ articleId: articleId }),
      headers: { "Content-Type": "application/json" },
      credentials: "include"
    })
    .then(response => {
      if (!response.ok) {
        throw new Error(`Errore HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      console.log("Risposta del server:", data);
      if (data.success) {
        likeCountElement.textContent = data.likeCount;
        console.log("Like aggiornato:", data);
      } else {
        alert(data.error);
        console.error("Errore aggiornamento like:", data.error);
      }
    })
    .catch(error => console.error("Errore nella richiesta:", error));
  }

  if (event.target.classList.contains("comment")) {
    if (!userEmail) {
      alert("Devi essere autenticato per commentare");
    } else {
      const articleId = event.target.getAttribute("dataArticle");
      if (articleId) {
        window.location.href = `../commentPage.php?articleId=${articleId}`;
      } else {
        console.error("articleId non trovato per il commento");
      }
    }
  }
});


document.addEventListener("DOMContentLoaded", () => {  
  setTimeout(() => {
    fetch("http://127.0.0.1/Projects/get_likes.php", { credentials: "include" })
      .then(response => response.json())
      .then(data => {
        console.log("Dati ricevuti da get_likes.php:", data);

        if (data.success) {

          data.likedArticles.forEach(articleId => {
            const likeIcon = document.querySelector(`.likeIcon[dataArticle="${articleId}"]`);
            if (likeIcon) {
              likeIcon.style.color = "blue";
            } else {
              console.warn(`Icona like non trovata per articolo ${articleId}`);
            }
          });

          data.likedArticles.forEach(articleId => {
            const likeCountElement = document.getElementById(`likeArticle${articleId}`);
            if (likeCountElement) {
              likeCountElement.textContent = data.likeCounts[articleId];
            } else {
              console.warn(`Elemento per likeCount non trovato per articolo ${articleId}`);
            }
          });
        } else {
          console.error("Errore: non è stato possibile recuperare i dati dei like.");
        }
      })
      .catch(error => console.error("Errore nel recupero dei like:", error));
  }, 2000);
});