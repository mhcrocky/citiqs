<?php
    define('HOSTNAME', 'localhost');
    define('USERNAME', 'root');
    define('PASSWORD', '');
    define('DATABASE', 'tiqs');


    defined('VISMA_client_id')      OR define('VISMA_client_id', 'reviewmedia');
    defined('VISMA_flow')      OR define('VISMA_flow', 'Code Flow');
    defined('VISMA_secret')      OR define('VISMA_secret', '4305mXa84olnp335EHQIprH57Zf5OS212x1v1N7BqTxZeeMY58VUlV52nj5yY21');
    defined('VISMA_redirect')      OR define('VISMA_redirect', 'http://localhost/tiqs_alfred/visma');
    defined('VISMA_scope')      OR define('VISMA_scope', 'offline_access ea:api ea:sales ea:accounting ea:purchase');
    defined('VISMA_SANDBOX_DEBUG_MODE')      OR define('VISMA_SANDBOX_DEBUG_MODE', TRUE);


    const EXACT_RETURN = 'http://localhost/tiqs_alfred/exact';
    const EXACT_CLIENT = 'b6b5b673-b871-4eb5-b465-a85053494dae';
    const EXACT_SECRET = 'GP0xMeNsEJiW';