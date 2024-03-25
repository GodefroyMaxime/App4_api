<?php

namespace App\Service;

use App\Service\ApiAuthenticationService;

class WorkdayService
{
    public function __construct(private ApiAuthenticationService $api)
    {
    }

    public function test() {
        
        $decodedResponse = json_decode($this->api->fetchData('WD', 'TA_-_WB_-_Employee_List')->getContent());
        $reportEntries = $decodedResponse->Report_Entry;

        dd($reportEntries);
    }
}