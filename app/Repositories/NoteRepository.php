<?php
namespace App\Repositories;

use App\Models\Note as Note;

class NoteRepository
{

    public function getAll()
    {
        return Note::all();
    }

    public function find($id)
    {
        return Note::findOrFail($id);
    }

    public function delete($note)
    {
        return $note->delete();
    }

    public function getNoteByUser($user)
    {
        return $user->notes();
    }

    public function getUncotegoryNotesByUser($user)
    {
        return $user->get_uncategories_notes();
    }

    public function create(array $data)
    {
        $note = new Note($data);
        return $note;
    }

    public function update($note, array $data)
    {
        $note->update($data);
    }
}