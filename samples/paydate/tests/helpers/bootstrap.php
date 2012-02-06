<?php
/**
 * Test bootstrap, calls general setup to setup autoloader and loads a couple
 * of additional helper classes for tests
 */
require_once '../setup.php';

// Data provider helper
require_once BASE_PATH . '/tests/helpers/Providers.php';
// Mock payment type helper
require_once BASE_PATH . '/tests/helpers/PaymentMock.php';