<?php
	require 'vendor/autoload.php';
        use Parse\ParseClient;
        ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8$
        use Parse\ParseObject;
        date_default_timezone_set('America/New_York');
        $testObject = ParseObject::create("TestObject");
        $testObject->set("foo", "bar");
        $testObject->save();
?>
