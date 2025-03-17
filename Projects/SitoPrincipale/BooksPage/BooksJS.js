document.addEventListener("DOMContentLoaded", () => {
    fetchBooks();
})

function fetchBooks() {
    const url = 'http://127.0.0.1/Projects/Books.php';

    fetch(url)
    .then(response => {
        if (!response.ok) throw new Error('Network response is not ok...');
        return response.json();
    })
    .then(data => {
        console.log(data);
        if(data.error) {
            console.error('Error: ', data.error);
            displayError(data.error);
        } else {
            displayBooks(data);
        }
    })
    .catch(error => {
        console.error('Error fetching books:', error);
    })
}

function displayBooks(books) {
    const container = document.getElementById('Container-1');
    container.innerHTML = '';

    if (books.length === 0) { 
        displayError('No book found');
        return ;
    }

    books.forEach(book => {
        const li = document.createElement('li');
        const img = document.createElement("img");
        img.src = book.book_image || 'default_image.jpg';
        img.alt = `Cover of ${book.title}`;

        const text = document.createElement("p");
        text.textContent = `${book.title} by ${book.author}`;

        li.appendChild(img);
        li.appendChild(text);

        container.appendChild(li);
    });
}