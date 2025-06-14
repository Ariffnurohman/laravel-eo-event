<?php
namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Participant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    // Generate sertifikat untuk peserta yang hadir
    public function generate($participantId)
    {
        $participant = Participant::with('user', 'event')->findOrFail($participantId);

        if ($participant->status_kehadiran !== 'hadir') {
            return back()->with('error', 'Sertifikat hanya tersedia jika peserta hadir.');
        }
    
        $pdf = Pdf::loadView('pdf.sertifikat', compact('participant'));
    
        $filename = 'sertifikat/sertifikat_' . $participant->id . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());
    
        Certificate::updateOrCreate(
            ['participant_id' => $participant->id],
            ['file_path' => $filename]
        );
    
        return back()->with('success', 'Sertifikat berhasil dibuat.');
    
    }

    // Peserta unduh sertifikatnya sendiri
    public function download($participantId)
    {
        $participant = Participant::with('certificate')->findOrFail($participantId);

        if (!$participant->certificate) {
            return response()->json(['message' => 'Sertifikat belum tersedia.'], 404);
        }

        return response()->download(storage_path('app/public/' . $participant->certificate->file_path));
    }

    // Verifikasi sertifikat publik (pakai token)
    public function verify($token)
    {
        $certificate = Certificate::with(['participant.user', 'participant.event'])
            ->where('verifikasi_token', $token)
            ->first();

        if (!$certificate) {
            return response()->json(['message' => 'Token tidak valid.'], 404);
        }

        return response()->json([
            'nama' => $certificate->participant->user->name,
            'event' => $certificate->participant->event->nama,
            'tanggal' => $certificate->issued_at->format('d M Y'),
            'valid' => true,
        ]);
    }
}