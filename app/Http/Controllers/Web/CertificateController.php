<?php

namespace App\Http\Controllers\Web;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Participant;
use App\Models\Certificate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function generate($participantId)
    {
        $participant = Participant::with('user', 'event')->findOrFail($participantId);

        // Cek akses
        if (Auth::id() !== $participant->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Tidak diizinkan mengakses sertifikat ini.');
        }

        if ($participant->status_kehadiran !== 'hadir') {
            return back()->with('error', 'Peserta belum hadir.');
        }

        $token = Str::uuid()->toString();

        $certificate = Certificate::updateOrCreate(
            ['participant_id' => $participant->id],
            ['file_path' => '', 'verification_token' => $token]
        );

        // Buat QR Code
        $url = route('verify.certificate', $token);
        $qr = new QrCode($url);
        $qrImage = (new PngWriter())->write($qr)->getString();

        $qrPath = "certificates/qrs/{$token}.png";
        Storage::disk('public')->put($qrPath, $qrImage);

        // Generate PDF
        $pdf = Pdf::loadView('certificates.template', [
            'participant' => $participant,
            'qrPath' => public_path('storage/' . $qrPath),
            'verifUrl' => $url,
        ]);

        $pdfPath = "certificates/{$token}.pdf";
        Storage::disk('public')->put($pdfPath, $pdf->output());

        $certificate->update(['file_path' => $pdfPath]);

        return back()->with('success', 'Sertifikat berhasil dibuat.');
    }
}