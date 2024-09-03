import $ from "jquery";

export default class Search {
  //1. inistantiate
  constructor() {
    this.addSearchHtml();
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.resultsDiv = $("#search-overlay__results");
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.typingTimer;
    this.previousValue;
    this.events();
  }

  // 2. events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
  }

  // 3. methods and functions
  typingLogic(e) {
    if (this.searchField.val() === this.previousValue) return;
    clearTimeout(this.typingTimer);
    if (this.searchField.val()) {
      if (!this.isSpinnerVisible) {
        this.resultsDiv.html('<div class="spinner-loader"></div>');
        this.isSpinnerVisible = true;
      }
      this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      this.previousValue = this.searchField.val();
    } else {
      this.resultsDiv.html("");
      this.isSpinnerVisible = false;
    }
  }

  getResults() {
    $.getJSON(
      universityData.root_url +
        "/wp-json/university/v1/search?term=" +
        this.searchField.val(),
      (results) => {
        this.resultsDiv.html(`
        <div class="row">
        <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${
              results.generalInfo.length === 0
                ? "<p>No general information matches result</p>"
                : ""
            }
            <ul class="link-list min-list" >   
                        ${results.generalInfo
                          .map(
                            (item) =>
                              `<li><a href="${item.permalink}">${
                                item.title
                              }</a> ${
                                item.postType === "post"
                                  ? "by " + item.authorName
                                  : ""
                              }</li>`
                          )
                          .join("")}
                    </ul>
        </div>
        <div class="one-third">
            <h2 class="search-overlay__section-title">Programs</h2>
              ${
                results.programs.length === 0
                  ? `<p>No programs matche result <a href='${universityData.root_url}/programs'>Viewl all programs</a> </p>`
                  : ""
              }
            <ul class="link-list min-list" >   
                        ${results.programs
                          .map(
                            (item) =>
                              `<li><a href="${item.permalink}">${item.title}</a></li>`
                          )
                          .join("")}
                    </ul>
            <h2 class="search-overlay__section-title">Professors</h2>
              ${
                results.professors.length === 0
                  ? `<p>No professors match results </p>`
                  : ""
              }
            <ul class="professor-cards" >   
                        ${results.professors
                          .map(
                            (item) =>
                              `
                                <li class="professor-card__list-item">
                                    <a class="professor-card" href="${item.permalink}">
                                    <img class="professor-card__image" src="${item.image}" />
                                    <span class="professor-card__name">${item.title}</span>
                                    </a>
                                </li>
                            `
                          )
                          .join("")}
                    </ul>
        </div>
        <div class="one-third">
        <h2 class="search-overlay__section-title">Campuses</h2>
          ${
            results.campuses.length === 0
              ? `<p>No campuses matche result <a href='${universityData.root_url}/campuses'>Viewl all campuses</a> </p>`
              : ""
          }
        <ul class="link-list min-list" >  
                        ${results.campuses
                          .map(
                            (item) =>
                              `<li><a href="${item.permalink}">${item.title}</a></li>`
                          )
                          .join("")}
                    </ul>
        <h2 class="search-overlay__section-title">Events</h2>
            ${
              results.events.length === 0
                ? `<p>No events match result <a href='${universityData.root_url}/events'>Viewl all events</a> </p>`
                : ""
            }
            ${results.events
              .map(
                (item) => `
            <div class="event-summary">
            <a class="event-summary__date t-center" href="${item.permalink}">
                <span class="event-summary__month">${item.month}</span>
                <span class="event-summary__day">${item.day}</span>
            </a>
            <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                <p>${item.description}<a href="${item.permalink}" class="nu gray">Learn more</a></p>
            </div>
            </div>
            `
              )
              .join("")}
        </div>
        </div>    
        `);
        this.isSpinnerVisible = false;
      }
    );
  }

  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.isOverlayOpen = true;
    this.searchField.val("");
    setTimeout(() => this.searchField.trigger("focus"), 301);
    return false;
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.isOverlayOpen = false;
  }

  keyPressDispatcher(e) {
    if (
      e.keyCode === 83 &&
      !this.isOverlayOpen &&
      !$("input, textarea").is(":focus")
    )
      return this.openOverlay();
    if (
      e.keyCode === 27 &&
      this.isOverlayOpen &&
      !$("input, textarea").is(":focus")
    )
      return this.closeOverlay();
  }

  addSearchHtml() {
    const overlay = `
                <div class="search-overlay">
                <div class="search-overlay__top">
                    <div class="container">
                    <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                    <input id="search-term" class="search-term" placeholder="What are you looking for" autofocus />
                    <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="container">
                    <div id="search-overlay__results"></div>
                </div>
                </div>
        `;
    $("body").append(overlay);
  }
}
