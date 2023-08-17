<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use App\Models\Gateway;
use Illuminate\Http\Request;


class PaymentMethodController extends Controller
{
    use Upload;
    public function index(Gateway $gateway)
    {
        $data['methods'] = Gateway::automatic()->orderBy('sort_by', 'asc')->get();
        $data['page_title'] = 'Payment Methods';
        return view('admin.payment_methods.index', $data);
    }

    public function sortPaymentMethods(Request $request, Gateway $gateway)
    {
        $data = $request->all();
        foreach ($data['sort'] as $key => $value) {
            Gateway::where('code', $value)->update([
                'sort_by' => $key + 1
            ]);
        }
    }

    public function deactivate(Request $request)
    {
        $data = Gateway::where('code', $request->code)->firstOrFail();

        if ($data->status == 1) {
            $data->status = 0;
        } else {
            $data->status = 1;
        }
        $data->save();

        return back()->with('success', 'Updated Successfully.');
    }

    public function edit($id)
    {
        $data['method'] = Gateway::findOrFail($id);
        $data['page_title'] = 'Edit Payment Methods';
        return view('admin.payment_methods.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'currency' => 'required',
            'currency_symbol' => 'required',
            'minimum_deposit_amount' => 'required|numeric',
            'maximum_deposit_amount' => 'required|numeric',
            'percentage_charge' => 'required|numeric',
            'fixed_charge' => 'required|numeric',
            'convention_rate' => 'required|numeric',
        ];

        $getGateway = Gateway::findOrFail($id);
        $parameters = [];
        foreach ($request->except('_token', '_method', 'image') as $k => $v) {
            foreach ($getGateway->parameters as $key => $cus) {
                if ($k != $key) {
                    continue;
                } else {
                    $rules[$key] = 'required|max:191';
                    $parameters[$key] = $v;
                }
            }
        }
        $this->validate($request, $rules);


        if ($request->hasFile('image')) {
            try {
                $old = $getGateway->image ?: null;
                $image = $this->uploadImage($request->image, config('location.gateway.path'), config('location.gateway.size'), $old);
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }


        try {
            $res = $getGateway->update([
                'currency' => $request->currency,
                'symbol' => $request->currency_symbol,
                'convention_rate' => $request->convention_rate,
                'min_amount' => $request->minimum_deposit_amount,
                'max_amount' => $request->maximum_deposit_amount,
                'percentage_charge' => $request->percentage_charge,
                'fixed_charge' => $request->fixed_charge,
                'parameters' => $parameters,
                'image' => $image ?? $getGateway->image,
                'status' => $request->status
            ]);

            if (!$res) {
                throw new \Exception('Unexpected error! Please try again.');
            }
            return back()->with('success', 'Gateway data has been updated.');

        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

    }
}
