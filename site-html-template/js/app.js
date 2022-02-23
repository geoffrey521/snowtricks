//carousel
let items = document.querySelectorAll('.carousel .carousel-item');

items.forEach((el) => {
    const minPerSlide = 6;
    let next = el.nextElementSibling
    for (let i=1; i<minPerSlide; i++) {
        if (!next) {
            // wrap carousel by using first child
            next = items[0]
        }
        let cloneChild = next.cloneNode(true);
        el.appendChild(cloneChild.children[0])
        next = next.nextElementSibling
    }
});

// show medias responsive tablet and mobile
let mediasButton = document.getElementById('seeMediasBtn');
let trickMedias = document.getElementById('trickMedias');

mediasButton.addEventListener('click', function (event) {
    trickMedias.classList.toggle('mobile-hidden');
});
