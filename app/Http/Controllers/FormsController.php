<?php

namespace App\Http\Controllers;

use App\Models\Forms;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class FormsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = Forms::all();
        return view('admin.forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.forms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'form_name' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:csv,xlsx',
        ]);

        $file = $request->file('file_path');

        $destinationPath = 'forms';

        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path($destinationPath), $filename);

        $filePath = $destinationPath . '/' . $filename;
        Forms::create(['form_name' => $request->form_name, 'file_path' => $filePath]);

        return redirect()->route('uploaded-forms.index')->with('success', 'Files Uploaded Successfully');
    }

    /**
     * Show the form for creating a pullout form.
     */
    public function pullout_form()
    {
        return view('admin.forms.create-pullout');
    }

    /**
     * Store the submitted pullout form data.
     */
    public function storePulloutForm(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'plate' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'dr' => 'required|string|max:255',
            'driver' => 'required|string|max:255',
            'seal_number' => 'required|array',
            'seal_number.*' => 'required|string',
            'total_cylinder_weight' => 'required|array',
            'total_cylinder_weight.*' => 'required|numeric',
            'tare_weight' => 'required|array',
            'tare_weight.*' => 'required|numeric',
        ]);

        try {
            // Store form data in the database first
            foreach ($request->seal_number as $index => $sealNumber) {
                Forms::create([
                    'form_name' => 'Pullout Form',
                    'file_path' => 'pullout-forms/' . time(),
                    'date' => $request->date,
                    'plate' => $request->plate,
                    'customer' => $request->customer,
                    'dr' => $request->dr,
                    'driver' => $request->driver,
                    'seal_number' => $sealNumber,
                    'total_cylinder_weight' => $request->total_cylinder_weight[$index],
                    'tare_weight' => $request->tare_weight[$index],
                ]);
            }

            // After saving to database, generate the Excel and PDF
            return $this->pulloutForm($request);

        } catch (\Exception $e) {
            \Log::error('Error saving pullout form: ' . $e->getMessage());
            return back()->with('error', 'Error saving form: ' . $e->getMessage());
        }
    }

    /**
     * Generate and download the pullout form as a PDF.
     */
    public function pulloutForm(Request $request)
    {
        try {
            // Check if the template file exists
            $templatePath = public_path('forms/1730439925_NEW PULLOUT FORM.xlsx');
            if (!file_exists($templatePath)) {
                \Log::error('Excel template not found at: ' . $templatePath);
                return back()->with('error', 'Excel template file not found. Please ensure the template exists in the forms directory.');
            }

            // Load the Excel template
            $spreadsheet = IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();

            // Set print scaling to None (Disable scaling)
            $sheet->getPageSetup()->setFitToWidth(1); // Disable scaling
            $sheet->getPageSetup()->setFitToHeight(1); // Disable scaling

            // Set paper size and orientation
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LETTER);
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);

            // Center the content on page
            $sheet->getPageSetup()->setHorizontalCentered(true);
            $sheet->getPageSetup()->setVerticalCentered(true);

            // Populate fixed cells in the Excel template
            $sheet->setCellValue('E11', $request->date);
            $sheet->setCellValue('E12', $request->customer);
            $sheet->setCellValue('M11', $request->plate);
            $sheet->setCellValue('M12', $request->driver);
            $sheet->setCellValue('E13', $request->dr);

            // Insert Seal Number, Total Cylinder Weight, and Tare Weight into specific cells
            $startRow = 16;
            $sealNumbers = $request->seal_number; // array
            $totalWeights = $request->total_cylinder_weight; // array
            $tareWeights = $request->tare_weight; // array

            foreach ($sealNumbers as $index => $sealNumber) {
                if ($startRow > 45)
                    break; // Limit to row 45

                // Populate first set of columns (C, D, E)
                $sheet->setCellValue("D{$startRow}", $sealNumber);
                $sheet->setCellValue("E{$startRow}", $totalWeights[$index] ?? '');
                $sheet->setCellValue("F{$startRow}", $tareWeights[$index] ?? '');

                // Check if C45, D45, and E45 are filled before populating the mirror columns (K, L, M)
                if (
                    !empty($sheet->getCell('D45')->getValue()) &&
                    !empty($sheet->getCell('E45')->getValue()) &&
                    !empty($sheet->getCell('F45')->getValue())
                ) {
                    // Populate the mirror columns (K, L, M) only if C45, D45, E45 are filled
                    $sheet->setCellValue("L{$startRow}", $sealNumber);
                    $sheet->setCellValue("M{$startRow}", $totalWeights[$index] ?? '');
                    $sheet->setCellValue("N{$startRow}", $tareWeights[$index] ?? '');
                }

                $startRow++;
            }

            // Create forms directory if it doesn't exist
            $formsDirectory = public_path('forms');
            if (!file_exists($formsDirectory)) {
                mkdir($formsDirectory, 0755, true);
            }

            // Generate unique filename
            $timestamp = now()->format('Ymd_His');
            $filename = "pullout_form_{$request->dr}_{$timestamp}";

            if ($request->action === 'save_and_download') {
                // First save as HTML
                $writer = IOFactory::createWriter($spreadsheet, 'Html');
                $htmlPath = public_path("forms/temp_{$filename}.html");
                $writer->save($htmlPath);

                // Create PDF using mPDF
                $mpdf = new \Mpdf\Mpdf([
                    'format' => 'letter',
                ]);

                $html = file_get_contents($htmlPath);
                $mpdf->WriteHTML($html);

                $pdfPath = public_path("forms/pullout_forms/{$filename}.pdf");
                $mpdf->Output($pdfPath, 'F');

                $excelPath = public_path("forms/pullout_forms/{$filename}.xlsx");
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save($excelPath);

                // Clean up temporary HTML file
                unlink($htmlPath);
                
                return response()->download($pdfPath);
            } else {
                // Save only (Excel file)
                $excelPath = public_path("forms/pullout_forms/{$filename}.xlsx");
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save($excelPath);
                
                return back()->with('success', 'Form saved successfully!');
            }

        } catch (\Exception $e) {
            \Log::error('Form Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Error generating form: ' . $e->getMessage());
        }
    }



    /**
     * Show the form for creating a delivery form.
     */
    public function delivery_form()
    {
        return view('admin.forms.delivery-form');
    }

     /**
     * Store the submitted delivery form data.
     */
    public function storeDeliveryForm(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'plate' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'dr' => 'required|string|max:255',
            'driver' => 'required|string|max:255',
            'seal_number' => 'required|array',
            'seal_number.*' => 'required|string',
            'total_cylinder_weight' => 'required|array',
            'total_cylinder_weight.*' => 'required|numeric',
            'tare_weight' => 'required|array',
            'tare_weight.*' => 'required|numeric',
        ]);

        try {
            // Store form data in the database first
            foreach ($request->seal_number as $index => $sealNumber) {
                Forms::create([
                    'form_name' => 'Delivery Form',
                    'file_path' => 'delivery-forms/' . time(),
                    'date' => $request->date,
                    'plate' => $request->plate,
                    'customer' => $request->customer,
                    'dr' => $request->dr,
                    'driver' => $request->driver,
                    'seal_number' => $sealNumber,
                    'total_cylinder_weight' => $request->total_cylinder_weight[$index],
                    'tare_weight' => $request->tare_weight[$index],
                ]);
            }

            // After saving to database, generate the Excel and PDF
            return $this->deliveryForm($request);

        } catch (\Exception $e) {
            \Log::error('Error saving pullout form: ' . $e->getMessage());
            return back()->with('error', 'Error saving form: ' . $e->getMessage());
        }
    }

    /**
     * Generate and download the delivery form as a PDF.
     */
    public function deliveryForm(Request $request)
    {
        try {
            // Check if the template file exists
            $templatePath = public_path('forms/1730439950_NEW DELIVERY FORM.xlsx');
            if (!file_exists($templatePath)) {
                \Log::error('Excel template not found at: ' . $templatePath);
                return back()->with('error', 'Excel template file not found. Please ensure the template exists in the forms directory.');
            }

            // Load the Excel template
            $spreadsheet = IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();

            // Set print scaling to None (Disable scaling)
            $sheet->getPageSetup()->setFitToWidth(1); // Disable scaling
            $sheet->getPageSetup()->setFitToHeight(1); // Disable scaling

            // Set paper size and orientation
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LETTER);
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);

            // Center the content on page
            $sheet->getPageSetup()->setHorizontalCentered(true);
            $sheet->getPageSetup()->setVerticalCentered(true);

            // Populate fixed cells in the Excel template
            $sheet->setCellValue('E11', $request->date);
            $sheet->setCellValue('E12', $request->customer);
            $sheet->setCellValue('M11', $request->plate);
            $sheet->setCellValue('M12', $request->driver);
            $sheet->setCellValue('E13', $request->dr);

            // Insert Seal Number, Total Cylinder Weight, and Tare Weight into specific cells
            $startRow = 16;
            $sealNumbers = $request->seal_number; // array
            $totalWeights = $request->total_cylinder_weight; // array
            $tareWeights = $request->tare_weight; // array

            foreach ($sealNumbers as $index => $sealNumber) {
                if ($startRow > 45)
                    break; // Limit to row 45

                // Populate first set of columns (C, D, E)
                $sheet->setCellValue("D{$startRow}", $sealNumber);
                $sheet->setCellValue("E{$startRow}", $totalWeights[$index] ?? '');
                $sheet->setCellValue("F{$startRow}", $tareWeights[$index] ?? '');

                // Check if C45, D45, and E45 are filled before populating the mirror columns (K, L, M)
                if (
                    !empty($sheet->getCell('D45')->getValue()) &&
                    !empty($sheet->getCell('E45')->getValue()) &&
                    !empty($sheet->getCell('F45')->getValue())
                ) {
                    // Populate the mirror columns (K, L, M) only if C45, D45, E45 are filled
                    $sheet->setCellValue("L{$startRow}", $sealNumber);
                    $sheet->setCellValue("M{$startRow}", $totalWeights[$index] ?? '');
                    $sheet->setCellValue("N{$startRow}", $tareWeights[$index] ?? '');
                }

                $startRow++;
            }

            // Create forms directory if it doesn't exist
            $formsDirectory = public_path('forms');
            if (!file_exists($formsDirectory)) {
                mkdir($formsDirectory, 0755, true);
            }

            // Generate unique filename
            $timestamp = now()->format('Ymd_His');
            $filename = "delivery_form_{$request->dr}_{$timestamp}";

            if ($request->action === 'save_and_download') {
                // First save as HTML
                $writer = IOFactory::createWriter($spreadsheet, 'Html');
                $htmlPath = public_path("forms/temp_{$filename}.html");
                $writer->save($htmlPath);

                // Create PDF using mPDF
                $mpdf = new \Mpdf\Mpdf([
                    'format' => 'letter',
                ]);

                $html = file_get_contents($htmlPath);
                $mpdf->WriteHTML($html);

                $pdfPath = public_path("forms/delivery_forms/{$filename}.pdf");
                $mpdf->Output($pdfPath, 'F');

                $excelPath = public_path("forms/delivery_forms/{$filename}.xlsx");
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save($excelPath);

                // Clean up temporary HTML file
                unlink($htmlPath);
                
                return response()->download($pdfPath);
            } else {
                // Save only (Excel file)
                $excelPath = public_path("forms/delivery_forms/{$filename}.xlsx");
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save($excelPath);
                
                return back()->with('success', 'Form saved successfully!');
            }

        } catch (\Exception $e) {
            \Log::error('Form Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Error generating form: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a delivery receipt.
     */
    public function delivery_receipt()
    {
        return view('admin.forms.delivery-receipt');
    }
}
