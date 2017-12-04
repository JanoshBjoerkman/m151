$(document).ready(function() {
    // event for delete button
    $('#btn_delete_event').click(function() {

    });
});

function delete_event(event_id) {
    if (confirm("Der Event und alle dazugehörigen Kurse (inklusive Teilnehmerlisten) werden gelöscht.\nWollen Sie wirklich fortfahren?")) {
        $request = $.ajax({
            type: "POST",
            url: "manage/delete_event",
            data: { ID: event_id }
        });
        $request.done(function(response, textStatus, jqXHR) {
            alert(response);
        });
        $request.fail(function(jqXHR, textStatus, errorThrown) {
            alert("chlapf lauft hart nöd");
        });
    }
}