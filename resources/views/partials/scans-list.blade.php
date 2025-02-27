<table class="table-auto w-full">
    <thead>
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Time In</th>
            <th class="px-4 py-2">Time Out</th>
            <th class="px-4 py-2">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
            @php
                $studentScan = $scans->where('scanned_by', $student->name)->first();
            @endphp
            <tr>
                <td class="border px-4 py-2">{{ $student->id }}</td>
                <td class="border px-4 py-2">{{ $student->name }}</td>
                <td class="border px-4 py-2">
                    {{ $studentScan ? \Carbon\Carbon::parse($studentScan->scanned_at)->format('h:i A') : '-' }}
                </td>
                <td class="border px-4 py-2">
                    {{ $studentScan && $studentScan->verified_at ? \Carbon\Carbon::parse($studentScan->verified_at)->format('h:i A') : '-' }}
                </td>
                <td class="border px-4 py-2">
                    {{ $studentScan && $studentScan->verified_at ? 'Present' : 'Absent' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
