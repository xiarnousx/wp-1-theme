import $ from "jquery";

class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    $(".delete-note").on("click", this.deleteNote);
    $(".edit-note").on("click", this.editNote.bind(this));
    $(".update-note").on("click", this.updateNote.bind(this));
  }

  deleteNote(e) {
    const note = $(e.target).parents("li");
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: universityData.root_url + "/wp-json/wp/v2/note/" + note.data("id"),
      type: "DELETE",
      success: (response) => {
        note.slideUp();
      },
      error: (response) => {},
    });
  }

  editNote(e) {
    const note = $(e.target).parents("li");
    if (note.data("state") === "editable") {
      this.makeNoteReadonly(note);
    } else {
      this.makeNoteEditable(note);
    }
  }

  makeNoteEditable(note) {
    note
      .find(".edit-note")
      .html(`<i class="fa fa-times" aria-hidden="true"></i> Cancel`);
    note
      .find(".note-title-field,.note-body-field")
      .removeAttr("readonly")
      .addClass("note-active-field");
    note.find(".update-note").addClass("update-note--visible");
    note.data("state", "editable");
  }

  makeNoteReadonly(note) {
    note
      .find(".edit-note")
      .html(`<i class="fa fa-pencil" aria-hidden="true"></i> Edit`);
    note
      .find(".note-title-field,.note-body-field")
      .attr("readonly", true)
      .removeClass("note-active-field");

    note.find(".update-note").removeClass("update-note--visible");
    note.data("state", "cancel");
  }

  updateNote(e) {
    const note = $(e.target).parents("li");
    const data = {
      title: note.find(".note-title-field").val(),
      content: note.find(".note-body-field").val(),
    };
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: universityData.root_url + "/wp-json/wp/v2/note/" + note.data("id"),
      type: "POST",
      data,
      success: (response) => {
        this.makeNoteReadonly(note);
      },
      error: (response) => {},
    });
  }
}

export default MyNotes;
