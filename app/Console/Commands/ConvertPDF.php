<?php

namespace App\Console\Commands;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\request as req;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
class ConvertPDF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-p-d-f';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $req= req::all();
        $pdf = PDF::loadView('pdf.req',['request'=>$req]);
        $pdf->save(storage_path('app/public/data.pdf'));
    
        // Kirim email dengan attachment PDF
       

    }
}
