<?php

namespace Mchervenkov\BnbFixing\Commands;
use Illuminate\Console\Command;
use Mchervenkov\BnbFixing\BnbFixing;

class SyncBnbFixings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bnb-fixing:sync-bnbfixing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get BNB fixings and saves it in database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('-> Sync BNB Fixings');

        try {

            $bnbFixing = new BnbFixing();
            $xmlContent = $bnbFixing->getXmlContent();
            $xml = new \SimpleXMLElement($xmlContent);

            foreach ($xml as $row) {
                if((int)$row->GOLD > 0) {
                    $rate = $row->RATE;
                    $reverseRate = $row->REVERSERATE;

                    if($rate && $reverseRate) {
                        $code = (string)$row->CODE;
                        $fixingData = [
                            'name' => (string)$row->NAME_,
                            'code' => $code,
                            'ratio' => (int)$row->RATIO,
                            'rate' => (string)$row->RATE,
                            'reverse_rate' => (string)$row->REVERSERATE,
                        ];

                        \Mchervenkov\BnbFixing\Models\BnbFixing::query()
                            ->updateOrCreate([
                                'code' => $code
                            ], $fixingData);
                    }
                }
            }

            $this->insertStaticExchangeRates();

            return 1;

        } catch (\Exception $e) {

            return 0;
        }
    }

    /**
     * @return void
     */
    protected function insertStaticExchangeRates() : void
    {
        $euro = \Mchervenkov\BnbFixing\Models\BnbFixing::query()
            ->where('code', 'EUR')
            ->first();

        $bgn = \Mchervenkov\BnbFixing\Models\BnbFixing::query()
            ->where('code', 'BGN')
            ->first();

        if(!$euro) {
            \Mchervenkov\BnbFixing\Models\BnbFixing::query()
                ->create([
                    'name' => 'Евро',
                    'code' => 'EUR',
                    'ratio' => 1,
                    'rate' => '1.95583',
                    'reverse_rate' => '0.511292',
                ]);
        }

        if(!$bgn) {
            \Mchervenkov\BnbFixing\Models\BnbFixing::query()
                ->create([
                    'name' => 'Лев',
                    'code' => 'BGN',
                    'ratio' => 1,
                    'rate' => 1,
                    'reverse_rate' => 1,
                ]);
        }
    }
}
