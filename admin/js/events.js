$("#start-datetime").keyup(function() {
    var endDate = Date.parse($("#start-datetime").val()+":00").add(3).hours().toString("yyyy-MM-ddTHH:mm");
    var onlineEndDate = Date.parse($("#start-datetime").val()+":00").add(-1).days().toString("yyyy-MM-ddTHH:mm");
    $("#end-datetime").val(endDate);
    $("#online-end-datetime").val(onlineEndDate);
});

$("#form-event-tags, #form-event-chair, #form-add-event-attendees, #form-delete-event-attendees, #form-add-override-hours, #form-delete-override-hours, #form-delete-other-attendees").chosen({
    placeholder_text_single: " ",
    placeholder_text_multiple: " ",
    display_disabled_options: false,
    search_contains: true,
});

$('.online-signups-checkbox').change(function() {
    $(".online-signups").toggle(this.checked);
});