<?php

return [
    'token_secret' => env_config('TOKEN_SECRET', 'HLVFscA97YMRRlVyNMvueWIBIITX8Q11'),
    'token_ttl'    => env_config('TOKEN_TTL', 120),
    'token_algo'   => 'sha512',
];
