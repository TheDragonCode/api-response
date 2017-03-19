<?php
/**
 * @author  Andrey Helldar <helldar@ai-rus.com>
 *
 * @since   2017-02-20
 * @since   2017-03-08 Add statuses for user.
 * @since   2017-03-20 Replace codes to HTTP Codes.
 */
return array(
    1 => 'Unknown method!',
    2 => 'Unknown error!',
    3 => 'Access denied.',

    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    204 => 'No content',

    301 => 'Moved',
    302 => 'Found',
    304 => 'Not Modified',

    400 => 'Bad Request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not Found',
    409 => 'Conflict',

    500 => 'Internal Server Error',
    502 => 'Bad Gateway',
    503 => 'Service Unvailable',
);
