<?php

namespace App\Imports;

use App\SmStaff;
use App\SmStaffAttendanceImport;
use App\Support\Imports\ParsesExcelDates;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StaffAttendanceBulk implements ToModel, WithHeadingRow, WithStartRow
{
    use ParsesExcelDates;

    public function model(array $row)
    {
        $staffIdentifier = $row['staff_id'] ?? $row['staff_no'] ?? null;
        $attendanceDate = $this->parseExcelDate($row['attendence_date'] ?? $row['attendance_date'] ?? null);
        $inTime = $this->parseExcelDate($row['in_time'] ?? null, 'h:i A');
        $outTime = $this->parseExcelDate($row['out_time'] ?? null, 'h:i A');

        if (! $staffIdentifier || ! $attendanceDate) {
            return null;
        }

        $staff = SmStaff::where('school_id', Auth::user()->school_id)
            ->where(function ($query) use ($staffIdentifier): void {
                $query->where('id', $staffIdentifier)
                    ->orWhere('staff_no', $staffIdentifier);
            })
            ->first();

        if (! $staff) {
            return null;
        }

        return new SmStaffAttendanceImport([
            'attendence_date' => $attendanceDate,
            'in_time' => $inTime,
            'out_time' => $outTime,
            'attendance_type' => $row['attendance_type'] ?? null,
            'notes' => $row['notes'] ?? null,
            'staff_id' => $staff->id,
            'school_id' => Auth::user()->school_id,
            'academic_id' => getAcademicId(),
        ]);
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
