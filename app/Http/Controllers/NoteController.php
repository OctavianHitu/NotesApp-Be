<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoteRequest;
use App\Models\Note;
use App\Http\Requests\UpdateNoteRequest;
use App\Traits\ApiResponses;
use Carbon\Carbon;

class NoteController extends Controller
{
    use ApiResponses;
    public function index($id)
    {
        $user = auth('sanctum')->user();
        if ($user->id != $id) {
            return $this->error("You can only see your notes", 401);
        }
        try {
            $notes = Note::where('user_id', $id)->get()->all();
            return $this->ok('Returned', $notes);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function store(CreateNoteRequest $request)
    {
        $request->validated($request->all());

        $user = auth('sanctum')->user();
        $note = Note::where('name', '=', $request->name)->first();
        if ($note && $note->user_id === $user->id) {
            return $this->error("You already have a note woth the same name!", 500);
        }


        $createdNote = Note::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'body' => $request->body,
            'image' => $request->image,
            'updated_at' => $request->updated_at,
            'created_at' => $request->created_at
        ]);

        return $this->ok('Note created succesfully!', [
            'user_id' => $createdNote->user_id,
            'name' => $createdNote->name,
        ]);
    }


    public function notePatch(UpdateNoteRequest $request)
    {
        try {
            $request->validated($request->all());
            $user = auth('sanctum')->user();
            $note = Note::find($request->note_id);
            if ($user->id != $note->user_id) {
                return $this->error("You can only delete your notes", 401);
            }
            $note->name = $request->name;
            $note->body = $request->body;
            $note->updated_at = Carbon::now();

            $note->save();

            return $this->ok("Updated succesfully!", $note);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }


    }


    public function destroy($id)
    {
        $user = auth('sanctum')->user();
        try {
            $note = Note::find($id);
            if ($user->id != $note->user_id) {
                return $this->error("You can only delete your notes", 401);
            }
            $note->delete();
            return $this->ok("Deleted!", "");
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }

    }
}
