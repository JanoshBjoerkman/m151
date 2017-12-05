$(document).ready(function() {
    // event for delete button
    $('#btn_delete_event').click(function() {

    });
});

function delete_event(event_id) {
    var dialog = confirm("Der Event und alle dazugehörigen Kurse (inklusive Teilnehmerlisten) werden gelöscht.\nWollen Sie wirklich fortfahren?");
    if (dialog == true) {
        $request = $.ajax({
            type: "POST",
            url: "manage/delete_event",
            data: { ID: event_id }
        });
        $request.done(function(response, textStatus, jqXHR) {
            refresh_events_table();
        });
        $request.fail(function(jqXHR, textStatus, errorThrown) {
            alert(textStatus);
        });
    } else {
        alert("Vorgang abgebrochen.");
    }
}

function refresh_events_table() {
    $request = $.ajax({
        type: "POST",
        url: "manage/refresh_events_table"
    });
    $request.done(function(response, textStatus, jqXHR) {
        $('#tbl_all_events').children('tbody').html(response);
    });
}