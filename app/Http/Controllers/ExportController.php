<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    private function exportCsv($headers, $data, $filename)
    {
        $callback = function() use ($headers, $data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }

    public function products()
    {
        $products = \App\Models\Product::all();
        $data = $products->map(function($product) {
            return [
                $product->id,
                $product->name,
                $product->code,
                $product->system_type,
                $product->description,
                $product->created_at,
            ];
        });

        return $this->exportCsv(
            ['ID', 'Name', 'Code', 'System Type', 'Description', 'Created At'],
            $data,
            'products_export_' . date('Y-m-d') . '.csv'
        );
    }

    public function bom()
    {
        $boms = \App\Models\BOM::with(['product', 'material'])->get();
        $data = $boms->map(function($item) {
            return [
                $item->product->name,
                $item->product->code,
                $item->material->name,
                $item->material->code,
                $item->quantity,
                $item->material->unit,
                $item->material->cost_per_unit,
                $item->quantity * $item->material->cost_per_unit
            ];
        });

        return $this->exportCsv(
            ['Product', 'Product Code', 'Material', 'Material Code', 'Quantity', 'Unit', 'Cost/Unit', 'Total Cost'],
            $data,
            'bom_export_' . date('Y-m-d') . '.csv'
        );
    }

    public function schedule()
    {
        $schedules = \App\Models\ProductionSchedule::with('product')->orderBy('start_date')->get();
        $data = $schedules->map(function($item) {
            return [
                $item->product->name,
                $item->activity_name,
                $item->start_date->format('Y-m-d'),
                $item->end_date->format('Y-m-d'),
                $item->status,
                $item->is_critical_path ? 'Yes' : 'No'
            ];
        });

        return $this->exportCsv(
            ['Product', 'Activity', 'Start Date', 'End Date', 'Status', 'Critical Path'],
            $data,
            'schedule_export_' . date('Y-m-d') . '.csv'
        );
    }

    public function orders()
    {
        $orders = \App\Models\ProductionOrder::orderBy('created_at', 'desc')->get();
        $data = $orders->map(function($item) {
            return [
                $item->order_number,
                $item->type,
                $item->status,
                is_string($item->details) ? $item->details : json_encode($item->details),
                $item->created_at
            ];
        });

        return $this->exportCsv(
            ['Order Number', 'Type', 'Status', 'Details', 'Date'],
            $data,
            'orders_export_' . date('Y-m-d') . '.csv'
        );
    }

    public function stakeholders()
    {
        $stakeholders = \App\Models\Stakeholder::all();
        $data = $stakeholders->map(function($item) {
            return [
                $item->name,
                $item->role,
                $item->matrix_position
            ];
        });

        return $this->exportCsv(
            ['Name', 'Role', 'Matrix Position'],
            $data,
            'stakeholders_export_' . date('Y-m-d') . '.csv'
        );
    }
}
