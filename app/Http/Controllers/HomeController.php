<?php

namespace App\Http\Controllers;


use App\Models\invoices;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير المدفوعة', 'الفواتير الغير مدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['rgba(0, 0, 255, 0.3)', 'rgba(54, 162, 235, 0.2)'],
                    'data' => [invoices::where('Value_Status',1)->count()/invoices::count() * 100 ]
                ],
                [
                    "label" => "الفواتير الغير مدفوعة",
                    'backgroundColor' => ['rgba(0, 255, 0, 0.3)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [invoices::where('Value_Status',2)->count()/invoices::count() * 100]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['rgba(255, 0, 0, 0.3)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [invoices::where('Value_Status',3)->count()/invoices::count() * 100]
                ]

            ])
            ->options([]);
        $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير المدفوعة', 'الفواتير الغير مدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [invoices::where('Value_Status',1)->count()/invoices::count() * 100 , invoices::where('Value_Status',2)->count()/invoices::count() * 100,invoices::where('Value_Status',3)->count()/invoices::count() * 100]
                ]
            ])
            ->options([]);
        return view('home',compact('chartjs','chartjs2'));
    }
}
