<script src="{{ URL::asset('/assets/js/tmpl.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/moment.js') }}"></script>

<script src="{{ URL::asset('/assets/js/plugins/bootstrap-dialog/bootstrap-dialog.min.js') }}"></script>

<script src="{{ URL::asset('/assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>

<script src="{{ URL::asset('/assets/js/plugins/datetimepicker/moment.js') }}"></script>
<script src="{{ URL::asset('/assets/js/plugins/datetimepicker/bootstrap-datetimepicker.js') }}"></script>

<script src="{{ URL::asset('/assets/js/plugins/blueimp/load-image/load-image.min.js') }}"></script>

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="{{ URL::asset('/assets/js/plugins/blueimp/file-upload/jquery.iframe-transport.js') }}"></script>
<!-- The basic File Upload plugin -->
<script src="{{ URL::asset('/assets/js/plugins/blueimp/file-upload/jquery.fileupload.js') }}"></script>
<!-- The File Upload processing plugin -->
<script src="{{ URL::asset('/assets/js/plugins/blueimp/file-upload/jquery.fileupload-process.js') }}"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="{{ URL::asset('/assets/js/plugins/blueimp/file-upload/jquery.fileupload-image.js') }}"></script>
<!-- The File Upload validation plugin -->
<script src="{{ URL::asset('/assets/js/plugins/blueimp/file-upload/jquery.fileupload-validate.js') }}"></script>

<script src="{{ URL::asset('/assets/js/plugins/blueimp/file-upload/jquery.fileupload-ui.js') }}"></script>

<script type="text/javascript">
$(function() {

    // Confirm deleting resources
    $("form[data-confirm]").submit(function() {
        if ( ! confirm($(this).attr("data-confirm"))) {
            return false;
        }
    });

    var panelList = $('#draggablePanelList');
    panelList.sortable({
        // Only make the .panel-heading child elements support dragging.
        // Omit this to make the entire <li>...</li> draggable.
        handle: '.thumbnail',
        update: function() {
            $('.panel', panelList).each(function(index, elem) {
                var $listItem = $(elem),
                    newIndex = $listItem.index();

                // Persist the new indices.
            });
        }
    });

    //bootstrap WYSIHTML5 - text editor
    $(".wysihtml5").wysihtml5({
        "image": false
    });

    $('#datetimepicker_work_date').datetimepicker({
        pickTime: false
    });

    $('#datetimepicker1').datetimepicker({
        pickTime: false
    });
    $('#datetimepicker2').datetimepicker({
        pickTime: false
    });
    $("#datetimepicker1").on("dp.change",function (e) {
        $('#datetimepicker2').data("DateTimePicker").setMinDate(e.date);
    });
    $("#datetimepicker2").on("dp.change",function (e) {
        $('#datetimepicker1').data("DateTimePicker").setMaxDate(e.date);
    });
});
function saveOrder() {
    var articleorder="";
    $("#draggablePanelList li").each(function(i) {
        if (articleorder=='')
            articleorder = $(this).attr('data-article-id');
        else
            articleorder += "," + $(this).attr('data-article-id');
    });
    //articleorder now contains a comme seperated list of the ID's of the articles in the correct order.
    $.post('/admin/orders', { order: articleorder })
        .success(function(data) {
            notificationSuccess(data.message);
        })
        .error(function(data) {
            alert('Error: ' + data);
            notificationError(data.message);
        });
};
</script>

@include('admin.layouts.footer-js-upload')