<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - {{ $certificate->class->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        @page {
            size: A4 landscape;
            margin: 0;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            width: 297mm;
            height: 210mm;
            margin: 0;
            padding: 0;
            background: white;
        }
        
        .certificate-container {
            width: 297mm;
            height: 210mm;
            position: relative;
            background: linear-gradient(135deg, #faf5ff 0%, #ede9fe 100%);
            padding: 15mm;
        }
        
        .border-outer {
            position: absolute;
            top: 8mm;
            left: 8mm;
            right: 8mm;
            bottom: 8mm;
            border: 6px double #7c3aed;
        }
        
        .border-inner {
            position: absolute;
            top: 12mm;
            left: 12mm;
            right: 12mm;
            bottom: 12mm;
            border: 1.5px solid #c4b5fd;
        }
        
        /* Decorative Corners */
        .corner {
            position: absolute;
            width: 15mm;
            height: 15mm;
        }
        
        .corner-tl {
            top: 15mm;
            left: 15mm;
            border-top: 3px solid #7c3aed;
            border-left: 3px solid #7c3aed;
        }
        
        .corner-tr {
            top: 15mm;
            right: 15mm;
            border-top: 3px solid #7c3aed;
            border-right: 3px solid #7c3aed;
        }
        
        .corner-bl {
            bottom: 15mm;
            left: 15mm;
            border-bottom: 3px solid #7c3aed;
            border-left: 3px solid #7c3aed;
        }
        
        .corner-br {
            bottom: 15mm;
            right: 15mm;
            border-bottom: 3px solid #7c3aed;
            border-right: 3px solid #7c3aed;
        }
        
        .content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding-top: 18mm;
        }
        
        .logo {
            width: 20mm;
            height: 20mm;
            margin: 0 auto 5mm;
            background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-inner {
            width: 10mm;
            height: 10mm;
            border: 2px solid white;
            border-radius: 50%;
            background: transparent;
        }
        
        .title {
            font-size: 36pt;
            font-weight: bold;
            color: #1f2937;
            letter-spacing: 6px;
            margin-bottom: 2mm;
            font-family: 'DejaVu Serif', Georgia, serif;
        }
        
        .subtitle {
            font-size: 12pt;
            color: #6b7280;
            letter-spacing: 4px;
            margin-bottom: 6mm;
        }
        
        .divider {
            width: 60mm;
            height: 1px;
            background: #7c3aed;
            margin: 5mm auto;
            opacity: 0.5;
        }
        
        .text-small {
            font-size: 10pt;
            color: #374151;
            margin-bottom: 3mm;
        }
        
        .student-name {
            font-size: 28pt;
            font-weight: bold;
            color: #581c87;
            margin: 3mm 0;
            font-family: 'DejaVu Serif', Georgia, serif;
        }
        
        .course-name {
            font-size: 20pt;
            font-weight: 600;
            color: #1f2937;
            margin: 3mm 0;
            padding: 0 25mm;
            line-height: 1.3;
        }
        
        .grade-section {
            margin: 6mm 0;
            padding: 0 40mm;
        }
        
        .grade-row {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        
        .grade-cell {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
            padding: 3mm 0;
        }
        
        .grade-value {
            font-size: 24pt;
            font-weight: bold;
            margin-bottom: 1mm;
        }
        
        .grade-label {
            font-size: 9pt;
            color: #6b7280;
        }
        
        .grade-a { color: #7c3aed; }
        .grade-b { color: #3b82f6; }
        .grade-c { color: #10b981; }
        
        .separator {
            display: table-cell;
            width: 1px;
            background: #d1d5db;
            vertical-align: middle;
            padding: 3mm 0;
        }
        
        .separator-line {
            width: 1px;
            height: 12mm;
            background: #d1d5db;
        }
        
        .date-text {
            font-size: 9pt;
            color: #6b7280;
            margin-top: 5mm;
        }
        
        .signatures {
            margin-top: 8mm;
            padding: 0 35mm;
        }
        
        .signature-row {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        
        .signature-cell {
            display: table-cell;
            text-align: center;
            padding: 0 8mm;
            vertical-align: bottom;
        }
        
        .signature-line {
            border-top: 2px solid #1f2937;
            padding-top: 2mm;
            margin-bottom: 1mm;
            min-width: 50mm;
            display: inline-block;
        }
        
        .signature-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 10pt;
        }
        
        .signature-title {
            font-size: 8pt;
            color: #6b7280;
            margin-top: 1mm;
        }
        
        .certificate-id {
            font-size: 7pt;
            color: #9ca3af;
            letter-spacing: 1.5px;
            margin-top: 3mm;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Borders -->
        <div class="border-outer"></div>
        <div class="border-inner"></div>
        
        <!-- Decorative Corners -->
        <div class="corner corner-tl"></div>
        <div class="corner corner-tr"></div>
        <div class="corner corner-bl"></div>
        <div class="corner corner-br"></div>
        
        <!-- Content -->
        <div class="content">
            <!-- Logo -->
            <div class="logo">
                <div class="logo-inner"></div>
            </div>
            
            <!-- Title -->
            <div class="title">CERTIFICATE</div>
            <div class="subtitle">OF ACHIEVEMENT</div>
            
            <!-- Divider -->
            <div class="divider"></div>
            
            <!-- Text -->
            <div class="text-small">This is to certify that</div>
            
            <div class="student-name">{{ $certificate->user->name }}</div>
            
            <div class="text-small">has successfully completed the course</div>
            
            <div class="course-name">{{ $certificate->class->name }}</div>
            
            <!-- Grades -->
            <div class="grade-section">
                <div class="grade-row">
                    <div class="grade-cell">
                        <div class="grade-value grade-a">{{ $certificate->letter_grade }}</div>
                        <div class="grade-label">Grade</div>
                    </div>
                    <div class="separator">
                        <div class="separator-line"></div>
                    </div>
                    <div class="grade-cell">
                        <div class="grade-value grade-b">{{ number_format($certificate->grade_point, 2) }}</div>
                        <div class="grade-label">GPA</div>
                    </div>
                    <div class="separator">
                        <div class="separator-line"></div>
                    </div>
                    <div class="grade-cell">
                        <div class="grade-value grade-c">{{ number_format($certificate->total_score, 2) }}</div>
                        <div class="grade-label">Score</div>
                    </div>
                </div>
            </div>
            
            <!-- Date -->
            <div class="date-text">
                Issued on {{ \Carbon\Carbon::createFromTimestamp($certificate->published_at)->format('F d, Y') }}
            </div>
            
            <!-- Signatures -->
            <div class="signatures">
                <div class="signature-row">
                    <div class="signature-cell">
                        <div class="signature-line">
                            <div class="signature-name">{{ $certificate->class->instructor->name }}</div>
                        </div>
                        <div class="signature-title">Course Instructor</div>
                    </div>
                    <div class="signature-cell">
                        <div class="signature-line">
                            <div class="signature-name">EduLearn</div>
                        </div>
                        <div class="signature-title">Learning Platform</div>
                    </div>
                </div>
            </div>
            
            <!-- Certificate ID -->
            <div class="certificate-id">
                CERTIFICATE ID: EDU-{{ str_pad($certificate->id, 8, '0', STR_PAD_LEFT) }}
            </div>
        </div>
    </div>
</body>
</html>