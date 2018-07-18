<?php

return [
    'hosts' => explode(',',env('ELASTICSEARCH_HOST','localhost:9200'))
];
