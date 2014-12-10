<?php

// Our test class.
class TddTests extends PHPUnit_Framework_TestCase {
    public function test_tdd_help() {
        // Arbritary function to ensure Drupal is bootstrapped properly.
        $this->assertEquals(check_plain("test"), "test");
        // This a core function that queries the database. We run this just as a test
        // to ensure that the database is connected
        print_r(_dblog_get_message_types());
    }
}
