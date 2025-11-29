<?php

// On part de la config fournie par le vendor
$config = require __DIR__ . '/vendor/umc/uutg/uutg.php.dist';

// Puis on surcharge juste ce qui nous intéresse
$config['namespace_strategy'] = function (string $fqcn) {
    // Tous les tests dans Tests\Domain
    return 'Tests\\Domain';
};

$config['test_method_prefix'] = 'test';
$config['use_test_attribute'] = true;

return $config;