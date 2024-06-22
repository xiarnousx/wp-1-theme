import $ from 'jquery';

export default class Search {
    //1. inistantiate
    constructor() {
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
            this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
            this.previousValue = this.searchField.val();
        } else {
            this.resultsDiv.html('');
            this.isSpinnerVisible = false;
        }

    }

    getResults() {
        this.resultsDiv.html("Imagine!");
        this.isSpinnerVisible = false;
    }

    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        this.isOverlayOpen = true;
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
}
