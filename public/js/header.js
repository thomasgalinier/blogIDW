
const topArticle = document.getElementsByClassName("top");

const last = document.getElementsByClassName("last");
const categories = document.getElementsByClassName("categories")
const path = window.location.pathname
console.log(path);
if (path === '/top') {
    topArticle[0].classList.add("active");
    last[0].classList.remove("active");
    categories[0].classList.remove("active");
} else if(path === '/last/article'){
    topArticle[0].classList.remove("active");
    last[0].classList.add("active");
    categories[0].classList.remove("active");
} else if (path === '/categorie'){
    topArticle[0].classList.remove("active");
    last[0].classList.remove("active");
    categories[0].classList.add("active");
}else {
    topArticle[0].classList.remove("active");
    last[0].classList.remove("active");
    categories[0].classList.remove("active");
}
