<?php

namespace App\Http\Controllers\Api\Deploy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;


class DeployController extends Controller
{
    public function deploy(Request $request)
    {
        $githubPayload = $request->getContent();
        $githubHash = $request->header('X-Hub-Signature');

        $localToken = config('app.deploy_secret');
        $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);
        Log::info("githubpayload: ".$request['action']);
        Log::info("githubpayload: ".$githubPayload);
        Log::info("github name: ".$request['repository']['full_name']);


        if (hash_equals($githubHash, $localHash)) {
            $process = new Process(['/var/www/dev.api.uwagadzik.pl/deploy.sh']);
            $process->run(function ($type, $buffer) {
                echo $buffer;
            });
        }
    }
}
