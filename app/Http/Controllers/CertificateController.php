<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function generateCertificate(Course $course)
    {
        // Pass data to the view
        $data = [
            'user' => Auth::user(),
            'course' => $course,
            'date' => \Illuminate\Support\Facades\Date::now()->format('F j, Y'),
            'sign' =>  'https://res.cloudinary.com/de2fnaud6/image/upload/v1726926143/Certificate/ew0whocx2qxkibaqgast.png',
            'logo' => 'https://res.cloudinary.com/de2fnaud6/image/upload/v1726926172/Certificate/wlcr1k94tlghactzwgsx.png'
        ];


        // Load the certificate Blade view and render it as HTML
        $pdf = Pdf::loadView('certificate.structure', $data);

        // Stream or download the PDF
        return $pdf->download('certificate.pdf');
    }
}
