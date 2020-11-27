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
        Log::info("Wchodze na deploy Controller");
        $githubPayload = $request->getContent();
        $githubHash = $request->header('X-Hub-Signature');

        $localToken = config('app.deploy_secret');
        Log::info("local token: ".$localToken);
        $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);
        Log::info("local hash: ".$localHash);
        Log::info("github hash: ".$githubHash);


        if (hash_equals($githubHash, $localHash)) {
            $root_path = base_path();
            $process = new Process('cd ' . $root_path . '; ./deploy.sh');
            $process->run(function ($type, $buffer) {
                echo $buffer;
            });
        }
    }
}
