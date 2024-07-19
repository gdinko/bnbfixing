<?php

use Mchervenkov\BnbFixing\BnbFixing;

test('setup default bnbfixing object', function () {

    $xmlUrl = env('BNB_XML_URL');

    config(['bnb_fixing.xml_url' => $xmlUrl]);

    $bnbFixing = new BnbFixing();

    expect($bnbFixing)->toBeInstanceOf(BnbFixing::class);

    $defaultBaseUrl = config('bnb_fixing.xml_url');

    expect($bnbFixing->getUrl())->toEqual($defaultBaseUrl);
});
