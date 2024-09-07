<?php

namespace App\Http\Livewire\Auth;

use Carbon\Carbon;
use App\Models\Dish;
use App\Models\User;
use App\Models\Order;
use App\Models\Report as ReportModel;
use Livewire\Component;
use App\Models\Category;
use App\Models\CustomDish;
use App\Models\OrderDetails;
use Livewire\WithPagination;

class Report extends Component
{
    use WithPagination;

    public $dateType;
    public $date;
    public $tempDate;
    public $date2 = "";

    public $cash;
    public $gCash;
    public $total;

    public $paginate = 15;

    public function mount()
    {
        $this->date = now()->toDateString();
        $this->dateType = 'single';
    }

    public function updatedDateType($value)
    {
        if ($value == 'range') {
            $this->tempDate = $this->date;
            $this->date = Carbon::parse($this->date)->startOfMonth()->toDateString();
            $this->date2 = Carbon::parse($this->date)->endOfMonth()->toDateString();
        } else {
            $this->date = $this->tempDate;
            $this->date2 = "";
        }
    }

    public function nextDate()
    {
        $date = Carbon::parse($this->date);
        $date->addDay();
        $this->date = $date->toDateString();
        $this->resetPage();
    }

    public function prevDate()
    {
        $date = Carbon::parse($this->date);
        $date->subDay();
        $this->date = $date->toDateString();
        $this->resetPage();
    }

    public function delete(Order $order)
    {
        //
        $order->orderDetails()->delete();
        $order->delete();
    }

    public function render()
    {
        $orders =  Order::with([
            'waiter' => function ($query) {
                $query->withTrashed();
            },
        ])->where('checked_out', 1)
            ->when($this->dateType == 'single', function ($query) {
                $query->whereDate('created_at', $this->date);
            })
            ->when($this->dateType == 'range', function ($query) {
                $query->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$this->date, $this->date2]);
            });


        $this->total = $orders->sum('total');
        $this->cash = (clone $orders)->wherePaymentType('cash')->sum('total');
        $this->gCash = (clone $orders)->wherePaymentType('gcash')->sum('total');

        $orders = $orders->paginate($this->paginate);

        return view('livewire.auth.report', [
            'orders' => $orders,
            'dishes' => Dish::leftJoin('order_details', 'dishes.id', 'dish_id')
                ->leftJoin('orders', 'orders.id', 'order_details.order_id')
                ->selectRaw('dishes.name, dishes.properties, SUM(pcs) as quantity')
                ->groupBy('dishes.name', 'dishes.properties')
                ->when($this->dateType == 'single', function ($query) {
                    $query->whereDate('orders.created_at', $this->date);
                })
                ->when($this->dateType == 'range', function ($query) {
                    $query->whereRaw('DATE(orders.created_at) BETWEEN ? AND ?', [$this->date, $this->date2]);
                })
                ->orderBy('name')
                ->get(),
            'waiters' => User::with([
                'cancelled' => function ($cancel) {
                    $cancel->when($this->dateType == 'single', function ($query) {
                        $query->whereDate('cancels.created_at', $this->date);
                    })->when($this->dateType == 'range', function ($query) {
                        $query->whereRaw('DATE(cancels.created_at) BETWEEN ? AND ?', [$this->date, $this->date2]);
                    });
                },
                'orders' => function ($order) {
                    $order->when($this->dateType == 'single', function ($query) {
                        $query->whereDate('orders.created_at', $this->date);
                    })->when($this->dateType == 'range', function ($query) {
                        $query->whereRaw('DATE(orders.created_at) BETWEEN ? AND ?', [$this->date, $this->date2]);
                    });
                }
            ])->get(),
            'overalls' => Category::with([
                'dishes' => function ($dish) {
                    $dish->orderBy('name');
                },
                'dishes.orderDetails' => function ($order) {
                    $order->when($this->dateType == 'single', function ($query) {
                        $query->whereDate('created_at', $this->date);
                    })->when($this->dateType == 'range', function ($query) {
                        $query->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$this->date, $this->date2]);
                    });
                },
                'dishes.orderDetails.order' => function ($order) {
                    $order->when($this->dateType == 'single', function ($query) {
                        $query->whereDate('created_at', $this->date);
                    })->when($this->dateType == 'range', function ($query) {
                        $query->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$this->date, $this->date2]);
                    });
                },
            ])->get(),
            'reports' => ReportModel::latest()->paginate($this->paginate),
            'unpaids' => Order::whereNull('paid_on')->get(),
        ]);
    }
}
