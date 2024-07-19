<?php

it('Inert Fixings into database', function () {

    $xmlUrl = env('BNB_XML_URL');
    config(['bnb_fixing.xml_url' => $xmlUrl]);

    $this->artisan('bnb-fixing:sync-bnbfixing')->assertExitCode(1);
});
