import '../component/bslider/index'

const categorySlider = document.getElementById("category-slider");
const recipeSlider = document.getElementById("recipe-slider");

createSlider(categorySlider, "category-slider-item");
createSlider(recipeSlider, "recipe-slider-item");