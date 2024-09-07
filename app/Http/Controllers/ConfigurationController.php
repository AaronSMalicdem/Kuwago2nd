<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = Configuration::first();
    }

    public function index()
    {
        return view('admin.config');
    }

    public function editOrderNo(Request $request)
    {
        //
        $this->config->update([
            'order_no' => $request->order_no,
        ]);
        return back()->with('message', 'Successfully updated order number');
    }

    public function editReceiptNo(Request $request)
    {
        //
        $this->config->update([
            'receipt_no' => $request->receipt_no,
        ]);
        return back()->with('message', 'Successfully updated receipt number');
    }

    public function editTinNo(Request $request)
    {
        //
        $this->config->update([
            'tin_no' => $request->tin_no,
        ]);
        return back()->with('message', 'Successfully updated tin number');
    }

    public function editTip(Request $request)
    {
        //
        $this->config->update([
            'tip' => $request->tip,
        ]);
        return back()->with('message', 'Successfully updated tip');
    }

    public function editTakeOutCharge(Request $request)
    {
        $this->config->update([
            'take_out_charge' => $request->take_out_charge
        ]);

        return back()->with('message', 'Successfully updated take out charge');
    }

    public function editNetworkPrinter(Request $request)
    {
        $this->config->update([
            'network_printer'=> $request->network_printer,
        ]);

        return back()->with('message', 'Successfully updated network printer');
    }
}
