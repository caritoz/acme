<script type="text/javascript">
    /*
     * jQuery File Upload stuff
     * jQuery minicolors stuff
     */
    /* global $, window */
    if( $('#fileupload').length > 0 )
    {
        $(function () {
            'use strict';
            var jupload = $('#fileupload');
            var args = {id: $("input[name='id']").val(), album: $("input[name='album']").val()};
            // Initialize the jQuery File Upload widget:
            jupload.fileupload({
                // Uncomment the following to send cross-domain cookies:
                xhrFields: {withCredentials: true},
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                url: '/admin/uploads',
                formData: args
            });

            // from http://stackoverflow.com/a/21728472
            if (typeof existingfiles !== 'undefined'){
                jupload.fileupload('option', 'done').call(jupload, $.Event('done'), {result: existingfiles});
            };
        });
    }

    if( $('#fileuploadAlbum').length > 0 )
    {
        $(function () {
            'use strict';
            var jupload = $('#fileuploadAlbum');
            var args = {album: $("input[name='album']").val()};
            // Initialize the jQuery File Upload widget:
            jupload.fileupload({
                // Uncomment the following to send cross-domain cookies:
                xhrFields: {withCredentials: true},
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                url: '/admin/albums/uploads',
                formData: args
            });

            // from http://stackoverflow.com/a/21728472
            if (typeof existingfiles !== 'undefined'){
                jupload.fileupload('option', 'done').call(jupload, $.Event('done'), {result: existingfiles});
            };
        });
    }

</script>