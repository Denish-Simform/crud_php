let slideIndex = 1;
showSlides(slideIndex);
function plusSlides(n) {
    showSlides(slideIndex += n);
}
function currentSlide(n) {
    showSlides(slideIndex = n);
}
function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("img-slide");
    let dots = document.getElementsByClassName("dot");
    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}
function scrollHide(link) {
    const collection = document.getElementsByClassName('section_toggle');
    for (const col of collection) {
        if (link == 'home') {
            col.classList.remove("hide");
        } else {
            if (!col.classList.contains(link)) {
                col.classList.add("hide");
            }
            if (col.classList.contains(link)) {
                col.classList.remove("hide");
            }
        }
    }
}