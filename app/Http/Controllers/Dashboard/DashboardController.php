<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Webhook;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public $view = 'pages.dashboard.';
	
    public function index(Request $request){
        $shop = \ShopifyApp::shop();
        if($shop->get_rulesets()->get()){
            if($request->filled('api')) {
                $data = $this->apiIndex($request);
                return response($data,200);
            }
            $firstSaleDate = $this->firstSale()[1];
            return view($this->view.'index',compact('firstSaleDate'));
        }
        return redirect()->route('setup.steps');

    }
    public function firstSale(){
        $shop = \ShopifyApp::shop();
        $storeFirstSaleDate = Webhook::where('shop_id',$shop->id)->orderBy('id','asc')->first();

        if($storeFirstSaleDate){
            $starttimestamp = $firstSaleDate = $storeFirstSaleDate->created_at->timestamp;

            $totalSeconds = 365*60*60*24;
            $diff = abs(time() - $firstSaleDate);
            $firstSaleDate = floor($diff / $totalSeconds);
        }else{
            $starttimestamp = $firstSaleDate = 0;
        }
        return [$starttimestamp,$firstSaleDate];
    }

    public function apiIndex($request){
        $dates = $this->currentMonthDates($request);
        $shop = \ShopifyApp::shop();

        if($request->filled('ruleset')){
            $keyword = $request->ruleset;
        }else{
            $keyword = "offer-dynamic-discount";
        }

        $enitites = Webhook::where('shop_id', $shop->id)->where('topic','orders/updated')->whereRaw('json_contains(tags, \'["' . $keyword . '"]\')');
        $total_extra_amount = $sale = $revenue = $average = 0;

        $start_dt = Carbon::today()->startOfMonth();
        $end_dt = $start_dt->copy()->endOfMonth();
        $diff_days = $diff = 0;
        if($request->filled('date_range')){
            $timestampDates = $this->getTimeStamp($request);
            $diff = $timestampDates['diff'];
            $diff_days = $timestampDates['diff_days'];
            $start_dt = date('Y-m-d 00:00:00',$timestampDates['start']);
            $end_dt = date('Y-m-d 23:59:59',$timestampDates['end']);
        }
        $currentYear = $enitites->whereBetween('created_at',[$start_dt, $end_dt])->orderBy('created_at','asc');
        $c = count($dates['timestamp']);
        $sales = $data = array_pad([],$c ,0);
        $max_value = $income = $cs = $c = 0;
        foreach($currentYear->get() as $key => $val){
            $order = json_decode($val->data,1);
            $c++;

            $timestamp = strtotime($val->created_at->toDateString());
            if($diff_days == 0){
                $prev = $val->created_at->timestamp - ($val->created_at->timestamp % 1800);
                $timestamp = $prev - 1800;
            }
            if(in_array($timestamp,$dates['timestamp'])) {

                $revenue += $order['total_price'];
                $total_extra_amount += $order['total_discounts'];

                $cs = array_search($timestamp, $dates['timestamp']);

                $sales[$cs]++;
                if($request->type =='sales'){
                    $data[$cs] = $sales[$cs];
                    $max_value = $max_value <= $sales[$cs]?$sales[$cs]:$max_value;
                }
                else if($request->type == 'revenue'){
                    $data[$cs] += $order['total_price'];
                    $data[$cs] = number_format((float)$data[$cs], 2, '.', '');
                    $max_value = $max_value <= $data[$cs]?$data[$cs]:$max_value;
                }
                else if($request->type == 'average'){
                    $data[$cs]['income'] = $data[$cs] = array(0 => 0);
                    $data[$cs]['sale'] = $sales[$cs];
                    $income += $order['total_price'];
                    $data[$cs]['income'] = $income;
                }
            }
        }



        if($request->type == 'average'){

            foreach ($data as $key => $val){
                if(is_array($val)){
                    $income = $val['income'] / $val['sale'];
                    $data[$key] = number_format((float)$income, 2, '.', '');
                    if($diff_days == 0)
                        $max_value = $max_value <= $val['income']?$val['income']:$max_value;
                    else
                        $max_value = $data[$key];
                }
            }
            //dump($max_value);

        }
        $max_value *= 1.3;
        if($diff_days == 0){

            $first = $data[0];
            unset($data[0]);
            array_push($data,$first);
            $data = array_values($data);

            $first = $dates['dates'][0];
            unset($dates['dates'][0]);
            array_push($dates['dates'],$first);
            $dates['dates'] = array_values($dates['dates']);

        }

        $revenue = number_format((float)$revenue, 2, '.', '');
        $average = ($revenue > 0)?$revenue / array_sum($sales):0;
        $average = number_format((float)$average, 2, '.', '');

        $currency = ($shop->money_format)?$shop->money_format:'$';
        $response['overview'] = ['sale' => array_sum($sales), 'total_extra_amount' => $total_extra_amount, 'revenue' => $revenue, 'currency'  => $currency, 'average' => $average];

        $response['graph_data'] = ['dates' => $dates['dates'], 'data' => $data, 'max_value' => $max_value];
        return $response;
    }

    public function currentMonthDates($request){
        $timestamp_num = $dates = [];
        if($request->filled('date_range')){

            $timestamp = $this->getTimeStamp($request);

            $format ="j M ";
            if($timestamp['diff'] > 1) {
                $format = "j M Y";
            }else{
                if($timestamp['diff_days'] <= 0) {
                    $format = "H:i";

                    for ($i=$timestamp['start'] - 61; $i<=$timestamp['end']; $i+=3600) {
                        $dates[]= date($format, $i);
                        $timestamp_num[] = strtotime(date("Y-M-d H:i:s", $i));
                    }
                }
            }

            if(!count($timestamp_num)){
                for ($i=$timestamp['start']; $i<=$timestamp['end']; $i+=86400) {
                    $dates[]= date($format, $i);
                    $timestamp_num[] = strtotime(date("Y-M-d", $i));
                }
            }
        }
        return [ 'dates'=> $dates, 'timestamp' => $timestamp_num];
    }

    public function getTimeStamp($request){
        $shop = \ShopifyApp::shop();
        if(!is_null($shop->timezone))
            date_default_timezone_set($shop->timezone);

        $date = json_decode($request->date_range,1);

        $start = Carbon::createFromDate($date['startDate']);
        $end = Carbon::createFromDate($date['endDate']);
        $diff_days = $start->diffInDays($end);

        $totalSeconds = 365*60*60*24;
        $start_dt = Carbon::parse($date['startDate'])->timestamp;
        $end_dt = Carbon::parse($date['endDate'])->timestamp;
        $shop_start = $this->firstSale()[0];
        $diff = abs($end_dt - $start_dt);
        $years = round(floor($diff / $totalSeconds));

        return ['start' => $start_dt, 'end' => $end_dt, 'shop_start' => $shop_start, 'diff' => $years,'diff_days' => $diff_days];
    }

}
