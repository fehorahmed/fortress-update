<?php

namespace App\Http\Controllers;

use App\Models\SmsLog;
use App\Models\SmsQuantity;
use App\Models\SmsTemplate;
use App\Models\Stakeholder;
use App\Models\TransactionLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function smsTemplate()
    {
        $smsTemplates = SmsTemplate::all();
        return view('sms.template.index', compact('smsTemplates'));
    }

    public function smsTemplateAdd()
    {
        return view('sms.template.add');
    }
    public function smsTemplateAddPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:warehouses',
            'text' => 'required',
            'status' => 'required'
        ]);

        $smsTemplate = new SmsTemplate();
        $smsTemplate->name = $request->name;
        $smsTemplate->text = $request->text;
        $smsTemplate->status = $request->status;
        $smsTemplate->save();

        return redirect()->route('sms.template')->with('message', 'SMS Template add successfully.');
    }

    public function smsTemplateEdit(SmsTemplate $smsTemplate)
    {
        return view('sms.template.edit', compact('smsTemplate'));
    }
    public function smsTemplateEditPost(Request $request, SmsTemplate $smsTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'text' => 'required',
            'status' => 'required'
        ]);

        $smsTemplate->name = $request->name;
        $smsTemplate->text = $request->text;
        $smsTemplate->status = $request->status;
        $smsTemplate->save();

        return redirect()->route('sms.template')->with('message', 'SMS Template update successfully.');
    }
    public function nextPaymentDateSms()
    {
        $transactionLog = TransactionLog::whereNotIn('stakeholder_id', null)->get();
    }
    public function smsLog()
    {
        $sms = SmsQuantity::first();
        $sentSmsCount = SmsLog::count('quantity');
        return view('sms.log', compact('sms', 'sentSmsCount'));
    }
    public function smsSent()
    {
        $smsLogs = SmsLog::all();
        return view('sms.sent', compact('smsLogs'));
    }

    public function sendMessageToStakeholder()
    {

        $date = date('Y-m-d');
        $addDay = strtotime($date . "+10 days");
        $smsDate = date('Y-m-d', $addDay);
        $counter = 0;
        // Send confirm SMS
        $smsQuantity = SmsQuantity::first();
        $transactionLogs = TransactionLog::whereNotNull('stakeholder_id')
            ->where('next_payment_date', $smsDate)->get();
        foreach ($transactionLogs as $transactionLog) {

            if ($smsQuantity->quantity >= 2) {

                $message = "Your installment date " . $transactionLog->next_payment_date . '. ' . env('APP_NAME');
                $quantity = ceil(strlen($message) / 160);
                $mobile = $this->validateMobile($transactionLog->stakeholder->mobile_no);

                if ($mobile && $message) {
                    $sms = $this->sendingSMS($mobile, $message);
                    $quantity = ceil(strlen($message) / 160);
                    SmsLog::create([
                        'stakeholder_id' => $transactionLog->stakeholder_id,
                        'message' => $message,
                        'mobile_no' => $mobile,
                        'quantity' => $quantity,
                    ]);
                    $smsQuantity->decrement('quantity', $quantity);
                }
                $counter++;
            }
            if ($smsQuantity->quantity >= 2) {
                $smsLogs = SmsLog::all();
                return redirect()->route('sms.sent', compact('smsLogs'))->with('message', 'Stakeholder sent successfully');
            } else {
                return redirect()->route('sms.template')->with('message', 'You no enough sms balance');
            }
        }
    }
}
