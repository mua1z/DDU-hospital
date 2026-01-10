<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ReportService
{
    protected $logo;
    
    public function __construct()
    {
        // Set logo path
        $this->logo = public_path('images/logo.png');
    }

    /**
     * Generate PDF report with logo header (no page form)
     */
    public function generatePDF($data, $view, $filename, $orientation = 'portrait')
    {
        // Add logo to data
        $data['logo'] = $this->getBase64Logo();
        $data['generated_at'] = now()->format('F d, Y h:i A');
        $data['generated_by'] = auth()->user()->name ?? 'System';
        
        $pdf = Pdf::loadView($view, $data);
        $pdf->setPaper('A4', $orientation);
        
        return $pdf->download($filename);
    }

    /**
     * Get base64 encoded logo for embedding in PDF
     */
    protected function getBase64Logo()
    {
        // Check if GD extension is loaded (required for image processing)
        if (!extension_loaded('gd')) {
            return null;
        }

        if (file_exists($this->logo)) {
            $imageData = base64_encode(file_get_contents($this->logo));
            return 'data:image/png;base64,' . $imageData;
        }
        return null;
    }

    /**
     * Stream PDF report (preview in browser)
     */
    public function streamPDF($data, $view, $orientation = 'portrait')
    {
        $data['logo'] = $this->getBase64Logo();
        $data['generated_at'] = now()->format('F d, Y h:i A');
        $data['generated_by'] = auth()->user()->name ?? 'System';
        
        $pdf = Pdf::loadView($view, $data);
        $pdf->setPaper('A4', $orientation);
        
        return $pdf->stream();
    }
}
