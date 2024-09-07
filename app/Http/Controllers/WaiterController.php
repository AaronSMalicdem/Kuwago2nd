<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Table;
use Mike42\Escpos\Printer;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\CustomDish;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class WaiterController extends Controller
{
    public function loginViaPasscode(Request $request)
    {
        $user = User::where('passcode', $request->passcode)->first();
        if (!$user) {
            return back()->withErrors([
                'passcode' => 'Incorrect passcode',
            ]);
        }
        $request->session()->regenerate();
        Auth::login($user);
        return redirect('/waiter-order');
    }

    public function waiterOrder()
    {

        return view('order');
    }

    public function adminCode(Request $request)
    {
        $user = User::where('passcode', $request->passcode)->first();
        if ($user->role->name == "admin" || $user->role->name == "operation") {
            return response()->json([
                'success' => 'Success',
            ]);
        } else {
            return response()->json([
                'error' => 'Incorrect code',
            ]);
        }
    }

    public function dashboard()
    {
        return view('waiter.dashboard');
    }

    public function printWaiterReport($waiter, $startDate, $endDate = null)
    {
        try {
            $date = now()->toDateTimeString();

            $orders = Order::with(['orderDetails', 'customOrderDetails'])
                ->where('waiter_id', $waiter);

            if($endDate)
            {
                $orders->whereRaw('DATE(orders.created_at) BETWEEN ? AND ?', [$startDate, $endDate]);
            }
            else{
                $orders->whereDate('orders.created_at', $startDate);
            }
            $orders = $orders->get();

            $waiterName = User::find($waiter)->full_name;

            $items = [];
            $totalFoodsCost = 0;
            $totalDrinksCost = 0;
            $totalServiceChargeCost = 0;
            $totalDiscountCost = 0;
            $totalPax = 0;
            $totalCashPaid = 0;
            $totalCheckPaid = 0;

            foreach($orders as $order){

                if($order->isCheck()){
                    $totalCheckPaid += $order->totalPrice();
                }else{
                    $totalCashPaid += $order->totalPrice();
                }

                $totalDiscountCost += $order->totalDiscountedPrice();
                $totalServiceChargeCost += $order->serviceChargeFromDB();
                $totalPax += $order->pax;

            }

            $orderDetails = OrderDetails::whereIn('order_id', $orders->pluck('id'))
                ->select('dish_id', DB::raw('SUM(order_details.pcs) as pcs'), DB::raw('SUM(order_details.price) as price'))
                ->groupBy('dish_id')
                ->get();

            foreach ($orderDetails as $i) {
                $items[] = new waiterItem($i->dish->name." X ".$i->pcs, number_format($i->price, 2, '.', ','));
                if($i->isDrink()){
                    $totalDrinksCost += $i->price;
                }
                if($i->isFood()){
                    $totalFoodsCost += $i->price;
                }
            }

            $customDishes = CustomDish::whereIn('order_id', $orders->pluck('id'))->get();

            foreach ($customDishes as $i) {
                $items[] = new waiterItem($i->name." X ".$i->pcs, number_format($i->price, 2, '.', ','));
                if($i->isDrink()){
                    $totalDrinksCost += $i->price;
                }
                if($i->isFood()){
                    $totalFoodsCost += $i->price;
                }
            }

            $totalSalesCost = $totalCheckPaid + $totalCashPaid;


            $totalFoods = new waiterItem("Total Foods", number_format($totalFoodsCost, 2, '.', ','));
            $totalDrinks = new waiterItem("Total Drinks", number_format($totalDrinksCost, 2, '.', ','));
            $totalSales = new waiterItem("Total Sales", number_format($totalSalesCost, 2, '.', ','));
            $totalDiscount = new waiterItem("Total Discount", number_format($totalDiscountCost, 2, '.', ','));
            $totalServiceCharge = new waiterItem("Total Service Charge", number_format($totalServiceChargeCost, 2, '.', ','));

            $totalCash = new waiterItem("Total Cash", number_format($totalCashPaid, 2, '.', ','));
            $totalCheck = new waiterItem("Total Check", number_format($totalCheckPaid, 2, '.', ','));
            // $totalIncome = new waiterItem("Total Income", number_format($totalServiceChargeCost + $totalSalesCost - $totalDiscountCost, 2, '.', ','));

            // Enter the share name for your USB printer here
            $connector = new WindowsPrintConnector("POS-58-BAR");
            // $connector = new WindowsPrintConnector("POS-58");

            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            $printer->initialize();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("SABINA\n");
            $printer->selectPrintMode();
            $printer->text("Leisure Coast Resort\n");
            $printer->text('Bonuan, Dagupan, 2400 Pangasinan');
            $printer->setEmphasis(false);
            $printer->feed();

            /* Title of receipt */
            $length = 60;
            $printer->setEmphasis(true);
            $printer->text("Daily Report\n");

            if($endDate != null)
            {
                $printer->text($startDate." - ".$endDate);
            }else{
                $printer->text($startDate);
            }
            $printer->text($waiterName."\n");
            $printer->setEmphasis(false);
            $printer->feed();
            $printer->text("Total Pax: ".$totalPax);

            $printer->setJustification(Printer::JUSTIFY_LEFT);

            $printer->feed(2);

            /* Items */
            foreach ($items as $o) {
                $printer->text($o->getAsString($length));
            }
            $printer->feed();
            $printer->text($totalFoods->getAsString($length));
            $printer->text($totalDrinks->getAsString($length));
            $printer->text($totalDiscount->getAsString($length));

            $printer->text($totalCash->getAsString($length));
            $printer->text($totalCheck->getAsString($length));
            $printer->text($totalSales->getAsString($length));

            $printer->text($totalServiceCharge->getAsString($length));
            // $printer->text($totalIncome->getAsString($length));

            $printer->feed(3);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text($date . "\n");

            $printer->feed(3);
            $printer->cut();

            /* Close printer */
            $printer->close();

        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    }

}

class waiterItem
{
    private $name;
    private $price;
    private $pesoSign;

    public function __construct($name = '', $price = '', $pesoSign = false)
    {
        $this->name = $name;
        $this->price = $price;
        $this->pesoSign = $pesoSign;
    }

    public function getAsString($width = 30)
    {
        $rightCols = 10;
        $leftCols = $width - $rightCols;
        if ($this->pesoSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this->name, $leftCols);

        $sign = ($this->pesoSign ? 'P ' : '');
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }

    public function __toString()
    {
        return $this->getAsString();
    }
}
