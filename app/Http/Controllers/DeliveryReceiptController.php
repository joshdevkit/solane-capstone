<?php

namespace App\Http\Controllers;

use App\Models\DeliveryReceipt;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Mpdf\Mpdf;

class DeliveryReceiptController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'date' => 'required|date',
                'invoice_number' => 'nullable|string',
                'invoice_to' => 'nullable|string',
                'attention' => 'nullable|string',
                'po_number' => 'nullable|string',
                'terms' => 'nullable|string',
                'rep' => 'nullable|string',
                'ship_date' => 'nullable|date',
                'qty' => 'required|array',
                'item' => 'required|array',
                'description' => 'required|array',
                'price_each' => 'required|array',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        // Sanitize invoice_to and po_number fields
        $invoiceTo = is_array($validatedData['invoice_to']) ? $validatedData['invoice_to'][0] : $validatedData['invoice_to'];
        $poNumber = is_array($validatedData['po_number']) ? $validatedData['po_number'][0] : $validatedData['po_number'];

        // Store the validated data in the delivery_receipts table
        try {
            $deliveryReceipt = DeliveryReceipt::create([
                'date' => $validatedData['date'],
                'invoice_number' => $validatedData['invoice_number'],
                'invoice_to' => $invoiceTo,
                'attention' => $validatedData['attention'] ?? null,
                'po_number' => $poNumber,
                'terms' => $validatedData['terms'] ?? null,
                'rep' => $validatedData['rep'] ?? null,
                'ship_date' => $validatedData['ship_date'] ?? null,
                'fob' => $validatedData['fob'] ?? null,
                'project' => $validatedData['project'] ?? null,
            ]);

            // Proceed with other operations (e.g., storing related items, generating files)
            return response()->json(['message' => 'Data stored successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to store data: ' . $e->getMessage()], 500);
        }
    }



    protected function generateFile($validatedData, $request, $deliveryReceipt)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set values in specified cells
        $sheet->setCellValue('J11', $validatedData['date']);
        $sheet->setCellValue('L11', $validatedData['invoice_number']);
        $sheet->setCellValue('A15', $validatedData['invoice_to']);
        $sheet->setCellValue('B16', $validatedData['attention']);
        $sheet->setCellValue('A20', $validatedData['po_number']);
        $sheet->setCellValue('B20', $validatedData['terms']);
        $sheet->setCellValue('C20', $validatedData['rep']);
        $sheet->setCellValue('D20', $validatedData['ship_date']);
        $sheet->setCellValue('K20', $validatedData['fob']);
        $sheet->setCellValue('M20', $validatedData['project']);

        // Loop through items and populate rows starting from row 25
        $startRow = 25;
        foreach ($validatedData['qty'] as $index => $qty) {
            $currentRow = $startRow + $index;
            $sheet->setCellValue('A' . $currentRow, $qty);
            $sheet->setCellValue('B' . $currentRow, $validatedData['item'][$index]);
            $sheet->setCellValue('C' . $currentRow, $validatedData['description'][$index]);
            $sheet->setCellValue('K' . $currentRow, $validatedData['price_each'][$index]);
            $sheet->setCellValue('M' . $currentRow, $validatedData['qty'][$index] * $validatedData['price_each'][$index]);
        }

        // Calculate and set total amount
        $totalRow = 49;
        $totalAmount = array_sum(array_map(function ($qty, $price) {
            return $qty * $price;
        }, $validatedData['qty'], $validatedData['price_each']));
        $sheet->setCellValue('J' . $totalRow, $totalAmount);

        // Save and download the Excel file
        $writer = new Xlsx($spreadsheet);
        $timestamp = now()->format('Ymd_His');
        $filename = "delivery_receipt_{$request->dr}_{$timestamp}";

        if ($request->action === 'save_and_download') {
            // Save as HTML first
            $htmlWriter = IOFactory::createWriter($spreadsheet, 'Html');
            $htmlPath = public_path("forms/temp_{$filename}.html");
            $htmlWriter->save($htmlPath);

            // Create PDF using mPDF
            $mpdf = new Mpdf(['format' => 'letter']);
            $html = file_get_contents($htmlPath);
            $mpdf->WriteHTML($html);

            $pdfPath = public_path("forms/delivery_receipt/{$filename}.pdf");
            $mpdf->Output($pdfPath, 'F');

            // Save Excel file
            $excelPath = public_path("forms/delivery_receipt/{$filename}.xlsx");
            $excelWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $excelWriter->save($excelPath);

            // Clean up temporary HTML file
            unlink($htmlPath);

            return response()->download($pdfPath);
        } else {
            // Save only the Excel file
            $excelPath = public_path("forms/delivery_receipt/{$filename}.xlsx");
            $excelWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $excelWriter->save($excelPath);

            return back()->with('success', 'Form saved successfully!');
        }
    }
}
