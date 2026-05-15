<?php

namespace App\Imports;

use App\Models\StudentRecord;
use App\SmStudent;
use App\StudentAttendanceBulk;
use App\Support\Imports\ParsesExcelDates;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentAttendanceImport implements ToModel, WithHeadingRow, WithStartRow
{
    use ParsesExcelDates;

    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public $class;

    public $section;

    public function __construct($class, $section)
    {
        $this->class = $class;
        $this->section = $section;
    }

    public function model(array $row)
    {
        $attendanceDate = $this->parseExcelDate($row['attendance_date'] ?? null);
        $student = SmStudent::select('id')->where('admission_no', $row['admission_no'] ?? null)->where('school_id', Auth::user()->school_id)->first();

        if ($student && $attendanceDate) {
            $record = StudentRecord::where('student_id', $student->id)->where('class_id', $this->class)->where('section_id', $this->section)->first();
            return new StudentAttendanceBulk([
                'attendance_date' => $attendanceDate,
                'attendance_type' => $row['attendance_type'] ?? null,
                'note' => $row['note'] ?? null,
                'student_id' => $student->id,
                'class_id' => $this->class,
                'section_id' => $this->section,
                'student_record_id' => @$record->id,
                'school_id' => Auth::user()->school_id,
            ]);
        }

        return null;

    }

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
