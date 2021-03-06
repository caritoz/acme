<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Session prefix name
    |--------------------------------------------------------------------------
    |
    | This will be used to prefix flash messages.
    |
    */
    'session_prefix'                        => 'notifications_',

    /*
    |--------------------------------------------------------------------------
    | Default container name
    |--------------------------------------------------------------------------
    |
    | This name will be used to name default container (when calling it with null value).
    |
    */
    'default_container'                     => 'default',

    /*
    |--------------------------------------------------------------------------
    | Default message format
    |--------------------------------------------------------------------------
    |
    | This format will be used when no format is specified.
    | Specify default format for each container.
    | Available place holders:
    |
    | :type - type of message (error, warning, info, success).
    | :message - message text.
    |
    */
    'default_format'                        => array(
        'default'               => '<div class="alert-acme"><div class="alert alert-:type alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    <b>:message</b></div></div>',

    ),

    /*
    |--------------------------------------------------------------------------
    | Default message formats for types and container types
    |--------------------------------------------------------------------------
    |
    | These formats can override default format for each type of message (error, warning, info, success).
    | You can set formats for each container by using this syntax:
    |
    | 'default_formats'         => array(
    |       'myContainer'   => array(
    |           'info'  => ':key - :message'
    |       )
    |   )
    |
    | Available place holders:
    |
    | :type - type of message (error, warning, info, success).
    | :message - message text.
    |
    */
    'default_formats'                       => array(

        'default'               => array(
            'error'             => '<div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>:message</div>'
        ),

    ),

    /*
    |--------------------------------------------------------------------------
    | Default message types available in containers
    |--------------------------------------------------------------------------
    |
    | Specify available types for each container.
    |
    */
    'default_types'                         => array(

        'default'               => array('info', 'success', 'warning', 'error'),

    ),

);
