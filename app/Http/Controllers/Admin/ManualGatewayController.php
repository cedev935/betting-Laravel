<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ManualGatewayController extends Controller
{
    use Upload;

    public function index(Gateway $gateway)
    {
        $data['methods'] = Gateway::manual()->orderBy('sort_by', 'asc')->get();
        $data['page_title'] = 'Payment Methods';
        return view('admin.payment_methods.manual.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Payment Methods';
        return view('admin.payment_methods.manual.create', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'currency' => 'required',
            'minimum_deposit_amount' => 'required|numeric',
            'maximum_deposit_amount' => 'required|numeric',
            'percentage_charge' => 'required|numeric',
            'fixed_charge' => 'required|numeric',
            'convention_rate' => 'required|numeric',
        ];


        $this->validate($request, $rules);

        $getGateway = new Gateway();
        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {
                $arr = array();
                $arr['field_name'] = clean($request->field_name[$a]);
                $arr['field_level'] = $request->field_name[$a];
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }

        if ($request->hasFile('image')) {
            try {
                $getGateway->image = $this->uploadImage($request->image, config('location.gateway.path'), config('location.gateway.size'));
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        try {
            $getGateway->name = $request->name;
            $getGateway->code = Str::slug($request->name);
            $getGateway->currency = $request->currency;
            $getGateway->symbol = $request->currency;
            $getGateway->convention_rate = $request->convention_rate;
            $getGateway->min_amount = $request->minimum_deposit_amount;
            $getGateway->max_amount = $request->maximum_deposit_amount;
            $getGateway->percentage_charge = $request->percentage_charge;
            $getGateway->fixed_charge = $request->fixed_charge;
            $getGateway->parameters = $input_form;
            $getGateway->status = $request->status;
            $getGateway->note = $request->note;
            $res = $getGateway->save();
            if (!$res) {
                throw new \Exception('Unexpected error! Please try again.');
            }
            return back()->with('success', 'Gateway data has been saved.');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

    }

    public function edit($id)
    {
        $data['method'] = Gateway::findOrFail($id);
        $data['page_title'] = 'Edit Payment Methods';
        return view('admin.payment_methods.manual.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'currency' => 'required',
            'minimum_deposit_amount' => 'required|numeric',
            'maximum_deposit_amount' => 'required|numeric',
            'percentage_charge' => 'required|numeric',
            'fixed_charge' => 'required|numeric',
            'convention_rate' => 'required|numeric'
        ];


        $getGateway = Gateway::findOrFail($id);

        if(1000 > $getGateway->id){
            return back()->with('error', 'Invalid Gateways Request');
        }

        $this->validate($request, $rules);


        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {
                $arr = array();
                $arr['field_name'] = clean($request->field_name[$a]);
                $arr['field_level'] = $request->field_name[$a];
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }




        if ($request->hasFile('image')) {
            try {
                $old = $getGateway->image ?? null;
                $getGateway->image = $this->uploadImage($request->image, config('location.gateway.path'), config('location.gateway.size'), $old);
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }


        try {
            $getGateway->name = $request->name;
            $getGateway->currency = $request->currency;
            $getGateway->symbol = $request->currency;
            $getGateway->convention_rate = $request->convention_rate;
            $getGateway->min_amount = $request->minimum_deposit_amount;
            $getGateway->max_amount = $request->maximum_deposit_amount;
            $getGateway->percentage_charge = $request->percentage_charge;
            $getGateway->fixed_charge = $request->fixed_charge;
            $getGateway->parameters = $input_form;
            $getGateway->status = $request->status;
            $getGateway->note = $request->note;
            $res = $getGateway->save();
            if (!$res) {
                throw new \Exception('Unexpected error! Please try again.');
            }
            return back()->with('success', 'Gateway data has been updated.');

        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

    }

}
