<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Message;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;

class MessageController extends MainController
{
    public function index(Request $request)
    {
        $query = Message::query();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($dateRange = $request->input('date_range')) {
            $dates = explode(' - ', $dateRange);
            if (count($dates) === 2) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }
        if ($request->has('status')) {
            $status = $request->input('status');
            $query->where('active', $status);
        }
        $query->orderBy('seq', 'asc');
        $messages = $query->paginate(10);
        $messages->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Messages';
        $page = 'admin.messages.index';
        return $this->template($page, compact('messages', 'title'));
    }

    public function create()
    {
        $title = 'Create Message';
        $comp = 'message';
        return $this->template('admin.messages.create', compact('title', 'comp'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a message.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'name' => $request->input('name'),
                'designation' => $request->input('designation'),
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
                'school_id' =>$user->school_id,
                'active' => 1,
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', null, 'messages', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            Message::create($data);
            Toastr::success('Message created successfully.', 'Success');
            return redirect()->route('admin.messages.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create message: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Message $message)
    {
        $title = 'Edit Message';
        $comp = 'message';
        return $this->template('admin.messages.edit', compact('message', 'title', 'comp'));
    }

    public function update(Request $request, Message $message)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a message.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'name' => $request->input('name'),
                'designation' => $request->input('designation'),
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', $message->image, 'messages', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            $message->update($data);
            Toastr::success('Message updated successfully.', 'Success');
            return redirect()->route('admin.messages.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update message: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Message $message)
    {
        try {
            if ($message->image && $message->image !== config('app.DEFAULT_IMAGE') . 'default-message.jpg') {
                UploadImage::deleteFile($message->image);
            }
            $message->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Message deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete message: ' . $e->getMessage(),
            ]);
        }
    }
}
