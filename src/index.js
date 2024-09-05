import "../css/style.scss";

// Our modules / classes
import MobileMenu from "./modules/MobileMenu";
import HeroSlider from "./modules/HeroSlider";
//import GoogleMap from "./modules/GoogleMap";
import Search from "./modules/Search";
import MyNotes from "./modules/MyNotes";

// Instantiate a new object using our modules/classes

try {
  const mobileMenu = new MobileMenu();
  const heroSlider = new HeroSlider();
  const search = new Search();
  //const googleMap = new GoogleMap();
  const myNotes = new MyNotes();
} catch (error) {
  console.log(error);
}
