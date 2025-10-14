<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/bootstrap_5.0.2.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap_5.0.2.js') }}"></script>
    <title>Patient Report</title>
     <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .report-container {
            max-width: 220mm;
            margin: 0 auto;
            background: white;
            padding: 40px;
        }
        .nav-buttons {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .nav-btn {
            padding: 8px 16px;
            background: #3d91eb;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .nav-btn:hover {
            background: #3d91eb;
            color: white;
        }
        /* Header */
        .report-header {
            text-align: center;
            margin-bottom: 30px;  
        }
        .report-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        /* Patient Info */
        .patient-info {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .patient-info table {
            width: 100%;
            margin: 0;
        }
        .patient-info td {
            padding: 5px 15px;
            font-size: 14px;
        }

        .patient-info strong {
            color: #333;
        }
        .section-block {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 0 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #333;
        }
        .section-content {
            font-size: 14px;
            line-height: 1.7;
            color: #333;
            text-align: justify;
        }
        .section-content b {
            color: #000;
        }
        /* Tables */
        .data-table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
            font-size: 14px;
        }
        .data-table th {
            background: #333;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: 600;
        }
        .data-table td {
            padding: 8px 10px;
            border: 1px solid #dee2e6;
        }
        .data-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        .signature-content {
            display: none;
        }
        .hand-imagecontent{
            display: none;
        }

        @media (max-width: 768px) {
            .report-container {
                padding: 25px;
                box-shadow: none;
            }
            .patient-info table {
                display: block;
            }
            .patient-info tr {
                display: block;
                margin-bottom: 10px;
            }
            .patient-info td {
                display: block;
                padding: 3px 0;
            }
        }
        @media print {
            .report-header {
                text-align: center;
                margin-bottom: 30px; 
                padding-top: 20px;
                border-top: 2px solid #333;  
            }
            .signature-content {
                display: block !important;
                margin-top: 100px;
                text-align: right;
            }
            .hand-images{
                display: block !important;
              
            }
            .hand-imagecontent{
                display: block !important;
                page-break-inside: avoid;
                break-inside: avoid;
            }
            h6 {
                page-break-after: avoid;
                break-after: avoid;
            }
            h6+* {
                page-break-before: avoid;
                page-break-inside: avoid;
                break-inside: avoid;
            }
            .dynamic-text,
            .table,
            .table-responsive {
                page-break-inside: avoid;
                break-inside: avoid;
            }
            .section-block {
                page-break-inside: avoid;
                break-inside: avoid;
                margin-bottom: 12px;
            }
            @page {
                margin-top: 100px;
            }

            body {
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', Arial, sans-serif;
                font-size: 15px;
            }
            .report-container {
                padding-bottom: 50px; /* space for footer */
            }
            .page {
                page-break-after: always;
            }
            .page:last-child {
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>
    <div class="nav-buttons d-print-none">
        <a href="{{ route('report.show', ['regno' => $recordata->regno]) }}" class="btn d-print-none nav-btn">← Back</a>
        <a href="{{ url('reception/reglist') }}" class="btn d-print-none nav-btn">Home</a>
        <a href="" class="nav-btn d-print-none" onclick="window.print()">Print</a>
    </div>
    <div class="report-container">
        <!-- Header -->
        <div class="report-header">
            <h1 class="report-title"> {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $recordata->type)) }} Report</h1>
        </div>
        <div class="patient-info">
            <table>
                <tbody>
                    <tr>
                        <td><strong>Patient Name:</strong> {{ $recordata->name }}</td>
                        <td><strong>Reg No:</strong>  {{ $recordata->regno }}</td>
                    </tr>
                    <tr>
                        <td><strong>Age:</strong> {{ $recordata->age }}</td>
                        <td><strong>Sex:</strong>  {{ $recordata->sex }}</td>
                    </tr>
                    <tr>
                        <td><strong>Consultant:</strong>{{ $recordata->consultant }}</td>
                        <td><strong>Date of Evaluation:</strong> {{ $recordata->created_at->format('d-m-Y h:i A') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Dynamic Sections -->
        @php
            $hasRegionalExam = false; // flag to track if Regional Examination exists
        @endphp
        @foreach ($grouped as $title => $contents)
            <div class="section-block">
                <h6><b>{{ $title }}</b></h6>
                {{-- Motor Strength --}}
                @if($recordata->type === 'spine')
                    @if ( $title === 'Motor Strength')
                        @php
                            $muscles = ['Deltoid','Biceps','Triceps','Wrist_Ext','Grip','Finger_Abd','Psoas','Quads',
                                'Hamstrings','TA','G.Med','EHL','Gastroc'];
                            // Check if at least one muscle has data
                            $hasData = false;
                            foreach ($muscles as $muscle) {
                                if (!empty($contents[$muscle . '_right']) || !empty($contents[$muscle . '_left'])) {
                                    $hasData = true;
                                    break;
                                }
                            }
                        @endphp
                        @if ($hasData)
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Muscle</th>
                                            <th>Right</th>
                                            <th>Left</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($muscles as $muscle)
                                            @php
                                                $right = $contents[$muscle . '_right'] ?? null;
                                                $left = $contents[$muscle . '_left'] ?? null;
                                            @endphp
                                            @if ($right || $left)
                                                <tr>
                                                    <td>{{ str_replace('_', ' ', $muscle) }}</td>
                                                    <td>{{ $right ?? '-' }}</td>
                                                    <td>{{ $left ?? '-' }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif

                    {{-- Special Test --}}
                        @if ( $title === 'Special Test')
                        @php
                            $tests = ['Hoffman', 'Spurling', 'Phalen', "Tinel's", 'SLR', 'FNST'];
                            // Check if at least one test has data
                            $hasData = false;
                            foreach ($tests as $test) {
                                if (!empty($contents[$test . '_right']) || !empty($contents[$test . '_left'])) {
                                    $hasData = true;
                                    break;
                                }
                            }
                        @endphp
                        @if ($hasData)
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Test</th>
                                            <th>Right</th>
                                            <th>Left</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tests as $test)
                                            @php
                                                $right = $contents[$test . '_right'] ?? null;
                                                $left = $contents[$test . '_left'] ?? null;
                                            @endphp
                                            @if ($right || $left)
                                                <tr>
                                                    <td>{{ $test }}</td>
                                                    <td>{{ $right ?? '-' }}</td>
                                                    <td>{{ $left ?? '-' }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif
                    {{-- Dynamic Sentences --}}
                    @php
                        $templates = [
                            'Chief_Complaints' => 'presented with <b>:value</b>',
                            'history' => 'has a history of <b>:value</b>',
                            'Back' => 'reports <b>:value%</b> pain in the back',
                            'R_Leg' => 'reports <b>:value%</b> pain in the right leg',
                            'L_Leg' => 'reports <b>:value%</b> pain in the left leg',
                            'Neck' => 'reports <b>:value%</b> pain in the neck',
                            'R_Arm' => 'reports <b>:value%</b> pain in the right arm',
                            'L_Arm' => 'reports <b>:value%</b> pain in the left arm',
                            'Intensity_Pain_Rate' => 'with an intensity of <b>:value</b>',
                            'Intensity_Duration' => 'lasting for <b>:value</b>',
                            'Progression' => 'progressing as <b>:value</b>',
                            'Aggravating_factors' => 'aggravated by <b>:value</b>',
                            'Aggravating_factors_None' => 'with no significant aggravating factors, except <b>:value</b>',
                            'Alleviating_Factors' => 'relieved by <b>:value</b>',
                            'weakness' => 'experiencing weakness symptoms including <b>:value</b>',
                            'sensory' => 'experiencing sensory symptoms including <b>:value</b>',
                            'bladder' => 'experiencing bladder symptoms including <b>:value</b>',
                            'Incontinence' => 'experiencing bladder incontinence described as <b>:value</b>',
                            'bowel' => 'experiencing bowel symptoms including <b>:value</b>',
                            'Abnormal' => 'with abnormal bowel symptoms described as <b>:value</b>',
                            'Treatment_So_Far' => 'treatment taken so far includes <b>:value</b>',
                            'Meds' => 'has been on medication: <b>:value</b>',
                            'Physiotherapy' => 'has undergone physiotherapy: <b>:value</b>',
                            'Injections' => 'has received injections: <b>:value</b>',
                            'Injections_Trigger' => 'has received trigger point injections: <b>:value</b>',
                            'Past_Medical_History' => 'past medical history includes <b>:value</b>',
                            'Past_Medical_History_None' => 'has no significant past medical history, except <b>:value</b>',
                            'Past_surgical_history' => 'past surgical history includes <b>:value</b>',
                            'Current_meds' => 'is currently taking <b>:value</b>',
                            'Current_meds_none' => 'is not currently on any medications',
                            'Allergies' => 'is allergic to <b>:value</b>',
                            'Allergies_N/A' => 'has a reported allergy to <b>:value</b>',
                            'Social_History_NKDA' => 'social history reveals <b>:value</b>',
                            'Occupation' => 'works in an occupation involving <b>:value</b> physical activity',
                            'Work_status' => 'work status is <b>:value</b>',
                            'General_Appearance' => 'on examination, appears <b>:value</b>',
                            'General_Appearance_Distressed' => 'on examination, appears distressed with <b>:value</b>',
                            'Gait' => 'gait assessment shows <b>:value</b>',
                            'Posture_erect' => 'posture is erect with <b>:value</b>',
                            'Romberg_Test' => 'Romberg test was <b>:value</b>',
                            'Tenderness' => 'tenderness was observed in <b>:value</b>',
                            'ROM' => 'range of motion was <b>:value</b>',
                            'ROM_Restricted' => 'range of motion was restricted (<b>:value</b>)',
                            'sensation' => 'sensation is <b>:value</b>',
                            'Sensation_Decreased' => 'sensation is decreased, described as <b>:value</b>',
                            'Reflexes' => 'reflexes are <b>:value</b>',
                            'Babinski' => 'Babinski sign is <b>:value</b>',
                            'Resting_Tone' => 'resting tone on per rectal examination is <b>:value</b>',
                            'VAC' => 'voluntary anal contraction (VAC) is <b>:value</b>',
                            'sensations' => 'perianal sensations are <b>:value</b>',
                            'BCR' => 'bulbocavernosus reflex (BCR) is <b>:value</b>',
                            'Pulse' => 'pulse is <b>:value</b>',
                            'Shoulder_Peripheral_Nerve_TOS' => 'shoulder peripheral nerve (TOS) test is <b>:value</b>',
                            'Shoulder_Peripheral_Nerve_TOS_If_No' => 'if TOS test is not normal, findings include <b>:value</b>',
                            'Hip_SI_Joint' => 'hip SI joint test is <b>:value</b>',
                            'Hip_SI_Joint_If_No' => 'if SI joint test is not normal, it is described as <b>:value</b>',
                            'Provisional_Diagnosis' => 'provisional diagnosis is <b>:value</b>',
                            'Plan_of_Care' => 'plan of care is <b>:value</b>',
                        ];                 
                        $sentences = [];

                        foreach ($contents as $field => $value) {
                            if (isset($templates[$field])) {
                                $sentence = str_replace(':value', str_replace('_', ' ', strtolower($value)), $templates[$field]);
                                $sentences[] = $sentence;
                            }
                        }
                        
                        $finalText = '';
                        if (!empty($sentences)) {
                            if (count($sentences) > 1) {
                            $text = implode(', ', array_slice($sentences, 0, -1)) . ', ' . end($sentences) . '.';
                            }  elseif (count($sentences) === 1) {
                            $text = $sentences[0] . '.';
                            }
                            if (!preg_match('/^the patient/i', $text)) {
                                $text = 'The patient ' . ltrim($text, ', ');
                            }
                            $finalText = ucfirst($text);
                        }
                    @endphp
                    @if($finalText)
                    <p class="dynamic-text">
                        {!! $finalText !!}
                    </p>
                    @endif

                @elseif($recordata->type === 'spinal_deformity')
                    @php
                        $templates_spinal_deformity = [
                            'Chief_Complaints' => 'presented with <b>:value</b>',
                            '1st_Noticed_at_Age' => 'first noticed at the age of <b>:value</b>',
                            'Pain' => 'reports pain as <b>:value</b>',
                            'location' => 'with pain located at <b>:value</b>',
                            'Intensity_Pain_Rate' => 'with an intensity of <b>:value</b>',
                            'Intensity_Duration' => 'lasting for <b>:value</b>',
                            'Progression' => 'progressing as <b>:value</b>',
                            'Aggravating_factors' => 'aggravated by <b>:value</b>',
                            'Alleviating_factors' => 'relieved by <b>:value</b>',
                            'Weakness' => 'with weakness of <b>:value</b>',
                            'Weakness_Unsteady_gait' => 'with weakness and unsteady gait described as <b>:value</b>',
                            'Sensory' => 'with sensory symptoms including <b>:value</b>',
                            'Sensory_paresthesia' => 'with sensory paresthesia described as <b>:value</b>',
                            'Bladder' => 'with bladder function reported as <b>:value</b>',
                            'bladder_description' => 'bladder symptoms described as <b>:value</b>',
                            'Treatment_so_for' => 'treatment so far includes <b>:value</b>',
                            'Bracing_Casting' => 'has undergone bracing/casting: <b>:value</b>',
                            'Physiotherapy' => 'has undergone physiotherapy: <b>:value</b>',
                            'Past_Medical_History' => 'past medical history includes <b>:value</b>',
                            'Past_Medical_History_Description' => 'details regarding past medical history: <b>:value</b>',
                            'Past_Surgical_History' => 'past surgical history includes <b>:value</b>',
                            'Past_Surgical_History_Description' => 'details regarding past surgical history: <b>:value</b>',
                            'Current_MEDs' => 'currently taking medications: <b>:value</b>',
                            'Current_MEDs_Description' => 'details regarding current medications: <b>:value</b>',
                            'Allergies' => 'allergies noted as <b>:value</b>',
                            'Allergies_Description' => 'details regarding allergies: <b>:value</b>',
                            'Family_History' => 'family history includes <b>:value</b>',
                            'Parents' => 'parental history includes <b>:value</b>',
                            'Non-consanguity' => 'non-consanguinity details: <b>:value</b>',
                            'Siblings' => 'siblings history includes <b>:value</b>',
                            'Siblings_Description' => 'details regarding siblings: <b>:value</b>',
                            'Birth_History' => 'birth history includes <b>:value</b>',
                            'Birth_History_Description' => 'details regarding birth history: <b>:value</b>',
                            'Development' => 'developmental history includes <b>:value</b>',
                            'Development_Delayed' => 'delayed development noted as <b>:value</b>',
                            'Learning_Disability' => 'learning disability status: <b>:value</b>',
                            'Onset_of_Menses' => 'onset of menses at <b>:value</b>',
                            'Social_History' => 'social history includes <b>:value</b>',
                            'Others' => 'additional social details: <b>:value</b>',
                            'Height' => 'height is <b>:value</b>',
                            'Weight' => 'weight is <b>:value</b>',
                            'Arm_Span' => 'arm span is <b>:value</b>',
                            'Gait' => 'gait observed as <b>:value</b>',
                            'Posture' => 'posture observed as <b>:value</b>',
                            'Tenderness' => 'tenderness noted at <b>:value</b>',
                            'paraspinal' => 'paraspinal tenderness described as <b>:value</b>',
                            'Trunk_Exam' => 'trunk examination shows <b>:value</b>',
                            'High_Thoracic_prominence' => 'forward bend test revealed high thoracic prominence on the <b>:value</b> side',
                            'Thoracic_prominence' => 'forward bend test revealed thoracic prominence on the <b>:value</b> side',
                            'TL_prominence' => 'forward bend test revealed thoracolumbar prominence on the <b>:value</b> side',
                            'Lumbar_prominence' => 'forward bend test revealed lumbar prominence on the <b>:value</b> side',
                            'ROM' => 'range of motion was <b>:value</b>',
                            'Push_prone_test' => 'push-prone test findings: <b>:value</b>',
                            'Suspension_(Traction)' => 'flexibility (suspension/traction) result: <b>:value</b>',
                            'Bending' => 'flexibility (bending) result: <b>:value</b>',
                            'Prone_hyperextension_test' => 'flexibility (prone hyperextension) result: <b>:value</b>',
                            'Motor_Strength' => 'motor strength is <b>:value</b>',
                            'Sensations_Intact' => 'sensations intact: <b>:value</b>',
                            'Hoffman' => 'Hoffman\'s sign: <b>:value</b>',
                            'Basinski' => 'Babinski\'s sign: <b>:value</b>',
                            'SLR-FST' => 'SLR/FST test result: <b>:value</b>',
                            'SLR/FST_Free' => 'SLR/FST details: <b>:value</b>',
                            'PULSE' => 'pulse is <b>:value</b>',
                            'Pulse_Description' => 'pulse details: <b>:value</b>',
                            'HIP_ROM' => 'hip ROM is <b>:value</b>',
                            'Thomas_Test' => 'Thomas test: <b>:value</b>',
                            'KNEE_ROM' => 'knee ROM is <b>:value</b>',
                            'Knee_ROM' => 'knee ROM details: <b>:value</b>',
                            'High_Arched_palate' => 'high-arched palate: <b>:value</b>',
                            'Facial_asymmetry' => 'facial asymmetry: <b>:value</b>',
                            'Cafe_Au_Lait_Spots' => 'café-au-lait spots: <b>:value</b>',
                            'Hair/Skin_pigmentation' => 'abnormal hair/skin pigmentation: <b>:value</b>',
                            'Skin_Hyperelasticity' => 'skin hyperelasticity: <b>:value</b>',
                            'Scars' => 'scars noted: <b>:value</b>',
                            'Joint_Hyperelasticity' => 'joint hyperelasticity: <b>:value</b>',
                            'Arachnodacytly' => 'arachnodactyly: <b>:value</b>',
                            'Chest_asymmetry' => 'chest asymmetry: <b>:value</b>',
                            'Anterior_chest_deformity' => 'anterior chest deformity: <b>:value</b>',
                            'Breath_hold_count' => 'breath-hold count: <b>:value</b>',
                            'Tanner_stage' => 'Tanner stage: <b>:value</b>',
                            'Axillary_hair' => 'axillary hair: <b>:value</b>',
                            'Axillary_hair_Description' => 'axillary hair details: <b>:value</b>',
                            'Breasts_development' => 'breast development: <b>:value</b>',
                            'Breasts_development_Description' => 'breast development details: <b>:value</b>',
                            'Pubic_Hair' => 'pubic hair: <b>:value</b>',
                            'Pubic_Hair_Description' => 'pubic hair details: <b>:value</b>',
                            'Other_MSK_findings' => 'other musculoskeletal findings: <b>:value</b>',
                            'Other_MSK_findings_Description' => 'musculoskeletal details: <b>:value</b>',
                            'Foot_abnormality' => 'foot abnormalities: <b>:value</b>',
                            'Foot_abnormality_Description' => 'foot abnormality details: <b>:value</b>',
                            'Leg_Length_Difference' => 'leg length difference: <b>:value</b>',
                            'Leg_Length_Difference_Description' => 'leg length discrepancy details: <b>:value</b>',
                            'PT_Cobb' => 'PT Cobb angle: <b>:value</b>',
                            'Thoracic_K' => 'thoracic kyphosis: <b>:value</b>',
                            'Rissers' => 'Risser sign: <b>:value</b>',
                            'MT_Cobb' => 'MT Cobb angle: <b>:value</b>',
                            'TL_Kyphosis' => 'thoracolumbar kyphosis: <b>:value</b>',
                            'Triradiate' => 'triradiate cartilage: <b>:value</b>',
                            'TL/L_Cobb' => 'TL/L Cobb angle: <b>:value</b>',
                            'L_Lordosis' => 'lumbar lordosis: <b>:value</b>',
                            'Sanders' => 'Sanders stage: <b>:value</b>',
                            'MRI' => 'MRI findings: <b>:value</b>',
                            'Diagnosis' => 'diagnosed with <b>:value</b>',
                        ];

                    $sentences = [];

                        foreach ($contents as $field => $value) {
                            if (isset($templates_spinal_deformity[$field])) {
                                $sentence = str_replace(':value', str_replace('_', ' ', strtolower($value)), $templates_spinal_deformity[$field]);
                                $sentences[] = $sentence;
                            }
                        }
                        
                        $finalText = '';
                        if (!empty($sentences)) {
                            if (count($sentences) > 1) {
                            $text = implode(', ', array_slice($sentences, 0, -1)) . ', ' . end($sentences) . '.';
                            }  elseif (count($sentences) === 1) {
                            $text = $sentences[0] . '.';
                            }
                            if (!preg_match('/^the patient/i', $text)) {
                                $text = 'The patient ' . ltrim($text, ', ');
                            }
                            $finalText = ucfirst($text);
                        }
                    @endphp

                    @if($finalText)
                        <p class="dynamic-text">
                            {!! $finalText !!}
                        </p>
                    @endif

                    @if ($recordata->type === 'spinal_deformity' && $title === 'Motor Strength')
                        @php
                            $muscles = ['Deltoid','Biceps','Triceps','Wrist_Ex','Grip','Fing_Abd'];
                            // Check if at least one muscle has data
                            $hasData = false;
                            
                            foreach ($muscles as $muscle) {
                                if (!empty($contents[$muscle . '_Right']) || !empty($contents[$muscle . '_Left'])) {
                                    $hasData = true;
                                    break;
                                }
                            }
                        @endphp
                        @if ($hasData)
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Right</th>
                                            <th>Left</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($muscles as $muscle)
                                            @php
                                                $right = $contents[$muscle . '_Right'] ?? null;
                                                $left = $contents[$muscle . '_Left'] ?? null;
                                            @endphp
                                            @if ($right || $left)
                                                <tr>
                                                    <td>{{ str_replace('_', ' ', $muscle) }}</td>
                                                    <td>{{ $right ?? '-' }}</td>
                                                    <td>{{ $left ?? '-' }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif
                    @if ($recordata->type === 'spinal_deformity' && $title === 'Motor Strength')
                        @php
                            $muscles = ['Psoas','G_Med','Quads','TA','Gastroc','EHL'];
                            // Check if at least one muscle has data
                            $hasData = false;
                            
                            foreach ($muscles as $muscle) {
                                if (!empty($contents[$muscle . '_Right']) || !empty($contents[$muscle . '_Left'])) {
                                    $hasData = true;
                                    break;
                                }
                            }
                        @endphp
                        @if ($hasData)
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Right</th>
                                            <th>Left</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($muscles as $muscle)
                                            @php
                                                $right = $contents[$muscle . '_Right'] ?? null;
                                                $left = $contents[$muscle . '_Left'] ?? null;
                                            @endphp
                                            @if ($right || $left)
                                                <tr>
                                                    <td>{{ str_replace('_', ' ', $muscle) }}</td>
                                                    <td>{{ $right ?? '-' }}</td>
                                                    <td>{{ $left ?? '-' }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif
                @elseif($recordata->type === 'shoulder_elbow')
                    @if ($recordata->type === 'shoulder_elbow' && $title === 'Movements-shoulder')
                            @php
                                $muscles = ['Flexion','Extension','Internal_Rotation(IR)','External_Rotation(ER)','Adduction','Abduction'];
                                // Check if at least one muscle has data
                                $hasData = false;
                                
                                foreach ($muscles as $muscle) {
                                    if (!empty($contents[$muscle . '_active']) || !empty($contents[$muscle . '_passive'])) {
                                        $hasData = true;
                                        break;
                                    }
                                }
                            @endphp
                            @if ($hasData)
                                <div class="table-responsive mb-3">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Active</th>
                                                <th>Pasive</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($muscles as $muscle)
                                                @php
                                                    $right = $contents[$muscle . '_active'] ?? null;
                                                    $left = $contents[$muscle . '_passive'] ?? null;
                                                @endphp
                                                @if ($right || $left)
                                                    <tr>
                                                        <td>{{ str_replace('_', ' ', $muscle) }}</td>
                                                        <td>{{ $right ?? '-' }}</td>
                                                        <td>{{ $left ?? '-' }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endif
                    @php
                        $templates_shoulder_elbow = [
                            'Chief_Complaint' => 'The Patient presented with <b>:value</b>',
                            'Side' => 'involving the <b>:value</b> side',
                            'Symptoms_Duration' => 'for the past <b>:value</b>',
                            'Onset' => 'with <b>:value</b> onset',
                            'Radiation' => 'with radiation of pain to the <b>:value</b>',
                            'Character' => 'pain of <b>:value</b> character',
                            'Aggravating_factors' => 'aggravated by <b>:value</b>',
                            'Aggravating_factors_others' => 'specifically aggravated by <b>:value</b>',
                            'Relieving_factors' => 'relieved by <b>:value</b>',
                            'Relieving_factors_Others' => 'specifically relieved by <b>:value</b>',
                            'Relation_to_trauma' => 'with history of trauma <b>:value</b>',
                            'Relation_to_trauma_Description' => 'with description of trauma as <b>:value</b>',
                            'Any_H/O_fever' => 'with history of fever <b>:value</b>',
                            'Instability' => 'with complaint of instability being <b>:value</b>',
                            'Onset_&_Duration' => 'with onset and duration being <b>:value</b>',
                            'Associated_Movements' => 'associated with movements such as <b>:value</b>',
                            'How_Frequent' => 'occurring with a frequency of <b>:value</b>',
                            'No_of_Dislocation' => 'with number of dislocations being <b>:value</b>',
                            'Pain_Severity' => 'with pain severity rated as <b>:value</b>',
                            'Prior_Treatments_Attempted' => 'with prior treatments attempted including <b>:value</b>',
                            'Prior_Treatment_Attempted' => 'with no prior treatments attempted',
                            'Shoulder_dislocation' => 'history of shoulder dislocation as <b>:value</b>',
                            'Pain_is_worst_in' => 'pain is worst in the <b>:value</b>',
                            'Activity_of_daily_living' => 'affecting activities of daily living such as <b>:value</b>',
                            'Patient_had_Similiar_complaint_in_the_Past' => 'with a history of similar complaints in the past being <b>:value</b>',
                            'fatigue' => 'with <b>:value</b> fatigue',
                            'Fatigue' => 'complaints of fatigue including <b>:value</b>',
                            'Bladder' => 'with bladder complaints such as <b>:value</b>',
                            'Bowel' => 'with bowel complaints such as <b>:value</b>',
                            'Fever' => 'with complaints of fever <b>:value</b>',
                            'Weight_loss' => 'with complaints of weight loss <b>:value</b>',
                            'Weight_gain' => 'with complaints of weight gain <b>:value</b>',
                            'Loss_of_Appetite' => 'with complaints of loss of appetite <b>:value</b>',
                            'Others' => 'with other complaints including <b>:value</b>',
                            'Alcohol' => 'with history of alcohol use as <b>:value</b>',
                            'Smoking' => 'with history of smoking as <b>:value</b>',
                            'Job' => 'with occupation being <b>:value</b>',
                            'Sports' => 'with participation in sports such as <b>:value</b>',
                            'Personal_History_Others' => 'with other personal history including <b>:value</b>',
                            'Hypertension' => 'with history of hypertension Since <b>:value</b>',
                            'Thyroid' => 'with history of thyroid disorder for <b>:value</b>',
                            'Diabetics' => 'with history of diabetes Since <b>:value</b>',
                            'Tuberculosis' => 'with history of tuberculosis for <b>:value</b>',
                            'Heart_Disorder' => 'with history of heart disorder <b>:value</b>',
                            'Heart_Disorder(Since)' => 'since <b>:value</b>',
                            'Liver_Disease' => 'with history of liver disease <b>:value</b>',
                            'Liver_Disease(Since)' => 'since <b>:value</b>',
                            'Renal_Problem' => 'with history of renal problem <b>:value</b>',
                            'Renal_Problem(Since)' => 'since <b>:value</b>',
                            'Gastro_-_Enterology' => 'with history of gastroenterology disorder <b>:value</b>',
                            'Gastro_-_Enterology(Since)' => 'since <b>:value</b>',
                            'Respiratory' => 'with history of respiratory disorder <b>:value</b>',
                            'Respiratory(Since)' => 'since <b>:value</b>',
                            'Neurology' => 'with history of neurological disorder <b>:value</b>',
                            'Neurology(Since)' => 'since <b>:value</b>',
                            'Previous_Surgery' => 'with history of previous surgery <b>:value</b>',
                            'Previous_Surgery(Since)' => 'since <b>:value</b>',
                            'Previous_Surgery_1' => 'with history of previous surgery <b>:value</b>',
                            'Previous_Surgery_1(Since)' => 'since <b>:value</b>',
                            'Other_Disorders' => 'with history of other disorders <b>:value</b>',
                            'Other_Disorders(Since)' => 'since <b>:value</b>',
                            'Inspection' => 'on inspection of the shoulder <b>:value</b>',
                            'Skin' => 'skin over the shoulder showing <b>:value</b>',
                            'Swelling' => 'with swelling being <b>:value</b>',
                            'Asymmetry' => 'with asymmetry noted as <b>:value</b>',
                            'Specific_Finding' => 'specific findings on shoulder inspection include <b>:value</b>',
                            'Anteriorly' => 'on palpation anteriorly <b>:value</b>',
                            'Lateral_Aspect' => 'on palpation over the lateral aspect <b>:value</b>',
                            'Posteriorly' => 'on palpation posteriorly <b>:value</b>',
                            'Other_Findings' => 'other findings on shoulder examination include <b>:value</b>',
                            'Neer\'s_Impingement_Sign' => 'Neer\'s impingement sign shows <b>:value</b>',
                            'Neer\'s_Impingement_Test' => 'Neer\'s impingement test reveals <b>:value</b>',
                            'Hawkins_-_Kennedy_Test' => 'Hawkins-Kennedy test demonstrates <b>:value</b>',
                            'Drop_Arm_Test' => 'Drop Arm test indicates <b>:value</b>',
                            'Herber\'s_Test' => 'Herber\'s test shows <b>:value</b>',
                            'Jobe\'s_Test' => 'Jobe\'s test reveals <b>:value</b>',
                            'Test_for_Infraspinatus_&_Teres_Minor' => 'Test for infraspinatus and teres minor shows <b>:value</b>',
                            'Anterior_Instability' => 'anterior instability test shows <b>:value</b>',
                            'Apprehension_Test' => 'apprehension test demonstrates <b>:value</b>',
                            'Relocation_Test_(Jobe\'s)' => 'relocation test (Jobe\'s) reveals <b>:value</b>',
                            'Sulcus_Sign' => 'Sulcus sign indicates <b>:value</b>',
                            'Central_Nervous_System(CNS)' => 'central nervous system examination reveals <b>:value</b>',
                            'Cardiovascular_System(CVS)' => 'cardiovascular system examination shows <b>:value</b>',
                            'Respiratory_System(RS)' => 'respiratory system examination indicates <b>:value</b>',
                            'Spine-Neurology' => 'spine and neurological examination demonstrates <b>:value</b>',
                            'Proposed_Diagnosis' => '<br>proposed diagnosis includes <b>:value</b>',
                            'From_Front' => 'on inspection from the front <b>:value</b>',
                            'From_Lateral_Aspect' => 'on inspection from the lateral aspect <b>:value</b>',
                            'From_Medical_Aspect' => 'on inspection from the medial aspect <b>:value</b>',
                            'Posterior_Aspect' => 'on inspection from the posterior aspect <b>:value</b>',
                            'skin' => 'skin over the elbow showing <b>:value</b>',
                            'swelling' => 'with swelling being <b>:value</b>',
                            'asymmetry' => 'with asymmetry noted as <b>:value</b>',
                            'Palpation' => 'on palpation of the elbow <b>:value</b>',
                            'Three_Point_Relation_Ship' => 'three point relationship of the elbow appears <b>:value</b>',
                            'Flexion' => 'flexion of the elbow is <b>:value</b>',
                            'Extension' => 'extension of the elbow is <b>:value</b>',
                            'Hyper_Extension' => 'hyperextension of the elbow is <b>:value</b>',
                            'Supination' => 'supination of the elbow is <b>:value</b>',
                            'Pronation' => 'pronation of the elbow is <b>:value</b>',
                            'Varus_Stress_Test' => 'varus stress test shows <b>:value</b>',
                            'Valgus_Stress_Test' => 'valgus stress test shows <b>:value</b>',
                            'Pivot_Shift_Test' => 'pivot shift test reveals <b>:value</b>',
                            'Test_for_Lateral_Epicondylitis' => 'test for lateral epicondylitis demonstrates <b>:value</b>',
                            'Other_System_Examination' => 'other system examination of the elbow reveals <b>:value</b>',
                            'Diagnosis' => '<br>proposed diagnosis for the elbow includes <b>:value</b>',
                            ];
                            $sentences = [];

                            foreach ($contents as $field => $value) {
                                if (isset($templates_shoulder_elbow[$field])) {
                                    $sentence = str_replace(':value', str_replace('_', ' ', strtolower($value)), $templates_shoulder_elbow[$field]);
                                    $sentences[] = $sentence;
                                }
                            }

                            $finalText = '';
                            if (!empty($sentences)) {
                            if (count($sentences) > 1) {
                            $text = implode(', ', array_slice($sentences, 0, -1)) . ', ' . end($sentences) . '.';
                            }  elseif (count($sentences) === 1) {
                            $text = $sentences[0] . '.';
                            }
                            if (!preg_match('/^the patient/i', $text)) {
                                $text = 'The patient ' . ltrim($text, ', ');
                            }
                            $finalText = ucfirst($text);
                        }
                    @endphp
                    @if($finalText)
                        <p class="dynamic-text">
                            {!! $finalText !!}
                        </p>
                    @endif
                    
                    @elseif($recordata->type === 'hand_wrist')
                @php
                $templates_handwrist= [
                    'dominant_hand' => "The patient's dominant hand is <b>:value</b>",
                    'chief_complaints' => 'The patient presented with <b>:value</b>',
                    'side'                 => "Affected side is <b>:value</b>",
                    'onset'                => "onset was <b>:value</b>",
                    'duration'             => "symptoms have been present for <b>:value</b>",
                    'character_pain'       => "pain is described as <b>:value</b>",
                    'Aggravating_factors'  => "<br>Pain is aggravated by <b>:value</b>",
                    'Aggravating_factors_other' => "additional details reported as <b>:value</b>",
                    'relieving_factors'    => "Pain is relieved by <b>:value</b>",
                    'relieving_factors_others' => "additional details reported as <b>:value</b>",
                    'relation_to_trauma'   => "had a history of trauma <b>:value</b>",
                    'history_of_feveryes'   => " <br>The patient had a fever <b>:value</b>",
                    'history_fever_yes'    => "with a <b>:value</b>",
                    'history_of_feverno'   => "<br>The patient did not have any fever",
                    'pain_severity'        => "reports a pain severity of <b>:value</b>",
                    'pain_worst'           => "Pain is worst in <b>:value</b>",
                    'treatment_attempted'  => "previously attempted <b>:value</b>",
                    'activities_daily_living' => "reports <b>:value</b>",
                    'patient_complaints_past' => " had similar complaints in the past <b>:value</b>",
                    'fatigue'              => "Report as <b>:value</b> ",
                    'fatigue_yes'          => "has <b>:value</b>",
                    'bladder'                => "has <b>:value</b> bladder symptoms",
                    'bowel'                 => "has <b>:value</b> bowel symptoms",
                    'fever'                 => "has <b>:value</b> fever",
                    'weight_loss'           => "reports <b>:value</b> weight loss",
                    'weight_gain'           => "reports <b>:value</b> weight gain",
                    'loss_appetite'         => "has <b>:value</b> loss of appetite",
                    'Other_Complaint'      => "also reports <b>:value</b>",
                    'Hypertension'         => "has hypertension since <b>:value</b>",
                    'Thyroid'              => "has a thyroid disorder for <b>:value</b>",
                    'Diabetics'            => "has diabetes since <b>:value</b>",
                    'Tuberculosis'         => "has a history of tuberculosis for <b>:value</b>",
                    'Heart_Disorder'       => "has a heart disorder <b>:value</b>",
                    'Heart_Disorder_since' => "since <b>:value</b>",
                    'Liver_Disease'        => "has liver disease <b>:value</b>",
                    'Liver_Disease_since'  => "since <b>:value</b>",
                    'Renal_Problem'        => " has a renal problem <b>:value</b>",
                    'Renal_Problem_since'  => "since <b>:value</b>",
                    'Gastro_Enterology'    => "has a gastro-enterology issue <b>:value</b>",
                    'Gastro_Enterology_since' => "since <b>:value</b>",
                    'Respiratory'          => "has a respiratory issue <b>:value</b>",
                    'Respiratory_since'    => "since <b>:value</b>",
                    'Neurology'            => "has a neurological issue <b>:value</b>",
                    'Neurology_since'      => " since <b>:value</b>",
                    'Previous_Surgery'     => "underwent surgery <b>:value</b>",
                    'Previous_Surgery_since' => "since <b>:value</b>",
                    'Previous_Surgery_1'   => " underwent surgery-1 <b>:value</b>",
                    'Previous_Surgery_1_since' => "since<b>:value</b>",
                    'Other'                => "additionally reports the <b>:value</b>",
                    'Other_since'          => "since <b>:value</b>",
                    'Alcohol' => "consumes alcohol <b>:value</b>",
                    'Smoking' => "smokes <b>:value</b>",
                    'Job' => "works as <b>:value</b>",
                    'Sports' => "plays <b>:value</b>",
                    'Others' => "other activities include <b>:value</b>",
                    'Allergies'  => "has allergies: <b>:value</b>",
                    'Dorsiflexion' => "dorsiflexion is <b>:value</b>",
                    'Palmar_Flexion' => "palmar flexion is <b>:value</b>",
                    'finger_movements' => "finger movements are <b>:value</b>",
                    'thumb_movements' => "thumb movements are <b>:value</b>",
                    'tinel_sign' => "shows Tinel's sign <b>:value</b>",
                    'phalen_test' => " Phalen's test <b>:value</b>",
                    'Durkan_Compression_Test' => " Durkan's compression test <b>:value</b>",
                    'Finkelstein_Test' => " Finkelstein's test <b>:value</b>",
                    'DRUJ_Instability_Test' => " DRUJ instability test <b>:value</b>",
                    'diagnosis' => "has a diagnosis of  <b>:value</b> "
                    ];
                    $sentences2 = [];
                    foreach ($contents as $field => $value) {
                        if (isset($templates_handwrist[$field]) && !empty($value)) {
                            $sentence = str_replace(':value', str_replace('_', ' ', strtolower($value)), $templates_handwrist[$field]);
                            $sentences2[] = trim($sentence);
                        }
                    }
                    $finalText = '';
                    if (!empty($sentences2)) {
                        if (count($sentences2) > 1) {
                        $text = implode(', ', array_slice($sentences2, 0, -1)) . ', ' . end($sentences2) . '.';
                        }  elseif (count($sentences2) === 1) {
                        $text = $sentences2[0] . '.';
                        }
                        if (!preg_match('/^the patient/i', $text)) {
                            $text = 'The patient ' . ltrim($text, ', ');
                        }
                        $finalText = ucfirst($text);
                    }
                @endphp
                @if(!empty($finalText))
                    <p class="dynamic-text">{!! $finalText !!}</p>
                @endif 
                {{-- Regional examination --}}
                @if($title === 'Regional Examination' && $recordata->type == 'hand_wrist')
                    @php
                        $hasRegionalExam = true;
                        $templates_regional= [
                            'Inspection' => "inspection shows <b>:value</b>",
                            'Palpation' => "palpation reveals <b>:value</b>",
                            'Deformity' => "deformity observed <b>:value</b>",
                        ];
                        foreach ($contents as $field => $value) {
                            if (isset($templates_regional[$field])) {
                                $sentence = ucfirst(str_replace(':value', str_replace('_', ' ', strtolower($value)), $templates_regional[$field]));
                                $sentences[] = $sentence;
                            }
                        }
                        $finalText = '';
                        if (!empty($sentences)) {
                            if (count($sentences) > 1) {
                            $text = implode(', ', array_slice($sentences, 0, -1)) . ', ' . end($sentences) . '.';
                            }  elseif (count($sentences) === 1) {
                            $text = $sentences[0] . '.';
                            }
                            if (!preg_match('/^the patient/i', $text)) {
                                $text = 'The patient ' . ltrim($text, ', ');
                            }
                            $finalText = ucfirst($text);
                        }
                    @endphp
                     <div class="hand-section">
                        @if(!empty($finalText))
                        <p class="dynamic-text">{!! $finalText !!}</p>
                        @endif 
                        <div class="hand-images" style="text-align: center; display:none;">
                            <img src="{{ asset('Image/hand.jpg') }}" alt="Hand Image" style="width:150px; margin-bottom:10px;">
                        </div>
                    </div>
                  @endif
                @endif
            </div>
        @endforeach
         @if(!$hasRegionalExam && $recordata->type == 'hand_wrist')
        <div class="hand-imagecontent">
            <h6 class="hand-text" ><strong> Regional Examination: </strong></h6>
            <div class="hand-image" style="text-align:center;">
                <img src="{{ asset('Image/hand.jpg') }}" alt="Hand Image" style=" width:150px; margin-bottom:10px;">
            </div>
        </div>
        @endif
        <div class="signature-content">
           <span><strong>{{ $recordata->consultant }}</strong></span> 
        </div>
    </div>
</body>
</html>
