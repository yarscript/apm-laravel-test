<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use PhilKra\ElasticApmLaravel\Facades\ElasticApm;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {

        $config = [
            'appName'     => 'Test',
//            'appVersion'  => '1.0.42',
            'serverUrl'   => 'http://10.0.4.227:8200',
//            'hostname' => 'ip-10-0-2-188'
//            'apmVersion' => '',
//            'secretToken' => 'DKKbdsupZWEEzYd4LX34TyHF36vDKRJP',
//            'hostname'    => 'node-24.app.network.com',
//            'env'         => ['DOCUMENT_ROOT', 'REMOTE_ADDR', 'REMOTE_USER'],
//            'cookies'     => ['my-cookie'],
//            'httpClient'  => [
//                'verify' => false,
//                'proxy'  => 'tcp://localhost:8125'
//            ],
        ];


//        Config::all();
        $agent = new \PhilKra\Agent($config);

        dump(((bool)$agent) ? 'Agent created' : 'Agent didn t create');

        $transaction = $agent->startTransaction('Test Transaction');

        dump(((bool)$transaction) ? 'Transact ceated' : 'Transact dedn t ceate');

        try {
            throw new \Exception('Test Exception');
        } catch (\Exception $exception) {
            $agent->captureThrowable($exception);
            $debug = true;
        }

        $agent->stopTransaction($transaction->getTransactionName());
        dump('Transation stoped');

        $test = $agent->send();
        dump('sended');

        $dbg = true;
    }
}
