<?php

namespace App\Imports;

use App\Models\Subject;
use App\Models\User;
use App\Models\User_Subject; // Assuming you have a model for the pivot table
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubjectImport implements ToCollection, WithHeadingRow
{
    private $schoolYear;
    private $semester;
    private $duplicateSubjects = [];
    private $duplicateInstructors = [];

    public function __construct($schoolYear, $semester)
    {
        $this->schoolYear = $schoolYear;
        $this->semester = $semester;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Skip rows where the 'name' is empty, assuming this is a required field
            if (empty($row['name'])) {
                continue;
            }

            // Check if any of the key subject fields are null
            $isNullField = empty($row['name']) || empty($row['code']) || empty($row['description']) || empty($row['section']);

            // Check for duplicate subjects
            $existingSubject = Subject::where('day', $row['day'])
                                      ->where('section', $row['section'])
                                      ->where('school_year', $this->schoolYear)
                                      ->where('semester', $this->semester)
                                      ->first();

            if ($existingSubject) {
                $this->duplicateSubjects[] = [
                    'code' => $row['code'],
                    'day' => $row['day'],
                    'section' => $row['section'],
                ];
                continue;
            }

            $generatedCode = mt_rand(11111111111, 99999999999);

            // Create the subject
            $subject = Subject::create([
                'name' => $row['name'] ?? null,
                'code' => $row['code'] ?? null,
                'description' => $row['description'] ?? null,
                'section' => $row['section'] ?? null,
                'qr' => $row['qr'] ?? $generatedCode,
                'start_time' => $this->formatTime($row['start_time']),
                'end_time' => $this->formatTime($row['end_time']),
                'day' => $row['day'],
                'image' => $row['image'],
                'school_year' => $this->schoolYear,
                'semester' => $this->semester,
            ]);

            // Check for duplicate instructors
            $existingInstructor = User::where('instructor_number', $row['instructor_number'])
                                      ->orWhere('email', $row['email'])
                                      ->first();

            if ($existingInstructor) {
                $this->duplicateInstructors[] = [
                    'instructor_number' => $row['instructor_number'],
                    'email' => $row['email'],
                ];
                $this->linkUserToSubject($existingInstructor, $subject); // Link the instructor to the subject
                continue;
            }

            // Insert the instructor into the users table
            $user = User::create([
                'instructor_number' => $row['instructor_number'] ?? null,
                'username' => $row['instructor'] ?? null,
                'email' => $row['email'] ?? null,
                'school_year' => $this->schoolYear,
                'semester' => $this->semester,
            ]);

            // Link the instructor to the subject
            $this->linkUserToSubject($user, $subject);
        }
    }

    /**
     * Link the instructor (user) to the subject.
     */
    private function linkUserToSubject(User $user, Subject $subject)
    {
        // Insert the user-subject relationship into the user_subject table
        User_Subject::firstOrCreate([
            'user_id' => $user->id,
            'subject_id' => $subject->id,
        ]);
    }

    public function getDuplicateSubjects()
    {
        return $this->duplicateSubjects;
    }

    public function getDuplicateInstructors()
    {
        return $this->duplicateInstructors;
    }

    private function formatTime($decimal)
    {
        if (is_null($decimal)) {
            return null;
        }

        $hours = floor($decimal * 24);
        $minutes = floor(($decimal * 24 - $hours) * 60);
        $seconds = floor((($decimal * 24 - $hours) * 60 - $minutes) * 60);

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
