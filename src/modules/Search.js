import $, { post } from 'jquery';

export default class Search {
    //1. inistantiate
    constructor() {
        this.addSearchHtml()
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
            this.resultsDiv.html('');
            this.isSpinnerVisible = false;
        }

    }

    getResults() {
        const posts = universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val();
        const pages = universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val();
        $.when($.getJSON(posts), $.getJSON(pages)).then((posts, pages) => {
            const combined = posts[0].concat(pages[0]);
            let items = `
                <p>
                    No general information matches search words.
                </p>
                `;
            if (combined.length) {
                items = `
                    <ul class="link-list min-list" >   
                        ${combined.map((item) => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                    </ul>
                    `;
            }
            const html = `
                    <h2 class="search-overlay__section-title" >General Information</h2>
                    ${items}
                `;
            this.resultsDiv.html(html);
            this.isSpinnerVisible = false;
        }, () => {
            this.resultsDiv.html('<p>Something went wrong!</p>');
        });
    }

    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        this.isOverlayOpen = true;
        this.searchField.val('');
        setTimeout(() => this.searchField.trigger("focus"), 301);
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.isOverlayOpen = false;
    }

    keyPressDispatcher(e) {
        if (e.keyCode === 83 && !this.isOverlayOpen && !$("input, textarea").is(":focus")) return this.openOverlay();
        if (e.keyCode === 27 && this.isOverlayOpen && !$("input, textarea").is(":focus")) return this.closeOverlay();
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
