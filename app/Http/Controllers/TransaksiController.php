<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use PDF;
use App;
use App\Mail\DemoMail;
use App\Pribadi;
use App\Instansi;

class TransaksiController extends Controller
{
    //transaksi
    public function TableTransaksi()
    {
        $pribadi = Pribadi::orderBy('id', 'DESC')->paginate(10);
        $instansi = Instansi::orderBy('id', 'DESC')->paginate(10);
        return view('admin.TabelTransaksi', ['cek' => 'validasiTransaksi'], ['pribadi' => $pribadi,'instansi' => $instansi]);
    }

    public function view_tansaksi_pribadi($id)
    {
        $pribadi = Pribadi::find($id);
        return view('admin.viewTransaksiPribadi', ['cek' => 'validasiTransaksi'], ['pribadi' => $pribadi]);
    }

    public function view_tansaksi_instansi($id)
    {
        $instansi = Instansi::find($id);
        return view('admin.viewTransaksiInstansi', ['cek' => 'validasiTransaksi'], ['instansi' => $instansi]);
    }

    public function validasiPribadi($id, Request $request)
    {
        $pribadi = Pribadi::find($id);
        $pribadi -> validasi = $request->validasi;
        $pribadi -> save();

        // $pdf = PDF::loadView('PDF.DownloadTiketPribadi', ['pribadi' => $pribadi]);
        // $mail = new DemoMail($data);
        // $mail->attachData($pdf->output(),"Detail Invoice.pdf");
        
        // if($mail){
        //     Mail::to($pribadi -> email)->send($mail);
        // }

        return redirect('/TabelTransaksi');
    }
    public function validasiInstansi($id, Request $request)
    {
        $instansi = Instansi::find($id);
        $instansi -> validasi = $request->validasi;
        $instansi -> save();

        // $pdf = PDF::loadView('PDF.DownloadTiketInstansi', ['instansi' => $instansi]);
        // $mail = new DemoMail($data);
        // $mail->attachData($pdf->output(),"Detail Invoice.pdf");
        
        // if($mail){
        //     Mail::to($pribadi -> email)->send($mail);
        // }

        return redirect('/TabelTransaksi');
    }

    public function tolakValidasiPribadi($id)
    {
        $instansi = Pribadi::find($id);
        $instansi -> validasi = 'TOLAK TRANSAKSI';
        $instansi -> save();

        return redirect('/TabelTransaksi');
    }
    public function tolakValidasiInstansi($id)
    {
        $instansi = Instansi::find($id);
        $instansi -> validasi = 'TOLAK TRANSAKSI';
        $instansi -> save();

        return redirect('/TabelTransaksi');
    }

    public function mailSend()
    {
        $details = [
            'title' => 'Detail Pesanan',
            'body'=>'keterangan Pesanan'
        ];
        \Mail::to('yogievan400@gmail.com')
                ->send(new SendMail($details));
        return redirect('/BookingLog');
    }
}
